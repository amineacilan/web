
<?php
include '../inc/config.php';
include '../inc/conn.php';
include '../inc/func.php';
$pageName = 'gasMeterInfo';
$demoAuth = true;
$useFunctionsJs = true;
$useDateFormatJs = true;
include '../inc/l_control.php';
include '../inc/header.php';

$msg = getParamUrl("m", 'GET', '');
$id = getParamUrl("id", 'GET', '');
$nowdate = date_create()->format('m.d.Y');
?>
</div>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css"/>
<link href="/assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="/lib/js/jquery_file_upload/css/style.css"/>
<link rel="stylesheet" href="/lib/js/jquery_file_upload/css/jquery.fileupload.css"/>
<link rel = "stylesheet" type = "text/css" href = "/assets/global/plugins/bootstrap-toastr/toastr.min.css"/>
<link rel="stylesheet" type="text/css" href="/assets/admin/pages/css/profile.css"/>
<link rel="stylesheet" type="text/css" href="/tooltipster/tooltipster.css"/>
<link rel="stylesheet" type="text/css" href="/dataTables/dataTables.css"/>
<link rel="stylesheet" type="text/css" href="/assets/plugins/data-tables/DT_bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-select/bootstrap-select.min.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/jquery-multi-select/css/multi-select.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>
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
if ($id != "")
{

  $sql = "SELECT * FROM gas_meter_info WHERE id = $id";
  $sorgu = mysql_query($sql, $connection);
  if ($result = mysql_query($sql, $connection))
  {
    while ($result = mysql_fetch_assoc($sorgu)) {
      $id = $result['id'];
      $location = $result['location'];
      $corrector_device_id = $result['corrector_device_id'];
      $production_date = $result['production_date'];
      $calibration_date = $result['calibration_date'];
      $next_calibration_date = $result['next_calibration_date'];
      $station_serial_no = $result['station_serial_no'];
      $station_input_output_pressure = $result['station_input_output_pressure'];
      $station_capacity = $result['station_capacity'];
      $meter_brand = $result['meter_brand'];
      $meter_type = $result['meter_type'];
      $meter_serial_no = $result['meter_serial_no'];
      $meter_q_max_q_min = $result['meter_q_max_q_min'];
      $corrector_brand = $result['corrector_brand'];
      $corrector_model = $result['corrector_model'];
      $corrector_serial_no = $result['corrector_serial_no'];
      $regulator_brand = $result['regulator_brand'];
      $regulator_model = $result['regulator_model'];
      $regulator_serial_no = $result['regulator_serial_no'];
      $regulator_pressure = $result['regulator_pressure'];
      $filter_type = $result['filter_type'];
      $filter_serial_no = $result['filter_serial_no'];
    }
  }
}
?>
<div class="row" style='max-width: 1200px;'>
  <div class="col-md-12">
    <div class="portlet box green">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-list"></i> Sayaç Ayarları
        </div>
        <div style='float: right;'>
          <a class="btn green" style='padding-top: 0px; padding-bottom: 0px;' href='gasMeterInfo.php'>
            <i class="fa fa-list"></i> Tüm Sayaçlar
          </a>
        </div>
      </div>
      <div class="portlet-body" sytle="max-width:1200px;">
        <div id="requiredField" class="alert alert-warning" style="display:none;">
          <button class="close" data-dismiss="alert"></button>
          (<span class="required" aria-required="true">*</span>) İşaretli alanları doldurunuz!
        </div>
        <form role="form" class="form-horizontal" id="frm1" name='frm1' method='POST' action='ajax/tx_updateGasMeterInfo.php'>
          <input type = "hidden" name = "id" value="<?php echo $id ?>"/>
          <input type = "hidden" name = "production_date" value="<?php echo $production_date ?>"/>
          <input type = "hidden" name = "calibration_date" value="<?php echo $calibration_date ?>"/>
          <input type = "hidden" name = "next_calibration_date" value="<?php echo $next_calibration_date ?>"/>
          <input type = "hidden" name = "station_serial_no" value="<?php echo $station_serial_no ?>"/>
          <input type = "hidden" name = "station_input_output_pressure" value="<?php echo $station_input_output_pressure ?>"/>
          <input type = "hidden" name = "station_capacity" value="<?php echo $station_capacity ?>"/>
          <input type = "hidden" name = "meter_brand" value="<?php echo $meter_brand ?>"/>
          <input type = "hidden" name = "meter_type" value="<?php echo $meter_type ?>"/>
          <input type = "hidden" name = "meter_serial_no" value="<?php echo $meter_serial_no ?>"/>
          <input type = "hidden" name = "meter_q_max_q_min" value="<?php echo $meter_q_max_q_min ?>"/>
          <input type = "hidden" name = "corrector_brand" value="<?php echo $corrector_brand ?>"/>
          <input type = "hidden" name = "corrector_model" value="<?php echo $corrector_model ?>"/>
          <input type = "hidden" name = "corrector_serial_no" value="<?php echo $corrector_serial_no ?>"/>
          <input type = "hidden" name = "regulator_brand" value="<?php echo $regulator_brand ?>"/>
          <input type = "hidden" name = "regulator_model" value="<?php echo $regulator_model ?>"/>
          <input type = "hidden" name = "regulator_serial_no" value="<?php echo $regulator_serial_no ?>"/>
          <input type = "hidden" name = "regulator_pressure" value="<?php echo $regulator_pressure ?>"/>
          <input type = "hidden" name = "filter_type" value="<?php echo $filter_type ?>"/>
          <input type = "hidden" name = "filter_serial_no" value="<?php echo $filter_serial_no ?>"/>

          <div class="form-body">
            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class = "form-group">
                  <label class = "control-label col-md-5 col-sm-6 col-xs-6" >Konum <span class="required" aria-required="true">*</span></label>
                  <div class = "col-md-6 col-sm-6 col-xs-6">
                    <input type = "text" name = "location" autocomplete="off" class = "form-control" value ="<?php echo $location ?>" />
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class = "form-group">
                  <label class = "control-label col-md-5 col-sm-6 col-xs-6" >Sayaç No <span class="required" aria-required="true">*</span></label>
                  <div class = "col-md-6 col-sm-6 col-xs-6">
                    <input type = "text" name = "corrector_device_id" autocomplete="off" class = "form-control" value ="<?php echo $corrector_device_id ?>" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class = "form-group">
                  <label class = "control-label col-md-5 col-sm-6 col-xs-6" >Üretim Tarihi</label>
                  <div class = "col-md-6 col-sm-6 col-xs-6" id ="sandbox-container">
                    <input type = "text" name = "production_date" autocomplete="off" class = "form-control" value ="<?php echo date_create($production_date)->format('d.m.Y') ?>" />
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class = "form-group">
                  <label class = "control-label col-md-5 col-sm-6 col-xs-6" >Kalibrasyon Tarihi</label>
                  <div class = "col-md-6 col-sm-6 col-xs-6" id ="sandbox-container2">
                    <input type = "text" name = "calibration_date" autocomplete="off" class = "form-control" value ="<?php echo date_create($calibration_date)->format('d.m.Y') ?>" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class = "form-group">
                  <label class = "control-label col-md-5 col-sm-6 col-xs-6" >Kalibrasyon Yapılacak Tarih</label>
                  <div class = "col-md-6 col-sm-6 col-xs-6" id ="sandbox-container3">
                    <input type = "text" name = "next_calibration_date" autocomplete="off" class = "form-control" value ="<?php echo date_create($next_calibration_date)->format('d.m.Y') ?>" />
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class = "form-group">
                  <label class = "control-label col-md-5 col-sm-6 col-xs-6" >İstasyon Seri No</label>
                  <div class = "col-md-6 col-sm-6 col-xs-6">
                    <input type = "text" name = "station_serial_no" autocomplete="off" class = "form-control" value ="<?php echo $station_serial_no ?>" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class = "form-group">
                  <label class = "control-label col-md-5 col-sm-6 col-xs-6" >İstasyon Giriş Çıkış Basıncı</label>
                  <div class = "col-md-6 col-sm-6 col-xs-6">
                    <input type = "text" name = "station_input_output_pressure" autocomplete="off" class = "form-control" value ="<?php echo $station_input_output_pressure ?>" />
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class = "form-group">
                  <label class = "control-label col-md-5 col-sm-6 col-xs-6" >İstasyon Kapasitesi</label>
                  <div class = "col-md-6 col-sm-6 col-xs-6">
                    <input type = "text" name = "station_capacity" autocomplete="off" class = "form-control" value ="<?php echo $station_capacity ?>" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class = "form-group">
                  <label class = "control-label col-md-5 col-sm-6 col-xs-6" >Sayaç Markası</label>
                  <div class = "col-md-6 col-sm-6 col-xs-6">
                    <input type = "text" name = "meter_brand" autocomplete="off" class = "form-control" value ="<?php echo $meter_brand ?>" />
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class = "form-group">
                  <label class = "control-label col-md-5 col-sm-6 col-xs-6" >Sayaç Modeli</label>
                  <div class = "col-md-6 col-sm-6 col-xs-6">
                    <input type = "text" name = "meter_type" autocomplete="off" class = "form-control" value ="<?php echo $meter_type ?>" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class = "form-group">
                  <label class = "control-label col-md-5 col-sm-6 col-xs-6" >Sayaç Seri No</label>
                  <div class = "col-md-6 col-sm-6 col-xs-6">
                    <input type = "text" name = "meter_serial_no" autocomplete="off" class = "form-control" value ="<?php echo $meter_serial_no ?>" />
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class = "form-group">
                  <label class = "control-label col-md-5 col-sm-6 col-xs-6" >Sayaç Q Max. Q Min.</label>
                  <div class = "col-md-6 col-sm-6 col-xs-6">
                    <input type = "text" name = "meter_q_max_q_min" autocomplete="off" class = "form-control" value ="<?php echo $meter_q_max_q_min ?>" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class = "form-group">
                  <label class = "control-label col-md-5 col-sm-6 col-xs-6" >Korrektör Markası</label>
                  <div class = "col-md-6 col-sm-6 col-xs-6">
                    <input type = "text" name = "corrector_brand" autocomplete="off" class = "form-control" value ="<?php echo $corrector_brand ?>" />
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class = "form-group">
                  <label class = "control-label col-md-5 col-sm-6 col-xs-6" >Korrektör Modeli</label>
                  <div class = "col-md-6 col-sm-6 col-xs-6">
                    <input type = "text" name = "corrector_model" autocomplete="off" class = "form-control" value ="<?php echo $corrector_model ?>" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class = "form-group">
                  <label class = "control-label col-md-5 col-sm-6 col-xs-6" >Korrektör Seri No</label>
                  <div class = "col-md-6 col-sm-6 col-xs-6">
                    <input type = "text" name = "corrector_serial_no" autocomplete="off" class = "form-control" value ="<?php echo $corrector_serial_no ?>" />
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class = "form-group">
                  <label class = "control-label col-md-5 col-sm-6 col-xs-6" >Regülatör Markası</label>
                  <div class = "col-md-6 col-sm-6 col-xs-6">
                    <input type = "text" name = "regulator_brand" autocomplete="off" class = "form-control" value ="<?php echo $regulator_brand ?>" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class = "form-group">
                  <label class = "control-label col-md-5 col-sm-6 col-xs-6" >Regülatör Modeli</label>
                  <div class = "col-md-6 col-sm-6 col-xs-6">
                    <input type = "text" name = "regulator_model" autocomplete="off" class = "form-control" value ="<?php echo $regulator_model ?>" />
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class = "form-group">
                  <label class = "control-label col-md-5 col-sm-6 col-xs-6" >Regülatör Seri No</label>
                  <div class = "col-md-6 col-sm-6 col-xs-6">
                    <input type = "text" name = "regulator_serial_no" autocomplete="off" class = "form-control" value ="<?php echo $regulator_serial_no ?>" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class = "form-group">
                  <label class = "control-label col-md-5 col-sm-6 col-xs-6" >Regülatör Basıncı</label>
                  <div class = "col-md-6 col-sm-6 col-xs-6">
                    <input type = "text" name = "regulator_pressure" autocomplete="off" class = "form-control" value ="<?php echo $regulator_pressure ?>" />
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class = "form-group">
                  <label class = "control-label col-md-5 col-sm-6 col-xs-6" >Filtre Tipi</label>
                  <div class = "col-md-6 col-sm-6 col-xs-6">
                    <input type = "text" name = "filter_type" autocomplete="off" class = "form-control" value ="<?php echo $filter_type ?>" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class = "form-group">
                  <label class = "control-label col-md-5 col-sm-6 col-xs-6" >Filtre Değişim Tarihi</label>
                  <div class = "col-md-6 col-sm-6 col-xs-6" id ="sandbox-container4">
                    <input type = "text" name = "filter_serial_no" autocomplete="off" class = "form-control" value ="<?php echo date_create($filter_serial_no)->format('d.m.Y') ?>" />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="form-actions fluid">
            <div class="row">
              <div class="col-md-12 col-sm-6 col-xs-12">
                <div class="">
                  <a  name = "submit" id="submitButton" class = "btn button-color pull-right">Kaydet </a>
                </div>
              </div>
            </div>
          </div>
        </form>
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

  var todayDate = '<?php echo $nowdate ?>';
  $(document).ready(function () {
    $('#sandbox-container input').datepicker({
      format: "dd.mm.yyyy",
      startDate: new Date().setDate(todayDate),
      language: "tr",
      weekStart: 1
    });
    $('#sandbox-container2 input').datepicker({
      format: "dd.mm.yyyy",
      startDate: new Date().setDate(todayDate),
      language: "tr",
      weekStart: 1
    });
    $('#sandbox-container3 input').datepicker({
      format: "dd.mm.yyyy",
      startDate: new Date().setDate(todayDate),
      language: "tr",
      weekStart: 1
    });
    $('#sandbox-container4 input').datepicker({
      format: "dd.mm.yyyy",
      startDate: new Date().setDate(todayDate),
      language: "tr",
      weekStart: 1
    });
    var msg = '<?php echo $msg; ?>';
    if (msg === '1') {
      showToastrMessage('success', "İşlem Başarılı");
    } else if (msg === '0') {
      showToastrMessage('error', "İşlem Başarısız");
    }

    $('#submitButton').click(function () {
      var location = document.frm1.location.value,
        corrector_device_id = document.frm1.corrector_device_id.value;
      if (location === '' || corrector_device_id === '')
      {
        $(document).scrollTop(0);
        $('#requiredField').show();
        return;
      } else
      {
        $('#requiredField').hide();
        document.getElementById('frm1').submit();
      }
    });

  });
</script>
<script src="/assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>
<script src="/js/ui-toastr.js"></script>
<script src="/assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
<script src="/js/tooltipster_func.js"></script>

<script src="/assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>
<script src="/assets/admin/pages/scripts/ui-alert-dialog-api.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>

<script type="text/javascript" charset="utf-8" src="/tooltipster/jquery.tooltipster.min.js"></script>
<script src="/assets/global/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script src="/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="/assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script src="/assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
<script src="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script src="/lib/js/jquery_file_upload/js/vendor/jquery.ui.widget.js"></script>
<script src="/lib/js/jquery_file_upload/js/jquery.iframe-transport.js"></script>
<script src="/lib/js/jquery_file_upload/js/jquery.fileupload.js"></script>
<script src="/lib/js/jquery_file_upload/js/jquery.fileupload-process.js"></script>
<script src="/lib/js/jquery_file_upload/js/jquery.fileupload-image.js"></script>

<script src="/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.tr.js" type="text/javascript"></script>
<?php
include('../inc/bottom.php');
