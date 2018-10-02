<?php
if ($session_type == 'admin')
{
  $menu_user_type = 'admin';
}
else
{
  $menu_user_type = 'public';
}
?>
<script src="/lib/js/browserInfo/platform.min.js"></script>
<?php
//$authUserArr = array("gunerdr@hotmail.com", "bayi@gruparge.com", "musteri@gruparge.com", "ikbalaltun@happy.com.tr", "yagmurbozkiz@kizilca.com.tr", "mehmet@3fazmuhendislik.com", "nerasmuh@hotmail.com", "bkt@bktenerji.com.tr", "aykelektrik@aykelektrik.com", "mehmeterdogmus@mynet.com", "halilertap@hotmail.com", "pazarlama@gruparge.com", "info@gmelektrik.com");
//if (($session_type == 'admin') || (in_array($session_email, $authUserArr)))
//{
?>
<!--  <div class="row">
    <div class="col-md-12">
      <div class="alert alert-info alert-dismissable text-center" style="background-color: #FF8600; color: white; margin-bottom: 0px;">
        <strong><i class="fa fa-check-circle"></i></strong> <?php echo $viewChangeInfo; ?> <strong><span onclick="javascript: changeView();" style="cursor: pointer;">  Geçiş Yap <i class="fa fa-exchange"></i></span></strong>
        <div class="fa fa-edit fa-2x pull-right tooltipOld" title="Geri Bildirim" style="cursor: pointer;" onclick="javascript: writeFeedback();">
        </div>
      </div>
    </div>
  </div>-->
<?php
//}
?>
<div class="row">
  <div class="col-md-12">
    <a href="/supportedBrowser.php">
      <div class="alert alert-info alert-dismissable" style="display: none;" id="browserCheck">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
        <strong><i class="fa fa-warning"></i></strong> Internet Explorer'ın eski bir sürümünü kullanıyorsunuz. Sistemin tüm özelliklerini kullanabilmeniz için lütfen tarayıcınızı son sürüme <strong>buradan güncelleyin</strong>.
      </div>
    </a>
  </div>
</div>
<script>
  var platformName = platform.name;
  var platformVersion = platform.version;
  var osVersion = platform.os.architecture;
  var osName = platform.os.family;

  if (platformName === 'IE' && (platformVersion === '9.0' || platformVersion === '8.0' || platformVersion === '7.0' || platformVersion === '6.0'))
  {
    $('#browserCheck').show();
  }

  function writeFeedback()
  {
    $('#modalDiv').load('/feedback/tx_writeFeedback.php', {}, function () {
      $('#modalDiv').modal();
    });
  }
</script>
<?php
if ($pageName != "")
{

  $sql_query_header = 'SELECT * FROM ' . $menuOption . ' Where page_name ="' . $pageName . '" AND group_name = ' . '"' . $menu_user_type . '"';
  $sql_header = mysql_query($sql_query_header);

  $i = 0;
  $header_arr = [];

  if (mysql_num_rows($sql_header) > 0)
  {
    ?>
    <div class="row">
      <div class="col-md-12">
        <?php
      }
      ?>

      <?php
      while ($header_row = mysql_fetch_assoc($sql_header)) {

        $header_menu = $header_row['icon'] . ',' . $header_row['link'] . ',' . $header_row['display_name'] . ',' . $header_row['parent_id'];

        $header_arr[$i] = $header_menu;

        $i++;

        if ($header_row['parent_id'] != 0)
        {

          $sql_query_header_parent = 'SELECT * FROM ' . $menuOption . ' Where id ="' . $header_row['parent_id'] . '"';

          $sql_header_parent = mysql_query($sql_query_header_parent);

          while ($header_parent_row = mysql_fetch_assoc($sql_header_parent)) {

            $header_menu = $header_parent_row['icon'] . ',' . $header_parent_row['link'] . ',' . $header_parent_row['display_name'] . ',' . $header_parent_row['parent_id'];

            $header_arr[$i] = $header_menu;
            $i++;
          }
        }
      }

      if (count($header_arr) > 0)
      {
        ?>
        <ul class="page-breadcrumb breadcrumb" style="margin-top: -10px; margin-bottom: 0px;">
          <?php
          for ($index = count($header_arr) - 1; $index >= 0; $index--) {

            $header_menu_row = explode(",", $header_arr[$index]);
            ?>
            <li>
              <i class = "<?php echo $header_menu_row[0]; ?>"></i>
              <a href = "<?php echo $header_menu_row[1]; ?>">
                <?php echo $header_menu_row[2]; ?>

                <?php
                if ($index == count($header_arr) - 1 && $header_menu_row[3] == 0)
                {
                  if (count($header_arr) > 1)
                  {
                    echo '<i class="fa fa-angle-right"></i>';
                  }
                }
                ?>
              </a>
            </li>
            <?php
          }
          ?>
        </ul>
        <?php
      }

      if (mysql_num_rows($sql_header) > 0)
      {
        ?>
      </div>
    </div>
    <br>
    <?php
  }
}

