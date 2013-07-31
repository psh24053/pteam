<?php
/**
 * 用户注册 cod 103
 * @author panshihao
 *
 */
class RegisterAction extends Action {
	
	function __construct() {
		$this->actionCode = 103;
		$this->actionName = 'RegisterAction';
	}
	
	public function doAction($action) {

		$prm = $action->prm;
		
		if(!isset($prm->username)){
			return $this->toError($action, ErrorCode::ERROR_CODE_MISSING_PARAMETER, '缺少 username 字段');
		}
		if(!isset($prm->password)){
			return $this->toError($action, ErrorCode::ERROR_CODE_MISSING_PARAMETER, '缺少 password 字段');
		}
		if(!isset($prm->phone)){
			return $this->toError($action, ErrorCode::ERROR_CODE_MISSING_PARAMETER, '缺少 phone 字段');
		}
		if(!isset($prm->email)){
			return $this->toError($action, ErrorCode::ERROR_CODE_MISSING_PARAMETER, '缺少 email 字段');
		}
		if(!isset($prm->realname)){
			return $this->toError($action, ErrorCode::ERROR_CODE_MISSING_PARAMETER, '缺少 realname 字段');
		}
		if(!isset($prm->login)){
			return $this->toError($action, ErrorCode::ERROR_CODE_MISSING_PARAMETER, '缺少 login 字段');
		}
		
		$accountService = new AccountService();
		// 判断用户名是否存在
		$isExist = $accountService->checkUsernameExist($prm->username);
		
		// 用户名存在
		if($isExist){
			return $this->toError($action, 8003, '用户名已存在');
		}

		$regResult = $accountService->registerUser($prm);
		
		//如果注册成功
		if($regResult){
			
			if($prm->login){
				$aut = GenerateAut($accountService->item);
				$pld->aut = $aut;
				return $this->toSuccess($action, $pld);
				
			}else{
				return $this->toSuccess($action);
			}
			
		}else{
			return $this->toError($action, ErrorCode::ERROR_CODE_SERVER_ERROR, '注册失败');
		}
		
		
		
		
		
		
		
	}
}

?>