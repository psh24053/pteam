<?php

/**
 * 获取动态列表 cod 114
 * @author hongyushui
 */
class GetTrendListAction extends Action{
	
	function __construct(){
		$this->actionCode = 114;
		$this->actionName = 'Get TrendList Action';
	}
	
	public function doAction($action){
		
		if(!isset($action->aut)){
			return $this->toError($action, ErrorCode::ERROR_CODE_AUT_NOT_FOUND);
		}
		if(!checkAutExist($action->aut)){
			return $this->toError($action, ErrorCode::ERROR_CODE_AUT_ERROR);
		}
		
		$prm = $action->prm;
		if (!isset($prm->start)) {
			return $this->toError($action, ErrorCode::ERROR_CODE_MISSING_PARAMETER, '缺少 start 字段');
		}
		if (!isset($prm->count)) {
			return $this->toError($action, ErrorCode::ERROR_CODE_MISSING_PARAMETER, '缺少 count 字段');
		}
		
		$getTrendService = new TrendService();
		$trendList = $getTrendService->GetTrendService($prm->start, $prm->count);
		if (isset($trendList)) {
			return $this->toSuccess($action,$trendList);
		}else {
			return $this->toError($action, ErrorCode::ERROR_CODE_SERVER_ERROR, '获取动态列表失败');
		}
	}
}
?>