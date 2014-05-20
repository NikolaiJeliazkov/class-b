<?php
require_once('config.php');

class DB extends PDO {
	function __construct() {
		parent::__construct(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::ATTR_PERSISTENT => true));
		$this->setAttribute(PDO::ATTR_ERRMODE, (DEBUG_MODE)?(PDO::ERRMODE_EXCEPTION):(PDO::ERRMODE_SILENT));
		$this->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
		$this->setAttribute(PDO::ATTR_STATEMENT_CLASS, array('DBStatement', array($this)));
	}
}

class DBStatement extends PDOStatement {
	public $dbh;
	protected function __construct($dbh) {
		$this->dbh = $dbh;
		$this->setFetchMode(PDO::FETCH_ASSOC);
	}
}

function appLog( $log_type = 'I', $log_text = null) {
	$db = new DB();
	$db->beginTransaction();
	$sql = "
INSERT INTO applog(
       log_type, log_text, phpsessid, http_host,
       request_uri, http_referer, remote_addr, http_user_agent, http_accept,
       http_accept_charset, http_accept_encoding, http_accept_language)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
";
	$sth = $db->prepare($sql);
	$bindParams = array(
		$log_type,
		$log_text,
		session_id(),
		$_SERVER["HTTP_X_FORWARDED_HOST"]? $_SERVER["HTTP_X_FORWARDED_HOST"] : $_SERVER["HTTP_HOST"],
		$_SERVER["REQUEST_URI"],
		$_SERVER["HTTP_REFERER"],
		$_SERVER["HTTP_X_FORWARDED_FOR"]? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"],
		$_SERVER["HTTP_USER_AGENT"],
		$_SERVER["HTTP_ACCEPT"],
		$_SERVER["HTTP_ACCEPT_CHARSET"],
		$_SERVER["HTTP_ACCEPT_ENCODING"],
		$_SERVER["HTTP_ACCEPT_LANGUAGE"]
	);
	if ($sth->execute($bindParams)) {
		$db->commit();
	} else {
		$db->rollback();
		d($db);
	}
}

function summarizeText($s, $toLenght = false) {
	global $CONFIG;
	$l = ($toLenght===false)?$CONFIG['summaryTextSize']:$toLenght;
	$s = eregi_replace('<p>(.*)<\/p>',"\\1\n",$s);
	$s = eregi_replace('<[a-z\/][^>]*>','',$s);
	$s = (strlen($s)>$l)?substr($s,0,strpos($s,' ',$l)+1)."...":$s;
	$s = str_replace(array("\r\n", "\n\n", "\r"),"\n",$s);
	$s = strip_tags($s);
	return ($s);
}

function parseSearchString($needle) {
	$stopWords = explode(',',$GLOBALS['searchStopWords']);
	$stopWords = array_map("trim", $stopWords);
	$query_to_parse = ' '.$needle;
	$query_to_parse = mb_ereg_replace('(\x00|\\\x00)','',$query_to_parse); // avoid null byte in query
	$query_to_parse = mb_ereg_replace('(\x1a|\\\x1a)','',$query_to_parse); // avoid sub byte in query
	$query_to_parse = mb_ereg_replace('\]','',$query_to_parse); // avoid ] in the query
	$query_to_parse = mb_ereg_replace('\[','',$query_to_parse); // avoid [ in the query
	$query_to_parse = mb_ereg_replace('>','',$query_to_parse); // avoid > in the query
	$query_to_parse = mb_ereg_replace('<','',$query_to_parse); // avoid < in the query
	$query_to_parse = mb_ereg_replace('\}','',$query_to_parse); // avoid } in the query
	$query_to_parse = mb_ereg_replace('\{','',$query_to_parse); // avoid { in the query
	$query_to_parse = mb_ereg_replace('\)','',$query_to_parse); // avoid ) in the query
	$query_to_parse = mb_ereg_replace('\(','',$query_to_parse); // avoid ( in the query
	$query_to_parse = mb_ereg_replace('\$','',$query_to_parse); // avoid $ in the query
	$query_to_parse = mb_ereg_replace('&[^ ]+','',$query_to_parse); // avoid &[chars] in the query
	$query_to_parse = mb_ereg_replace('[?]*','',$query_to_parse); // avoid ? in the query
	$query_to_parse = mb_strtolower($query_to_parse); //made all lowercase
	$query_to_parse = mb_ereg_replace('([+-])\s+((\"[^\"]+\")|(\w+))','\\1\\2',$query_to_parse);
	$query_to_parse = mb_ereg_replace('([+])((\"[^\"]+\")|(\w+))','\\2',$query_to_parse);
	$query_to_parse = mb_ereg_replace('(\s+)((\"[^\"]+\")|(\w+))',' +\\2',$query_to_parse);
	mb_ereg_search_init($query_to_parse);
	while ($regs = mb_ereg_search_regs('([+-])(\"([^\"]+)\"|(\w+))')) {
		$r['rule'] = $regs[1];
		$r['subject'] = ($regs[3])?$regs[3]:$regs[4];
		$rules[] = $r;
	}
	$r = array();
	foreach($rules as $rule) {
		if (!in_array($rule['subject'],$stopWords)) {
			$r[] = $rule;
		}
	}
	return $r;
}


function d($var,$bgcolor="#FFFFFF") {
	if (!DEBUG_MODE) {
		return;
	}
	$search = array(
		'INSERT INTO',
		'VALUES',
		'SELECT',
		'DELETE',
		'UPDATE',
		'SET',
		'ORDER BY',
		'DESC',
		'ASC',
		'WHERE',
	);
	$replace = array(
		'<strong style="color: #666666;">INSERT INTO</strong>',
		'<strong style="color: #666666;">VALUES</strong>',
		'<strong style="color: #666666;">SELECT</strong>',
		'<strong style="color: #666666;">DELETE</strong>',
		'<strong style="color: #666666;">UPDATE</strong>',
		'<strong style="color: #666666;">SET</strong>',
		'<strong style="color: #666666;">ORDER BY</strong>',
		'<strong style="color: #666666;">DESC</strong>',
		'<strong style="color: #666666;">ASC</strong>',
		'<strong style="color: #666666;">WHERE</strong>',
	);
	$var_type = gettype($var);
	$output = '<pre style="background-color: $bgcolor; font-family: \'Lucida Console\'; font-size: 11px; color: #0066CC"><strong>DEBUG: </strong><span style="color: #008000; font-family: \'Lucida Console\';">(' . $var_type . ')</span>';
	$callers=debug_backtrace();
	foreach ($callers as $caller) {
		echo "file:".$caller["file"]." ,";
		echo "line:".$caller["line"]." ,";
		echo "function:".$caller["function"]."(...)\n\r";
	}
	if ($var_type == 'string') {
		$output .= '<span style="color: #CC0000; font-family: \'Lucida Console\';">' . var_export($var, true) . '</span>';
	} else {
		$var_dump = var_export($var, true);
		$var_dump = preg_replace("/^Array|Object/", null, $var_dump);
		//$var_dump = preg_replace("/\[([^\]]*)\] =>/", "<span style=\"color: #000080; font-family: \'Lucida Console\';\">[\\1]</span> =>", $var_dump);
		$output .= $var_dump;
	}
	$output .= '</pre>';
	// Highlight Words
	$output = str_replace($search, $replace, $output);
	$output = preg_replace("/'([^']*)' =>/", "'<span style=\"color: #EA1515; font-family: \'Lucida Console\';\">\\1</span>' =>", $output);
	$output = preg_replace("/=> '([^']*)'/", "=> '<span style=\"color: #3A8F3A; font-family: \'Lucida Console\';\">\\1</span>'", $output);
	$output = str_replace('=> true', '=> <span style="color: #2A2AD4; font-family: \'Lucida Console\';">true</span>', $output);
	$output = str_replace('=> false', '=> <span style="color: #2A2AD4; font-family: \'Lucida Console\';">false</span>', $output);
	print $output;
}


?>