<?php

ob_start();
session_start();
$prevPageName = getParamUrl('pageName', 'SESSION', '');
$_SESSION['pageName'] = $pageName;
$errNum = 3;
$auth_level = 2;

if (array_key_exists('ses', $_COOKIE))
{
  $sessionId = $_COOKIE['ses'];
  $result = mysql_query('SELECT email,date_last_trx,type,user_id FROM session WHERE status=1 AND session_id=' . "'$sessionId'", $connection);

  if ($result && ($row = mysql_fetch_assoc($result)))
  {
    $session_type = $row['type'];
    $session_user_id = $row['user_id'];
    $session_email = $row['email'];
    $date_last_trx = $row['date_last_trx'];
    $isNotInSession = ((strtotime('now') - strtotime($date_last_trx)) > 2592000); //60 * 60 * 24 * 30 (30 gün)
  }

  $sql = "SELECT status FROM user WHERE id=$session_user_id AND email='$session_email'";
  $isNotActiveUser = (($session_type != 'admin') && ($result = mysql_query($sql, $connection)) && (mysql_result($result, 0) == 0));
  $errNum = 0;

  if ((($pageName == 'admin') && ($session_type != 'admin')) ||
    (($session_type == 'normal') && (($pageName == 'user' || $pageName == 'userCommDeviceAuthSettings' || $pageName == 'userDeviceAuthSettings' || $pageName == 'userGroupSettings'))))
  {
    $errNum = 2;
  }
  else if ($isNotActiveUser || $isNotInSession)
  {
    $errNum = 3;
  }
}

if ($errNum != 0)
{
  if ($errNum == 2)
  {
    $host = $_SERVER['HTTP_HOST'];
    header("Location: http://{$host}/unAuthorized.php");
    ob_end_flush();
    exit();
  }

  $prevPageUrl = $_SERVER['REQUEST_URI'];
  $host = $_SERVER['HTTP_HOST'];
  header("Location: http://{$host}/login.php?errNum={$errNum}&prevPageUrl={$prevPageUrl}");
  ob_end_flush();
  exit();
}

mysql_query('UPDATE session SET date_last_trx=NOW() WHERE session_id=' . "'$sessionId'", $connection);
logTransaction($session_email, $sessionId, $pageName, $session_user_id, $session_type, $connection);


$real_session_type = $real_session_email = '';

if ($session_type == 'admin')
{
  $useFunctionsJs = true;
  $virtualUserId = getParamUrl('virtualUserId', 'SESSION', '');

  if (($virtualUserId !== '') && ($result = mysql_query('SELECT type,email FROM user WHERE id=' . $virtualUserId, $connection)) && ($row = mysql_fetch_assoc($result)))
  {
    $real_session_type = $session_type;
    $real_session_email = $session_email;

    $session_type = $row['type'];
    $session_email = $row['email'];
    $session_user_id = $virtualUserId;
  }
}

if (($session_type != 'admin') && ($result = mysql_query('SELECT amount,auth_level, buildingPage, gasMeterPage, transformerPage, payment_alert_active FROM user WHERE email=' . "'$session_email'", $connection)) && ($row = mysql_fetch_assoc($result)))
{
  $amount = $row['amount'];
  $auth_level = $row['auth_level'];
  $buildingPagePrm = $row['buildingPage'];
  $gasMeterPagePrm = $row['gasMeterPage'];
  $transformerPagePrm = $row['transformerPage'];
  $userPaymentAlertActive = $row['payment_alert_active'];
}


include('page_auth_check.php');
include('auth_demo.php');
