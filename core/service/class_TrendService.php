<?php

/**
 * Trend Service
 * @author hongyushui
 */
class TrendService extends Service{
	
	/**
	 * 获取动态列表
	 * @param Int Start Int Count
	 */
	public function GetTrendService($start,$count){
		$db = $GLOBALS['mysql'];
		$db->Connect();
		
		$sql = 'select * from pt_trend limit '.$start.','.$count;
		
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
		
			$resultArray['shareList'] = $s;
		
		
		}else {
			log_error($db->getError());
		}
		$db->Close();
		return $resultArray;
	}
}
?>