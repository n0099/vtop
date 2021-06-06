<?php

/**
 * Author VICZONE
 * Copyright 2015
 * Website http://vicz.cn/
 */

require 'core.php';

$get=http_build_query($_GET);

$res=cget(POST.KW."&$get",COOKIE);

$res=swh($res);

$res=preg_replace_callback('/https:\/\/imgsrc.baidu.com\/forum\/abpic\/item\/\w+.jpg/',function ($matches){return "picgetter.php?url=$matches[0]";},$res);
$res=hide($res);;
echo $res;



?>