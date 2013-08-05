<?php
/**
 * 用户创建备忘录 cod 105
 * @author hongyushui
 */
class CreateMemoAction extends Action{
	
	function __construct(){
		$this->actionCode = 105;
		$this->actionName = 'CreateMemoAction';
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
		if (!isset($prm->remindTime)) {
			return $this->toError($action, ErrorCode::ERROR_CODE_MISSING_PARAMETER, '缺少 remindTime 字段');
		}
		
		$prm->accountId = $account['accountId'];
		
		$memoService = new MemoService();
		
		$creResult = $memoService->createMemo($prm);
		
		//创建成功
		if ($creResult) {
			return $this->toSuccess($action);
		}
		else {
			return $this->toError($action, ErrorCode::ERROR_CODE_SERVER_ERROR, '创建备忘录失败');
		}
	}
}
?>