<?php

/**
 * Author VICZONE
 * Copyright 2015
 * Website http://vicz.cn/
 */

require 'core.php';

$res=cget(BAWU.KW,COOKIE);
$res=swh($res);

echo $res;


?>