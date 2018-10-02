<?php
$dataLinkClass = $instantDataLinkClass = $graphLinkClass = $reportLinkClass = $billLinkClass = '';
$harmonicsLinkClass = $loadProfileLinkClass = $controlLinkClass = $settingsLinkClass = $userCommDeviceLinkClass = $alarmLinkClass = '';

switch ($pageName) {
  case 'data':
  case 'export_index_data':
    $dataLinkClass = 'active';
    break;
  case 'instantData':
  case 'instantGraph':
  case 'instantValues':
    $instantDataLinkClass = 'active';
    break;
  case 'graph':
  case 'heatMap':
    $graphLinkClass = 'active';
    break;
  case 'report':
    $reportLinkClass = 'active';
    break;
  case 'bill':
    $billLinkClass = 'active';
    break;
  case 'harmonics':
  case 'harmonicValues':
    $harmonicsLinkClass = 'active';
    break;
  case 'load_profile':
    $loadProfileLinkClass = 'active';
    break;
  case 'control':
    $controlLinkClass = 'active';
    break;
  case 'deviceSettings':
    $settingsLinkClass = 'active';
    break;
  case 'deviceAlarm':
    $alarmLinkClass = 'active';
    break;
  case 'userCommDeviceAuthSettings':
  case 'userDeviceAuthSettings':

    $userCommDeviceLinkClass = 'active';
}

// Is Modem Transparent? If so, show the control page link. Otherwise, do not show!
$isModemTransparent = false;
// Yük profili linki ?
$hasLoadProfileData = false;
// Anlık değerler linki?
$hasInstantData = false;
// Harmonik linki?
$hasHarmonicData = false;

$result = mysql_query('SELECT id, is_transparent, communication_type, sw_version, data_read_period, last_packet_time, location_name ' .
  "FROM comm_device_settings WHERE comm_device_id = '$d_info->ModemId'", $connection);

if ($result && ($row = mysql_fetch_assoc($result)))
{
  $modemDbId = $row['id'];
  $isModemTransparent = $row['is_transparent'];
  $sw_version = formatSwVersion($row['sw_version']);
  $data_read_period = formatSwVersion($row['data_read_period']);
  $last_conn_time = convertTrDate(date_create($row['last_packet_time'])->format('j M Y D H:i'));

  $title = '<table>'
    . '<tr><td style=\'color:#11f79f;\'>Konum</td><td style=\'color: white;\'>&nbsp;:&nbsp;</td><td style=\'color: white;\'>' . $row['location_name'] . '</td></tr>'
    . '<tr><td style=\'color:#11f79f;\'>Cihaz Tipi</td><td style=\'color: white;\'>&nbsp;:&nbsp;</td><td style=\'color: white;\'>' . $row['communication_type'] . '</td></tr>'
    . '<tr><td style=\'color:#11f79f;\'>Versiyon</td><td style=\'color: white;\'>&nbsp;:&nbsp;</td><td style=\'color: white;\'>' . $sw_version . '</td></tr>';
  $title .= ($isModemTransparent == false) ? ('<tr><td style=\'color:#11f79f;\'>Periyot</td><td style=\'color: white;\'>&nbsp;:&nbsp;</td><td style=\'color: white;\'>' . $data_read_period . ' dk.</td></tr>') : '';
  $title .= '<tr><td style=\'color:#11f79f;\'>Son Bağlantı</td><td style=\'color: white;\'>&nbsp;:&nbsp;</td><td style=\'color: white;\'>' . $last_conn_time . '</td></tr>'
    . '</table>';
}

$result = mysql_query("SELECT has_export_data,id, has_load_profile_data, has_instant_values_data, has_harmonic_data FROM measuring_device_settings WHERE measuring_device_id = '$d_info->SerialNumber'", $connection);

if ($result && ($row = mysql_fetch_assoc($result)))
{
  $di_database_id = $row['id'];
  $hasLoadProfileData = $row['has_load_profile_data'];
  $hasInstantData = $row['has_instant_values_data'];
  $hasHarmonicData = $row['has_harmonic_data'];
  $has_export_data = $row['has_export_data'];
}

$dataLinkName = (($d_info->DeviceCategory == 1) ? 'Endeks' : 'Enerji');
$settingsLink = (($session_email == 'demo') ? '/deviceSettingsD.php' : '/deviceSettings.php') . "?id=$di_database_id";
$serialNumberTitle = (($d_info->DeviceCategory == 1) ? 'Sayaç No:' : 'Cihaz No:');
?>
<link href="/assets/global/plugins/bootstrap-tabdrop/css/tabdrop.css" rel="stylesheet" type="text/css"/>
<style>
  .nav-tabs>li>a {
    margin-right: 0px;
    padding: 5px 15px;
  }
</style>
<div class="portlet box blue">
  <div class="portlet-title">
    <div class="caption">
      <b>Konum: </b><?php echo $d_info->CompanyName; ?> |
      <b><?php echo $serialNumberTitle; ?> </b><?php echo $d_info->SerialNumber; ?> |
      <b>Modem: </b><a id="modemLink" style='color: white;' class="tooltipOld" title="<?php echo $title; ?>" href="/updateCommDeviceSettings.php?id=<?php echo $modemDbId; ?>"><?php echo $d_info->ModemId; ?></a>
      <?php
      if (($d_info->DeviceCategory != 1) && ($d_info->DeviceModel != 'Undefined') && ($d_info->DeviceModel != ''))
      {
        ?>
        | <b>Cihaz Modeli: </b><span><?php echo $d_info->DeviceModel; ?></span>
        <?php
      }
      ?>
    </div>
  </div>
  <div class="portlet-body">
    <div class="tabbable tabbable-tabdrop">
      <ul class="nav nav-tabs nav-just">
        <li class="<?php echo $dataLinkClass; ?>">
          <a href="/data.php?id=<?php echo $d_info->SerialNumber; ?>">
            <?php echo $dataLinkName; ?> </a>
        </li>
        <?php
        if ($hasInstantData)
        {
          ?>
          <li class="<?php echo $instantDataLinkClass; ?>">
            <a href="/instantData.php?id=<?php echo $d_info->SerialNumber; ?>">
              Akım/Gerilim </a>
          </li>
          <?php
        }
        if ($d_info->DeviceCategory != 1 && $isModemTransparent)
        {
          ?>
          <li class="<?php echo $instantDataLinkClass; ?>">
            <a href="/instantValues.php?id=<?php echo $d_info->SerialNumber; ?>">
              Akım/Gerilim </a>
          </li>
          <?php
        }
        ?>
        <li class="<?php echo $graphLinkClass; ?>">
          <a href="/graph.php?id=<?php echo $d_info->SerialNumber; ?>">
            Grafik </a>
        </li>
        <li class="<?php echo $reportLinkClass; ?>">
          <a href="/report.php?id=<?php echo $d_info->SerialNumber; ?>">
            Rapor </a>
        </li>
        <?php
        if ($billSupport)
        {
          ?>
          <li class="<?php echo $billLinkClass; ?>">
            <a href="/bill.php?id=<?php echo $d_info->SerialNumber; ?>">
              Fatura </a>
          </li>
          <?php
        }

        if ($hasHarmonicData)
        {
          ?>
          <li class="<?php echo $harmonicsLinkClass; ?>">
            <a href="/harmonics.php?id=<?php echo $d_info->SerialNumber; ?>">
              Harmonik </a>
          </li>
          <?php
        }
        if ($d_info->DeviceModel == 'SIEMENS_SENTRON_PAC4200')
        {
          ?>
          <li class="<?php echo $harmonicsLinkClass; ?>">
            <a href="/harmonicValues.php?id=<?php echo $d_info->SerialNumber; ?>">
              Harmonik </a>
          </li>
          <?php
        }
        if ($d_info->DeviceCategory == 1)
        {
          ?>
          <li class="<?php echo $loadProfileLinkClass; ?>">
            <a href="/load_profile.php?id=<?php echo $d_info->SerialNumber; ?>">
              Yük Profili </a>
          </li>
          <?php
        }
        elseif ($isModemTransparent)
        {
          ?>
          <li class="<?php echo $controlLinkClass; ?>">
            <a href="/control.php?id=<?php echo $d_info->SerialNumber; ?>">
              Kontrol </a>
          </li>
          <?php
        }
        ?>
        <li class="<?php echo $settingsLinkClass; ?>">
          <a href="<?php echo $settingsLink; ?>">
            Ayarlar </a>
        </li>
        <li class="<?php echo $alarmLinkClass; ?>">
          <a href="/alarm/deviceAlarm.php?id=<?php echo $d_info->SerialNumber; ?>">
            Alarm </a>
        </li>
        <?php
        if (($session_type == 'admin') || ($session_type == 'bayi'))
        {
          ?>
          <li class="<?php echo $userCommDeviceLinkClass; ?>">
            <a href="/userDeviceAuthSettings.php?id=<?php echo $d_info->SerialNumber; ?>">
              Yetkiler </a>
          </li>
          <?php
        }
        ?>
      </ul>
      <script src="/assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
      <script>
        $(document).ready(function () {
          $.fn.tooltipster('setDefaults', {
            arrow: false,
            contentAsHTML: true,
            delay: 50,
            offsetX: -30,
            offsetY: -10,
            position: 'bottom-left',
            theme: 'tooltipster-punk'
          });

          $('.tooltipOld').tooltipster();

        });
        $('.nav-pills, .nav-tabs').tabdrop();
      </script>
      <link href="/tooltipster/tooltipster.css" rel="stylesheet" type="text/css"/>
      <!--<script src="../js/tooltipster_func.js"></script>-->
      <script src="/tooltipster/jquery.tooltipster.min.js" type="text/javascript"></script>
