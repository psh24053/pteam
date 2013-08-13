<?php

include 'core/core.php';

$accountService = new AccountService();


$filter->sort->field = 'phone';
$filter->sort->order = 'asc';
$filter->columns = array('phone');

$where1->field = 'username';
$where1->mode = '=';
$where1->args = array('admin');

$filter->where = array($where1);

array_push($filter->where, $where1);

print_r($filter);
echo '<hr />';

$result = $accountService->filterSerivce(0, 10, $filter);

print_r($result);

/**
 * 测试
 * @author hongyushui
 */
//测试Action 103 注册
// $prm->username = 'Rock';
// $prm->password = '123456';
// $prm->phone = '18030467664';
// $prm->email = 'hysnot@163.com';
// $prm->realname = 'hongyushui';
// $prm->login = true;
// $response =  localRequest(103, $prm,null);
// print_r($response);

//测试Action 101 登录
// $prm->username = 'Rock';
// $prm->password = '123456';
// $response = localRequest(101, $prm);
// print_r($response);

//测试Action 102 用户信息
// $resps = localRequest(102,null,$response->pld->aut);
// print_r($resps);

//测试Action 105 创建通讯录
// $prmt->content = '明天八点起床';
// $prmt->remindTime = '2013-07-31 17:23:20';
// $resps = localRequest(105, $prmt,$response->pld->aut);
// print_r($resps);

//获取用户备忘录列表Action 104
// $prmt->start = 0;
// $prmt->count = 3;
// $resps = localRequest(104, $prmt,$response->pld->aut);
// print_r($resps); 

//删除备忘录Action 106;
// $prmt->memoId = 10;
// echo localRequest(106, $prmt,$response->pld->aut,false);

//发送消息Action 109
// $prmt->toAccountId = 2;
// $prmt->content = '明天起床喊我';
// echo localRequest(109, $prmt,$response->pld->aut,false);

//设置消息已读 Action 108
// $prmt->messageId = 6;
// echo localRequest(108, $prmt,$response->pld->aut,false);

//获取消息列表Action 107
// $prmt->start = 0;
// $prmt->count = 3;
// echo localRequest(107, $prmt,$response->pld->aut,false);

//删除消息Action 110
// $prmt->messageId = 5;
// echo localRequest(110, $prmt,$response->pld->aut,false);

//获取用户列表Action 111
// $prmt->start = 0;
// $prmt->count = 3;
// echo localRequest(111, $prmt,$response->pld->aut,false);

//获取公告列表Action 112
// $prmt->start = 0;
// $prmt->count = 3;
// echo localRequest(112, $prmt,$response->pld->aut,false);

//获取分享内容Action 112
// $prmt->start = 0;
// $prmt->count = 3;
// echo localRequest(113, $prmt,$response->pld->aut,false);

//获取动态列表Action 114
// $prmt->start = 0;
// $prmt->count = 3;
// echo localRequest(114, $prmt,$response->pld->aut,false);

?>