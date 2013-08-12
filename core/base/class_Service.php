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
	abstract public function hasField($field);
	/**
	 * 通用过滤器，使用过滤器机制返回数据
	 * @param int $start
	 * @param int $count
	 * @param Object $filter
	 */
	public function filterSerivce($start, $count, $filter){
		$db = $GLOBALS['mysql'];
		$db->Connect();
		
		// columns的初值是 *
		$columns = '*';
		// tables的初值是主表名称
		$tables = $this->getTableName();
		// where的初值
		$where = '1 = 1 and ';
		
		
		// 首先进入 columns的判断
		if(isset($filter->columns) && $filter->columns instanceof ArrayObject){
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
		if(isset($filter->where) && $filter->where instanceof ArrayObject){
			// 如果where是一个数组则继续判断，否则终止
			// 遍历 where
			for($i = 0 ; $i < count($filter->where) ; $i ++){
				$whereItem = $filter->where[$i];
					
				//判断tableitem对象的字段是否存在
				if(isset($whereItem->field)){
					log_error('$whereItem->field field not found!');
					continue;
				}
				if(isset($whereItem->mode)){
					log_error('$whereItem->mode mode not found!');
					continue;
				}
				if(isset($whereItem->args)){
					log_error('$whereItem->args args not found!');
					continue;
				}
			
				// 根据不同的mode进行判断
				switch ($whereItem->mode){
					case 'in':
						
						
						// 将joinwhere条件加入where
						$where .= 'and ' . $whereItem->field . ' in(';
						break;
					case 'notin':
						break;
					case 'between':
						break;
					case 'notbetween':
						break;
					case 'like':
						break;
					case 'notlike':
						break;
					case 'isnull':
						break;
					case 'isnotnull':
						break;
					default:
						break;
				}
				
			
			
				
					
			}		
			
		}
		
// 		sort : {    //排序方式字段，可为空
// 			field : '排序字段',
// 			order : 'desc'  //desc或者asc
// 		},
// 		where : [{  // 过滤条件字段数组，可为空,所有where条件之间都是and的关系
// 			field : '字段名称',   // 表字段名称
// 			mode : '过滤方式',   //  =,!=,<,>,<=,>=,in(notin),between(notbetween),like(notlike),isnull(isnotnull)
// 			args : ['10']   // 过滤参数数组
// 		}],
		
		$sql = 'select ';
		
		
	}
	
	
	
}

