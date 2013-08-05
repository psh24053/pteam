<?php

/**
 * 删除信息 cod 110
 * @author hongyushui
 */
class DeleteMessageAction extends Action{
	
	function __construct(){
		$this->actionCode = 110;
		$this->actionName = 'Delete Message Action';
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
		
		$delMessage = new MessageService();
		$delResult = $delMessage->deleteMessage($prm->messageId);
		
		//删除成功
		if ($delResult) {
			return $this->toSuccess($action);
		}
		else {
			return $this->toError($action, ErrorCode::ERROR_CODE_SERVER_ERROR, '删除消息失败');
		}
		
		
		
	}
}
?>