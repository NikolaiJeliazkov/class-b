<?php
function ob_callback($buffer) {
	global $title;
	$ret =<<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>{$title}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="/__zmin/css/reset.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="/__zmin/css/layout.css" type="text/css" media="screen" />
	<script type="text/javascript" src="/scripts/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="/__zmin/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="/__zmin/ckeditor/adapters/jquery.js"></script>
	<script type="text/javascript" src="/__zmin/ckfinder/ckfinder.js"></script>
	<script src="/__zmin/dhtmlx/codebase/dhtmlxcommon.js"></script>
	<script src="/__zmin/dhtmlx/codebase/dhtmlxcontainer.js"></script>
	<script src="/__zmin/dhtmlx/codebase/dhtmlxtree.js"></script>
	<script src="/__zmin/dhtmlx/codebase/dhtmlxdataprocessor.js"></script>
	<script src="/__zmin/dhtmlx/codebase/dhtmlxtoolbar.js"></script>
	<script src="/__zmin/dhtmlx/codebase/dhtmlxwindows.js"></script>
	<script src="/__zmin/dhtmlx/classMap.js"></script>
	<link rel="stylesheet" type="text/css" href="/__zmin/dhtmlx/codebase/dhtmlxtree.css"/>
	<link rel="stylesheet" type="text/css" href="/__zmin/dhtmlx/codebase/dhxtoolbar_dhx_black.css"/>
	<link rel="stylesheet" type="text/css" href="/__zmin/dhtmlx/codebase/dhtmlxwindows.css"/>
	<link rel="stylesheet" type="text/css" href="/__zmin/dhtmlx/codebase/dhtmlxwindows_dhx_skyblue.css"/>
</head>
<body style="padding-left:25px;">
{$buffer}
</body>
</html>
EOF;
	return $ret;
}
?>