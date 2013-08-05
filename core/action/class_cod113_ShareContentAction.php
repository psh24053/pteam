<?php

/**
 * 分享内容 cod 113
 * @author hongyushui
 */
class ShareContentAction extends Action{
	
	function __construct(){
		$this->actionCode = 113;
		$this->actionName = 'Share Content Action';
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
		
		$shareContentService = new ShareService();
		$shareList = $shareContentService->shareContent($prm->start, $prm->count);
		
		if (isset($shareList)) {
			return $this->toSuccess($action,$shareList);
		}else {
			return $this->toError($action, ErrorCode::ERROR_CODE_SERVER_ERROR, '获取分享列表失败');
		}
	}
}
?>