<?php

$qUrl = strtolower($_SERVER['QUERY_STRING']);

if (strpos($qUrl, 'select') > 0 || strpos($qUrl, 'update') > 0 || strpos($qUrl, 'insert') > 0 ||
  strpos($qUrl, 'delete') > 0 || strpos($qUrl, '--') > 0 || strpos($qUrl, 'script') > 0 ||
  strpos($qUrl, 'drop') > 0 || strpos($qUrl, 'create') > 0 || strpos($qUrl, 'rename') > 0 ||
  strpos($qUrl, 'substring') > 0 || strpos($qUrl, 'limit') > 0 || strpos($qUrl, '(') > 0)
{
  header('Location: login.php?errNum=72');
  exit();
}

$connection_i = mysqli_connect('127.0.0.1', $dbUser, $dbPwd, $dbName);
mysqli_set_charset($connection_i, 'utf8');
