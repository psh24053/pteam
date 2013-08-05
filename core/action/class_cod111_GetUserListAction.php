<?php

/**
 * 获取用户列表 cod 111
 * @author hongyushui
 */
class GetUserListAction extends Action{
	
	function __construct(){
		$this->actionCode = 111;
		$this->actionName = 'Get UserList Action';
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
		
		$account = new AccountService();
		$userList = $account->GetUserList($prm->start, $prm->count);
		
		if (isset($userList)) {
			return $this->toSuccess($action,$userList);
		}else {
			return $this->toError($action, ErrorCode::ERROR_CODE_SERVER_ERROR, '获取用户列表失败');
		}
		
	}
}
?>