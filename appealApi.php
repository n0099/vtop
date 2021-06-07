<?php
// also in appealSW.js
$allowedApiEndpoints = [
	'postappeal/detailAppeal',
	'postappeal/listAppeal',
	'postappeal/next',
	'appeal/detail',
	'appeal/list',
	'appeal/next',
	'appeal/tpl'
];

if (empty($_GET['url'] ?? null) && !in_array($_GET['url'], $allowedApiEndpoints, false)) {
	http_response_code(403);
	die();
};

require 'core.php';

$url = $_GET['url'];
unset($_GET['url']);
$res = cget('http://tieba.baidu.com/bawu2/' . $url . '?' . http_build_query($_GET), COOKIE);
echo $res;
