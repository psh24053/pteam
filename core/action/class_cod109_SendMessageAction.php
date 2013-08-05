<?php

/**
 * 发送消息 cod 109
 * @author hongyushui
 */
class SendMessageAction extends Action{
	
	function __construct(){
		$this->actionCode = 109;
		$this->actionName = 'Send Message Action';
	}
	
	public function doAction($action){
		
		if(!isset($action->aut)){
			return $this->toError($action, ErrorCode::ERROR_CODE_AUT_NOT_FOUND);
		}
		if(!checkAutExist($action->aut)){
			return $this->toError($action, ErrorCode::ERROR_CODE_AUT_ERROR);
		}
		
		$account = getAutObject($action->aut);
		
		$prm = $action->prm;	
		if (!isset($prm->content)) {
			return $this->toError($action, ErrorCode::ERROR_CODE_MISSING_PARAMETER, '缺少 content 字段');
		}
		if (!isset($prm->toAccountId)) {
			return $this->toError($action, ErrorCode::ERROR_CODE_MISSING_PARAMETER, '缺少 toAccountId 字段');
		}
		
		$prm->fromAccountId = $account['accountId'];
		
		$sendMessage = new MessageService();
		$sendResult = $sendMessage->sendMessage($prm);
		
		//发送信息成功
		if ($sendResult) {
			return $this->toSuccess($action);
		}
		else {
			return $this->toError($action, ErrorCode::ERROR_CODE_SERVER_ERROR, '消息发送失败');
		}
	}
}
?>