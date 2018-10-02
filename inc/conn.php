<?php

//error_reporting(0);
//ini_set('error_reporting', E_ALL);
//error_reporting(E_ALL | E_STRICT);
//ini_set('display_errors',TRUE);

$qUrl = strtolower($_SERVER['QUERY_STRING']);

if (strpos($qUrl, 'select') > 0 || strpos($qUrl, 'update') > 0 || strpos($qUrl, 'insert') > 0 ||
  strpos($qUrl, 'delete') > 0 || strpos($qUrl, '--') > 0 || strpos($qUrl, 'script') > 0 ||
  strpos($qUrl, 'drop') > 0 || strpos($qUrl, 'create') > 0 || strpos($qUrl, 'rename') > 0 ||
  strpos($qUrl, 'substring') > 0 || strpos($qUrl, 'limit') > 0 || strpos($qUrl, '(') > 0)
{
  header('Location: login.php?errNum=72');
  exit();
}

$connection = mysql_connect('127.0.0.1', $dbUser, $dbPwd);
mysql_select_db($dbName, $connection);
mysql_set_charset('utf8', $connection);
