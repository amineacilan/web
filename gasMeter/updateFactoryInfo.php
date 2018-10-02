<?php
include '../inc/config.php';
include '../inc/conn.php';
include '../inc/func.php';
$pageName = 'gasMeter';
$demoAuth = true;
$useFunctionsJs = true;
$useDateFormatJs = true;
include '../inc/l_control.php';
include '../inc/header.php';

$id = getParamUrl('id', 'GET', '');
$msg = getParamUrl("m", 'GET', '');
$corrector_id = "";
$location = "";
$volume_channel = "";
$station_type = "";

if ($id != '')
{
  $gasQuery = "SELECT id,corrector_id,location,volume_channel,station_type FROM corrector_device_id WHERE id = $id";
  $gasResult = mysql_query($gasQuery);

  if ($gasRow = mysql_fetch_array($gasResult))
  {
    $corrector_id = $gasRow["corrector_id"];
    $location = $gasRow["location"];
    $volume_channel = $gasRow["volume_channel"];
    $station_type = $gasRow["station_type"];
  }
}
?>
</div>
<link rel="stylesheet" type="text/css" href="/assets/admin/pages/css/profile.css"/>
<link href="/assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="/lib/js/bootstrap_validator/dist/css/bootstrapValidator.min.css"/>
<script type="text/javascript" language='javascript' src="/lib/js/bootstrap_validator/dist/js/bootstrapValidator.min.js"></script>
<style>
  .button-color{
    background-color:#35aa47;
    color: white;
  }
</style>
<div class="row" style='max-width: 1200px;'>
  <div class="col-md-12">
    <div class="portlet box green">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-industry"></i> Fabrika Ayarları
        </div>
        <div style='float: right;'>
          <a class="btn green" style='padding-top: 0px; padding-bottom: 0px;' href='listFactories.php'>
            <i class="fa fa-list"></i> Tüm Fabrikalar
          </a>
        </div>
      </div>
      <div class="portlet-body" sytle="max-width:1202px;">
        <div id="requiredField" class="alert alert-warning" style="display:none;">
          <button class="close" data-dismiss="alert"></button>
          (<span class="required" aria-required="true">*</span>) İşaretli alanları doldurunuz!
        </div>
        <form role="form" class="form-horizontal" id="frm1" name='frm1' method='POST' action='ajax/tx_updateFactoryInfo.php'>
          <input type="hidden" name="id" value="<?php echo $id; ?>"/>
          <div class="form-body">
            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label col-md-5 col-sm-6 col-xs-6">Konum <span class="required" aria-required="true">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-6">
                    <input type="text" class="form-control" id="location" placeholder="Fabrika Adı" value="<?php echo $location; ?>" name="location"/>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label col-md-5 col-sm-6 col-xs-6">Fabrika No <span class="required" aria-required="true">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-6">
                    <input type="text" class="form-control" id="corrector_id" placeholder="Fabrika No" value="<?php echo $corrector_id; ?>" name="corrector_id"/>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label col-md-5 col-sm-6 col-xs-6">Volume Channel</label>
                  <div class="col-md-6 col-sm-6 col-xs-6">
                    <select class="form-control" name="volume_channel">
                      <option value="Volume1" <?php echo ($volume_channel == 'Volume1') ? 'selected' : ''; ?>>Volume1</option>
                      <option value="Volume2" <?php echo ($volume_channel == 'Volume2') ? 'selected' : ''; ?>>Volume2</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label class="control-label col-md-5 col-sm-6 col-xs-6">İstasyon Tipi</label>
                  <div class="col-md-6 col-sm-6 col-xs-6">
                    <input type="text" class="form-control" placeholder="İstasyon Tipi" value="<?php echo $station_type; ?>" name="station_type"/>
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
  var shortCutFunction = 'error',
    msg = 'Bir hata oluştu.',
    title = 'Uyarı',
    showDuration = 1000,
    hideDuration = 1000,
    timeOut = 5000,
    extendedTimeOut = 1000,
    showEasing = 'swing',
    hideEasing = 'linear',
    showMethod = 'fadeIn',
    hideMethod = 'fadeOut',
    one_day = 86400000; // miliseconds;
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
    $('#submitButton').click(function () {
      var location = document.frm1.location.value,
        corrector_id = document.frm1.corrector_id.value;
      if (location === '' || corrector_id === '')
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
  });</script>
<script src="/js/tooltipster_func.js"></script>
<script type="text/javascript" charset="utf-8" src="/tooltipster/jquery.tooltipster.min.js"></script>
<script src="/assets/global/plugins/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/select2/select2.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>
<script src="/js/ui-toastr.js"></script>
<?php
include('../inc/bottom.php');
