<?php

/**
 * 用户登录 cod 101
 * @author Panshihao
 *        
 */
class UserLoginAction extends Action {
	// TODO - Insert your code here
	
	/**
	 */
	function __construct() {
		$this->actionCode = 101;
		$this->actionName = 'UserLoginAction';
	}
	public function doAction($action) {
		$prm = $action->prm;
		
		if(!isset($prm->username)){
			return $this->toError($action, ErrorCode::ERROR_CODE_MISSING_PARAMETER, '缺少 username 字段');
		}
		if(!isset($prm->password)){
			return $this->toError($action, ErrorCode::ERROR_CODE_MISSING_PARAMETER, '缺少 password 字段');
		}
		
		$accountService = new AccountService();
		
		// 判断username 是否存在
		if(!$accountService->checkUsernameExist($prm->username)){
			return $this->toError($action, 8001, '用户名不存在');
		}
		// 判断密码是否正确
		if(!$accountService->validationPassword($prm->username, $prm->password)){
			return $this->toError($action, 8002, '密码错误');
		}
		//  生成aut
		$aut = GenerateAut($accountService->item);
		
		$pld->aut = $aut;
		
		return $this->toSuccess($action, $pld);
		
	}

}

?>