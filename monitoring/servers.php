<meta charset="UTF-8">
<?php
include ('../inc/config.php');
include ('../inc/conn.php');
include ('../inc/func.php');

$demoAuth = true;
$useFunctionsJs = true;
$useDateFormatJs = true;
include ('../inc/l_control.php');
include ('../inc/header.php');

$sql = "SELECT * FROM server_info";
$sorgu = mysql_query($sql, $connection);
?>
</div>
<div class="row">
  <div class="col-md-12">
    <?php
    $host = array();
    $i = 0;
    while ($row = mysql_fetch_assoc($sorgu)) {
      $host[] = $row['host'];
      ?>
      <div class="col-md-4" id="server<?php echo $i ?>">
        <div class="dashboard-stat grey-silver serviceTest" style='cursor: pointer;'>
          <div class="visual">
            <i class="fa fa-spinner fa-spin fa-2x deneme"></i>
          </div>
          <div class="details">
            <div class="desc">
              <h5>IP: <?php echo $row['host']; ?> </h5>
              <h5>Sunucu Adı: <?php echo $row['server_name']; ?></h5>
              <h5>Web Url: <a href="<?php echo $row['web_url']; ?>"><?php echo $row['web_url']; ?></a></h5>
            </div>
          </div>
          <a class="more">
            Servis Durumu <span style='float:right;' onclick="serviceControl('#server<?php echo $i ?>');" data-host="<?php echo $row['host']; ?>">TEST ET <i class="m-icon-swapright m-icon-white" style='vertical-align: text-bottom;'></i></span>
          </a>
        </div>
      </div>
      <?php
      $i++;
    }
    ?>

  </div>
</div>

<?php
include ('../inc/bottom.php');
?>
<script>

  var host_info = $.parseJSON('<?php echo json_encode($host, JSON_UNESCAPED_UNICODE); ?>');
  var host_info_length = host_info.length;
  var counter = 0;
  serviceControl("#server" + counter);
  setInterval(function () {
    counter = 0;
    serviceControl("#server" + counter);
  }, 600000);

  function serviceControl(element) {
    // console.log("girdi" + element);
    var host = $(element).find("span").attr('data-host');
    $(element).find("span").attr('data-host');

    $(element).find(".serviceTest").removeClass("red-flamingo");
    $(element).find(".deneme").addClass("fa-spinner fa-spin fa-2x");
    $(element).find(".serviceTest").addClass("grey-silver");

    $.ajax({
      type: "post",
      url: "tx_servicecontrol.php",
      data: {
        host: host
      },
      success: function (data) {
        var x = $.parseJSON(data);
        if (x.correct == 1) {
          $(element).find(".serviceTest").removeClass("grey-silver");
          $(element).find(".serviceTest").addClass("green-turquoise");
          $(element).find(".deneme").removeClass("fa-spinner fa-spin fa-2x");
          $(element).find(".deneme").addClass("fa fa-check");
        }
        if (x.correct == 0) {
          $(element).find(".serviceTest").removeClass("grey-silver");
          $(element).find(".serviceTest").addClass("red-flamingo");
          $(element).find(".deneme").removeClass("fa-spinner fa-spin fa-2x");
          $(element).find(".deneme").addClass("fa fa-times");
        }

        counter++;

        if (counter < host_info_length) {
          // console.log("Çağrılıyor" + counter);
          serviceControl("#server" + counter);
        }

      }

    })
  }
</script>
