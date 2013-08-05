<?php
	
/**
 * Memo Service
 * @author hongyushui
 */
class MemoService extends Service{
	
	/**
	 * 创建备忘录
	 * @param object $memo
	 * @return boolean
	 */
	public function createMemo($memo){
 		$db = $GLOBALS['mysql'];
 		$db->Connect();
		
		$memo->content = mysql_escape_string($memo->content);
		$memo->pubTime = date('Y-m-d H:i:s',time());
		$sql = 'insert into pt_memo(accountId,content,pubTime,remindTime) values('.$memo->accountId.',"'.$memo->content.'","'.date('Y-m-d H:i:s',time()).'","'.$memo->remindTime.'")';
		
		$db->query($sql);
		

		$result = -1;
		
		if($db->isGo()){
			//执行成功
			$result = $db->getUpdateNum();
		}else{
			log_error($db->getError());
		}
		// 关闭数据库连接
		$db->Close(); 
		return $result > 0;
	}
	
	/**
	 * 删除备忘录
	 * @param Int $memoId 
	 * @return boolean
	 */
	public function deleteMemo($memoId){
		$db = $GLOBALS['mysql'];
		$db->Connect();
		
		$sql = 'delete from pt_memo where memoId='.$memoId;
		
		$db->query($sql);
		
		$reslut = -1;
		
		if($db->isGo()){
			//执行成功
			$result = $db->getUpdateNum();
		}else{
			log_error($db->getError());
		}
		// 关闭数据库连接
		$db->Close();
		return $result > 0;
	}
	
	/**
	 * 获取备忘录列表
	 * @param Int start,Int count
	 * @return array
	 */
	public function GetMemoList($start,$count){
		$db = $GLOBALS['mysql'];
		$db->Connect();
		
		$sql = 'select * from pt_memo limit '.$start.','.$count;
		
		$db->query($sql);
		$resultArray = array();
		$s = array();
		if($db->isGo()){
			$relCount = $db->getSelectNum();
			//array_push($pld, $relCount);
			$resultArray['count'] = $relCount;
			
			while ($this->item = $db->getRow())
			{
				array_push($s, $this->item);
			}
		
			$resultArray['memolist'] = $s;
			
			
		}else {
			log_error($db->getError());
		}
		$db->Close();
		return $resultArray;
		
	}
	
}


?>