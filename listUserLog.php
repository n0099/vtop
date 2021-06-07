<?php
/**
 * Author VICZONE
 * Copyright 2015
 * Website http://vicz.cn/
 */
require 'core.php';

$res=cget(USER.KW.'&'.http_build_query($_GET),COOKIE);
$res=swh($res);
echo $res;
