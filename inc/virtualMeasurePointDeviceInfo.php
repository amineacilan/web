<?php
$group_id = getParamUrl("group_id", "GET", "");
$dataLinkClass = $instantDataLinkClass = $graphLinkClass = $graphLinkClass_ = $reportLinkClass = $billLinkClass = '';
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
  case 'virtualMeasurePointGraph':
    $graphLinkClass_ = 'active';
    break;
  case 'heatMap':
    $graphLinkClass = 'active';
    break;
  case 'virtualMeasurePointReport':
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
      <i></i>Sanal Ölçü Noktası
    </div>
  </div>
  <div class="portlet-body">
    <div class="tabbable tabbable-tabdrop">
      <ul class="nav nav-tabs nav-just">
        <li class="<?php echo $graphLinkClass_; ?>">
          <a href="/virtualMeasurePointGraph.php?group_id=<?php echo $group_id; ?>">
            Grafik </a>
        </li>
        <li class="<?php echo $reportLinkClass; ?>">
          <a href="/virtualMeasurePointReport.php?group_id=<?php echo $group_id; ?>">
            Rapor </a>
        </li>
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
