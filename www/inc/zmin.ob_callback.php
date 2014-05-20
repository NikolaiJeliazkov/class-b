<?php
function ob_callback($buffer) {
	global $title,$menuid,$zUserId,$_SESSION;
	print_r($zUserId);
	$ccc = basename($_SERVER['PHP_SELF'], ".php");
	$rc = ($_SESSION['currentSite']["site_id"]==3)?"<li><a href='/__zmin/rightColumnForm.php'>дясна колона</a></li>":"";
	$ret =<<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>{$title}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="/__zmin/css/reset.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="/__zmin/css/layout.css" type="text/css" media="screen" />
	<script type="text/javascript" src="/scripts/jquery-1.4.2.min.js"></script>
</head>
<body>
<div id="zmin_headWrapper">
	<div id="zmin_logo"></div>
	<div id="zmin_userinfo">{$zUserId}</div>
	<div id="zmin_mainmenu">
		<ul>
			<li><a href="/__zmin/index.php">съдържание</a></li>
			{$rc}
<!--
			<li><a href="/__zmin/urls.php">urls</a></li>
			<li><a href="/__zmin/sitewidgets.php">site widgets</a></li>
-->
			<li><a href="/__zmin/?logout=true">logout</a></li>
		</ul>
	</div>
	<h1>{$title}</h1>
</div>
{$buffer}
</body>
</html>
<script>
$("#zmin_mainmenu a[href='/__zmin/{$ccc}.php']").attr("class","current");
</script>
EOF;
//	$ret = $zUserId;
	return $ret;
}
?>