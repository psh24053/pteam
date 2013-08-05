<?php

/**
 * account Service
 * @author Panshihao
 *
 */
class AccountService extends Service {
	
	/**
	 * 检查用户名是否存在
	 * @param string $username
	 * @return boolean
	 */
	public function checkUsernameExist($username){
		$db = $GLOBALS['mysql'];
		$db->Connect();
		
		
		$sql = 'select * from pt_account where username = "' . mysql_real_escape_string($username) . '"';
		
		$db->query($sql);

		$result = false;
		
		if($db->isGo()){
			//执行成功
			if($this->item = $db->getRow()){
				$result = true;
			}
		}else{
			log_error($db->getError());
		}
		// 关闭数据库连接
		$db->Close();
		return $result;
	}
	/**
	 * 检查密码是否正确
	 * @param string $username
	 * @param string $password
	 */
	public function validationPassword($username, $password){
		$db = $GLOBALS['mysql'];
		$db->Connect();
		
		$sql = 'select * from pt_account where username = "' . mysql_real_escape_string($username) . '" and password = "' . mysql_real_escape_string($password) . '"';
		
		$db->query($sql);
		
		$result = false;
		
		if($db->isGo()){
			//执行成功
			if($this->item = $db->getRow()){
				$result = true;
			}
		}else{
			log_error($db->getError());
		}
		// 关闭数据库连接
		$db->Close();
		return $result;
		
	}
	/**
	 * 获取用户信息
	 * @param int $accountId
	 * @return boolean
	 */
	public function getUserInfo($accountId){
		$db = $GLOBALS['mysql'];
		$db->Connect();
		
		$sql = 'select * from pt_account where accountId = "' . mysql_real_escape_string($accountId) . '"';
		
		$db->query($sql);
		
		$result = null;
		
		if($db->isGo()){
			//执行成功
			if($this->item = $db->getRow()){
				$result = $this->item;
			}
		}else{
			log_error($db->getError());
		}
		// 关闭数据库连接
		$db->Close();
		return $result;
	}
	/**
	 * 注册用户
	 * @param object $account
	 * @return boolean
	 */
	public function registerUser($account){
		$db = $GLOBALS['mysql'];
		$db->Connect();
		
		$account->username = mysql_real_escape_string($account->username);
		$account->password = mysql_real_escape_string($account->password);
		$account->phone = mysql_real_escape_string($account->phone);
		$account->email = mysql_real_escape_string($account->email);
		$account->realname = mysql_real_escape_string($account->realname);
		
		$sql = 'insert into pt_account(username,password,phone,email,realname) values("'.$account->username.'","'.$account->password.'","'.$account->phone.'","'.$account->email.'","'.$account->realname.'")';
		
		$db->query($sql);
		
		$result = -1;
		
		if($db->isGo()){
			//执行成功
			$result = $db->getUpdateNum();
		}else{
			log_error($db->getError());
		}
		// 关闭数据库连接
		$db->Close();
		return $result > 0;
	}
	/**
	 * 获取用户列表
	 * @param Int start,Int count
	 * @return array
	 */
	public function GetUserList($start,$count){
		$db = $GLOBALS['mysql'];
		$db->Connect();
		
		$sql = 'select * from pt_account limit '.$start.','.$count;
		
		$db->query($sql);
		
		$resultArray = array();
		$s = array();
		if($db->isGo()){
			$relCount = $db->getSelectNum();
			//array_push($pld, $relCount);
			$resultArray['count'] = $relCount;
		
			while ($this->item = $db->getRow())
			{
				array_push($s, $this->item['accountId']);
				array_push($s, $this->item['realname']);
			}
		
			$resultArray['userList'] = $s;
		
		
		}else {
			log_error($db->getError());
		}
		$db->Close();
		return $resultArray;
	}
}

?>