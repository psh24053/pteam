<?php

/**
 * Share Service
 * @author hongyushui
 */
class ShareService extends Service{
	
	/**
	 * 分享内容
	 * @param Int start,Int count
	 */
	public function shareContent($start,$count){
		$db = $GLOBALS['mysql'];
		$db->Connect();
		
		$sql = 'select * from pt_share limit '.$start.','.$count;
		
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
		return 'pt_share';
		}

	/* (non-PHPdoc)
	 * @see Service::getTablePrimary()
	 */public function getTablePrimary() {
		// TODO Auto-generated method stub
		return 'shareId';
		}

	/* (non-PHPdoc)
	 * @see Service::getTableFieldArray()
	 */public function getTableFieldArray() {
		// TODO Auto-generated method stub
		return array(
				'shareId',
				'accountId',
				'comment',
				'scope',
				'scopeTargetId',
				'shareContent',
				'shareTime'
		);
		}

}
?>