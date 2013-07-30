<?php
/**
 * 获取用户信息 cod 102 
 * @author Panshihao
 *
 */
class GetUserInfoAction extends Action {
	
	function __construct() {
		$this->actionCode = 102;
		$this->actionName = "GetUserInfoAction";
	}
	public function doAction($action) {
		
		if(!isset($action->aut)){
			return $this->toError($action, ErrorCode::ERROR_CODE_AUT_NOT_FOUND);
		}
		if(!checkAutExist($action->aut)){
			return $this->toError($action, ErrorCode::ERROR_CODE_AUT_ERROR);
		}
		
		$account = getAutObject($action->aut);

		return $this->toSuccess($action, $account);
		
		
	}

}

?>