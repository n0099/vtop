<?php

/**
 * Author VICZONE
 * Copyright 2014
 * Website http://vicz.cn/
 */
 
 
/*

这是一个未做完的功能，如果你有兴趣，就看一看吧。

*/


include("curl.php");
include("../config/main.php");

header("Content-type: application/x-shockwave-flash"); 

$url=$_GET["url"];

echo cget($url,COOKIE);

?>

