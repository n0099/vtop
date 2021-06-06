<?php

/**
 * Author VICZONE
 * Copyright 2015
 * Website http://vicz.cn/
 */

//0.12新core
 
header("Content-type:text/html;charset=GBK");
 
require 'config.php';

function cget($url,$cookie)
{
	$ch=curl_init($url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64; rv:21.0) Gecko/20100101 Firefox/21.0','Connection:keep-alive','Referer:http://wapp.baidu.com/'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch,CURLOPT_COOKIE,$cookie);
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	$get_url = curl_exec($ch);
	curl_close($ch);
	if(!$get_url) return 'err';
	return $get_url;
}

function swh($res)
{
	if($res=='err') return 'COOKIE失效或无权限';

	$res=preg_replace_callback('/<head>/', function ($matches) { 
		return '<style>
			.user_info * { color: white; }
			.pic_list li { height: auto !important; }
			.pic_list img { height: 100px; }
		</style>';
	}, $res);
	$res=preg_replace_callback('/<div class="user_info">(.*)<\/div><nav/', function ($matches) { 
		return '<div class="user_info">
			<a href="./">
				<h2>VTOP 0.14</h2>
				<p>贴吧公开后台<br />所在吧：' . urldecode(KW) . '吧</p>
			</a>
			<p>
				<a href="http://vicz.cn">Powered By VICZONE-&gt;BFE</a><br />
				2015：原作者<a href="https://tieba.baidu.com/home/main/?un=%E8%93%9D%E8%89%B2%E7%81%AB%E7%84%B0E">贴吧@蓝色火焰E</a><br />
				2021：<a href="http://sst.st">SS\'S TRACE</a><br />
				<a href="https://github.com/n0099/vtop">本修改版源码 @ GitHub</a><br />
				<a href="https://n0099.net">n0099 四叶重工</a>
			</p>
		</div><nav';
	}, $res);

	// 根据学术豚要求隐藏帖子内容 by n0099
	if (HIDE_DELETED_POST_CONTENT) {
		$res=preg_replace_callback('/<div class="post_text">(.*?)<\/div>/', function ($matches) {
			return '<div class="post_text">抱歉，根据<a href="http://tieba.baidu.com/p/4825438125" target="_blank">相关吧规和政策</a>，帖子内容暂不公开</div>';
		}, $res);
	}
	
	$res=str_replace('/bawu2/platform/','./',$res);
	// https资源url自适应 by n0099
	$res=str_replace('http://tb1.bdstatic.com','//tb1.bdstatic.com',$res);
	$res=str_replace('http://tb2.bdstatic.com','//tb2.bdstatic.com',$res);
	$res=str_replace('//tb1.bdstatic.com','https://tb1.bdstatic.com',$res);
	$res=str_replace('//tb2.bdstatic.com','https://tb2.bdstatic.com',$res);
	$res=str_replace('src="/','src="https://tieba.baidu.com/',$res);
	$res=str_replace('href="/','href="https://tieba.baidu.com/',$res);
	$res=str_replace('<img src="/','<img src="https://tieba.baidu.com/',$res);
	$res=str_replace('http://passport.baidu.com','https://passport.baidu.com',$res);

	// 将删帖日志页中位于 article.post_wrapper > div.post_content > div.post_media > ul.pic_list > li > a > img 下的帖子正文图片的lazyload加载图片url提取出来 by n0099
	$res=preg_replace_callback('/<li><a target="_blank" href="(.*?)"><img(.*?)src=".*?".*?original=".*?"/',function ($matches){return "<li><a target=\"_blank\" href=\"$matches[1]\"><img$matches[2]src=\"$matches[1]\"";},$res);

	if (OPENPIC) { // 选择性反代用户头像portrait图片域tb.himg.baidu.com
		$res=preg_replace_callback('/<img(.*?)src=(\'|")(http(s|):\/\/(tb\.himg\.baidu\.com)\/.*?)(\'|")/',function ($matches){return "<img$matches[1]src=\"picgetter.php?url=$matches[3]\"";},$res);
	}
	// tb.himg.baidu.com之外的贴吧图片域都可以无referer访问所以不需要反代 by n0099
	$res=preg_replace_callback('/<img/',function ($matches){return '<img referrerpolicy="no-referrer"';},$res);

	return $res;
}



function hide($res)
{
	if(!HIDE) return $res;
	$res=preg_replace_callback('/<a href="#" class="ui_text_normal">[^<]+<\/a>/',function (){return '<span class="ui_text_normal"><strong>Hidden</strong></span>';},$res);
	return $res;
}
