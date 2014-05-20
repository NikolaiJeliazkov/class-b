<?php

session_start();

// who's the site
$HTTP_HOST = $_SERVER["HTTP_X_FORWARDED_HOST"]? $_SERVER["HTTP_X_FORWARDED_HOST"] : $_SERVER["HTTP_HOST"];
$stmt = $db->prepare("select s.site_id, s.site_name, u.site_url from sites s inner join site_urls u on s.site_id=u.site_id where u.site_url = ?");
$stmt->execute(array($HTTP_HOST));
$currentSite = $stmt->fetch();
if ($currentSite === false) {
	header('HTTP/1.0 404 File not found');
	exit;
}
$_SESSION['currentSite'] = $currentSite;

//$uri = $_SERVER['REQUEST_URI'];

// set $CONFIG vars
$stmt = $db->prepare("select var_name, var_value from site_vars where site_id = ?");
$stmt->execute(array($currentSite['site_id']));
$vars = $stmt->fetchAll();
foreach($vars as $row) {
	$CONFIG[$row['var_name']] = $row['var_value'];
}
if (!isset($CONFIG['default_lang'])) {
	$CONFIG['default_lang'] = DEFAULT_LANG;
}
$stmt = $db->prepare("select l.lang_code, l.lang_name from site_languages sl inner join languages l on sl.lang_code=l.lang_code where sl.site_id = ?");
$stmt->execute(array($currentSite['site_id']));
$res = $stmt->fetchAll();
if ($res===false) {
	$CONFIG['default_lang'] = DEFAULT_LANG;
	$CONFIG['site_languages'] = array($CONFIG['default_lang']);
} else {
	foreach($res as $row) {
		$CONFIG['site_languages'][$row['lang_code']] = $row['lang_name'];
	}
}

//$SESS =& $_SESSION[$currentSite['site_id']];
if ($_SESSION['logged'] && isset($_GET['logout'])) {
	$_SESSION['logged'] = false;
} elseif (!$_SESSION['logged'] && isset($_POST['myusername'])) {
	$sql = "select zUserId, zUserName from zUsers where (site_id=?) and (lower(zUserName)=lower(?)) and (zUserPass=md5(?))";
	$stmt = $db->prepare($sql);
	$stmt->execute(array($currentSite['site_id'], $_POST['myusername'], $_POST['mypassword']));
	if ($row = $stmt->fetch()) {
		$_SESSION['logged'] = true;
		$_SESSION['userData'] = $row;
		header('Location: /__zmin/');
		exit;
	}
}
if (!$_SESSION['logged']) {
	header('Location: /__zmin/login.php');
	exit;
}
?>