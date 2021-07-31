<?php

/**
 * Author VICZONE
 * Copyright 2015
 * Website http://vicz.cn/
 */

require 'core.php';

header('Content-Disposition: attachment; filename="bawuuserdata_' . date('Ymd') . '.xls"');

$res = cget(USER_DATA_EXCEL . KW, COOKIE);

echo $res;
