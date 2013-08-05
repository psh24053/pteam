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
}
?>