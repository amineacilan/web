<?php
include 'inc/config.php';
include 'inc/conn.php';
include 'inc/func.php';
$pageName = 'subcriberManagement';
$demoAuth = true;
$useFunctionsJs = true;
$useDateFormatJs = true;
include 'inc/l_control.php';
include 'inc/header.php';
include 'func_updateCommDeviceSettings.php';

$msg = getParamUrl("m", 'GET', '');
$nowdate = date_create()->format('m.d.Y');
$subcriber_type = getParamUrl("subcriber_type", 'POST', '');
$tariff_type = getParamUrl("tariff_type", 'POST', '');
?>
</div>
<link rel="stylesheet" type="text/css" href="/assets/admin/pages/css/profile.css"/>
<link rel="stylesheet" type="text/css" href="/tooltipster/tooltipster.css"/>
<link rel="stylesheet" type="text/css" href="/dataTables/dataTables.css"/>
<link rel="stylesheet" type="text/css" href="/assets/plugins/data-tables/DT_bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-select/bootstrap-select.min.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/jquery-multi-select/css/multi-select.css"/>
<link href="/assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/select2/select2.css"/>
<style>
  .pointer {
    cursor: pointer;
  }
  .fa-info-circle{
    color: #00cca3;
    vertical-align: top;
  }
  .table th {
    vertical-align: middle !important;
  }
  .select2-container .select2-choice {
    height: 34px;
    padding-top: 3px;
  }

</style>

<div class="row" style='max-width: 1200px; margin-bottom: 10px;'>
  <form class = "form-horizontal" id = "frm1" role = "form" action = "" method = "POST">
    <div class="col-md-3 col-sm-3 col-xs-3">
      <select name ="subcriber_type" id="subcriber_type">
        <option value=""></option>
        <option <?php
        if ($subcriber_type == 'Sanayi (AG)')
        {
          ?> selected <?php } ?> value="Sanayi (AG)">Sanayi (AG)</option>
        <option <?php
        if ($subcriber_type == 'Sanayi (OG)')
        {
          ?> selected <?php } ?> value="Sanayi (OG)">Sanayi (OG)</option>
        <option <?php
        if ($subcriber_type == 'Ticarethane (AG)')
        {
          ?> selected <?php } ?> value="Ticarethane (AG)">Ticarethane (AG)</option>
        <option <?php
        if ($subcriber_type == 'Ticarethane (OG)')
        {
          ?> selected <?php } ?> value="Ticarethane (OG)">Ticarethane (OG)</option>
      </select>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-3">
      <select name ="tariff_type" id="tariff_type">
        <option value=""></option>
        <option <?php
        if ($tariff_type == '0')
        {
          ?> selected <?php } ?> value="0">Tek Zamanlı Tarife</option>
        <option <?php
        if ($tariff_type == '1')
        {
          ?> selected <?php } ?> value="1">Üç Zamanlı Tarife</option>
      </select>
    </div>
  </form>
  <form class = "form-horizontal" id = "frm1" role = "form" action = "subcriberExcel.php" method = "POST">
    <div class="col-md-1 col-sm-1 col-xs-1 text-center margin-bottom-10 ">
      <button class="btn yellow" type="submit"><i class="fa fa-file-excel-o"></i> Dışa Aktar</button>
      <input type="hidden" name="subcriber_type" id="subcriber_type" value="<?php echo $subcriber_type; ?>"/>
      <input type="hidden" name="tariff_type" id="tariff_type" value="<?php echo $tariff_type; ?>"/>
    </div>
  </form>
  <div class='col-md-5 col-sm-3 col-xs-3'>
    <div class="colorInfo pull-right-sm">
      <p class="divInfo">
        <span class="color_info_warning"></span>
        <span class="infoText">SSB Bitiş Yaklaşan</span>
      </p>
      <p class="divInfo">
        <span class="color_info_danger"></span>
        <span class="infoText">SSB Bitiş Geçen</span>
      </p>
    </div>
  </div>
</div>

<?php

class subcribersInfo
{

  public $id;
  public $subcriber_no;
  public $subcriber_type;
  public $tariff_type;
  public $location;
  public $sanayi_sicil_begin_date;
  public $sanayi_sicil_end_date;
  public $status;
  public $measuring_device_id;
  public $comm_device_id;
  public $location_name;

}

$sql = "SELECT s.id,subcriber_no,subcriber_type,s.tariff_type,location,sanayi_sicil_begin_date,
sanayi_sicil_end_date,status,measuring_device_id,mds.comm_device_id,mds.last_packet_time,cds.location_name
FROM subcribers s
LEFT JOIN measuring_device_settings mds ON mds.tesisat_no = s.subcriber_no
LEFT JOIN comm_device_settings AS cds ON mds.comm_device_id = cds.comm_device_id
WHERE status = 1";

if ($subcriber_type != "" && $tariff_type == "")
{
  $sql .= " AND subcriber_type = '$subcriber_type'";
}
else if ($tariff_type != "" && $subcriber_type == "")
{
  $sql .= " AND s.tariff_type = '$tariff_type'";
}
else if ($subcriber_type != "" && $tariff_type != "")
{
  $sql .= " AND s.tariff_type = '$tariff_type' AND subcriber_type = '$subcriber_type'";
}

$sql .= " ORDER BY subcriber_no ASC, last_packet_time DESC";

$sorgu = mysql_query($sql, $connection);

$subcribers_list = array();

if ($result = mysql_query($sql, $connection))
{
  while ($result = mysql_fetch_assoc($sorgu)) {

    $curr_subcriber_no = $result['subcriber_no'];

    $info = new subcribersInfo();
    $info->id = $result['id'];
    $info->subcriber_no = $curr_subcriber_no;
    $info->subcriber_type = $result['subcriber_type'];
    $info->tariff_type = $result['tariff_type'];
    $info->location = $result['location'];
    $info->sanayi_sicil_begin_date = $result['sanayi_sicil_begin_date'];
    $info->sanayi_sicil_end_date = $result['sanayi_sicil_end_date'];
    $info->status = $result['status'];
    $info->measuring_device_id = $result['measuring_device_id'];
    $info->comm_device_id = $result['comm_device_id'];
    $info->location_name = $result['location_name'];


    if (array_key_exists($curr_subcriber_no, $subcribers_list))
    {
      $subcribers_list[$curr_subcriber_no]->measuring_device_id .= "<br>" . $info->measuring_device_id;
    }
    else
    {
      $subcribers_list[$curr_subcriber_no] = $info;
    }
  }
}

$data_array = array();
foreach ($subcribers_list as $value) {
  $data_array[] = $value;
}
?>

<div class="row" style='max-width: 1200px;'>
  <div class="col-md-12">
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-address-card"></i>Abone Yönetimi Tablosu
        </div>
        <div class="pull-right">
          <?php
          if ($session_type == 'admin')
          {
            ?>
            <a class="btn btn-default btn-sm yellow" style='margin-top:-5px' href="/deviceConsumption.php"><i class="fa fa-bolt"></i> Tüketim Görünümü</a>
            <a class="btn btn-default btn-sm yellow" style='margin-top:-5px' href="javascript:inactiveSubcriber()"> Pasif Aboneler</a>
            <a class="btn btn-default btn-sm yellow" style='margin-top:-5px' href="javascript:addNewSubcriber()"><i class="fa fa-plus"></i> Yeni Abone Ekle</a>
            <?php
          }
          ?>
        </div>
      </div>
      <div class="portlet-body" sytle="max-width:1202px;">
        <table class="table table-striped table-bordered table-hover table-full-width" id="subcriberList" sytle="max-width:1202px;">
        </table>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" language="javascript">
  var shortCutFunction = 'error',
    msg = 'Lütfen excele aktarmadan önce bir rapor tipi seçin!',
    title = 'Uyarı',
    showDuration = 1000,
    hideDuration = 1000,
    timeOut = 5000,
    extendedTimeOut = 1000,
    showEasing = 'swing',
    hideEasing = 'linear',
    showMethod = 'fadeIn',
    hideMethod = 'fadeOut';

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

  var nowdate = '<?php echo $nowdate ?>';
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

    $('#subcriber_type').select2({allowClear: true, placeholder: "Abone Tipi", width: "calc(100%)"});
    $("#subcriber_type").change(function () {
      $('#frm1').submit();
    });

    $('#tariff_type').select2({allowClear: true, placeholder: "Tarife Türü", width: "calc(100%)"});
    $("#tariff_type").change(function () {
      $('#frm1').submit();
    });

    $('#modem').select2({allowClear: true, placeholder: "Modem", width: "calc(100%)"});
    $("#modem").change(function () {
      $('#frm1').submit();
    });

    var msg = '<?php echo $msg; ?>';
    if (msg === '1') {
      showToastrMessage('success', "İşlem Başarılı");
    } else if (msg === '0') {
      showToastrMessage('error', "İşlem Başarısız");
    }
    data = $.parseJSON('<?php echo escapeJsonString(json_encode($data_array)); ?>');
    $('#subcriberList').dataTable({
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
      "fnRowCallback": function (nRow, aaData) {
        sanayi_sicil_tarih = moment(aaData.sanayi_sicil_end_date).subtract(20, 'days').format('MM.DD.YYYY');
        var title = "";
        if (nowdate >= sanayi_sicil_tarih) {

          date1 = new Date(aaData.sanayi_sicil_end_date);
          date2 = new Date(nowdate);
          var day = 1000 * 60 * 60 * 24;
          var gun = Math.round((date1.getTime() - date2.getTime()) / day);
          if (gun > 0) {
            $(nRow).addClass("warning");
            title += "<tr><td class=\"tooltipX\">Sanayi Sicil Belgesinin bitimine kalan gün</td><td>:&nbsp;</td><td>" + gun + " gün</td></tr> ";
            $("td", nRow).attr("title", title);
            $("td:eq(0)", nRow).removeAttr("title", title);
            $("td:eq(8)", nRow).removeAttr("title", title);
            $("td", nRow).addClass("tooltipOld");
            $("td:eq(0)", nRow).removeClass("tooltipOld");
            $("td:eq(8)", nRow).removeClass("tooltipOld");
          } else {
            $(nRow).addClass("danger");
            title += "<tr><td class=\"tooltipX\">Sanayi Sicil Belgesinin Tarihi </td><td>:&nbsp;</td><td>" + -gun + " gün geçmiştir</td></tr> ";
            $("td", nRow).attr("title", title);
            $("td:eq(0)", nRow).removeAttr("title", title);
            $("td:eq(8)", nRow).removeAttr("title", title);
            $("td", nRow).addClass("tooltipOld");
            $("td:eq(0)", nRow).removeClass("tooltipOld");
            $("td:eq(8)", nRow).removeClass("tooltipOld");
          }
        }
      },
      "aaData": data,
      "order": [1, "asc"],
      "aoColumns": [
        {
          "sTitle": "Abone <br> Ayarları",
          "sClass": "columnCenterAlign",
          "data": function (source) {
            duzenle = '<a onclick ="updateSubcriber(\'' + source.id + '\')""><img class="tooltipOld link_icon pointer" title="Abone Ayarları" src="images/settings.png"/></a>';
            return duzenle;
          }
        },
        {
          "sTitle": "Abone No",
          "sClass": "columnLeftAlign",
          data: 'subcriber_no'
        },
        {
          "sTitle": "Abone Ünvanı",
          "sClass": "columnLeftAlign",
          data: 'location'
        },
        {
          "sTitle": "Trafo Bilgisi",
          "sClass": "columnLeftAlign",
          "data": function (source) {
            var tariff_type_ = "";
            if (source.tariff_type == "0") {
              tariff_type_ = "Tek Zamanlı Tarife";
            } else {
              tariff_type_ = "Üç Zamanlı Tarife";
            }
            var abone_type = source.subcriber_type + "<br>" + tariff_type_;
            return abone_type;
          }
        },
        {
          "sTitle": "Modem",
          "sClass": "columnLeftAlign",
          "data": function (source) {
            var modem = source.comm_device_id + "<br>" + source.location_name;
            return modem;
          }
        },
        {
          "sTitle": "Sayaç",
          "sClass": "columnLeftAlign",
          data: 'measuring_device_id'
        },
        {
          "sTitle": "SSB Başlangıç",
          "sClass": "columnLeftAlign text-nowrap",
          "data": function (source, type) {

            var DateEntry = source.sanayi_sicil_begin_date;
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
              return source.sanayi_sicil_begin_date;
            }
          }
        },
        {
          "sTitle": "SSB Bitiş",
          "sClass": "columnLeftAlign text-nowrap",
          "data": function (source, type) {

            var DateEntry = source.sanayi_sicil_end_date;
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
              return source.sanayi_sicil_end_date;
            }
          }
        },
        {
          "sTitle": "Pasif Et",
          "sClass": "columnCenterAlign",
          "data": function (source) {
            inactive = '<a onclick ="tx_inactiveSubcriber(\'' + source.id + '\',\'' + source.status + '\')""><i class="fa fa-ban tooltipOld pointer"title="Aboneliği Pasif Et"  style="vertical-align: middle; color:red;"/></a>';
            return inactive;
          }
        }
      ],
      "oLanguage": {
        "sUrl": "dataTables/dataTables.turkish.txt"
      }
    });
  });
  function updateSubcriber(id) {

    self.document.location.href = "addSubcribers.php?subcriber_id=" + id;
  }
  function tx_inactiveSubcriber(id, status) {

    self.document.location.href = "tx_inactiveSubcribers.php?subcriber_id=" + id + "&status=" + status + "";
  }
  function addNewSubcriber()
  {
    document.location.href = "addSubcribers.php";
  }
  function inactiveSubcriber()
  {
    document.location.href = "inactiveSubcribers.php";
  }
  function ExportExcel(subcriber_type, tariff_type)
  {
    document.location.href = "subcriberExcel.php?subcriber_type=" + subcriber_type + "&tariff_type=" + tariff_type;
  }
</script>
<script src="/js/tooltipster_func.js"></script>
<script type="text/javascript" charset="utf-8" src="/tooltipster/jquery.tooltipster.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script src="/assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>
<script src="/js/ui-toastr.js"></script>
<script src="/assets/global/plugins/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/select2/select2.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/select2/lodash.min.js"></script>
<script src="/assets/global/plugins/select2/lodash/select2.min.js"></script>
<script src="/assets/global/plugins/select2/select2_locale_tr.js" type="text/javascript"></script>
<?php
include('inc/bottom.php');
