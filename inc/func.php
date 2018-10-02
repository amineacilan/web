<?php

function getParamUrl($paramName, $httpMethod, $defaultVal)
{
  switch ($httpMethod) {
    case 'POST':
      return array_key_exists($paramName, $_POST) ? $_POST[$paramName] : $defaultVal;
    case 'GET':
      return array_key_exists($paramName, $_GET) ? $_GET[$paramName] : $defaultVal;
    case 'SESSION':
      session_start();
      return array_key_exists($paramName, $_SESSION) ? $_SESSION[$paramName] : $defaultVal;
  }

  return $defaultVal;
}

function clearStrParam($param_Val, $mode)
{
  switch ($mode) {
    case 0:
      return str_replace(array('#39&;', '#34&;', "'", '"', '(', ')'), ' ', $param_Val);
    case 1:
      return str_replace(array('#39&;', '#34&;', "'", '"'), ' ', $param_Val);
    default:
      return $param_Val;
  }
}

function getUniqueId()
{
  return (rand(1000000, 9999999) . time());
}

function dateConvert($dateStr, $direction, $timeAdded)
{
  $dtArr = explode(' ', $dateStr);

  switch ($dtArr[0]) {
    case '':
    case '0000-00-00':
    case '00.00.0000':
      return '';
  }

  $timeStr = ($timeAdded == 1) ? (' ' . $dtArr[1]) : '';

  switch ($direction) {
    case 'dbToPage':
      return (implode('.', array_reverse(explode('-', $dtArr[0]))) . $timeStr);
    case 'pageToDb':
      return (implode('-', array_reverse(explode('.', $dtArr[0]))) . $timeStr);
    default:
      return $dateStr;
  }
}

function convertTrDate($dateStr)
{
  $enMonths = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December',
    'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec',
    'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
  $trMonths = array('Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık',
    'Oca', 'Şub', 'Mar', 'Nis', 'May', 'Haz', 'Tem', 'Ağu', 'Eyl', 'Eki', 'Kas', 'Ara',
    'Pazar', 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi', 'Paz', 'Pzt', 'Sal', 'Çar', 'Per', 'Cum', 'Cmt');
  return str_replace($enMonths, $trMonths, $dateStr);
}

function hourDiffInHours($date_record_pre, $date_record)
{
  return ((strtotime($date_record) - strtotime($date_record_pre)) / 3600);
}

function logTransaction($session_email, $session_id, $pageName, $session_user_id, $session_type, $connection)
{
  if ($pageName == "getUserInterfaceValues" || $pageName == "getIO" || $pageName == "")
  {
    return;
  }

  $ip = $_SERVER ['REMOTE_ADDR'];
  $url = $_SERVER['PHP_SELF'];
  $ref = (array_key_exists('HTTP_REFERER', $_SERVER) ? ($_SERVER['HTTP_REFERER']) : '');

  mysql_unbuffered_query('INSERT DELAYED INTO log (ip, page_name, email, page_url, session_id, user_id, type, referer) ' .
    " VALUES ('$ip', '$pageName', '$session_email', '$url', '$session_id', $session_user_id, '$session_type', '$ref')", $connection);
}

function sayacCheckFormat($str)
{
  if (strlen($str) != 11) :
    return false;
  endif;

  $firstCh = strtoupper(substr($str, 0, 3));
  $secondCh = substr($str, 3, 8);

  $alphabet = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
  $numbers = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

  for ($i = 0; $i < 3; $i++) {
    if (!in_array($firstCh[$i], $alphabet)) :
      return false;
    endif;
  }

  for ($i = 0; $i < 8; $i++) {
    if (!in_array($secondCh[$i], $numbers)) :
      return false;
    endif;
  }

  return true;
}

function escapeJsonString($value)
{
  $escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c", "'");
  $replacements = array("\\\\", "\\/", "\"", "\\n", "\\r", "\\t", "\\f", "\\b", "\'");
  $result = str_replace($escapers, $replacements, $value);
  return $result;
}

function formatSwVersion($swVer)
{
  switch (substr($swVer, -1)) {
    case 'S':
      return $swVer . ' (Sayaç Okuma)';
    case 'T':
      return $swVer . ' (Röle Kontrol)';
    default:
      return $swVer;
  }
}

function getAuthLevel()
{
  global $session_type, $session_email, $connection;

  if ($session_type === 'admin')
  {
    return 2;
  }

  if (($result = mysql_query('SELECT auth_level FROM user WHERE email=' . "'$session_email'", $connection)) && ($row = mysql_fetch_assoc($result)))
  {
    return $row['auth_level'];
  }

  return 0;
}

function getTimeStr($begin_date, $end_date)
{
  $day = floor((strtotime($end_date) - strtotime($begin_date)) / (24 * 60 * 60));
  $hour = floor((strtotime($end_date) - strtotime($begin_date)) / (60 * 60));
  $minute = floor(((strtotime($end_date) - strtotime($begin_date)) / 60) % 60);
  $time = '';

  if ($day < 1)
  {
    if ($hour > 0)
    {
      $time .= $hour . ' saat ';
    }

    if ($minute > 0)
    {
      $time .= $minute . ' dakika ';
    }
  }
  else
  {
    $time .= $day . ' gün ';

    if ($hour - ($day * 24) > 0)
    {
      $time .= $hour - ($day * 24) . ' saat ';
    }
  }

  return $time;
}

function getMeterBrand($measuring_device_id)
{
  $meterBrands = array(
    'MSY' => 'Makel',
    'AEL' => 'Köhler',
    'KHL' => 'Köhler',
    'VIK' => 'Viko',
    'ELM' => 'Elektromed',
    'LUN' => 'Luna',
    'ELS' => 'Elster',
    'ABB' => 'Elster',
    'ACE' => 'Itron',
    'LGZ' => 'Landis',
    'ORB' => 'Orbis',
    'BSE' => 'Kaan'
  );

  if (isset($meterBrands[substr($measuring_device_id, 0, 3)]))
  {
    $brand = $meterBrands[substr($measuring_device_id, 0, 3)];
  }
  else
  {
    $brand = substr($measuring_device_id, 0, 3);
  }

  return $brand;
}

function insertDefaultAlarm($deviceId)
{
  global $connection;
  global $smsSupport;

  $deviceQuery = "SELECT mds.comm_device_id, dt.device_category, dt.supported_alarm_types FROM measuring_device_settings AS mds "
    . "JOIN device_type AS dt ON dt.device_type_code=mds.device_type "
    . "WHERE mds.measuring_device_id='$deviceId'";
  $deviceResult = mysql_query($deviceQuery, $connection);

  if ($deviceRow = mysql_fetch_array($deviceResult))
  {
    $modemId = $deviceRow["comm_device_id"];
    $deviceCategory = $deviceRow["device_category"];

    if ($smsSupport)
    {
      $supportedAlarmTypes = str_replace("-", ",", $deviceRow["supported_alarm_types"]);

      $defaultAlarmQuery = "SELECT * FROM alarm_type WHERE is_sms_alarm=1 AND id IN ($supportedAlarmTypes)";
      $defaultAlarmResult = mysql_query($defaultAlarmQuery, $connection);

      while ($defaultAlarmRow = mysql_fetch_array($defaultAlarmResult)) {
        $tableName = $defaultAlarmRow["table_name"];
        $alarmType = $defaultAlarmRow["id"];
        $alarmName = $defaultAlarmRow["name"];

        $insertQuery = "INSERT INTO $tableName SET device_id='$deviceId', type_id=$alarmType, name='$alarmName (Varsayılan)'";
        mysql_unbuffered_query($insertQuery);
      }
    }
    /* cihaz yetkisi verdiğinde de aynı fonk çalışıyor şimdilik.
     * modeme yeki olmasa da modeme bağlı cihazların tüm alarm tanımları oluşturuluyor
     * fakat sistem tarafından cihaz yetkisine bakıldığı için tanımlar anlamsız olacak .daha sonra iyileştirilebilir
     * auth_level koşuluna göre tümü yada yetkili olanların tanımı oluşturulacak şekilde ayarlama yapmak gerekiyor */

    $authQuery = "SELECT user_id FROM user_comm_device WHERE comm_device_id='$modemId'";
    $authResult = mysql_query($authQuery, $connection);

    while ($authRow = mysql_fetch_array($authResult)) {
      $userId = $authRow["user_id"];
      insertDefaultUserAlarm($userId, $deviceId, $deviceCategory);
    }
  }
}

function insertModemDefaultAlarm($userId, $modemId)
{
  global $connection;
  insertDefaultUserAlarm($userId, $modemId, 0);
  $authQuery = "SELECT mds.measuring_device_id, device_type.device_category FROM measuring_device_settings AS mds "
    . "JOIN device_type ON device_type.device_type_code=mds.device_type WHERE mds.comm_device_id='$modemId'";
  $authResult = mysql_query($authQuery, $connection);

  while ($authRow = mysql_fetch_array($authResult)) {
    $deviceId = $authRow["measuring_device_id"];
    $deviceCategory = $authRow["device_category"];
    insertDefaultUserAlarm($userId, $deviceId, $deviceCategory);
  }
}

function deleteModemAlarm($userId, $modemId)
{
  global $connection;

  deleteUserAlarm($userId, false, $modemId);
  $authQuery = "SELECT mds.measuring_device_id, device_type.device_category FROM measuring_device_settings AS mds "
    . "JOIN device_type ON device_type.device_type_code=mds.device_type WHERE mds.comm_device_id='$modemId'";
  $authResult = mysql_query($authQuery, $connection);

  while ($authRow = mysql_fetch_array($authResult)) {
    $deviceId = $authRow["measuring_device_id"];
    $deviceCategory = $authRow["device_category"];
    deleteUserAlarm($userId, false, $deviceId);
  }
}

function insertDefaultUserAlarm($userId, $deviceId, $deviceCategory)
{
  global $connection;
  $parameterArr = array();
  $sCategoryArr = array();

  $parameterQuery = "SELECT alarm_type, parameter FROM alarm_user_parameter WHERE user_id=$userId";
  $parameterResult = mysql_query($parameterQuery, $connection);

  while ($parameterRow = mysql_fetch_array($parameterResult)) {
    $parameterArr[$parameterRow["alarm_type"]] = explode("|", $parameterRow["parameter"]);
  }

  $alarmQuery = "SELECT * FROM alarm_type";
  $alarmResult = mysql_query($alarmQuery, $connection);

  while ($alarmRow = mysql_fetch_array($alarmResult)) {
    $sCategoryArr[$alarmRow["id"]] = explode("-", $alarmRow["category_support"]);
  }

  //////////////////   REAKTİF ALARM    \\\\\\\\\\\\\\\\\\\
  if (in_array($deviceCategory, $sCategoryArr[1]))
  {
    if (!mysql_fetch_array(mysql_query("SELECT * FROM alarm_reactive WHERE user_id=$userId AND device_id=$deviceId LIMIT 1", $connection)))
    {
      $insertQuery = "INSERT INTO alarm_reactive SET user_id=$userId, device_id='$deviceId', name='Reaktif Limit Aşımı Alarmı (Varsayılan)'";

      foreach ($parameterArr[1] as $parameter) {
        $tempArr = explode(":", $parameter);
        $key = $tempArr[0];
        $value = $tempArr[1];
        $insertQuery .= ", $key=$value";
      }
      mysql_unbuffered_query($insertQuery);
    }
  }
  ///////////////// REAKTİF ALARM BİTTİ \\\\\\\\\\\\\\\\\\\
  //////////////////   HABERLEŞME ALARMI   \\\\\\\\\\\\\\\\\\\
  if (in_array($deviceCategory, $sCategoryArr[3]))
  {
    if (!mysql_fetch_array(mysql_query("SELECT * FROM alarm_communication WHERE user_id=$userId AND device_id=$deviceId LIMIT 1", $connection)))
    {
      $insertQuery = "INSERT INTO alarm_communication SET user_id=$userId, device_id='$deviceId', name='Haberleşme Hatası Alarmı (Varsayılan)'";

      foreach ($parameterArr[3] as $parameter) {
        $tempArr = explode(":", $parameter);
        $key = $tempArr[0];
        $value = $tempArr[1];
        $insertQuery .= ", $key=$value";
      }
      mysql_unbuffered_query($insertQuery);
    }
  }
  ///////////////// HABERLEŞME ALARMI BİTTİ \\\\\\\\\\\\\\\\\\\
  //////////////////   ENERJİ KESİNTİSİ ALARMI   \\\\\\\\\\\\\\\\\\\
  if (in_array($deviceCategory, $sCategoryArr[5]))
  {
    if (!mysql_fetch_array(mysql_query("SELECT * FROM alarm_poweroff WHERE user_id=$userId AND device_id=$deviceId LIMIT 1", $connection)))
    {
      $support = true;

      if ($deviceCategory == 0)
      {
        $sql = "SELECT model_version, communication_type FROM comm_device_settings WHERE comm_device_id='$deviceId'";
        $result = mysql_query($sql, $connection);

        if ($row = mysql_fetch_array($result))
        {
          if ($row["communication_type"] != 'GPRS' || ($row["model_version"] == 'GPRS 1.0' || $row["model_version"] == 'GPRS 1.1'))
          {
            $support = false;
          }
        }
      }

      if ($support == true)
      {
        $insertQuery = "INSERT INTO alarm_poweroff SET user_id=$userId, device_id='$deviceId', name='Enerji Kesintisi Alarmı (Varsayılan)'";

        foreach ($parameterArr[5] as $parameter) {
          $tempArr = explode(":", $parameter);
          $key = $tempArr[0];
          $value = $tempArr[1];
          $insertQuery .= ", $key=$value";
        }
        mysql_unbuffered_query($insertQuery);
      }
    }
  }
  /////////////////  ENERJİ KESİNTİSİ ALARMI BİTTİ \\\\\\\\\\\\\\\\\\\
  //////////////////   GİRİŞ DEĞİŞİMLERİ ALARMI   \\\\\\\\\\\\\\\\\\\
  if (in_array($deviceCategory, $sCategoryArr[7]))
  {
    if (!mysql_fetch_array(mysql_query("SELECT * FROM alarm_inputchange WHERE user_id=$userId AND device_id=$deviceId LIMIT 1", $connection)))
    {
      $support = true;

      if ($deviceCategory == 0)
      {
        $sql = "SELECT model_version, communication_type FROM comm_device_settings WHERE comm_device_id='$deviceId'";
        $result = mysql_query($sql, $connection);

        if ($row = mysql_fetch_array($result))
        {
          if ($row["communication_type"] != 'GPRS' || ($row["model_version"] == 'GPRS 1.0' || $row["model_version"] == 'GPRS 1.1'))
          {
            $support = false;
          }
        }
      }

      if ($support == true)
      {
        $insertQuery = "INSERT INTO alarm_inputchange SET user_id=$userId, device_id='$deviceId', name='Giriş Değişimleri Alarmı (Varsayılan)'";

        foreach ($parameterArr[7] as $parameter) {
          $tempArr = explode(":", $parameter);
          $key = $tempArr[0];
          $value = $tempArr[1];
          $insertQuery .= ", $key=$value";
        }
        mysql_unbuffered_query($insertQuery);
      }
    }
  }
  /////////////////  GİRİŞ DEĞİŞİMLERİ ALARMI BİTTİ \\\\\\\\\\\\\\\\\\\
  //////////////////   GERİLİM ALARMI   \\\\\\\\\\\\\\\\\\\
  if (in_array($deviceCategory, $sCategoryArr[9]))
  {
    if (!mysql_fetch_array(mysql_query("SELECT * FROM alarm_voltage WHERE user_id=$userId AND device_id=$deviceId LIMIT 1", $connection)))
    {
      $voltageType = 0;
      $defaultHighLimit = 0;
      $defaultLowLimit = 0;
      $votageTypeArray = array(
        1 => array("ag220_high_limit", "ag220_low_limit"),
        2 => array("og_high_limit", "og_low_limit"),
        3 => array("oggd_high_limit", "oggd_low_limit"),
        4 => array("ag300_high_limit", "ag300_low_limit"));

      if ($deviceCategory == 1)
      {//sayaç ise
        $deviceQuery = "SELECT voltage_type,device_type FROM measuring_device_settings WHERE measuring_device_id = '$deviceId' AND has_instant_values_data=1";
      }
      elseif ($deviceCategory == 2 || $deviceCategory == 3)
      {//röle veya analizör ise
        $deviceQuery = "SELECT voltage_type,device_type FROM measuring_device_settings WHERE measuring_device_id = '$deviceId'";
      }

      $deviceResult = mysql_query($deviceQuery, $connection);

      if ($deviceRow = mysql_fetch_array($deviceResult))
      {
        $voltageType = $deviceRow["voltage_type"];
        $deviceType = $deviceRow["device_type"];
        $status = 0;
        $emailPeriod = 24;

        /* cihaz tipi alarm tipini destekliyor mu */
        $deviceTypeSupportAlarmSql = "SELECT supported_alarm_types FROM device_type WHERE device_type_code='$deviceType'";
        $supported_alarm_types_result = mysql_query($deviceTypeSupportAlarmSql, $connection);

        if ($supportedAlarmRow = mysql_fetch_array($supported_alarm_types_result))
        {
          $supported_alarm_types_str = $supportedAlarmRow["supported_alarm_types"];
          $supported_alarm_types_arr = explode("-", $supported_alarm_types_str);
        }

        if (in_array(9, $supported_alarm_types_arr))
        {//cihaz tipinin desteklediği alarm tiplerinde 9. alarm varsa
          foreach ($parameterArr[9] as $parameter) {
            $tempArr = explode(":", $parameter);
            $key = $tempArr[0];
            $value = $tempArr[1];
            $defaultHighLimit = ($key == $votageTypeArray[$voltageType][0]) ? $value : $defaultHighLimit;
            $defaultLowLimit = ($key == $votageTypeArray[$voltageType][1]) ? $value : $defaultLowLimit;
            $status = ($key == "status") ? $value : $status;
            $emailPeriod = ($key == "email_period") ? $value : $emailPeriod;
          }

          $insertQuery = "INSERT INTO alarm_voltage SET user_id=$userId, device_id='$deviceId', name='Gerilim Alarmı (Varsayılan)', high_limit=$defaultHighLimit, low_limit=$defaultLowLimit, email_period=$emailPeriod, status=$status";
          mysql_unbuffered_query($insertQuery);
        }
      }
    }
  }
  /////////////////  GERİLİM ALARMI BİTTİ \\\\\\\\\\\\\\\\\\\
  //////////////////   DENGESİZ AKIM ALARMI   \\\\\\\\\\\\\\\\\\\
  if (in_array($deviceCategory, $sCategoryArr[10]))
  {
    if (!mysql_fetch_array(mysql_query("SELECT * FROM alarm_currentunstable WHERE user_id=$userId AND device_id=$deviceId LIMIT 1", $connection)))
    {
      if ($deviceCategory == 1)
      {//sayaç ise
        $deviceQuery = "SELECT device_type FROM measuring_device_settings WHERE measuring_device_id = '$deviceId' AND has_instant_values_data=1";
      }
      elseif ($deviceCategory == 2 || $deviceCategory == 3)
      {//röle veya analizör ise
        $deviceQuery = "SELECT device_type FROM measuring_device_settings WHERE measuring_device_id = '$deviceId'";
      }

      $deviceResult = mysql_query($deviceQuery, $connection);

      if ($deviceRow = mysql_fetch_array($deviceResult))
      {
        $deviceType = $deviceRow["device_type"];

        /* cihaz tipi alarm tipini destekliyor mu */
        $deviceTypeSupportAlarmSql = "SELECT supported_alarm_types FROM device_type WHERE device_type_code='$deviceType'";
        $supported_alarm_types_result = mysql_query($deviceTypeSupportAlarmSql, $connection);

        if ($supportedAlarmRow = mysql_fetch_array($supported_alarm_types_result))
        {
          $supported_alarm_types_str = $supportedAlarmRow["supported_alarm_types"];
          $supported_alarm_types_arr = explode("-", $supported_alarm_types_str);
        }

        if (in_array(10, $supported_alarm_types_arr))
        {//cihaz tipinin desteklediği alarm tiplerinde 10. alarm varsa
          $insertQuery = "INSERT INTO alarm_currentunstable SET user_id=$userId, device_id='$deviceId', name='Dengesiz Akım Alarmı (Varsayılan)'";

          foreach ($parameterArr[10] as $parameter) {
            $tempArr = explode(":", $parameter);
            $key = $tempArr[0];
            $value = $tempArr[1];
            $insertQuery .= ", $key=$value";
          }
          mysql_unbuffered_query($insertQuery);
        }
      }
    }
  }
  /////////////////  DENGESİZ AKIM ALARMI BİTTİ \\\\\\\\\\\\\\\\\\\
  //////////////////   5A DEN YUKSEK AKIM ALARMI   \\\\\\\\\\\\\\\\\\\
  if (in_array($deviceCategory, $sCategoryArr[11]))
  {
    if (!mysql_fetch_array(mysql_query("SELECT * FROM alarm_current5a WHERE user_id=$userId AND device_id=$deviceId LIMIT 1", $connection)))
    {
      $deviceQuery = "SELECT * FROM measuring_device_settings WHERE measuring_device_id = '$deviceId' AND has_instant_values_data=1";
      $deviceResult = mysql_query($deviceQuery, $connection);

      if (mysql_num_rows($deviceResult) > 0)
      {
        $insertQuery = "INSERT INTO alarm_current5a SET user_id=$userId, device_id='$deviceId', name='5 A\'dan Yüksek Akım Alarmı (Varsayılan)'";

        foreach ($parameterArr[11] as $parameter) {
          $tempArr = explode(":", $parameter);
          $key = $tempArr[0];
          $value = $tempArr[1];
          $insertQuery .= ", $key=$value";
        }
        mysql_unbuffered_query($insertQuery);
      }
    }
  }
  /////////////////  5A DEN YUKSEK AKIM ALARMI BİTTİ \\\\\\\\\\\\\\\\\\\
  //////////////////  JENERATÖR ENERJİ KESİNTİSİ ALARMI   \\\\\\\\\\\\\\\\\\\
  if (in_array($deviceCategory, $sCategoryArr[21]))
  {
    if (!mysql_fetch_array(mysql_query("SELECT * FROM alarm_poweroff_genset WHERE user_id=$userId AND device_id=$deviceId LIMIT 1", $connection)))
    {
      $insertQuery = "INSERT INTO alarm_poweroff_genset SET user_id=$userId, device_id='$deviceId', name='Enerji Kesintisi Alarmı (Jeneratör)'";

//                foreach ($parameterArr[21] as $parameter) {
//                    $tempArr = explode(":", $parameter);
//                    $key = $tempArr[0];
//                    $value = $tempArr[1];
//                    $insertQuery .= ", $key=$value";
//                }
      mysql_unbuffered_query($insertQuery);
    }
  }
  /////////////////  JENERATÖR ENERJİ KESİNTİSİ ALARMI BİTTİ \\\\\\\\\\\\\\\\\\\
  //////////////////  JENERATÖR YAKIT SEVİYESİ ALARMI   \\\\\\\\\\\\\\\\\\\
  if (in_array($deviceCategory, $sCategoryArr[21]))
  {
    if (!mysql_fetch_array(mysql_query("SELECT * FROM alarm_fuel_level WHERE user_id=$userId AND device_id=$deviceId LIMIT 1", $connection)))
    {
      $insertQuery = "INSERT INTO alarm_fuel_level SET user_id=$userId, device_id='$deviceId', name='Yakıt Seviyesi Alarmı (Varsayılan)'";

//                foreach ($parameterArr[21] as $parameter) {
//                    $tempArr = explode(":", $parameter);
//                    $key = $tempArr[0];
//                    $value = $tempArr[1];
//                    $insertQuery .= ", $key=$value";
//                }
      mysql_unbuffered_query($insertQuery);
    }
  }
  /////////////////  JENERATÖR YAKIT SEVİYESİ ALARMI BİTTİ \\\\\\\\\\\\\\\\\\\
  ////////////////////  JENERATÖR AKÜ GERİLİMİ ALARMI   \\\\\\\\\\\\\\\\\\\
  if (in_array($deviceCategory, $sCategoryArr[21]))
  {
    if (!mysql_fetch_array(mysql_query("SELECT * FROM alarm_battery_voltage WHERE user_id=$userId AND device_id=$deviceId LIMIT 1", $connection)))
    {
      $insertQuery = "INSERT INTO alarm_battery_voltage SET user_id=$userId, device_id='$deviceId', name='Akü Gerilimi Alarmı (Varsayılan)'";

//                foreach ($parameterArr[21] as $parameter) {
//                    $tempArr = explode(":", $parameter);
//                    $key = $tempArr[0];
//                    $value = $tempArr[1];
//                    $insertQuery .= ", $key=$value";
//                }
      mysql_unbuffered_query($insertQuery);
    }
  }
  /////////////////  JENERATÖR AKÜ GERİLİMİ ALARMI BİTTİ \\\\\\\\\\\\\\\\\\\
  // ////////////////////  JENERATÖR MANUEL MOD ALARMI   \\\\\\\\\\\\\\\\\\\
  if (in_array($deviceCategory, $sCategoryArr[21]))
  {
    if (!mysql_fetch_array(mysql_query("SELECT * FROM alarm_manual_mode WHERE user_id=$userId AND device_id=$deviceId LIMIT 1", $connection)))
    {
      $insertQuery = "INSERT INTO alarm_manual_mode SET user_id=$userId, device_id='$deviceId', name='Manuel Mod Alarmı (Varsayılan)'";

//                foreach ($parameterArr[21] as $parameter) {
//                    $tempArr = explode(":", $parameter);
//                    $key = $tempArr[0];
//                    $value = $tempArr[1];
//                    $insertQuery .= ", $key=$value";
//                }
      mysql_unbuffered_query($insertQuery);
    }
  }
  /////////////////  JENERATÖR MANUEL MOD ALARMI BİTTİ \\\\\\\\\\\\\\\\\\\
  //////////////////   SAYAÇ FAZ KESİNTİSİ ALARMI   \\\\\\\\\\\\\\\\\\\
//  if (in_array($deviceCategory, $sCategoryArr[12]))
//  {
//    if (!mysql_fetch_array(mysql_query("SELECT * FROM alarm_phasefailure WHERE user_id=$userId AND device_id=$deviceId LIMIT 1", $connection)))
//    {
//      $deviceQuery = "SELECT * FROM measuring_device_settings WHERE measuring_device_id = '$deviceId' AND measuring_device_id IN (SELECT meter_id FROM meter_info)";
//      $deviceResult = mysql_query($deviceQuery, $connection);
//
//      if (mysql_num_rows($deviceResult) > 0)
//      {
//        $insertQuery = "INSERT INTO alarm_phasefailure SET user_id=$userId, device_id='$deviceId', name='Sayaç Faz Kesintisi Alarmı (Varsayılan)'";
//
//        foreach ($parameterArr[12] as $parameter) {
//          $tempArr = explode(":", $parameter);
//          $key = $tempArr[0];
//          $value = $tempArr[1];
//          $insertQuery .= ", $key=$value";
//        }
//        mysql_unbuffered_query($insertQuery);
//      }
//    }
//  }
  ///////////////// SAYAÇ FAZ KESİNTİSİ ALARMI BİTTİ \\\\\\\\\\\\\\\\\\\
  //////////////////  ZAYIF PİL ALARMI  \\\\\\\\\\\\\\\\\\\
//  if (in_array($deviceCategory, $sCategoryArr[13]))
//  {
//    if (!mysql_fetch_array(mysql_query("SELECT * FROM alarm_lowbattery WHERE user_id=$userId AND device_id=$deviceId LIMIT 1", $connection)))
//    {
//      $deviceQuery = "SELECT * FROM measuring_device_settings WHERE measuring_device_id = '$deviceId' AND measuring_device_id IN (SELECT meter_id FROM meter_info)";
//      $deviceResult = mysql_query($deviceQuery, $connection);
//
//      if (mysql_num_rows($deviceResult) > 0)
//      {
//        $insertQuery = "INSERT INTO alarm_lowbattery SET user_id=$userId, device_id='$deviceId', name='Zayıf Pil Alarmı (Varsayılan)'";
//
//        foreach ($parameterArr[13] as $parameter) {
//          $tempArr = explode(":", $parameter);
//          $key = $tempArr[0];
//          $value = $tempArr[1];
//          $insertQuery .= ", $key=$value";
//        }
//        mysql_unbuffered_query($insertQuery);
//      }
//    }
//  }
  ///////////////// ZAYIF PİL ALARMI BİTTİ \\\\\\\\\\\\\\\\\\\
  //////////////////  GÖVDE KAPAĞI AÇILDI ALARMI  \\\\\\\\\\\\\\\\\\\
//  if (in_array($deviceCategory, $sCategoryArr[14]))
//  {
//    if (!mysql_fetch_array(mysql_query("SELECT * FROM alarm_bodycover WHERE user_id=$userId AND device_id=$deviceId LIMIT 1", $connection)))
//    {
//      $deviceQuery = "SELECT * FROM measuring_device_settings WHERE measuring_device_id = '$deviceId' AND measuring_device_id IN (SELECT meter_id FROM meter_info)";
//      $deviceResult = mysql_query($deviceQuery, $connection);
//
//      if (mysql_num_rows($deviceResult) > 0)
//      {
//        $insertQuery = "INSERT INTO alarm_bodycover SET user_id=$userId, device_id='$deviceId', name='Gövde Kapağı Açıldı Alarmı (Varsayılan)'";
//
//        foreach ($parameterArr[14] as $parameter) {
//          $tempArr = explode(":", $parameter);
//          $key = $tempArr[0];
//          $value = $tempArr[1];
//          $insertQuery .= ", $key=$value";
//        }
//        mysql_unbuffered_query($insertQuery);
//      }
//    }
//  }
  ///////////////// GÖVDE KAPAĞI AÇILDI ALARMI BİTTİ \\\\\\\\\\\\\\\\\\\
  //////////////////  KLEMENS KAPAĞI AÇILDI ALARMI  \\\\\\\\\\\\\\\\\\\
//  if (in_array($deviceCategory, $sCategoryArr[15]))
//  {
//    if (!mysql_fetch_array(mysql_query("SELECT * FROM alarm_terminalcover WHERE user_id=$userId AND device_id=$deviceId LIMIT 1", $connection)))
//    {
//      $deviceQuery = "SELECT * FROM measuring_device_settings WHERE measuring_device_id = '$deviceId' AND measuring_device_id IN (SELECT meter_id FROM meter_info)";
//      $deviceResult = mysql_query($deviceQuery, $connection);
//
//      if (mysql_num_rows($deviceResult) > 0)
//      {
//        $insertQuery = "INSERT INTO alarm_terminalcover SET user_id=$userId, device_id='$deviceId', name='Klemens Kapağı Açıldı Alarmı (Varsayılan)'";
//
//        foreach ($parameterArr[15] as $parameter) {
//          $tempArr = explode(":", $parameter);
//          $key = $tempArr[0];
//          $value = $tempArr[1];
//          $insertQuery .= ", $key=$value";
//        }
//
//        mysql_unbuffered_query($insertQuery);
//      }
//    }
//  }
  ///////////////// KLEMENS KAPAĞI AÇILDI ALARMI BİTTİ \\\\\\\\\\\\\\\\\\\
}

function deleteDeviceAlarm($deviceId)
{
  global $connection;

  $alarmTypeQuery = "SELECT * FROM alarm_type WHERE table_name!=''";
  $alarmTypeResult = mysql_query($alarmTypeQuery, $connection);

  while ($alarmTypeRow = mysql_fetch_array($alarmTypeResult)) {
    $table_name = $alarmTypeRow["table_name"];
    $deleteQuery = "DELETE FROM $table_name WHERE device_id='$deviceId'";
    mysql_unbuffered_query($deleteQuery, $connection);
  }
}

function deleteUserAlarm($userId, $isAll = false, $deviceId = "")   //// isAll -> Kullanıcının tüm alarmları ise 'true'
{
  ///        -> Kullanıcının bir cihazına tanımlanmış alarmlar ise 'false' olmalı
  global $connection;
  $sqlAdded = "AND device_id='$deviceId'";

  if ($isAll == true)
  {
    $sqlAdded = "";
  }

  $alarmTypeQuery = "SELECT * FROM alarm_type WHERE table_name!=''";
  $alarmTypeResult = mysql_query($alarmTypeQuery, $connection);

  while ($alarmTypeRow = mysql_fetch_array($alarmTypeResult)) {
    $table_name = $alarmTypeRow["table_name"];
    $deleteQuery = "DELETE FROM $table_name WHERE user_id=$userId $sqlAdded";
    mysql_unbuffered_query($deleteQuery, $connection);
  }
}

function insertUserDefaultAlarmSettings($userId)
{
  global $connection;

  $multiQuery = "INSERT INTO alarm_user_parameter (user_id, alarm_type, parameter) VALUES"
    . "($userId,1,(SELECT parameter FROM alarm_default_parameter WHERE alarm_type=1)),"
    . "($userId,3,(SELECT parameter FROM alarm_default_parameter WHERE alarm_type=3)),"
    . "($userId,5,(SELECT parameter FROM alarm_default_parameter WHERE alarm_type=5)),"
    . "($userId,7,(SELECT parameter FROM alarm_default_parameter WHERE alarm_type=7)),"
    . "($userId,9,(SELECT parameter FROM alarm_default_parameter WHERE alarm_type=9)),"
    . "($userId,10,(SELECT parameter FROM alarm_default_parameter WHERE alarm_type=10)),"
    . "($userId,11,(SELECT parameter FROM alarm_default_parameter WHERE alarm_type=11))";

//  $query1 = "INSERT INTO alarm_user_parameter SET user_id=$userId, alarm_type=1, parameter='inductive_limit:20|capacitive_limit:15|consumption_limit:0|calculation_interval:72|email_period:24|status:1'";
//  $query1 = "INSERT INTO alarm_user_parameter SET user_id=$userId, alarm_type=1, "
//    . "parameter=(SELECT parameter FROM alarm_default_parameter WHERE alarm_type=1)";
//  $query2 = "INSERT INTO alarm_user_parameter SET user_id=$userId, alarm_type=3, "
//    . "parameter=(SELECT parameter FROM alarm_default_parameter WHERE alarm_type=3)";
//  $query3 = "INSERT INTO alarm_user_parameter SET user_id=$userId, alarm_type=5, "
//    . "parameter=(SELECT parameter FROM alarm_default_parameter WHERE alarm_type=5)";
//  $query4 = "INSERT INTO alarm_user_parameter SET user_id=$userId, alarm_type=7, "
//    . "parameter=(SELECT parameter FROM alarm_default_parameter WHERE alarm_type=7)";
//  $query5 = "INSERT INTO alarm_user_parameter SET user_id=$userId, alarm_type=9, "
//    . "parameter=(SELECT parameter FROM alarm_default_parameter WHERE alarm_type=9)";
//  $query6 = "INSERT INTO alarm_user_parameter SET user_id=$userId, alarm_type=10, "
//    . "parameter='status:1'";
//  $query7 = "INSERT INTO alarm_user_parameter SET user_id=$userId, alarm_type=11, "
//    . "parameter=(SELECT parameter FROM alarm_default_parameter WHERE alarm_type=11)";
//  $query8 = "INSERT INTO alarm_user_parameter SET user_id=$userId, alarm_type=12, parameter='status:1'";
//  $query9 = "INSERT INTO alarm_user_parameter SET user_id=$userId, alarm_type=13, parameter='status:1'";
//  $query10 = "INSERT INTO alarm_user_parameter SET user_id=$userId, alarm_type=14, parameter='status:1'";
//  $query11 = "INSERT INTO alarm_user_parameter SET user_id=$userId, alarm_type=15, parameter='status:1'";
  mysql_unbuffered_query($multiQuery, $connection);

//  mysql_unbuffered_query($query1, $connection);
//  mysql_unbuffered_query($query2, $connection);
//  mysql_unbuffered_query($query3, $connection);
//  mysql_unbuffered_query($query4, $connection);
//  mysql_unbuffered_query($query5, $connection);
//  mysql_unbuffered_query($query6, $connection);
//  mysql_unbuffered_query($query7, $connection);
//  mysql_unbuffered_query($query8, $connection);
//  mysql_unbuffered_query($query9, $connection);
//  mysql_unbuffered_query($query10, $connection);
//  mysql_unbuffered_query($query11, $connection);
}

function getDeviceIcon($deviceCategory)
{
  if (!is_numeric($deviceCategory))
  {
    $deviceCategory = -1;
  }

  switch ($deviceCategory) {
    case 0:
    case 4:
    case 5:
      $icon = 'icon icon2-switch2 io-item';
      break;
    case 1:
      $icon = 'fa fa-tachometer comsumption-item';
      break;
    case 2:
      $icon = 'icon icon2-dashboard compensation-item';
      break;
    case 3:
      $icon = 'icon icon2-power comsumption-item';
      break;
    case 6:
      $icon = 'icon icon2-thermometer temperature-item';
      break;
    case 7:
    case 9:
      $icon = 'icon icon2-fire gas-item';
      break;
    case 8:
      $icon = 'icon icon2-droplet water-item';
      break;
    case 10:
      $icon = 'fa fa-list-ol';
      break;
    case 11:
      $icon = 'icon sp-feed';
      break;
    case 12:
      $icon = 'fa fa-ioxhost';
      break;
    default:
      $icon = 'fa fa-question-circle';
  }

  return $icon;
}

function emailSignatureStr()
{
  $email_signature = '';
  $result = mysql_query("SELECT value_str FROM server_settings WHERE key_str='email_signature'");

  if ($row = mysql_fetch_assoc($result))
  {
    $email_signature = $row['value_str'];
  }
  return $email_signature;
}

function devicePageUrls($deviceCategory, $deviceId, $modemId)//Modem,cihaz ayar sayfaları linkleri
{
  global $connection;
  switch ($deviceCategory) {
    case 0://Modem
      $result = mysql_query("SELECT id FROM comm_device_settings WHERE comm_device_id='$modemId'", $connection);

      if ($row = mysql_fetch_assoc($result))
      {
        $dbId = $row['id'];
      }
      $deviceSettingsUrl = "/updateCommDeviceSettings.php?id=$dbId";
      $deviceDetailsUrl = "/updateCommDeviceSettings.php?id=$dbId";
      break;
    case 1://sayaç
    case 2://röle
    case 3://analizör
      $result = mysql_query("SELECT id FROM measuring_device_settings WHERE measuring_device_id='$deviceId'", $connection);

      if ($row = mysql_fetch_assoc($result))
      {
        $deviceDbId = $row['id'];
      }
      $deviceSettingsUrl = "/deviceSettings.php?id=$deviceDbId";
      $deviceDetailsUrl = "/report.php?id=$deviceId";

      break;
    case 4://giriş-çıkış modülü
    case 5://giriş-çıkış modülü
      $result = mysql_query("SELECT id FROM io_module WHERE module_id='$deviceId'", $connection);

      if ($row = mysql_fetch_assoc($result))
      {
        $dbId = $row['id'];
      }
      $deviceSettingsUrl = "/ioSettings.php?ioDbId=$dbId&isModule=1";
      $deviceDetailsUrl = "/ioSettings.php?ioDbId=$dbId&isModule=1";
      break;
    case 6://Sıcaklık Sensör
      $deviceSettingsUrl = "/sensor/sensorSettings.php?id=$deviceId";
      $deviceDetailsUrl = "/sensor/temperatureDetails.php?id=$deviceId";
      break;
    case 7://Grup Arge Doğal Gaz Sayacı
      $deviceSettingsUrl = "/gasMeter/updateGasMeter.php?id=$deviceId";
      $deviceDetailsUrl = "/gasMeter/gasMeterGraph.php?id==$deviceId";
      break;
    case 8://Debi Metre
      $deviceSettingsUrl = "/flow/flowMeterSettings.php?id=$deviceId";
      $deviceDetailsUrl = "/flow/detailsTransducer.php?id=$deviceId";
      break;
    case 9://Hacim Düzeltici
      $deviceSettingsUrl = "/gasMeter/updateGasMeter.php?id=$deviceId";
      $deviceDetailsUrl = "/gasMeter/gasMeterGraph.php?id=$deviceId";
      break;
    case 10://Pulse Sayıcı
      $deviceSettingsUrl = "/gasMeter/updateGasMeter.php?id=$deviceId";
      $deviceDetailsUrl = "/gasMeter/gasMeterGraph.php?id=$deviceId";
      break;
    case 11://Analog Sensör
      $deviceSettingsUrl = "/sensor/analog/analogSensorSettings.php?id=$deviceId";
      $deviceDetailsUrl = "/sensor/analog/analogSensorDetails.php?id=$deviceId";
      break;
    case 12://Jeneratör
      $deviceSettingsUrl = "/generator/generatorSettings.php?id=$deviceId";
      $deviceDetailsUrl = "/generator/generatorDetail.php?id=$deviceId";
      break;
    default:
      $deviceSettingsUrl = "#";
      $deviceDetailsUrl = "#";
      break;
  }

  $return['settings_url'] = $deviceSettingsUrl;
  $return['details_url'] = $deviceDetailsUrl;
  return $return;
}

function isOxiServer()
{
  global $connection;
  $result = mysql_query('SELECT value_str FROM server_settings WHERE key_str = "server_license"', $connection);

  if ($result && ($row = mysql_fetch_assoc($result)))
  {
    switch ($row['value_str']) {
      case '364AA3CE-3CE9-447D-95BF-5FED79ED538F': // Oxi Enerji
      case 'F8C51308-2E96-4B17-AC3F-D8E70BDCE772': // Sistem Takibi
        // case 'mrrobot':
        return true;
    }
  }

  return false;
}

function log_email($is_send, $to, $subject, $body, $unique_code, $read_date, $sender, $error_message)
{
  global $connection;

  $sql = 'INSERT INTO log_email (is_send,to_email,subject,body,error_message,unique_code,read_date,sender) '
    . "VALUES ('$is_send','$to','$subject','$body','$error_message','$unique_code','$read_date','$sender')";
  $result = mysql_query($sql, $connection);
  return $result;
}

function getUserAuthDevice($user_id, $categories)
{
  /* Kullanıcının yetkili olduğu cihazları çeker */
  global $connection;
  if ($categories != "")
  {
    $whereAdd = " AND dt.device_category IN($categories)";
    $joinTable = " JOIN measuring_device_settings AS mds ON mds.measuring_device_id = user_device.device_id "
      . "JOIN device_type AS dt ON dt.device_type_code = mds.device_type";
  }
  $sql = "SELECT device_id FROM user_device $joinTable WHERE user_id=$user_id $whereAdd";
  $result = mysql_query($sql, $connection);
  $device_id_arr = array();

  while ($row = mysql_fetch_array($result)) {
    $device_id_arr[] = $row["device_id"];
  }
  return $device_id_arr;
}
