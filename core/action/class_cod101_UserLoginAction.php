<?php
/**
 * 用户登录 cod 101
 * @author panshihao
 *        
 */
class UserLoginAction extends \Action {
	// TODO - Insert your code here
	
	/**
	 * 构造方法
	 */
	function __construct() {
		$this->actionCode = 101;
		$this->actionName = "UserLoginAction";
	}
	public function doAction($action) {
		// TODO Auto-generated method stub
		
		
		$this->toSuccess($action);
	}

}

?>