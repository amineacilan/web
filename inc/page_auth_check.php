<?php

//exit();

if ((isset($id_auth)) && ($session_type != 'admin'))
{

  if (($id_auth === '0') || ($id_auth === 0) || ($id_auth === '') || (($id_auth == 0) && ($pageName == 'deviceSettings' || $pageName == 'commDeviceSettings')))
  {
    $exit = true;
  }
  else
  {
    $sql = "SELECT id FROM user_device WHERE user_id= $session_user_id AND ";

    switch ($pageName) {
      case 'data':
      case 'manual_data':
      case 'instantValues':
      case 'instantData':
      case 'deviceAlarm':
      case 'bill':
      case 'graph':
      case 'heatMap':
      case 'report':
      case 'control':
      case 'harmonics':
      case 'load_profile':
      case 'userDeviceAuthSettings':
      case 'createAction':
      case 'analogSensorDetails':
      case 'analogSensorSettings':
      case 'temperatureSensor':
      case 'temperatureDetails':
      case 'maintenanceList':
      case 'generatorControl':
      case 'generatorDetail':
      case 'generatorFileUploaded':
      case 'generatorReport':
      case 'generatorSettings':
      case 'flowMeters':
      case 'FlowMeterSettings':
        $sql .= " device_id='$id_auth'";
        break;
      case 'deviceSettings':
        $sql .= " device_id=(SELECT measuring_device_id FROM measuring_device_settings WHERE id='$id_auth')";
        break;
      case 'modemAlarm':
      case 'signalGraph':
        $sql = "SELECT id FROM user_comm_device WHERE  user_id= $session_user_id AND comm_device_id='$id_auth' AND auth_level=100";
        break;
      case 'userCommDeviceAuthSettings':
      case 'commDeviceSettings':
        $sql = "SELECT id FROM user_comm_device WHERE  user_id= $session_user_id AND comm_device_id=(SELECT comm_device_id FROM comm_device_settings WHERE id='$id_auth')  AND auth_level=100";
        break;
      default:
        $sql = 'asd';
    }
    $exit = (($sql != '') && ($result = mysql_query($sql, $connection)) && (mysql_num_rows($result) == 0));
  }
//  echo $sql;
//  exit();
  if ($exit)
  {
    if ($pageName != 'createAction')
    {
      echo '<!DOCTYPE html><html><head><title>' . $config_title . '</title><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head>';
    }

    header('Location: /unAuthorized.php');
//    echo 'YETKİ YOK';
    exit;
  }
}