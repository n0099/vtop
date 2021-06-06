<?php

/*
VTOP 0.12
Powered By VICZONE->BFE
*/

require 'core.php';

if(!@$_POST['hours']||!@$_POST['adminpwd'])
{
	?>
	<title>VTOP ADMIN</title>
	<body>
		<div style="margin-top: 30px; text-align:center;">
			<form method="post">
				<h1>VTOP后台密码生成器</h1>
				<p>请输入密码有效小时数 <input type="number" max="1000" name="hours" value="1"></p>
				<p>管理密码 <input name="adminpwd" placeholder="密码在config.php中设置"/></p>
				<p><input type="submit"/></p>
			</form>
		</div>
	</body>
	<?php
	exit;
}
elseif($_POST['adminpwd']!=ADMINPWD)
{	
	?>
	<title>VTOP ADMIN</title>
	<body>
		<div style="margin-top: 30px; text-align:center;">
			<p><strong>管理密码错误</strong></p>
		</div>
	</body>
	<?php
}
else
{
	$h=$_POST['hours'];
	$s=gen_pwd($h);
	$t=date('Y年m月d日H时',time()+$h*3600);
	echo <<<EOF
	<title>VTOP ADMIN</title>
	<body>
		<div style="margin-top: 30px; text-align:center;">
			<p>密码已生成：<strong>$s</strong></p>
			<p>有效期至：$t</p>
		</div>
	</body>
EOF;
}