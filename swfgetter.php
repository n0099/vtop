<?php

/**
 * Author VICZONE
 * Copyright 2014
 * Website http://vicz.cn/
 */
 
 
/*

����һ��δ����Ĺ��ܣ����������Ȥ���Ϳ�һ���ɡ�

*/


include("curl.php");
include("../config/main.php");

header("Content-type: application/x-shockwave-flash"); 

$url=$_GET["url"];

echo cget($url,COOKIE);

?>

