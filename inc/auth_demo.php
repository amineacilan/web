<?php

if (($session_email == 'demo') && (!isset($demoAuth) || !$demoAuth))
{
  echo '<!DOCTYPE html><html><head><title>' . $config_title . '</title><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head>';

  header('Location: /unAuthorized.php');
}