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
				<h1>VTOP��̨����������</h1>
				<p>������������ЧСʱ�� <input type="number" max="1000" name="hours" value="1"></p>
				<p>�������� <input name="adminpwd" placeholder="������config.php������"/></p>
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
			<p><strong>�����������</strong></p>
		</div>
	</body>
	<?php
}
else
{
	$h=$_POST['hours'];
	$s=gen_pwd($h);
	$t=date('Y��m��d��Hʱ',time()+$h*3600);
	echo <<<EOF
	<title>VTOP ADMIN</title>
	<body>
		<div style="margin-top: 30px; text-align:center;">
			<p>���������ɣ�<strong>$s</strong></p>
			<p>��Ч������$t</p>
		</div>
	</body>
EOF;
}