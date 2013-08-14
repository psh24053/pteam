<?php

/**
 * Service基类
 * @author Panshihao
 *        
 */
abstract class Service {
	// TODO - Insert your code here
	
	public $item;
	
	/**
	 * 返回表名
	 * @return String $tableName
	 */
	abstract public function getTableName();
	/**
	 * 返回主键名称
	 * @return String $tablePrimary
	 */
	abstract public function getTablePrimary();
	/**
	 * 返回表字段名的数组
	 * @return array $tableFieldArray
	 */
	abstract public function getTableFieldArray();
	/**
	 * 判断传入的字段是否存在
	 * @param String $field
	 * @return boolean
	 */
	public function hasField($field){
		// TODO Auto-generated method stub
		$array = $this->getTableFieldArray ();
		for($i = 0; $i < count ( $array ); $i ++) {
			$f = $array[$i];
			if ($f == $field) {
				return true;
			}
		}
		
		return false;
	}
	/**
	 * 通用过滤器，使用过滤器机制返回数据
	 * @param int $start
	 * @param int $count
	 * @param Object $filter
	 */
	public function filterSerivce($start, $count, $filter){
		$db = $GLOBALS['mysql'];
		$db->Connect();
		
		// 如果filter为空则为其赋初值
		if(!isset($filter)){
			$filter = array();
		}
		
		// columns的初值是 *
		$columns = '*';
		// tables的初值是主表名称
		$tables = $this->getTableName();
		// where的初值
		$where = '1 = 1 ';
		// sort的初值
		$sort = 'ORDER BY ';
		// limit的初值
		$limit = 'LIMIT ' . $start . ',' . $count;
		
		// 首先进入 columns的判断
		if(isset($filter->columns) && count($filter->columns) > 0){
			// 如果columns是一个数组则继续判断，否则终止
			// 如果columns不是一个空数组，则将其设置为空
			if(count($filter->columns) > 0){
				$columns = '';
			}
			// 遍历 columns
			for($i = 0 ; $i < count($filter->columns) ; $i ++){
				$columnItem = $filter->columns[$i];
				
				if($i == count($filter->columns) - 1){
					$columns .= $columnItem;
				}else{
					$columns .= $columnItem . ',';
					
				}
				
			}
			
			
			
		}
		// columns处理完成后，为其增加空格
		$columns .= ' ';
		
		
		// 进入tables的判断
		if(isset($filter->tables) && $filter->tables instanceof ArrayObject){
			// 如果tables是一个数组则继续判断，否则终止
			// 如果tables不是一个空数组，则为主表增加别名
			if(count($filter->tables) > 0){
				// 主表默认的别名为m
				$tables = $this->getTableName() . ' as m,';
			}
			// 遍历 tables
			for($i = 0 ; $i < count($filter->tables) ; $i ++){
				$tableItem = $filter->tables[$i];
			
				//判断tableitem对象的字段是否存在
				if(isset($tableItem->table)){
					log_error('$tableItem->table table not found!');
					continue;
				}
				if(isset($tableItem->as)){
					log_error('$tableItem->as as not found!');
					continue;
				}
				if(isset($tableItem->joinWhere)){
					log_error('$tableItem->joinWhere joinWhere not found!');
					continue;
				}
				
				
				if($i == count($filter->tables) - 1){
					$tables .= $tableItem->table . ' as ' . $tableItem->as ;
				}else{
					$tables .= $tableItem->table . ' as ' . $tableItem->as . ',';
				}
				
				// 将joinwhere条件加入where
				$where .= 'and ' . $tableItem->joinWhere . ' ';
			
			}
			
			
			
		}
		// tables处理完成后，为其增加空格
		$tables .= ' ';
		
		// 进入where的判断
		
		if(isset($filter->where) && count($filter->where) > 0){
			// 如果where是一个数组则继续判断，否则终止
			// 遍历 where
			for($i = 0 ; $i < count($filter->where) ; $i ++){
				$whereItem = $filter->where[$i];
					
				//判断tableitem对象的字段是否存在
				if(!isset($whereItem->field)){
					log_error('$whereItem->field field not found!');
					continue;
				}
				if(!isset($whereItem->mode)){
					log_error('$whereItem->mode mode not found!');
					continue;
				}
				if(!isset($whereItem->args)){
					log_error('$whereItem->args args not found!');
					continue;
				}
			
				// 根据不同的mode进行判断
				switch ($whereItem->mode){
					case 'in':
						// 如果args的数量为0，则跳出本次循环
						if(count($whereItem->args) == 0){
							continue;
						}
						// 遍历args,构造inStr
						$inStr = '';
						for($i = 0 ; $i < count($whereItem->args) ; $i ++){
							$arg = $whereItem->args[$i];
							
						if($i == count($whereItem->args) - 1){
								$inStr .= "'".$arg."'";
							}else{
								$inStr .= "'".$arg."'" . ',';
						
							}
							
						}
						
						
						$where .= 'and ' . $whereItem->field . ' in(' . $inStr . ')';
						break;
					case 'notin':
						// 如果args的数量为0，则跳出本次循环
						if(count($whereItem->args) == 0){
							continue;
						}
						
						// 遍历args,构造notinStr
						$notinStr = '';
						for($i = 0 ; $i < count($whereItem->args) ; $i ++){
							$arg = $whereItem->args[$i];
								
							if($i == count($whereItem->args) - 1){
								$notinStr .= "'".$arg."'";
							}else{
								$notinStr .= "'".$arg."'" . ',';
						
							}
								
						}
						
						
						$where .= 'and ' . $whereItem->field . ' not in(' . $notinStr . ')';
						break;
					case 'between':
						// 如果args的数量小于2，则跳出本次循环
						if(count($whereItem->args) < 2){
							continue;
						}
						$where .= 'and (' . $whereItem->field . ' between "' . $whereItem->args[0] . '" and "' . $whereItem->args[1] . '")';
						break;
					case 'notbetween':
						// 如果args的数量小于2，则跳出本次循环
						if(count($whereItem->args) < 2){
							continue;
						}
						$where .= 'and (' . $whereItem->field . ' not between "' . $whereItem->args[0] . '" and "' . $whereItem->args[1] . '")';
						
						break;
					case 'like':
						// 如果args的数量为0，则跳出本次循环
						if(count($whereItem->args) == 0){
							continue;
						}
						$where .= 'and ' . $whereItem->field . ' like "' . $whereItem->args[0] . '"';
						
						break;
					case 'notlike':
						// 如果args的数量为0，则跳出本次循环
						if(count($whereItem->args) == 0){
							continue;
						}
						$where .= 'and ' . $whereItem->field . ' not like "' . $whereItem->args[0] . '"';
						break;
					case 'isnull':
						$where .= 'and ' . $whereItem->field . ' is null';
						break;
					case 'isnotnull':
						$where .= 'and ' . $whereItem->field . ' is not null';
						break;
					default:
						// 如果args的数量为0，则跳出本次循环
						if(count($whereItem->args) == 0){
							continue;
						}
						$where .= 'and ' . $whereItem->field . ' ' . $whereItem->mode . ' "' . $whereItem->args[0].'"';
						break;
				}
				
				$where .= ' ';
					
			}		
			
		}
		
		// 完成sort的判断
		if(isset($filter->sort)){
			$sort .= $filter->sort->field . ' ' . $filter->sort->order . ' ';
		}else{
			$sort = 'ORDER BY ' . $this->getTablePrimary() . ' asc ';
		}
		
		$sql = 'SELECT ' . $columns . ' FROM ' . $tables . ' WHERE ' . $where . ' ' . $sort . ' ' . $limit;
		echo $sql . '<hr />';
		log_debug($sql);
		
		$db->query($sql);
		
		$result = array();
		
		$data = array();
		if($db->isGo()){
			$relCount = $db->getSelectNum();
			//array_push($pld, $relCount);
			$result['count'] = $relCount;
		
			while ($row = $db->getRow())
			{
				array_push($data, $row);
			}
		
			$result['data'] = $data;
		
		
		}else {
			log_error($db->getError());
		}
		$db->Close();
		return $result;
		
	}
	
	
	
}

