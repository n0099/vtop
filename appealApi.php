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

if (empty($_GET['url'] ?? null) && !in_array($_GET['url'], $allowedApiEndpoints, true)) {
	http_response_code(403);
	die();
};

require 'core.php';

$url = $_GET['url'];
unset($_GET['url']);
$res = cget('http://tieba.baidu.com/bawu2/' . $url . '?' . http_build_query($_GET), COOKIE);
if ($res === 'err') {
	http_response_code(400);
	die();
}

if (HIDE) {
	$res = json_decode($res, true);
	$res['data'] = array_map(function ($appeals) {
		unset($appeals['op_uid']);
		unset($appeals['op_uname']);
		var_dump($appeals);
		return $appeals;
	}, $res['data']);
	echo json_encode($res);
} else {
	echo $res;
}
