<?php

/**
 * Author VICZONE
 * Copyright 2015
 * Website http://vicz.cn/
 */

//0.12新core
 
require 'config.php';

function cget($url,$cookie)
{
	$ch=curl_init($url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
		'Accept-Language: zh-CN,zh;q=0.9',
		'Cache-Control: no-cache',
		'Connection: keep-alive',
		'Referer: https://tieba.baidu.com/f?ie=utf-8&kw=' . urlencode(KW_RAW),
		'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36'
	));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	$get_url = curl_exec($ch);
	curl_close($ch);
	if(!$get_url) return 'err';
	return $get_url;
}

function swh($res)
{
	// 防止当bduss账号担任多个吧吧务时可通过手写url querystring访问指定贴吧以外贴吧的后台
	if($res==='err' || !empty($_GET['word']) && ($_GET['word'] === KW_RAW || $_GET['word'] === KW_GBK)) return 'COOKIE失效或无权限';
	$res = iconv('GBK', 'UTF-8', $res);

	$res=str_replace(
		'<head>',
		'<head><style>
			.user_info * { color: white; }
			.pic_list li { height: auto !important; }
			.pic_list img { height: 100px; }
		</style>',
		$res
	);
	$res=preg_replace('/<div class="user_info">(.*)<\/div><nav/',
		'<div class="user_info">
			<a href="./">
				<h2>VTOP 0.14</h2>
				<p>贴吧公开后台<br />所在吧：' . KW . '吧</p>
			</a>
			<p>
				<a href="http://vicz.cn">Powered By VICZONE-&gt;BFE</a><br />
				2015：原作者<a href="https://tieba.baidu.com/home/main/?un=%E8%93%9D%E8%89%B2%E7%81%AB%E7%84%B0E">贴吧@蓝色火焰E</a><br />
				2021：<a href="http://sst.st">SS\'S TRACE</a><br />
				<a href="https://github.com/n0099/vtop">本修改版源码 @ GitHub</a><br />
				<a href="https://n0099.net">n0099 四叶重工</a>
			</p>
		</div><nav', $res);

	// 隐藏删帖日志页的帖子内容
	if (HIDE_DELETED_POST_CONTENT) {
		$res=preg_replace(
			'/<div class="post_text">(.*?)<\/div>/',
			'<div class="post_text">抱歉，根据相关吧规和政策，帖子内容暂不公开</div>',
			$res
		);
	}

	$res=preg_replace_callback(
		'/<a href="\/bawu2\/platform\/(.*?)\?word=.*?"/',
		function ($matches){return "<a href=\"/bawu2/platform/$matches[1]" . (URL_REWRITE_ENABLED ? '"' : '.php"');},
		$res
	);

	$res=str_replace('/bawu2/platform/','./',$res);
	// https资源url自适应
	$res=str_replace('http://tb1.bdstatic.com','//tb1.bdstatic.com',$res);
	$res=str_replace('http://tb2.bdstatic.com','//tb2.bdstatic.com',$res);
	$res=str_replace('//tb1.bdstatic.com','https://tb1.bdstatic.com',$res);
	$res=str_replace('//tb2.bdstatic.com','https://tb2.bdstatic.com',$res);
	$res=str_replace('src="/','src="https://tieba.baidu.com/',$res);
	$res=str_replace('href="/','href="https://tieba.baidu.com/',$res);
	$res=str_replace('<img src="/','<img src="https://tieba.baidu.com/',$res);
	$res=str_replace('http://passport.baidu.com','https://passport.baidu.com',$res);

	// 将删帖日志页中位于 article.post_wrapper > div.post_content > div.post_media > ul.pic_list > li > a > img 下的帖子正文图片的lazyload加载图片url提取出来
	$res=preg_replace_callback(
		'/<li><a target="_blank" href="(.*?)"><img(.*?)src=".*?".*?original=".*?"/',
		function ($matches){return "<li><a target=\"_blank\" href=\"$matches[1]\"><img$matches[2]src=\"$matches[1]\"";},
		$res
	);

	if (OPENPIC) { // 选择性反代用户头像portrait图片域tb.himg.baidu.com
		$res=preg_replace_callback(
			'/<img(.*?)src=(\'|")(http(s|):\/\/(tb\.himg\.baidu\.com)\/.*?)(\'|")/',
			function ($matches){return "<img$matches[1]src=\"picgetter.php?url=$matches[3]\"";},
			$res
		);
	}
	// tb.himg.baidu.com之外的贴吧图片域都可以无referer访问所以不需要反代
	$res=str_replace('<img', '<img referrerpolicy="no-referrer"', $res);

	header("Content-Type: text/html; charset=GBK");
	return iconv('UTF-8', 'GBK', $res);
}



function hide($res)
{
	if(!HIDE) return $res;
	$res=preg_replace('/<a href="#" class="ui_text_normal">[^<]+<\/a>/', '<span class="ui_text_normal"><strong>Hidden</strong></span>', $res);
	return $res;
}
