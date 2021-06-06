<?php
// 是否隐藏已删除帖子的内容预览，具体修改位于core.php:58 by n0099
define('HIDE_DELETED_POST_CONTENT', true);

/**
 * Author VICZONE
 * Copyright 2015
 * Website http://vicz.cn/
 */


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
// $kw='bug';
$kw='';

//是否隐藏操作人
#不隐藏：  define('HIDE',false);
#隐藏：  define('HIDE',true);
define('HIDE',false);


//可以开启防止百度盗链的图片，但是会增加服务器带宽负担
//实际上就是服务器要下载图片了……
//如果不愿意开启请把true改成false
define('OPENPIC',true);

///不要修改以下部分了
//中文吧名需要以GBK/GB2312编码进行urlencode才能传给贴吧url
define('KW',urlencode(iconv('UTF-8', 'GBK', $kw)));
///STATIC PART
define('MAIN','http://tieba.baidu.com/bawu2/platform/index?word=');
define('POST','http://tieba.baidu.com/bawu2/platform/listPostLog?word=');
define('USER','http://tieba.baidu.com/bawu2/platform/listUserLog?word=');
define('DATA','http://tieba.baidu.com/bawu2/platform/data?word=');
define('BAWU','http://tieba.baidu.com/bawu2/platform/listBawuLog?word=');

define('VERSION','0.12');

define('SK',md5(BDUSS.'VTOP!!!'));

$urls=array(MAIN,POST,USER,DATA,BAWU);

define('COOKIE','BDUSS='.BDUSS.';');

?>
