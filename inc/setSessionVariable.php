<?php

include('func.php');

$varName = getParamUrl('varName', 'POST', '');
$varName2 = getParamUrl('varName2', 'POST', '');
$val = getParamUrl('val', 'POST', '');
$val2 = getParamUrl('val2', 'POST', '');

session_start();
$_SESSION[$varName] = ( ($val !== '') ? $val : 0 );

if ($varName2 !== '')
{
  $_SESSION[$varName2] = ( ($val2 != '') ? $val2 : 0 );
}