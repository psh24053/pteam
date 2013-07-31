<?php

include 'core/core.php';

$prm->username = 'admin3';
$prm->password = 'admin';
$prm->phone = '15858586969';
$prm->email = 'panshihao@panshihao.cn';
$prm->realname = '张三';
$prm->login = true;

echo localRequest(103, $prm, null, false);