<?php

/**
 * 获取消息列表 cod 107
 * @author hongyushui
 */
class GetMessageListAction extends Action{
	
	function __construct(){
		$this->actionCode = 107;
		$this->actionName = 'Get Message List';
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
		
		$messageService = new MessageService();
		$messageList = $messageService->GetMessageList($prm->start, $prm->count);
		
		if (isset($messageList)) {
			return $this->toSuccess($action,$messageList);
		}
		else {
			return $this->toError($action, ErrorCode::ERROR_CODE_SERVER_ERROR, '获取消息列表失败');
		}
		
		
	}
}
?>