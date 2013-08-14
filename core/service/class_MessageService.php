<?php

/**
 * Message Service
 * @author hongyushui
 */
class MessageService extends Service{
	/**
	 * 发送消息
	 * @param object $Message
	 * @return boolean
	 */
	public function sendMessage($Message){
		$db = $GLOBALS['mysql'];
		$db->Connect();
		
		$Message->content = mysql_escape_string($Message->content);
		$Message->readMark = 1;
		$sql = 'insert into pt_message(fromAccountId,toAccountId,content,pubTime,readMark) values('.$Message->fromAccountId.
					','.$Message->toAccountId.',"'.$Message->content.'","'.date('Y-m-d H:i:s',time()).'",'.$Message->readMark.')';
		
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
	 * 删除信息
	 * @param Int $messageId
	 * @return boolean
	 */
	public function deleteMessage($messageId){
		$db = $GLOBALS['mysql'];
		$db->Connect();
		
		$sql = 'delete from pt_message where messageId='.$messageId;
		
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
	 * 设置消息已读
	 * @param Int messageId
	 * @return boolean
	 */
	public function SetMessageRead($messageId){
		$db = $GLOBALS['mysql'];
		$db->Connect();
		
		$sql = 'update pt_message set readMark = 0 where messageId='.$messageId;
		
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
	 * 获取消息列表
	 * @param Int start,Int count
	 * @return array
	 */
	public function GetMessageList($start,$count){
		$db = $GLOBALS['mysql'];
		$db->Connect();
		
		$sql = 'select * from pt_message limit '.$start.','.$count;
		
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
		
			$resultArray['messageList'] = $s;
				
				
		}else {
			log_error($db->getError());
		}
		$db->Close();
		return $resultArray;
	}
	/* (non-PHPdoc)
	 * @see Service::getTableName()
	 */public function getTableName() {
		// TODO Auto-generated method stub
		return 'pt_message';
		}

	/* (non-PHPdoc)
	 * @see Service::getTablePrimary()
	 */public function getTablePrimary() {
		// TODO Auto-generated method stub
		return 'messageId';
		}

	/* (non-PHPdoc)
	 * @see Service::getTableFieldArray()
	 */public function getTableFieldArray() {
		// TODO Auto-generated method stub
		return array(
				'messageId',
				'fromAccountId',
				'toAccountId',
				'content',
				'pubTime',
				'readMark'
		);
		}

}

?>