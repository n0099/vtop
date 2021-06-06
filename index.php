<?php

/**
 * Author VICZONE
 * Copyright 2015
 * Website http://vicz.cn/
 */

require 'core.php';


$res=cget(MAIN.KW,COOKIE);

$res=swh($res);

echo $res;


?>