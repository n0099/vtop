<?php

/**
 * Author VICZONE
 * Copyright 2015
 * Website http://vicz.cn/
 */
 
require 'core.php';

header("Content-type: image/png"); 

$url=$_GET["url"];

echo cget($url,COOKIE);

?>

