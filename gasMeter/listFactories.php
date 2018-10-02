
<?php
include '../inc/config.php';
include '../inc/conn.php';
include '../inc/func.php';
$pageName = 'listFactories';
$demoAuth = true;
$useFunctionsJs = true;
$useDateFormatJs = true;
include '../inc/l_control.php';
include '../inc/header.php';

$id = getParamUrl("id", "GET", "");
$msg = getParamUrl("m", 'GET', '');
?>

</div>
<link rel="stylesheet" type="text/css" href="/assets/admin/pages/css/profile.css"/>
<link rel="stylesheet" type="text/css" href="/tooltipster/tooltipster.css"/>
<link rel="stylesheet" type="text/css" href="/dataTables/dataTables.css"/>
<link rel="stylesheet" type="text/css" href="/assets/plugins/data-tables/DT_bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-select/bootstrap-select.min.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/jquery-multi-select/css/multi-select.css"/>
<link href="/assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css" />
<style>
  .pointer {
    cursor: pointer;
  }
  .button-color{
    background-color:#35aa47;
    color: white;
  }
  .button-color:hover{
    background-color:#319b3f;
    color: white;
  }
</style>

<?php

class factoryInfo
{

  public $id;
  public $corrector_id;
  public $location;
  public $volume_channel;
  public $station_type;

}

$sql = "SELECT id,corrector_id,location,volume_channel,station_type FROM corrector_device_id";
$sorgu = mysql_query($sql, $connection);

if ($result = mysql_query($sql, $connection))
{
  while ($result = mysql_fetch_assoc($sorgu)) {

    $info = new factoryInfo();
    $info->id = $result['id'];
    $info->corrector_id = $result['corrector_id'];
    $info->location = $result['location'];
    $info->volume_channel = $result['volume_channel'];
    $info->station_type = $result['station_type'];

    $factoryInfo[] = $info;
  }
}
?>
<div class="row" style='max-width: 1200px;'>
  <div class="col-md-12">
    <div class="portlet box green">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-industry"></i>Fabrika Listesi
        </div>
        <div class="pull-right">
          <?php
          if ($session_type == 'admin')
          {
            ?>
            <a class="btn btn-default btn-sm button-color" style='margin-top:-5px' href="javascript:addNewFactory()"><i class="fa fa-plus"></i> Yeni Fabrika Ekle</a>
            <button class="btn btn-default btn-sm button-color" onclick="ExportExcel()"  style='margin-top:-5px'><i class="fa fa-file-excel-o"></i> Dışa Aktar</button>
            <?php
          }
          ?>
        </div>
      </div>
      <div class="portlet-body" sytle="max-width:1200px;">
        <table class="table table-striped table-bordered table-hover table-full-width" id="factoryList" sytle="max-width:1200px;">
        </table>
      </div>
    </div>
  </div>
</div>
<form class = "form-horizontal" id = "frm1" name="frm1" action = "tx_listFactoriesExcel.php" method = "POST">
  <input type="hidden" name="dataText" id="dataText" value=""/>
</form>
<script type="text/javascript" language="javascript">
  var shortCutFunction = 'success',
    msg = '',
    title = '',
    showDuration = 1000,
    hideDuration = 1000,
    timeOut = 5000,
    extendedTimeOut = 1000,
    showEasing = 'swing',
    hideEasing = 'linear',
    showMethod = 'fadeIn',
    hideMethod = 'fadeOut';

  function showToastrMessage(statusPrm, msgPrm)
  {
    shortCutFunction = statusPrm;
    msg = msgPrm;
    toastr.options = {
      closeButton: true,
      debug: false,
      positionClass: 'toast-top-center',
      onclick: null
    };
    UIToastr.init();
  }

  $(document).ready(function () {
    var msg = '<?php echo $msg; ?>';
    if (msg === '1') {
      showToastrMessage('success', "İşlem Başarılı");
    } else if (msg === '0') {
      showToastrMessage('error', "İşlem Başarısız");
    }

    data = $.parseJSON('<?php echo escapeJsonString(json_encode($factoryInfo)); ?>');

    $('#factoryList').dataTable({
      "fnDrawCallback": function () {
        initTooltipster();
        $('.tooltipOld:not(.tooltipstered)').tooltipster({
          arrow: false,
          contentAsHTML: true,
          delay: 5000,
          offsetX: 0,
          offsetY: -13,
          position: 'top',
          theme: 'tooltipster-punk'
        });
      },
      "aaData": data,
      "order": [1, "asc"],
      "aoColumns": [
        {
          "sTitle": "Ayarlar",
          "sClass": "columnCenterAlign",
          "width": "10%",
          "data": function (source) {
            var settings = "";
<?php
if ($session_type == 'admin')
{
  ?>
              settings += '<a onclick="deleteDevice(\'' + source.id + '\')""><img class="tooltipOld link_icon pointer" title="Bu Fabrikayı Sil" src="../images/delete_data32x32.png"/></a>';
              settings += '<a onclick ="setting(\'' + source.id + '\')""><img class="tooltipOld link_icon pointer" title="Düzenle" src="../images/settings.png"/></a>';

  <?php
}
?>
            return settings;

          }
        },
        {
          "sTitle": "Fabrika No",
          "sClass": "columnLeftAlign",
          data: 'corrector_id'
        },
        {
          "sTitle": "Konum",
          "sClass": "columnLeftAlign",
          data: 'location'
        },
        {
          "sTitle": "Kanal",
          "sClass": "columnLeftAlign",
          data: 'volume_channel'
        },
        {
          "sTitle": "İstasyon Tipi",
          "sClass": "columnLeftAlign",
          data: 'station_type'
        }
      ],
      "oLanguage": {
        "sUrl": "/dataTables/dataTables.turkish.txt"
      }
    });
  });
  function setting(id) {

    self.document.location.href = "updateFactoryInfo.php?id=" + id;
  }
  function deleteDevice(id) {

    self.document.location.href = "tx_deleteFactory.php?id=" + id;
  }
  function addNewFactory()
  {
    document.location.href = "updateFactoryInfo.php";
  }
  function ExportExcel()
  {
    dataArrayExcel = JSON.stringify(data);
    $('#dataText').val(dataArrayExcel);
    document.getElementById('frm1').submit();
  }
</script>
<script src="/assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>

<script src="/js/tooltipster_func.js"></script>
<script type="text/javascript" charset="utf-8" src="/tooltipster/jquery.tooltipster.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script src="/assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>
<script src="/js/ui-toastr.js"></script>
<?php
include('../inc/bottom.php');
?>