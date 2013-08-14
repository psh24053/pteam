<?php

/**
 * Notice Service
 * @author hongyushui
 */
class NoticeService extends Service{
	
	/**
	 * 获取公告列表
	 * @param Int start,Int count
	 */
	public function GetNoticeList($start,$count){
		$db = $GLOBALS['mysql'];
		$db->Connect();
		
		$sql = 'select * from pt_notice limit '.$start.','.$count;
		
		$db->query($sql);
		
		$resultArray = array();
		$s = array();
		
		if($db->isGo()){
			$relCount = $db->getSelectNum();
			$resultArray['count'] = $relCount;
				
			while ($this->item = $db->getRow())
			{
				array_push($s, $this->item);
			}
		
			$resultArray['noticeList'] = $s;
				
				
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
		return 'pt_notice';
		}

	/* (non-PHPdoc)
	 * @see Service::getTablePrimary()
	 */public function getTablePrimary() {
		// TODO Auto-generated method stub
		return 'noticeId';
		}

	/* (non-PHPdoc)
	 * @see Service::getTableFieldArray()
	 */public function getTableFieldArray() {
		// TODO Auto-generated method stub
		return array(
				'noticeId',
				'type',
				'sourceId',
				'title',
				'content',
				'pubtime'
				
		);
		}
 
}
?>