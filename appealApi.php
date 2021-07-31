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
    http_response_code(400);
    die();
};

require 'core.php';

$url = $_GET['url'];
unset($_GET['url']);
if (HIDE) {
    unset($_GET['op_uname']);
}
$res = cget('http://tieba.baidu.com/bawu2/' . $url . '?' . http_build_query($_GET), COOKIE);
if ($res === 'err') {
    http_response_code(502);
    die();
}

header('Content-Type: application/json');
if (HIDE) {
    $res = json_decode($res, true);
    $hideOperators = function (&$v) use (&$hideOperators) {
        if (is_array($v)) {
            $idFieldsToBeHide = ['del_uid', 'op_uid'];
            $usernameFieldsToBeHide = ['del_uname', 'op_uname', 'operate_man']; // operate_man only appears in appealRecordList[0] of appeal/list endpoint as the operator who baned that user
            array_walk($v, function (&$v, $k) use ($idFieldsToBeHide, $usernameFieldsToBeHide) {
                if (in_array($k, $idFieldsToBeHide, true)) {
                    $v = 0;
                }
                if (in_array($k, $usernameFieldsToBeHide, true)) {
                    $v = 'Hidden';
                }
            });
            array_walk($v, $hideOperators); // recursive
        }
    };
    array_walk($res, $hideOperators);
    echo json_encode($res);
} else {
    echo $res;
}
