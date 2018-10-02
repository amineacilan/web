<?php
$comm_id = getParamUrl('id', 'GET', 0);

if ($pageName == 'commDeviceSettings' || $pageName == 'userCommDeviceAuthSettings')
{
  $commDeviceInfo = 'SELECT id, comm_device_id, communication_type, location_name FROM comm_device_settings WHERE id =' . $comm_id;
}
else if ($pageName == 'signalGraph' || $pageName == 'modemLog' || $pageName == 'modemAlarm' || $pageName == 'deviceAlarm')
{
  $commDeviceInfo = 'SELECT id, comm_device_id, communication_type, location_name FROM comm_device_settings WHERE comm_device_id ="' . $comm_id . '"';
}

if (($result = mysql_query($commDeviceInfo, $connection)) && ($row = mysql_fetch_assoc($result)))
{
  $comm_id = $row['id'];
  $communication_type = $row['communication_type'];
  $comm_device_id = $row['comm_device_id'];
  $location_name = $row['location_name'];
}
?>
<link href="/assets/global/plugins/bootstrap-tabdrop/css/tabdrop.css" rel="stylesheet" type="text/css"/>
<style>
  .nav-tabs>li>a {
    margin-right: 0px;
    padding: 5px 15px;
  }
</style>
<!--<div class="col-md-12">-->
<div class="tabbable tabbable-tabdrop">
  <ul class="nav nav-tabs nav-just">
    <?php
    if ($comm_id > 0)
    {
      ?>
      <li class="<?php
      if ($pageName == 'commDeviceSettings')
      {
        echo 'active';
      }
      ?>">
        <a href='/updateCommDeviceSettings.php?id=<?php echo $comm_id; ?>'>
          Modem Ayarları</a>
      </li>
      <li class="<?php
      if ($pageName == 'userCommDeviceAuthSettings')
      {
        echo 'active';
      }
      ?>">
        <a href='/userCommDeviceAuthSettings.php?id=<?php echo $comm_id; ?>'>
          Yetki Ayarları</a>
      </li>
      <li class="<?php
      if ($pageName == 'modemAlarm' || $pageName == 'deviceAlarm')
      {
        echo 'active';
      }
      ?>">
        <a href='/alarm/modemAlarm.php?id=<?php echo $comm_device_id; ?>'>
          Modem Alarmları</a>
      </li>
      <?php
      if ($communication_type == 'GPRS')
      {
        ?>
        <li class="
        <?php
        if ($pageName == 'signalGraph')
        {
          echo 'active';
        }
        ?>">
          <a href="/signalGraph.php?id=<?php echo $comm_device_id; ?>">Sinyal Gücü</a>
        </li>
        <?php
      }
      if ($session_type == 'admin')
      {
        ?>
        <li class="
        <?php
        if ($pageName == 'modemLog')
        {
          echo 'active';
        }
        ?>">
          <a href="/modemLog.php?id=<?php echo $comm_device_id; ?>"><?php echo $comm_device_id . '.log'; ?></a>
        </li>
        <?php
      }
    }
    ?>
  </ul>
  <!--</div>-->
  <script src="/assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
  <script>
    $('.nav-pills, .nav-tabs').tabdrop();
  </script>