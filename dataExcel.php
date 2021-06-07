<?php

/**
 * Author VICZONE
 * Copyright 2015
 * Website http://vicz.cn/
 */

require 'core.php';

header('Content-Disposition: attachment; filename="bawudata_' . date('Ymd') . '.xls"');

$res=cget(DATA_EXCEL.KW,COOKIE);

echo $res;
