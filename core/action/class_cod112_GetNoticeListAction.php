<?php

/**
 * 获取公告列表 cod 112
 * @author hongyushui
 */
class GetNoticeListAction extends Action{
	
	function __construct(){
		$this->actionCode = 112;
		$this->actionName = 'Get NoticeList Action';
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
		
		$getNoticeService = new NoticeService();
		$noeticeList = $getNoticeService->GetNoticeList($prm->start, $prm->count);
		
		if (isset($noeticeList)) {
			return $this->toSuccess($action,$noeticeList);
		}else {
			return $this->toError($action, ErrorCode::ERROR_CODE_SERVER_ERROR, '获取公告列表失败');
		}
	}
}
?>