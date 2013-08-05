<?php
/**
 * 用户删除备忘录 cod 106
 * @author hongyushui
 */

class DeleteMemoAction extends Action{
	
	function __construct(){
		$this->actionCode = 106;
		$this->actionName = 'DeleteMemoAction';
	}
	
	public function doAction($action){

		if(!isset($action->aut)){
			return $this->toError($action, ErrorCode::ERROR_CODE_AUT_NOT_FOUND);
		}
		if(!checkAutExist($action->aut)){
			return $this->toError($action, ErrorCode::ERROR_CODE_AUT_ERROR);
		}
		
		$prm = $action->prm;
		if (!isset($prm->memoId)) {
			return $this->toError($action, ErrorCode::ERROR_CODE_MISSING_PARAMETER, '缺少 memoId 字段');
		}
		
		$memoService = new MemoService();
		$delResult = $memoService->deleteMemo($prm->memoId);
		
		//删除成功
		if ($delResult) {
			return $this->toSuccess($action);
		}
		else {
			return $this->toError($action, ErrorCode::ERROR_CODE_SERVER_ERROR, '删除备忘录失败');
		}
	}
}

?>