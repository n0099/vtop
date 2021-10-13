<?php
require 'core.php';

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
$fidFilename = './fid.' . KW_RAW . '.tmp';

if (file_exists($fidFilename)) {
    $fid = (int)file_get_contents($fidFilename);
} else {
    $fid = json_decode(cget('http://tieba.baidu.com/mg/f/getFrsData?kw=' . KW, COOKIE))->data->forum->id;
    file_put_contents($fidFilename, $fid);
}

if ((int)$_GET['forum_id'] !== $fid
    || (empty($_GET['url'] ?? null) && !in_array($_GET['url'], $allowedApiEndpoints, true))) {
    http_response_code(400);
    die();
}

$url = $_GET['url'];
unset($_GET['url']);
if (HIDE) {
    unset($_GET['op_uname']);
}
$res = cget('http://tieba.baidu.com/bawu2/' . $url . '?' . http_build_query($_GET), COOKIE);
if ($res === 'err') {
    http_response_code(502);
    exit();
}

$isHideDeletedPostContent = HIDE_DELETED_POST_CONTENT && $url === 'postappeal/detailAppeal';
if (HIDE
    || ($isHideDeletedPostContent)) {
    $res = json_decode($res, true);
    if (HIDE) {
        $hideOperators = function (&$v) use (&$hideOperators) {
            if (is_array($v)) {
                $idFieldsToBeHide = ['del_uid', 'op_uid'];
                // operate_man only appears in appealRecordList[0] of appeal/list endpoint as the operator who baned that user
                $usernameFieldsToBeHide = ['del_uname', 'op_uname', 'operate_man'];
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
    }
    if ($isHideDeletedPostContent) {
        $res['data']['content'] = '';
        $res['data']['post_img'] = $res['data']['post_vedio'] = $res['data']['post_audio'] = [];
    }
    $res = json_encode($res);
}

header('Content-Type: application/json');
echo $res;
