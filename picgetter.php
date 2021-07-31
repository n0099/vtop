<?php

/**
 * Author VICZONE
 * Copyright 2015
 * Website http://vicz.cn/
 */

require 'core.php';

header("Content-Type: image/jpeg");

$url = $_GET["url"];

echo cget($url, COOKIE);
