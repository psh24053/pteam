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
	/* (non-PHPdoc)
	 * @see Service::getTableName()
	 */public function getTableName() {
		// TODO Auto-generated method stub
		return 'pt_trend';
		}

	/* (non-PHPdoc)
	 * @see Service::getTablePrimary()
	 */public function getTablePrimary() {
		// TODO Auto-generated method stub
		return 'trendId';
		}

	/* (non-PHPdoc)
	 * @see Service::getTableFieldArray()
	 */public function getTableFieldArray() {
		// TODO Auto-generated method stub
		return array(
				'trendId',
				'produceTime',
				'accountId',
				'scope',
				'scopeTargetId',
				'trendJSON'
		);
		}


}
?>