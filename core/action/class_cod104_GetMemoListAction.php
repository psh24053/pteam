<?php
/**
 * 获取备忘录列表 cod 104
 * @author hongyushui
 */
class GetMemoListAction extends Action{
	
	function __construct(){
		$this->actionCode = 104;
		$this->actionName = 'GetMemoListAction';
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
		
		$memoService = new MemoService();
		$memo = $memoService->GetMemoList($prm->start, $prm->count);
		
		if (isset($memo)) {
			return $this->toSuccess($action,$memo);
		}else {
			return $this->toError($action, ErrorCode::ERROR_CODE_SERVER_ERROR, '获取备忘录列表失败');
		}
		
	}
}
?>