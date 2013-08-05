<?php

/**
 * 设置消息已读 cod 108
 * @author hongyushui
 */
class SetMessageReadAction extends Action{
	
	function __construct(){
		$this->actionCode = 108;
		$this->actionName = 'Set Message Read';
	}
	
	public function doAction($action){
		
		if(!isset($action->aut)){
			return $this->toError($action, ErrorCode::ERROR_CODE_AUT_NOT_FOUND);
		}
		if(!checkAutExist($action->aut)){
			return $this->toError($action, ErrorCode::ERROR_CODE_AUT_ERROR);
		}
		
		$prm = $action->prm;
		if (!isset($prm->messageId)) {
			return $this->toError($action, ErrorCode::ERROR_CODE_MISSING_PARAMETER, '缺少 messageId 字段');
		}
		
		$setMessage = new MessageService();
		$setResult = $setMessage->SetMessageRead($prm->messageId);
		
		//设置成功
		if ($setResult) {
			return $this->toSuccess($action);
		}
		else {
			return $this->toError($action, ErrorCode::ERROR_CODE_SERVER_ERROR, '设置消息已读失败');
		}
	}
}
?>