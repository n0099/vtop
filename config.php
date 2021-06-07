<?php
// 是否省略左侧面板链接url末尾的.php，需要已配置正确的urlrewrite
define('URL_REWRITE_ENABLED', false);
// 是否隐藏已删除帖子的内容预览，具体修改位于core.php:71
define('HIDE_DELETED_POST_CONTENT', false);

/**
 * Author VICZONE
 * Copyright 2015
 * Website http://vicz.cn/
 */

// 是否隐藏操作人，作用于删帖封禁日志、黑名单列表、吧务上下任日志、删帖/封禁申诉页
define('HIDE', false);

//输入cookie，如果不会，VICZONE·交流有写（http://vicz.cn）

/*
2015-7-14 加入隐藏操作人
☆☆☆
define('BDUSS','***');

其中，大写的那个BDUSS是定义的常量，不要修改他。
 ***就是裸BDUSS

以下每一个填写都会给出示例。

*/

//cookie，不多赘述
//Eg.:
# define('COOKIE','BDUSS=***;');

define('BDUSS','');

//这是贴吧名，必须要有权限！
//Eg.:
// define('KW_RAW','bug');
define('KW_RAW','');

///不要修改以下部分了
//中文吧名需要以GBK/GB2312编码进行urlencode才能传给贴吧url
define('KW_GBK', iconv('UTF-8', 'GBK', KW_RAW));
define('KW',urlencode(KW_GBK));
///STATIC PART
define('MAIN','http://tieba.baidu.com/bawu2/platform/index?word=');
define('POST','http://tieba.baidu.com/bawu2/platform/listPostLog?word=');
define('USER','http://tieba.baidu.com/bawu2/platform/listUserLog?word=');
define('DATA','http://tieba.baidu.com/bawu2/platform/data?word=');
define('BAWU','http://tieba.baidu.com/bawu2/platform/listBawuLog?word=');

define('BAWU_DUTY','http://tieba.baidu.com/bawu2/platform/listBawuDuty?word=');
define('BLACKLIST','http://tieba.baidu.com/bawu2/platform/listBlackUser?word=');
define('DATA_EXCEL','http://tieba.baidu.com/bawu2/platform/dataExcel?word=');
define('USER_DATA_EXCEL','http://tieba.baidu.com/bawu2/platform/userDataExcel?word=');
define('APPEAL','http://tieba.baidu.com/bawu2/appeal/index?type=grid&kw=');
define('POST_APPEAL','http://tieba.baidu.com/bawu2/postappeal/index?type=grid&kw=');

define('VERSION','0.14');

define('SK',md5(BDUSS.'VTOP!!!'));

$urls=array(MAIN,POST,USER,DATA,BAWU);

define('COOKIE','BDUSS='.BDUSS.';');
