
<?php
include '../inc/config.php';
include '../inc/conn.php';
include '../inc/func.php';
$pageName = 'server_upload_list';
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

class serverInfo
{

  public $id;
  public $server_name;
  public $date_entry;
  public $notes;
  public $user;

}

$sql = "SELECT id,server_name,date_entry,notes,user FROM server_upload_log ORDER BY id DESC";
$sorgu = mysql_query($sql, $connection);


  while ($result = mysql_fetch_assoc($sorgu)) {

    $info = new serverInfo();
    $info->id = $result['id'];
    $info->server_name = $result['server_name'];
    $info->date_entry = $result['date_entry'];
    $info->notes = $result['notes'];
    $info->user = $result['user'];
   
    
    $serverInfo[] = $info;
  }

?>


<div class="row" style='max-width: 1200px;'>
  <div class="col-md-12">
    <div class="portlet box green">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-industry"></i>Server Listesi
        </div>
        <div class="pull-right">
          <?php
          if ($session_type == 'admin')
          {
            ?>
            <a class="btn btn-default btn-sm button-color" style='margin-top:-5px' href="server_upload_log.php"><i class="fa fa-plus"></i> Yeni server Ekle</a>
           
            <?php
          }
          ?>
        </div>
      </div>
      <div class="portlet-body" sytle="max-width:1200px;">
        <table class="table table-striped table-bordered table-hover table-full-width" id="server_upload_list" sytle="max-width:1200px;">
        </table>
      </div>
    </div>
  </div>
</div>

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

    data = $.parseJSON('<?php echo escapeJsonString(json_encode($serverInfo)); ?>');

    $('#server_upload_list').dataTable({
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
            
              settings += '<a onclick ="setting(\'' + source.id + '\')""><img class="tooltipOld link_icon pointer" title="Düzenle" src="../images/settings.png"/></a>';

  <?php
}
?>
            return settings;

          }
        },
       
        {
          "sTitle": "Server Adı",
          "sClass": "columnLeftAlign",
          data: 'server_name'
        },
     {
         "sTitle": "Tarih",
         "sClass": "columnLeftAlign",
         "data": function (source, type) {

           var DateEntry = source.date_entry;
           var DateEntryObj, DateEntryStr;
           if ((DateEntry === null) || (DateEntry === ''))
           {
             DateEntry = '';
             DateEntryObj = '';
             DateEntryStr = '';
           } else
           {
             DateEntryObj = parseDbDate(DateEntry);
             DateEntryStr = moment(DateEntryObj).format('DD.MM.YYYY');
           }
           source.DateEntryDisplay = DateEntryStr;
           source.DateEntrySort = DateEntryObj;
           if (type === 'display')
           {
             return source.DateEntryDisplay;
           } else if (type === 'sort')
           {
             return source.DateEntrySort;
           } else
           {
             return source.date_entry;
           }
         }
       },
        {
          "sTitle": " Notes",
          "sClass": "columnLeftAlign",
          data: 'notes'
        },
        {
          "sTitle": " Kullanıcı",
          "sClass": "columnLeftAlign",
          data: 'user'
        }
      ],
      "oLanguage": {
        "sUrl": "/dataTables/dataTables.turkish.txt"
      }
    });
  });
  function setting(id) {

    self.document.location.href = "server_upload_log.php?id=" + id;
  }
 
  function addNewServer()
  {
    document.location.href = "server_upload_log.php";
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