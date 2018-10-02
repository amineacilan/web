<?php
include('inc/config.php');
include('inc/conn.php');
include('inc/i_conn.php');
include('inc/func.php');
include('inc/common.php');
$pageName = 'deviceSettings';
$id_auth = getParamUrl('id', 'GET', 0);
if ($id_auth == 0)
{
  $measurşng_device_id = getParamUrl('measuring_device_id', 'GET', 0);
  $sql = "SELECT id FROM measuring_device_settings WHERE measuring_device_id = '$measurşng_device_id'";
  $sorgu = mysql_query($sql, $connection);
  if ($result = mysql_query($sql, $connection))
  {
    while ($result = mysql_fetch_assoc($sorgu)) {
      $id_auth = $result['id'];
    }
  }
}
include('inc/l_control.php');
include('inc/header.php');
include('db/getTariffTypesFunction.php');

$isAnalyzer = false;
$deviceTypeCode = '';
$id = $id_auth;
$errNum = getParamUrl('errNum', 'POST', 0);

if ($errNum == 1 || $errNum == 2 || $errNum == 3)
{
  $id = getParamUrl('id', 'POST', 0);
}

if ($id == 0)
{
  if ($session_type != 'admin')
  {
    die('<br>Bu sayfayı görme yetkiniz yok!');
  }

  switch ($device_category = getParamUrl('category', 'GET', 0)) {
    case 1:
    case 2:
    case 3: break;
    case 0: die('<br>Eksik parametre!');
    default: die('<br>Yanlış parametre!');
  }
}

$ct_ratio = $vt_ratio = $day_of_invoice = 1;
$energy_unit_cost_active = '0';
$energy_unit_cost_reactive = '0';
$energy_unit_cost_T1 = '0';
$energy_unit_cost_T2 = '0';
$energy_unit_cost_T3 = '0';
$sozlesme_gucu = 60;
$consumerTariff = 6;
$has_sms_service = ($id == 0) ? 1 : 0;
$mail_alert = ($id == 0) ? 1 : 0;
$payment_state = 'open';
$is_public = $tariff_type = 0;
$usageEndTime = '';
$device_id = $comm_device_id = $tesisat_no = $location_name = $location_address = $notes = $meter_production_date = '';
$meter_brand = $meter_type_code = $meter_connection_type = '';
$has_ct30 = 0;
$columnList = 'device_category, modbus_adr, location_name, location_address,mds.has_ct30, measuring_device_id, comm_device_id, day_of_invoice, '
  . 'ct_ratio, vt_ratio, energy_unit_cost_active, energy_unit_cost_reactive, energy_unit_cost_T1, energy_unit_cost_T2, '
  . 'energy_unit_cost_T3, sozlesme_gucu, distribution_cost,transmission_cost_consumption_share,transmission_cost_power_share, energy_fund, trt_share, energy_consumption_tax, '
  . 'transformer_power, transformer_loss_unit_cost, power_unit_cost, tariff_type, meter_production_date, tesisat_no, '
  . 'is_public, meter_brand, meter_type_code, meter_connection_type, mail_alert, notes, has_sms_service, payment_state, '
  . 'lat, lon, payment_date, consumer_tariff, city_id, country_id,is_server_time ';

if ($session_type == 'admin')
{
  $authLevel = 2;
}
else
{
  $authLevel = 0;
  $result = mysql_query("SELECT auth_level FROM user WHERE email='$session_email'", $connection);

  if ($result && ($row = mysql_fetch_assoc($result)))
  {
    $authLevel = $row['auth_level'];
  }
}

if ($authLevel == 0)
{
  header("Location: deviceSettingsD.php?id={$id}");
}

if ($id > 0)
{
  $sql = "SELECT * FROM device_type JOIN measuring_device_settings AS mds ON mds.device_type = device_type.device_type_code "
    . "WHERE device_category = 3 AND mds.id = $id";

  if (($result = mysql_query($sql, $connection)) && ($row = mysql_fetch_assoc($result)))
  {
    $isAnalyzer = true;
    $deviceTypeCode = $row['device_type_code'];
  }

  $sql2 = "SELECT $columnList FROM measuring_device_settings AS mds JOIN device_type AS dt ON dt.device_type_code=mds.device_type "
    . "WHERE mds.id=$id";

  if (($result = mysql_query($sql2, $connection)) && ($row = mysql_fetch_assoc($result)))
  {

    $device_category = $row['device_category'];
    $modbusAddress = $row['modbus_adr'];
    $location_name = $row['location_name'];
    $location_address = $row['location_address'];
    $city = $row['city_id'];
    $country = $row['country_id'];
    $notes = $row['notes'];
    $tesisat_no = $row['tesisat_no'];
    $comm_device_id = $row['comm_device_id'];
    $device_id = $row['measuring_device_id'];
    $day_of_invoice = $row['day_of_invoice'];
    $ct_ratio = $row['ct_ratio'];
    $vt_ratio = $row['vt_ratio'];
    $energy_unit_cost_active = $row['energy_unit_cost_active'];
    $energy_unit_cost_reactive = $row['energy_unit_cost_reactive'];
    $sozlesme_gucu = $row['sozlesme_gucu'];
    $distribution_cost = $row['distribution_cost'];
    $transmission_cost_consumption_share = $row['transmission_cost_consumption_share'];
    $transmission_cost_power_share = $row['transmission_cost_power_share'];

    $energy_fund = $row['energy_fund'];
    $trt_share = $row['trt_share'];
    $energy_consumption_tax = $row['energy_consumption_tax'];
    $transformer_power = $row['transformer_power'];
    $transformer_loss_unit_cost = $row['transformer_loss_unit_cost'];
    $power_unit_cost = $row['power_unit_cost'];
    $meter_production_date = $row['meter_production_date'];
    $has_sms_service = $row['has_sms_service'];
    $mail_alert = $row['mail_alert'];
    $payment_state = $row['payment_state'];
    $usageEndTime = $row['payment_date'];
    $tariff_type = $row['tariff_type'];
    $energy_unit_cost_T1 = $row['energy_unit_cost_T1'];
    $energy_unit_cost_T2 = $row['energy_unit_cost_T2'];
    $energy_unit_cost_T3 = $row['energy_unit_cost_T3'];
    $consumerTariff = $row['consumer_tariff'];
    $latitude = $row['lat'];
    $longitude = $row['lon'];
    $has_ct30 = $row['has_ct30'];

    if ($device_category == 1)
    {
      $is_public = $row['is_public'];
      $meter_brand = $row['meter_brand'];
      $meter_type_code = $row['meter_type_code'];
      $meter_connection_type = $row['meter_connection_type'];
      $is_server_time = $row['is_server_time'];
    }
    $sql3 = "SELECT image_name FROM device_images WHERE measuring_device_id = '$device_id' ORDER BY id DESC LIMIT 1";

    if ($rowImg = mysql_fetch_assoc(mysql_query($sql3, $connection)))
    {
      $deviceImage = $rowImg["image_name"];
    }
  }
  else
  {
    die('<br>Cihaz bulunamadı!');
  }

  $sql4 = "SELECT is_transparent, data_read_period FROM comm_device_settings WHERE comm_device_id='$comm_device_id'";

  if ($result = mysql_query($sql4, $connection))
  {
    $is_transparent = mysql_result($result, 0, 0);
    $data_read_period = mysql_result($result, 0, 1);
  }
}
else if ($errNum == 1 || $errNum == 2 || $errNum == 3)
{
  $location_name = getParamUrl('location_name', 'POST', '');
  $location_address = getParamUrl('location_address', 'POST', '');
  $city = getParamUrl('city', 'POST', 0);
  $country = getParamUrl('country', 'POST', 0);
  $notes = getParamUrl('notes', 'POST', '');
  $tesisat_no = getParamUrl('tesisat_no', 'POST', '');
  $comm_device_id = getParamUrl('comm_device_id', 'POST', '');
  $device_category = getParamUrl('device_category', 'POST', '');
  $device_id = getParamUrl('measuring_device_id', 'POST', '');
  $energy_unit_cost_active = getParamUrl('energy_unit_cost_active', 'POST', '1');
  $energy_unit_cost_reactive = getParamUrl('energy_unit_cost_reactive', 'POST', '1');
  $sozlesme_gucu = getParamUrl('sozlesme_gucu', 'POST', '60');
  $distribution_cost = getParamUrl('distribution_cost', 'POST', '0');
  $transmission_cost_consumption_share = getParamUrl('transmission_cost_consumption_share', 'POST', '0');
  $transmission_cost_power_share = getParamUrl('transmission_cost_power_share', 'POST', '0');

  $energy_fund = getParamUrl('energy_fund', 'POST', '0');
  $trt_share = getParamUrl('trt_share', 'POST', '0');
  $energy_consumption_tax = getParamUrl('energy_consumption_tax', 'POST', '0');
  $transformer_power = getParamUrl('transformer_power', 'POST', '0');
  $transformer_loss_unit_cost = getParamUrl('transformer_loss_unit_cost', 'POST', '0');
  $power_unit_cost = getParamUrl('power_unit_cost', 'POST', '0');
  $day_of_invoice = getParamUrl('day_of_invoice', 'POST', '1');
  $ct_ratio = getParamUrl('ct_ratio', 'POST', '1');
  $vt_ratio = getParamUrl('vt_ratio', 'POST', '1');
  $meter_production_date = getParamUrl('meter_production_date', 'POST', '');
  $has_sms_service = getParamUrl('has_sms_service', 'POST', 0);
  $mail_alert = getParamUrl('mail_alert', 'POST', 0);
  $usageEndTime = getParamUrl('usageEndTime', 'POST', '');
  $payment_state = getParamUrl('payment_state', 'POST', 'open');
  $tariff_type = getParamUrl('tariff_type', 'POST', '0');
  $energy_unit_cost_T1 = getParamUrl('energy_unit_cost_T1', 'POST', '1');
  $energy_unit_cost_T2 = getParamUrl('energy_unit_cost_T2', 'POST', '1');
  $energy_unit_cost_T3 = getParamUrl('energy_unit_cost_T3', 'POST', '1');
  $latitude = getParamUrl('latitude', 'POST', '');
  $longitude = getParamUrl('longitude', 'POST', '');

  if ($device_category == 1)
  {
    $is_public = getParamUrl('is_public', 'POST', '0');
    $meter_brand = getParamUrl('meter_brand', 'POST', 0);
    $meter_type_code = getParamUrl('meter_type_code', 'POST', '');
    $meter_connection_type = getParamUrl('meter_connection_type', 'POST', '');
  }
}

if (strpos($deviceTypeCode, "GRP_EnergyMeter") !== false)
{
  if ($has_ct30 == 1)
  {
    $has_ct30_ = "CT30";
  }
  else
  {
    $has_ct30_ = "X5";
  }
}
?>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/select2/select2.css"/>
<!--<link rel="stylesheet" type="text/css" href="/assets/global/plugins/select2/lodash/select2.css"/>-->
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-toastr/toastr.min.css"/>
<link rel="stylesheet" type="text/css" href="/lib/js/bootstrap_validator/dist/css/bootstrapValidator.min.css"/>
<link href="/assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="lib/js/jquery_file_upload/css/style.css"/>
<link rel="stylesheet" href="lib/js/jquery_file_upload/css/jquery.fileupload.css"/>
<script type="text/javascript" language='javascript' src="/lib/js/bootstrap_validator/dist/js/bootstrapValidator.min.js"></script>
<style>
  .select2-container .select2-choice {
    height: 34px;
    padding-top: 3px;
  }
</style>
</div>
<?php
if ($id > 0)
{
  $d_info = new DeviceInfo();
  $d_info->CompanyName = $location_name;
  $d_info->SerialNumber = $device_id;
  $d_info->ModemId = $comm_device_id;
  $d_info->DeviceCategory = $device_category;

  include('inc/deviceInfo.php');
}
include('inc/devicePaymentControl.php');
$success = (getParamUrl('opOk', 'GET', 0) == 1) ? 'İşlem Başarılı.' : '';
$uploadErr = array("Şeçilen dosya resim dosyası olmadığı için resim kaydedilemedi.",
  "Resim boyutu çok büyük.",
  "Resimleri sadece JPG, JPEG, PNG & GIF formatlarında yükleyebilirsiniz.",
  "Resim yüklemesinde bir hata oluştu.");
$upload_message = $uploadErr[getParamUrl('uploadMsg', 'GET', 999)];
?>
<?php
$color = '';
if ($device_category == 1)
{
  $color = 'yellow';
  $icon = 'fa-tachometer';
  $headerStr = ($id == 0) ? 'Yeni Sayaç' : 'Sayaç Detay';
  $errArr = ['', 'Bu sayaç sistemde daha önceden tanımlanmış!',
    'Bir haberleşme cihazı üzerinde en fazla 32 adet sayaç tanımlanabilir!',
    'Sayaç No istenen formatta değil!'];
  $deviceNoStr = 'Sayaç No';
  $errMsg = $errArr[$errNum];
}
else if ($device_category == 2)
{
  $color = 'red';
  $icon = 'fa-share-alt';
  $headerStr = ($id == 0) ? 'Yeni Röle' : 'Röle Detay';
  $errArr = ['', 'Bu röle sistemde daha önceden tanımlanmış!',
    'Bir haberleşme cihazı üzerinde en fazla 32 adet röle tanımlanabilir!',
    'Röle Seri No istenen formatta değil!'];
  $deviceNoStr = 'Röle Seri No';
  $errMsg = $errArr[$errNum];
}
else if ($device_category == 3)
{
  $color = 'blue';
  $icon = 'fa fa-bolt';
  $headerStr = 'Analizör Detay';
  $deviceNoStr = 'Analizör Seri No';
}
// Tarife Türü
$sql = "SELECT * FROM tariff_types";
//$dataSql = "SELECT * FROM user_comm_device WHERE comm_device_id = '$comm_device_id'";
$dataSql = "SELECT * FROM user_device WHERE device_id = '$device_id'";

$result = mysql_query($dataSql, $connection);

$authUserIdArr = array();
$authUserIdArr[] = 0;

while ($row = mysql_fetch_assoc($result)) {
  $authUserIdArr[] = $row['user_id'];
}

$authUserIdStr = implode(",", $authUserIdArr);

if ($session_type == 'admin')
{
  $sql = "SELECT * FROM tariff_types where user_id IN ($authUserIdStr)";
}
else
{
  $sql = "SELECT * FROM tariff_types where user_id IN ($authUserIdStr) or user_id = $session_user_id";
}

if ($tariffTypeQuery = mysql_query($sql, $connection))
{
  while ($tariffTypeRow = mysql_fetch_assoc($tariffTypeQuery)) {
    $tariffId[] = $tariffTypeRow['id'];
    $tariffName[] = $tariffTypeRow['tariff_name'];
  }
}

if ($consumerTariff !== '0')
{
  $dbGetTariffTypes = new DbGetTariffTypes();
  $dbGetTariffTypes->TariffId = $consumerTariff;
  $dbGetTariffTypes->UserId = $session_user_id;
  $dbGetTariffTypes->UserType = $session_type;
  $tariffTypeParameters = getTariffTypes($dbGetTariffTypes);

  $distribution_cost = (float) $tariffTypeParameters->UnitCostDistribution;
  $transmission_cost_consumption_share = (float) $tariffTypeParameters->TransmissionCostConsumptionShare;
  $transmission_cost_power_share = (float) $tariffTypeParameters->TransmissionCostPowerShare;

  $energy_fund = (float) $tariffTypeParameters->EnergyFund;
  $trt_share = (float) $tariffTypeParameters->TrtShare;
  $energy_consumption_tax = (float) $tariffTypeParameters->EnergyConsumptionTax;
  $transformer_power = (float) $tariffTypeParameters->TransformerPower;
  $transformer_loss_unit_cost = (float) $tariffTypeParameters->TransformerLossUnitCost;
  $power_unit_cost = (float) $tariffTypeParameters->PowerUnitCost;

  $energy_unit_cost_active = (float) $tariffTypeParameters->UnitCostActive;
  $energy_unit_cost_reactive = (float) $tariffTypeParameters->UnitCostReactive;
  $energy_unit_cost_T1 = (float) $tariffTypeParameters->UnitCostT1;
  $energy_unit_cost_T2 = (float) $tariffTypeParameters->UnitCostT2;
  $energy_unit_cost_T3 = (float) $tariffTypeParameters->UnitCostT3;
}


$commDeviceArr = array();
if ($resultIn = mysql_query('SELECT comm_device_id FROM comm_device_settings ORDER BY comm_device_id', $connection))
{

  class CommDeviceInfo
  {

    public $id;
    public $text;

  }

  while ($rowIn = mysql_fetch_assoc($resultIn)) {

    $comm_device_idDb = $rowIn['comm_device_id'];
    $commDevice = new CommDeviceInfo();
    $commDevice->id = $comm_device_idDb;
    $commDevice->text = $comm_device_idDb;
    $commDeviceArr[] = $commDevice;
  }
}
?>
<style>
  div.checker span
  {
    display: initial;
  }

  .form-control:focus
  {
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6);
  }

  #deviceSettingsForm .form-control-feedback
  {
    right: 15px;
  }
  #deviceSettingsForm .selectContainer .form-control-feedback
  {
    right: 25px;
  }

  .input-icon.right > i
  {
    right: 18px;
  }

  .hiddenMode
  {
    display: none;
  }

  .img-effect
  {
    -moz-box-shadow: 0 0 2px 2px #888;
    -webkit-box-shadow: 0 0 2px 2px #888;
    box-shadow: 0 0 2px 2px #888;
    max-height: 250px !important;

  }

  .modal-dialog
  {
    position: relative;
    width: 100% !important;
    margin: 0 !important;
  }
</style>
<?php
if ($id == 0 && $device_category == 1)
{
  ?>
  <div class="modal fade" id="basic" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top: 10%;">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h4 class="modal-title" id="myModalLabel"> <b>Firma Kodları</b> (Format : ABC12345678) </h4>
    </div>
    <div class="modal-body" >
      <tbody>
        <tr>
          <td>
            <table>
              <tbody>
                <tr>
                  <td class="txtBlack_b">Marka</td>
                  <td>&nbsp;</td>
                  <td class="txtBlack_b">Firma</td>
                  <td>&nbsp;</td>
                  <td class="txtBlack_b">Flag Kodu</td>
                </tr>
                <tr>
                  <td colspan="5" class="txtBlack_b"><hr width="250" align="left"></td>
                </tr>
                <tr>
                  <td class="txtBlack">ESEM</td>
                  <td>&nbsp;</td>
                  <td class="txtBlack">Monosan A.Ş.</td>
                  <td>&nbsp;</td>
                  <td class="txtBlack">ESI</td>
                </tr>
                <tr>
                  <td class="txtBlack">KÖHLER</td>
                  <td>&nbsp;</td>
                  <td class="txtBlack">Köhler A.Ş.</td>
                  <td>&nbsp;</td>
                  <td class="txtBlack">AEL / KHL</td>
                </tr>
                <tr>
                  <td class="txtBlack">MAKEL</td>
                  <td>&nbsp;</td>
                  <td class="txtBlack">Mak-Say Ltd.Şti.</td>
                  <td>&nbsp;</td>
                  <td class="txtBlack">MSY</td>
                </tr>
                <tr>
                  <td class="txtBlack">Vİ-KO</td>
                  <td>&nbsp;</td>
                  <td class="txtBlack">Viko A.Ş.</td>
                  <td>&nbsp;</td>
                  <td class="txtBlack">VIK</td>
                </tr>
                <tr>
                  <td class="txtBlack">LUNA</td>
                  <td>&nbsp;</td>
                  <td class="txtBlack">Protokol San. Tic.</td>
                  <td>&nbsp;</td>
                  <td class="txtBlack">LUN</td>
                </tr>
                <tr>
                  <td class="txtBlack">ALFATECH</td>
                  <td>&nbsp;</td>
                  <td class="txtBlack">Elektromed A.Ş.</td>
                  <td>&nbsp;</td>
                  <td class="txtBlack">ELM</td>
                </tr>
                <tr>
                  <td class="txtBlack">ELSTER</td>
                  <td>&nbsp;</td>
                  <td class="txtBlack">Elster Ltd.Şti.</td>
                  <td>&nbsp;</td>
                  <td class="txtBlack">ABB / ELS</td>
                </tr>
                <tr>
                  <td class="txtBlack">LANDIS</td>
                  <td>&nbsp;</td>
                  <td class="txtBlack">Landis Ltd.Şti.</td>
                  <td>&nbsp;</td>
                  <td class="txtBlack">LGZ</td>
                </tr>
                <tr>
                  <td class="txtBlack">KAAN</td>
                  <td>&nbsp;</td>
                  <td class="txtBlack">Başarı A.Ş.</td>
                  <td>&nbsp;</td>
                  <td class="txtBlack">BSE</td>
                </tr>
                <tr>
                  <td class="txtBlack">ORBIS</td>
                  <td>&nbsp;</td>
                  <td class="txtBlack">Elma Ltd.Şti.</td>
                  <td>&nbsp;</td>
                  <td class="txtBlack">ORB</td>
                </tr>
                <tr>
                  <td class="txtBlack">ONUR</td>
                  <td>&nbsp;</td>
                  <td class="txtBlack">Onur A.Ş.</td>
                  <td>&nbsp;</td>
                  <td class="txtBlack">ONR</td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
    </div>
  </div>
<?php } ?>
<div class="tab-content">
  <div class="row">
    <div class="col-md-12 ">
      <div class="tab-pane " id="tab_2">
        <div class="portlet box <?php echo $color; ?>">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa <?php echo $icon; ?>"></i><?php echo $headerStr; ?>
            </div>
          </div>
          <div class="portlet-body">
            <div id="requiredField" class="alert alert-warning" style="display:none;">
              <button class="close" data-dismiss="alert"></button>
              İşaretli alanları doldurunuz!
            </div>
            <form role="form" class="form-horizontal" id="deviceSettingsForm" name='frm1' method='post' action='tx_deviceSettings.php'  enctype="multipart/form-data">
              <input type="hidden" name="id" value="<?php echo $id; ?>"/>
              <input type="hidden" name="device_category" value="<?php echo $device_category; ?>"/>
              <div class="form-body">
                <h3 class="form-section">Genel Ayarlar</h3>
                <div class="row">
                  <?php
                  if ($id > 0)
                  {
                    ?>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label class="control-label col-md-5 col-sm-6 col-xs-6"><?php echo $deviceNoStr; ?></label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                          <p class="form-control-static">
                            <?php echo $device_id; ?>
                          <input type="hidden" value="<?php echo $device_id; ?>" name="measuring_device_id"/>
                          </p>
                        </div>
                      </div>
                    </div>
                    <?php
                  }
                  else
                  {
                    ?>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label class="control-label col-md-5 col-sm-6 col-xs-6"><?php echo $deviceNoStr; ?><span class="required" aria-required="true">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                          <input type="text" class="form-control" name="measuring_device_id" placeholder="Sayaç No"/>
                          <?php
                          if ($device_category == 1)
                          {
                            ?>
                            <small> (Format : ABC12345678)</small> <a href="javascript:void(0);" data-toggle='modal' data-target='#basic' >
                              Firma Kodları</a>
                            <?php
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                    <?php
                  }
                  ?>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group selectContainer">
                      <label class="control-label col-md-5 col-sm-6 col-xs-6">Modem ID
                        <?php
                        if ($id > 0)
                        {

                        }
                        else
                        {
                          ?>
                          <span class="required" aria-required="true">*</span>
                          <?php
                        }
                        ?>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <?php
                        if ($id > 0)
                        {
                          ?>
                          <p class="form-control-static">
                            <?php echo $comm_device_id; ?>
                          </p>
                          <input type="hidden" value="<?php echo $comm_device_id; ?>" name="comm_device_id"/>
                          <?php
                        }
                        else
                        {
                          ?>
                          <input type="text" name="comm_device_id" class="form-control" id="comm_device_id" value="<?php echo $comm_device_id; ?>"/>
                          <?php
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                </div>

                <?php
                if ($is_transparent == 1 && $id > 0)
                {
                  ?>
                  <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label class="control-label col-md-5 col-sm-6 col-xs-6">Modbus Adresi</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                          <p class="form-control-static">
                            <?php echo $modbusAddress; ?>
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php } ?>
                <div class="row">
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label class="control-label col-md-5 col-sm-6 col-xs-6">İşletme Adı</label>
                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" placeholder="İşletme Adı" value="<?php echo htmlentities($location_name); ?>" name="location_name"/>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label class="control-label col-md-5 col-sm-6 col-xs-6">Tesisat No</label>
                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" placeholder="Tesisat No" value="<?php echo htmlentities($tesisat_no); ?>" name="tesisat_no"/>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label class="control-label col-md-5 col-sm-6 col-xs-6">İl Seçiniz</label>
                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <select class="form-control" name="city" id="city">
                          <option value="0">--- İl Seç ---</option>
                          <?php
                          $cityResult = mysql_query("SELECT * FROM city ORDER BY city ASC", $connection);
                          while ($cityRow = mysql_fetch_array($cityResult)) {
                            echo "<option value='" . $cityRow["id"] . "' " . (($cityRow["id"] == $city) ? "selected" : "") . ">" . $cityRow["city"] . "</option>";
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label class="control-label col-md-5 col-sm-6 col-xs-6">İlçe Seçiniz</label>
                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <select class="form-control" name="country" id="country">
                          <option value="0">--- İlçe Seç ---</option>
                          <?php
                          $countryResult = mysql_query("SELECT * FROM country WHERE city_id=$city ORDER BY country ASC", $connection);
                          while ($countryRow = mysql_fetch_array($countryResult)) {
                            echo "<option value='" . $countryRow["id"] . "' " . (($countryRow["id"] == $country) ? "selected" : "") . ">" . $countryRow["country"] . "</option>";
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label class="control-label col-md-5 col-sm-6 col-xs-6">Enlem</label>
                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" placeholder="Enlem" value="<?php echo htmlentities($latitude); ?>" name="latitude"/>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label class="control-label col-md-5 col-sm-6 col-xs-6">Boylam</label>
                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" placeholder="Boylam" value="<?php echo htmlentities($longitude); ?>" name="longitude"/>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label class="control-label col-md-5 col-sm-6 col-xs-6">Adres</label>
                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <textarea class ="form-control" rows="3" name="location_address"><?php echo htmlentities($location_address); ?></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-5 col-sm-6 col-xs-6">Notlar</label>
                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <textarea class ="form-control" rows="3" name="notes"><?php echo htmlentities($notes); ?></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label class="control-label col-md-5 col-sm-6 col-xs-6">Resim Yükle</label>
                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <center>
                          <div class="imageDiv">
                            <?php
                            if (htmlentities($deviceImage) != "")
                            {
                              ?>
                              <a href="javascript:deleteDeviceImg('<?php echo $device_id; ?>')" class="fancybox-close" style="top: -20px; right: -3px; z-index:8000 !important;" title="Resmi Sil"></a>
                              <a class="fancybox effect7 fancyUpload" href="<?php echo $deviceImage; ?>" title="Cihaz Resmi">
                                <img class="img-responsive img-effect" id="uploaded_image" src="<?php echo $deviceImage; ?>" alt="">
                              </a>
                              <?php
                            }
                            ?>
                          </div>
                        </center>
                        <br>
                        <span class="btn btn-success fileinput-button" style="width: 100%;">
                          <i class="glyphicon glyphicon-plus"></i>
                          <span><br>Resmi Seçin<br>veya<br>Bu Alana Sürükleyin</span>
                          <input id="fileupload" type="file" name="files[]" multiple>
                        </span>
                        <p style="color:#B64545; text-align:center; font-size:11px;">Max. Dosya Boytu: 1 MB</p>
                        <div id="progress" class="progress">
                          <div class="progress-bar progress-bar-success"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <?php
                  if (($device_category == 1) || ($isAnalyzer && $deviceTypeCode != 'GRP_EnergyMeter_Screen' && $deviceTypeCode != 'GRP_EnergyMeter_Screen_V2' && $deviceTypeCode != 'GRP_EnergyMeter_Screen_V3'))
                  {
                    ?>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class ="form-group">
                        <label class="control-label col-md-5 col-sm-6 col-xs-6">Akım Trafosu Oranı</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                          <select class="form-control"  name="ct_ratio" id="ct_ratio">
                            <?php
                            $ctRatioArr = array(5, 10, 15, 20, 25, 30, 40, 50, 60, 75, 80, 90, 100, 120, 125, 150, 160, 175, 200, 250, 300, 350, 400, 500, 600, 750, 800, 1000, 1200, 1250, 1500, 1600, 1800, 2000, 2500, 3000, 3200, 4000, 5000, 6000, 7500, 8000, 10000);
                            $vtRatioArr = array(1, 63, 105, 150, 158, 300, 315, 330, 345, 360);
                            foreach ($ctRatioArr as $value) {
                              $selected = (($ct_ratio * 5 == $value) ? 'selected' : '');
                              echo "<option $selected value='$value'>{$value}/5</option>";
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label class="control-label col-md-5 col-sm-6 col-xs-6">Gerilim Trafosu Oranı</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                          <select class="form-control" name="vt_ratio" id="vt_ratio">
                            <?php
                            foreach ($vtRatioArr as $value) {
                              $selected = (($vt_ratio == $value) ? 'selected' : '');
                              echo "<option $selected value='$value'>{$value}</option>";
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <?php
                  }
                  ?>
                </div>
                <div class="row">
                  <?php
                  if (($device_category == 1) || ($isAnalyzer && $deviceTypeCode != 'GRP_EnergyMeter_Screen' && $deviceTypeCode != 'GRP_EnergyMeter_Screen_V2' && $deviceTypeCode != 'GRP_EnergyMeter_Screen_V3'))
                  {
                    ?>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label class="control-label col-md-5 col-sm-6 col-xs-6">Çarpan</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                          <input type="text" class="form-control" placeholder="Çarpan" value="<?php echo ($ct_ratio * $vt_ratio); ?>" id="tdFactor" disabled/>
                        </div>
                      </div>
                    </div>
                    <?php
                  }

                  if ($isAnalyzer && ($deviceTypeCode == 'GRP_EnergyMeter_Screen' || $deviceTypeCode == 'GRP_EnergyMeter_Screen_V2' || $deviceTypeCode == 'GRP_EnergyMeter_Screen_V3'))
                  {
                    ?>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label class="control-label col-md-5 col-sm-6 col-xs-6">Çarpan</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                          Ekranlı analizörler için çarpan değerinizi cihazın ekranından veya kontrol sayfasından ayarlayabilirsiniz.
                          <a href="control.php?id=<?php echo $device_id; ?>" target="_blank">Kontrol</a>
                          / <a href="control.php?id=<?php echo $device_id; ?>&active=4" target="_blank">Parametreler</a> sayfasına gidiniz.
                        </div>
                      </div>
                    </div>
                    <?php
                  }

                  if ($id > 0)
                  {
                    ?>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label class="control-label col-md-5 col-sm-6 col-xs-6">Veri Gönderme Aralığı</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                          <?php
                          if ($is_transparent == 0)
                          {
                            $readPeriodArr = array(1, 5, 15, 30, 45, 60, 120, 180, 240);
                            ?>
                            <input type="hidden" name="data_read_period" id="data_read_period" value=""/>
                            <select class="form-control" name="selectReadPeriod" id="selectReadPeriod">
                              <?php
                              foreach ($readPeriodArr as $value) {
                                $selected = (($data_read_period == $value) ? 'selected' : '');
                                echo "<option $selected value='$value'>{$value}</option>";
                              }
                              ?>
                            </select>
                            <?php
                          }
                          else if ($is_transparent == 1)
                          {
                            ?>
                            <a href="control.php?id=<?php echo $device_id; ?>" target="_blank">Kontrol</a>
                            / <a href="control.php?id=<?php echo $device_id; ?>&active=5" target="_blank">Periyodik Okuma Ayarları</a> 'na gidiniz.
                            <?php
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                    <?php
                  }
                  ?>
                </div>
                <div class="row">
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label class="control-label col-md-5 col-sm-6 col-xs-6">Üretim Yılı</label>
                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" placeholder="Üretim Yılı" value="<?php echo $meter_production_date; ?>" name="meter_production_date"/>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label class="control-label col-md-5 col-sm-6 col-xs-6">Ayın Fatura Günü</label>
                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <select class="form-control" name="day_of_invoice">
                          <?php
                          for ($i = 1; $i <= 28; $i++) {
                            $selected = (($i == $day_of_invoice) ? 'selected' : '');
                            echo "<option $selected value='$i'>{$i}</option>";
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <?php
                  if ($device_category == 1)
                  {
                    ?>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label class="control-label col-md-5 col-sm-6 col-xs-6">Sayaç Markası</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                          <select class="form-control" name="meter_brand">
                            <option value="0">---</option>
                            <?php
                            if ($result = mysql_query('SELECT id, brand FROM meter_brand ORDER BY brand', $connection))
                            {
                              while ($row = mysql_fetch_assoc($result)) {
                                $brandId = $row['id'];
                                $brand = $row['brand'];
                                $selected = (($meter_brand == $brandId) ? 'selected' : '');
                                echo "<option $selected value='$brandId'>{$brand}</option>";
                              }
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label class="control-label col-md-5 col-sm-6 col-xs-6">Bağlantı Şekli</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                          <select class="form-control" name="meter_connection_type">
                            <option value="0">---</option>
                            <option <?php
                            if ($meter_connection_type == 'RS485')
                            {
                              ?> selected <?php } ?> value="RS485">RS485</option>
                            <option <?php
                            if ($meter_connection_type == 'Optik')
                            {
                              ?> selected <?php } ?> value="Optik">Optik</option>
                            <option <?php
                            if ($meter_connection_type == 'RS232')
                            {
                              ?> selected <?php } ?> value="RS232">RS232</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <?php
                  }
                  ?>
                </div>
                <div class="row">
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label class="control-label col-md-5 col-sm-6 col-xs-6">Mail Uyarıları Aktif ?</label>
                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <input type="checkbox" value="1" <?php
                        if ($mail_alert == 1)
                        {
                          ?>checked
                               <?php } ?>name="mail_alert"/>
                      </div>
                    </div>
                  </div>
                  <?php
                  if ($paymentSupport)
                  {
                    ?>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label class="control-label col-md-5 col-sm-6 col-xs-6">Son Kullanım Tarihi</label>
                        <div id="sandbox-container" class ="col-md-6 col-sm-6 col-xs-6">
                          <?php
                          if ($session_type === 'admin')
                          {
                            ?>
                            <input type="text" id="usageEndTime" style="cursor:pointer;" class="form-control" value="<?php echo date_create($usageEndTime)->format('d.m.Y'); ?>" name="usageEndTime"/>
                            <?php
                          }
                          else
                          {
                            ?>
                            <p class='form-control-static'>
                              <?php echo date_create($usageEndTime)->format('d.m.Y'); ?>
                            </p>
                            <?php
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                    <?php
                  }
                  ?>
                </div>
                <?php
                if ($session_type == 'admin')
                {
                  ?>
                  <div class="row">
                    <?php
                    if ($smsSupport)
                    {
                      ?>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <label class="control-label col-md-5 col-sm-6 col-xs-6">SMS Hizmeti Mevcut ?</label>
                          <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="checkbox" value="1" <?php
                            if ($has_sms_service == 1)
                            {
                              ?> checked <?php } ?> name="has_sms_service"/>
                          </div>
                        </div>
                      </div>
                      <?php
                    }
                    else
                    {
                      ?>
                      <input type="hidden" value="<?php echo $has_sms_service; ?>" name="has_sms_service"/>
                      <?php
                    }

                    if ($paymentSupport)
                    {
                      ?>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <label class="control-label col-md-5 col-sm-6 col-xs-6">Ödemeden Muaf ?</label>
                          <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="checkbox" value="1" <?php
                            if ($payment_state == 'free')
                            {
                              ?> checked <?php } ?> name="payment_state"/>
                            <input type="hidden" value="<?php echo $payment_state; ?>" name="cur_payment_state"/>
                          </div>
                        </div>
                      </div>
                      <?php
                    }
                    ?>
                  </div>
                  <?php
                }
                else
                {
                  ?>
                  <input type="hidden" value="<?php echo $has_sms_service; ?>" name="has_sms_service"/>
                  <?php
                }
                ?>
                <div class="row">
                  <?php
                  if ($device_category == 1)
                  {
                    ?>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label class="control-label col-md-5 col-sm-6 col-xs-6">Tip Kodu</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                          <input type="text" class="form-control" placeholder="Tip Kodu" value="<?php echo $meter_type_code; ?>" name="meter_type_code"/>
                        </div>
                      </div>
                    </div>
                    <?php
                  }
                  ?>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label class="control-label col-md-5 col-sm-6 col-xs-6">Sözleşme Gücü (kW)</label>
                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <input value="<?php echo $sozlesme_gucu; ?>" class="form-control" name="sozlesme_gucu" id="sozlesme_gucu"/>
                      </div>
                    </div>
                  </div>
                  <?php
                  if ($device_category == 1)
                  {
                    ?>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label class="control-label col-md-5 col-sm-6 col-xs-6">Veri Zamanı</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                          <select class="form-control" name="is_server_time">
                            <option value="1" <?php echo ($is_server_time == 1) ? 'selected' : ''; ?>>Sunucu Saati</option>
                            <option value="0" <?php echo ($is_server_time == 0) ? 'selected' : ''; ?>>Sayaç Saati</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <?php
                  }
                  ?>
                  <?php
                  if ($device_category == 3)
                  {
                    if (strpos($deviceTypeCode, "GRP_EnergyMeter") !== false)
                    {
                      ?>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <label class="control-label col-md-5 col-sm-6 col-xs-6">Akım Trafosu Tipi</label>
                          <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" class="form-control" readonly value="<?php echo $has_ct30_; ?>"/>
                          </div>
                        </div>
                      </div>
                      <?php
                    }
                  }
                  ?>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="alert alert-warning text-center">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                      Alarm ayarlarının (SMS ayarları, reaktif limit ayarları vb.) yeri değiştirilmiştir. Bu ayarları üst taraftaki alarm sekmesinden yapabilirsiniz.
                    </div>
                  </div>
                </div>
                <?php
                if ($billSupport)
                {
                  ?>
                  <h3 class="form-section">Fatura Ayarları</h3>
                  <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group tarife_sec">
                        <label class="control-label col-md-6">Tarife Tipi</label>
                        <div class="col-md-6">
                          <select class="bs-select form-control" data-style="yellow" id="tariffType" name="tariffType">
                            <option value="0" selected>Özel Tarife</option>
                            <?php
                            foreach ($tariffId as $key => $value) {
                              ?>
                              <option value="<?php echo $value; ?>" <?php echo ($value == $consumerTariff) ? 'selected' : ''; ?> ><?php echo $tariffName[$key]; ?></option>
                              <?php
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <p style="color:red">
                        Bu tarifeler dışında birim fiyatlara sahipseniz sayaca ait birim fiyatları fatura tipini
                        'Özel Tarife' seçerek belirleyebelirsiniz.
                        Yandaki tarifelerin dışında yeni bir tarife tanımlamak için <a href="/updateTariff.php" target="_blank">tıklayın.</a>
                      </p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label class="control-label col-md-6 col-sm-3 col-xs-12">Tarife Türü</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <div class="radio-list">
                            <label>
                              <input type="radio" onchange="setEnableInputs()" name="tariff_type" value="0" <?php
                              if ($tariff_type == 0)
                              {
                                ?> checked <?php } ?>/>
                              Tek Zamanlı Tarife
                            </label>
                            <label>
                              <input type="radio" onchange="setEnableInputs()" name="tariff_type" value="1" <?php
                              if ($tariff_type == 1)
                              {
                                ?> checked <?php } ?>/>
                              Üç Zamanlı Tarife
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div id="tariffForm">
                    <div class="row">
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <label class="control-label col-md-6 col-sm-6 col-xs-12">Aktif Birim Fiyat (TL/kW·h)</label>
                          <div class="col-md-6 col-sm-6 col-xs-12 col-xs-12 energy_unit_cost_active_div">
                            <input value="<?php echo $energy_unit_cost_active; ?>" class="form-control" name="energy_unit_cost_active" id="energy_unit_cost_active" <?php
                            if ($tariff_type == 1 || $consumerTariff !== '0')
                            {
                              ?> disabled <?php } ?>/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <label class="control-label col-md-6 col-sm-6 col-xs-12">Reaktif Birim Fiyat (TL/kVAr·h)</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="<?php echo $energy_unit_cost_reactive; ?>" class="form-control" name="energy_unit_cost_reactive" id="energy_unit_cost_reactive" <?php echo $consumerTariff == '0' ? '' : 'disabled'; ?>/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <label class="control-label col-md-6 col-sm-6 col-xs-12">Gündüz (T1) Birim Fiyat (TL/kW·h)</label>
                          <div class="col-md-6 col-sm-6 col-xs-12 energy_unit_cost_T1_div">
                            <input value="<?php echo $energy_unit_cost_T1; ?>" class="form-control" name="energy_unit_cost_T1" id="energy_unit_cost_T1" <?php
                            if ($tariff_type == 0 || $consumerTariff !== '0')
                            {
                              ?> disabled <?php } ?>/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <label class="control-label col-md-6 col-sm-6 col-xs-12">Puant (T2) Birim Fiyat (TL/kW·h)</label>
                          <div class="col-md-6 col-sm-6 col-xs-12 energy_unit_cost_T2_div">
                            <input value="<?php echo $energy_unit_cost_T2; ?>" class="form-control" name="energy_unit_cost_T2" id="energy_unit_cost_T2" <?php
                            if ($tariff_type == 0 || $consumerTariff !== '0')
                            {
                              ?> disabled <?php } ?>/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <label class="control-label col-md-6 col-sm-6 col-xs-12">Gece (T3) Birim Fiyat (TL/kW·h)</label>
                          <div class="col-md-6 col-sm-6 col-xs-12 energy_unit_cost_T3_div">
                            <input value="<?php echo $energy_unit_cost_T3; ?>" class="form-control" name="energy_unit_cost_T3" id="energy_unit_cost_T3" <?php
                            if ($tariff_type == 0 || $consumerTariff !== '0')
                            {
                              ?> disabled <?php } ?>/>
                          </div>
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                          <label class="control-label col-md-6 col-sm-6 col-xs-12">Dağıtım Bedeli (TL/kW·h)</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="distribution_cost" id="distribution_cost" class="form-control" value="<?php echo $distribution_cost; ?>" <?php echo $consumerTariff == '0' ? '' : 'disabled'; ?>/>
                          </div>
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                          <label class="control-label col-md-6 col-sm-6 col-xs-12">İletim Bedeli (Tük. Payı) (TL/kW·h)</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="transmission_cost_consumption_share" id="transmission_cost_consumption_share" class="form-control" value="<?php echo $transmission_cost_consumption_share; ?>" <?php echo $consumerTariff == '0' ? '' : 'disabled'; ?>/>
                          </div>
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                          <label class="control-label col-md-6 col-sm-6 col-xs-12">İletim Bedeli (Güç Payı) (TL/kW·h)</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="transmission_cost_power_share" id="transmission_cost_power_share" class="form-control" value="<?php echo $transmission_cost_power_share; ?>" <?php echo $consumerTariff == '0' ? '' : 'disabled'; ?>/>
                          </div>
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                          <label class="control-label col-md-6 col-sm-6 col-xs-12">Enerji Fonu (%)</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="energy_fund" id="energy_fund" class="form-control" value="<?php echo $energy_fund; ?>" <?php echo $consumerTariff == '0' ? '' : 'disabled'; ?>/>
                          </div>
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                          <label class="control-label col-md-6 col-sm-6 col-xs-12">TRT Payı (%)</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="trt_share" id="trt_share" class="form-control" value="<?php echo $trt_share; ?>" <?php echo $consumerTariff == '0' ? '' : 'disabled'; ?>/>
                          </div>
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                          <label class="control-label col-md-6 col-sm-6 col-xs-12">Elek. Tük. Vergisi (%)</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="energy_consumption_tax" id="energy_consumption_tax" class="form-control" value="<?php echo $energy_consumption_tax; ?>" <?php echo $consumerTariff == '0' ? '' : 'disabled'; ?>/>
                          </div>
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                          <label class="control-label col-md-6 col-sm-6 col-xs-12">Trafo Kaybı Birim Fiyat (TL/kW·h)</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="transformer_loss_unit_cost" id="transformer_loss_unit_cost" class="form-control" value="<?php echo $transformer_loss_unit_cost; ?>" <?php echo $consumerTariff == '0' ? '' : 'disabled'; ?>/>
                          </div>
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                          <label class="control-label col-md-6 col-sm-6 col-xs-12">Trafo Gücü (kV·A)</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="bs-select form-control" data-style="yellow" id="transformer_power" name="transformer_power">
                              <option value="50" <?php if ($transformer_power == 50) echo "selected"; ?>>50</option>
                              <option value="100" <?php if ($transformer_power == 100) echo "selected"; ?>>100</option>
                              <option value="160" <?php if ($transformer_power == 160) echo "selected"; ?>>160</option>
                              <option value="250" <?php if ($transformer_power == 250) echo "selected"; ?>>250</option>
                              <option value="400" <?php if ($transformer_power == 400) echo "selected"; ?>>400</option>
                              <option value="500" <?php if ($transformer_power == 500) echo "selected"; ?>>500</option>
                              <option value="1000" <?php if ($transformer_power == 1000) echo "selected"; ?>>1000</option>
                              <option value="1500" <?php if ($transformer_power == 1500) echo "selected"; ?>>1500</option>
                              <option value="2000" <?php if ($transformer_power == 2000) echo "selected"; ?>>2000</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                          <label class="control-label col-md-6 col-sm-6 col-xs-12">Güç Birim Fiyatı (TL/kVA)</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="power_unit_cost" id="power_unit_cost" class="form-control" value="<?php echo $power_unit_cost; ?>" <?php echo $consumerTariff == '0' ? '' : 'disabled'; ?>/>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php
                }
                ?>
              </div>
              <div class="form-actions fluid">
                <div class="row">
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="col-md-offset-3 col-sm-offset-3 col-md-9 col-sm-9 col-xs-3">
                      <button id="submitButton" name="b1" class="btn blue">Kaydet</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
</div>
<script>
  var success = '<?php echo $success; ?>',
    shortCutFunction = 'success',
    msg = 'Işlem Başarılı',
    title = 'Bilgilendirme',
    showDuration = 1000,
    hideDuration = 1000,
    timeOut = 5000,
    extendedTimeOut = 1000,
    showEasing = 'swing',
    hideEasing = 'linear',
    showMethod = 'fadeIn',
    hideMethod = 'fadeOut',
    id = <?php echo $id; ?>;

  var errorMsg = '<?php echo $errMsg; ?>';
  var commDeviceArray = $.parseJSON('<?php echo escapeJsonString(json_encode($commDeviceArr)); ?>');

  var device_id = "<?php echo $device_id; ?>";
  config_title = 'Ayarlar - ' + device_id;

  $(document).ready(function () {

    if (errorMsg != '') {
      shortCutFunction = 'error';
      title = 'Hata';
      msg = errorMsg;
      toastr.options = {
        closeButton: true,
        debug: false,
        positionClass: 'toast-top-center',
        onclick: null
      };
      UIToastr.init();
    }

    $("#city").change(function () {
      var city = $("#city").val();

      $.ajax({
        type: 'POST',
        url: 'ajax/getCountries.php',
        data: {
          city: city
        },
        success: function (response) {
          var countryArr = $.parseJSON(response);

          $("#country").html('<option value="0">--- İlçe Seç ---</option>');

          $.each(countryArr, function (i, country) {
            $("#country").append('<option value="' + country.Id + '">' + country.Name + '</option>');
          });
        }
      });
    });

    //  $("#city").trigger("change");

    $("#comm_device_id").select2({
      width: "100%",
      allowClear: true,
      placeholder: "Modem Seçiniz",
      initSelection: function (element, callback) {
        var selection = _.find(commDeviceArray, function (metric) {
          return metric.id === element.val();
        });
        callback(selection);
      },
      query: function (options) {
        var pageSize = 20;
        var startIndex = (options.page - 1) * pageSize;
        var filteredData = commDeviceArray;
        if (options.term && options.term.length > 0) {
          if (!options.context) {
            var term = options.term.toLowerCase();
            options.context = commDeviceArray.filter(function (metric) {
              return (metric.text.toLowerCase().indexOf(term) !== -1);
            });
          }
          filteredData = options.context;
        }

        options.callback({
          context: filteredData,
          results: filteredData.slice(startIndex, startIndex + pageSize),
          more: (startIndex + pageSize) < filteredData.length
        });
      }
    }).on("change", function (e) {
      $(this).trigger("blur");
    });



    $(".fancybox").fancybox({
      maxWidth: 800,
      maxHeight: 600,
      fitToView: false,
      width: '70%',
      height: '70%'
    });

    if (success !== '')
    {
      toastr.options = {
        closeButton: true,
        debug: false,
        positionClass: 'toast-top-center',
        onclick: null
      };
      UIToastr.init();
    }
    setEnableInputs();

    $("#upload_image").change(function () {
      $(".imageDiv").html("<center><img src='/images/loading.gif' style='margin:20px; width: 35px;'/></center>");

      frm1.submit();
    });

    $('#deviceSettingsForm').bootstrapValidator({
      // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      trigger: 'blur',
      fields: {
        measuring_device_id: {
          message: 'Geçersiz sayaç no.',
          validators: {
            notEmpty: {
              message: 'Bir değer giriniz'
            },
            regexp: {
              regexp: /^[a-zA-Z0-9]+$/,
              message: 'Geçerli bir değer giriniz'
            }
          }
        },
        comm_device_id: {
          validators: {
            notEmpty: {
              message: 'Bir modem seçiniz'
            }
          }
        }
      },
      onError: function (e) {
        //        console.log("error");
      },
      onSuccess: function (e) {
        //        console.log("success");
      }
    }).bootstrapValidator('validate');

    $('#submitButton').click(function () {
      controlInputs(document.frm1);
    });

    $('#tariffForm').bootstrapValidator({
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      trigger: 'blur',
      fields: {
        energy_unit_cost_active: {
          message: 'Geçersiz değer.',
          validators: {
            notEmpty: {
              message: 'Bir değer giriniz'
            },
            regexp: {
              regexp: /^[0-9 .]+$/,
              message: 'Geçersiz karakter kullandınız'
            }
          }
        },
        energy_unit_cost_T1: {
          message: 'Geçersiz değer.',
          validators: {
            notEmpty: {
              message: 'Bir değer giriniz'
            },
            regexp: {
              regexp: /^[0-9 .]+$/,
              message: 'Geçersiz karakter kullandınız'
            }
          }
        },
        energy_unit_cost_T2: {
          message: 'Geçersiz değer.',
          validators: {
            notEmpty: {
              message: 'Bir değer giriniz'
            },
            regexp: {
              regexp: /^[0-9 .]+$/,
              message: 'Geçersiz karakter kullandınız'
            }
          }
        },
        energy_unit_cost_T3: {
          message: 'Geçersiz değer.',
          validators: {
            notEmpty: {
              message: 'Bir değer giriniz'
            },
            regexp: {
              regexp: /^[0-9 .]+$/,
              message: 'Geçersiz karakter kullandınız'
            }
          }
        },
        energy_unit_cost_reactive: {
          message: 'Geçersiz değer.',
          validators: {
            notEmpty: {
              message: 'Bir değer giriniz'
            },
            regexp: {
              regexp: /^[0-9 .]+$/,
              message: 'Geçersiz karakter kullandınız'
            }
          }
        },
        distribution_cost: {
          message: 'Geçersiz değer.',
          validators: {
            notEmpty: {
              message: 'Bir değer giriniz'
            },
            regexp: {
              regexp: /^[0-9 .]+$/,
              message: 'Geçersiz karakter kullandınız'
            }
          }
        },
        transmission_cost_power_share: {
          message: 'Geçersiz değer.',
          validators: {
            notEmpty: {
              message: 'Bir değer giriniz'
            },
            regexp: {
              regexp: /^[0-9 .]+$/,
              message: 'Geçersiz karakter kullandınız'
            }
          }
        },
        transmission_cost_consumption_share: {
          message: 'Geçersiz değer.',
          validators: {
            notEmpty: {
              message: 'Bir değer giriniz'
            },
            regexp: {
              regexp: /^[0-9 .]+$/,
              message: 'Geçersiz karakter kullandınız'
            }
          }
        },
        energy_fund: {
          message: 'Geçersiz değer.',
          validators: {
            notEmpty: {
              message: 'Bir değer giriniz'
            },
            regexp: {
              regexp: /^[0-9 .]+$/,
              message: 'Geçersiz karakter kullandınız'
            }
          }
        },
        trt_share: {
          message: 'Geçersiz değer.',
          validators: {
            notEmpty: {
              message: 'Bir değer giriniz'
            },
            regexp: {
              regexp: /^[0-9 .]+$/,
              message: 'Geçersiz karakter kullandınız'
            }
          }
        },
        energy_consumption_tax: {
          message: 'Geçersiz değer.',
          validators: {
            notEmpty: {
              message: 'Bir değer giriniz'
            },
            regexp: {
              regexp: /^[0-9 .]+$/,
              message: 'Geçersiz karakter kullandınız'
            }
          }
        },
        transformer_loss_unit_cost: {
          message: 'Geçersiz değer.',
          validators: {
            notEmpty: {
              message: 'Bir değer giriniz'
            },
            regexp: {
              regexp: /^[0-9 .]+$/,
              message: 'Geçersiz karakter kullandınız'
            }
          }
        },
        transformer_power: {
          message: 'Geçersiz değer.',
          validators: {
            notEmpty: {
              message: 'Bir değer giriniz'
            },
            regexp: {
              regexp: /^[0-9 .]+$/,
              message: 'Geçersiz karakter kullandınız'
            }
          }
        },
        power_unit_cost: {
          message: 'Geçersiz değer.',
          validators: {
            notEmpty: {
              message: 'Bir değer giriniz'
            },
            regexp: {
              regexp: /^[0-9 .]+$/,
              message: 'Geçersiz karakter kullandınız'
            }
          }
        }
      },
      onError: function (e) {
        console.log("error");
      },
      onSuccess: function (e) {
        console.log("success");
      }
    });


    //    $('#comm_device_id').select2({height: "30px", allowClear: true,
    //      placeholder: "Kullanıcı Seçiniz"});

    UIAlertDialogApi.init();

    $('#sandbox-container input').datepicker({
      format: "dd.mm.yyyy",
      startDate: new Date(),
      language: "tr",
      weekStart: 1
    });

    $("#selectReadPeriod").change(function () {
      $('#data_read_period').val($(this).val());
    });

    $("#vt_ratio").change(function () {
      var vt_ratio = $("#vt_ratio").val();
      var ct_ratio = $("#ct_ratio").val();
      ct_ratio = ct_ratio / 5;
      $("#tdFactor").val(ct_ratio * vt_ratio);
    });

    $("#ct_ratio").change(function () {
      var vt_ratio = $("#vt_ratio").val();
      var ct_ratio = $("#ct_ratio").val();
      ct_ratio = ct_ratio / 5;
      $("#tdFactor").val(ct_ratio * vt_ratio);
    });
  });

  function controlInputs(obj) {
    if (id === 0)
    {
      if (obj.comm_device_id.value === '' || obj.measuring_device_id.value === '')
      {
        $(document).scrollTop(0);
        $('#requiredField').show();
        return;
      } else
      {
        $('#requiredField').hide();
      }
    }

    if ($('#energy_unit_cost_active').val() == '' || $('#energy_unit_cost_T1').val() == '' || $('#energy_unit_cost_T2').val() == '' ||
      $('#energy_unit_cost_T3').val() == '' || $('#energy_unit_cost_reactive').val() == '' ||
      $('#transmission_cost_consumption_share').val() == '' || $('#transmission_cost_power_share').val() == '' ||
      $('#energy_fund').val() == '' || $('#trt_share').val() == '' || $('#energy_consumption_tax').val() == '' || $('#transformer_power').val() == '' ||
      $('#transformer_loss_unit_cost').val() == '' || $('#power_unit_cost').val() == '')
    {
      return false;
    } else
    {
      obj.submit();
    }
  }

  $('#tariffType').change(function () {
    $.ajax({
      type: 'POST',
      url: 'tx_getTariffValues.php',
      data: {
        deviceId: '<?= $device_id; ?>',
        tariffId: $('#tariffType').val()
      },
      success: function (tariffValues) {
        tariff_values = $.parseJSON(tariffValues);

        $('#energy_unit_cost_active').val(tariff_values.UnitCostActive);
        $('#energy_unit_cost_T1').val(tariff_values.UnitCostT1);
        $('#energy_unit_cost_T2').val(tariff_values.UnitCostT2);
        $('#energy_unit_cost_T3').val(tariff_values.UnitCostT3);
        $('#energy_unit_cost_reactive').val(tariff_values.UnitCostReactive);
        $('#distribution_cost').val(tariff_values.UnitCostDistribution);
        $('#transmission_cost_consumption_share').val(tariff_values.TransmissionCostConsumptionShare);
        $('#transmission_cost_power_share').val(tariff_values.TransmissionCostPowerShare);

        $('#energy_fund').val(tariff_values.EnergyFund);
        $('#trt_share').val(tariff_values.TrtShare);
        $('#energy_consumption_tax').val(tariff_values.EnergyConsumptionTax);
        $('#transformer_loss_unit_cost').val(tariff_values.TransformerLossUnitCost);
        $('#transformer_power').val(tariff_values.TransformerPower);
        $('#power_unit_cost').val(tariff_values.PowerUnitCost);
        setEnableInputs();
      }
    });
  });
  function setEnableInputs()
  {
    if ($('#tariffType').val() != 0)
    {
      $('#tariffForm input, #tariffForm select').prop('disabled', true);
      $('#tariffForm input, #tariffForm select').css('backgroundColor', '#C7FFC9');

      if ($('input[name=tariff_type]:checked').val() == 0)
      {
        $('#energy_unit_cost_T1').css('backgroundColor', '#FFC7C7');
        $('#energy_unit_cost_T2').css('backgroundColor', '#FFC7C7');
        $('#energy_unit_cost_T3').css('backgroundColor', '#FFC7C7');

        $('.energy_unit_cost_T1_div,.energy_unit_cost_T2_div,.energy_unit_cost_T3_div').addClass('tooltipOld2');
        $('.energy_unit_cost_T1_div,.energy_unit_cost_T2_div,.energy_unit_cost_T3_div').attr("title", "Bu değerin geçerli olması için tarife türü kısmı 'Üç Zamanlı Tarife' seçili olmalıdır.");

        try
        {
          $('.energy_unit_cost_active_div').tooltipster('disable');
          $('.energy_unit_cost_T1_div').tooltipster('enable');
          $('.energy_unit_cost_T2_div').tooltipster('enable');
          $('.energy_unit_cost_T3_div').tooltipster('enable');
        } catch (e)
        {
        }
      } else
      {
        $('#energy_unit_cost_active').css('backgroundColor', '#FFC7C7');
        $('.energy_unit_cost_active_div').addClass('tooltipOld2');
        $('.energy_unit_cost_active_div').attr("title", "Bu değerin geçerli olması için tarife türü kısmı 'Tek Zamanlı Tarife' seçili olmalıdır.");
        try
        {
          $('.energy_unit_cost_active_div').tooltipster('enable');
          $('.energy_unit_cost_T1_div').tooltipster('disable');
          $('.energy_unit_cost_T2_div').tooltipster('disable');
          $('.energy_unit_cost_T3_div').tooltipster('disable');
        } catch (e)
        {
        }
      }
    } else
    {
      $('#tariffForm input, #tariffForm select').prop('disabled', false);
      $('#tariffForm input, #tariffForm select').css('backgroundColor', '#fff');

      if ($('input[name=tariff_type]:checked').val() == 0)
      {
        $('#energy_unit_cost_T1').css('backgroundColor', '#FFC7C7');
        $('#energy_unit_cost_T2').css('backgroundColor', '#FFC7C7');
        $('#energy_unit_cost_T3').css('backgroundColor', '#FFC7C7');

        $('#energy_unit_cost_T1').prop('disabled', true);
        $('#energy_unit_cost_T2').prop('disabled', true);
        $('#energy_unit_cost_T3').prop('disabled', true);

        $('.energy_unit_cost_T1_div,.energy_unit_cost_T2_div,.energy_unit_cost_T3_div').addClass('tooltipOld2');
        $('.energy_unit_cost_T1_div,.energy_unit_cost_T2_div,.energy_unit_cost_T3_div').attr("title", "Bu değerin geçerli olması için tarife türü kısmı 'Üç Zamanlı Tarife' seçili olmalıdır.");

        try
        {
          $('.energy_unit_cost_active_div').tooltipster('disable');
          $('.energy_unit_cost_T1_div').tooltipster('enable');
          $('.energy_unit_cost_T2_div').tooltipster('enable');
          $('.energy_unit_cost_T3_div').tooltipster('enable');
        } catch (e)
        {
        }
      } else
      {
        $('#energy_unit_cost_active').css('backgroundColor', '#FFC7C7');
        $('#energy_unit_cost_active').prop('disabled', true);
        $('.energy_unit_cost_active_div').addClass('tooltipOld2');
        $('.energy_unit_cost_active_div').attr("title", "Bu değerin geçerli olması için tarife türü kısmı 'Tek Zamanlı Tarife' seçili olmalıdır.");
        try
        {
          $('.energy_unit_cost_active_div').tooltipster('enable');
          $('.energy_unit_cost_T1_div').tooltipster('disable');
          $('.energy_unit_cost_T2_div').tooltipster('disable');
          $('.energy_unit_cost_T3_div').tooltipster('disable');
        } catch (e)
        {
        }
      }
    }
    $('.tooltipOld2').tooltipster({offsetX: 10, offsetY: -5, position: 'bottom-left', arrow: true, interactive: true});
    $('.tooltipOld2').removeAttr("title");
  }

  function deleteDeviceImg(deviceId)
  {
    bootbox.confirm("Resim silinecek. \n\nSilmek istediğinizden emin misiniz ?", function (result) {
      if (result)
      {
        $.ajax({
          type: 'POST',
          url: 'tx_deleteDeviceImg.php',
          data: {
            deviceId: deviceId
          },
          success: function (response) {
            $(".imageDiv").html("");
          }
        });
      }
    });

  }

  $(function () {
    'use strict';
    var url = 'lib/js/jquery_file_upload/server/php/';
    $('#fileupload').fileupload({
      url: url,
      dataType: 'json',
      add: function (e, data) {

<?php
if ($fileUpload == false)
{
  ?>
          bootbox.alert("Bu özellik geçici olarak devre dışı bırakılmıştır.");
          return false;
  <?php
}
?>

        var acceptExtentions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
        var tempArr = new Array();
        tempArr = data.originalFiles[0]['name'].split('.');
        var ext = tempArr[tempArr.length - 1];

        if (ext == acceptExtentions[0] ||
          ext == acceptExtentions[1] ||
          ext == acceptExtentions[2] ||
          ext == acceptExtentions[3] ||
          ext == acceptExtentions[4])
        {
          data.submit();
        } else
        {
          bootbox.alert("Sadece resim formatındaki dosyaları yükleyebilirsiniz. Lütfen uygun bir dosya formatı seçiniz.");
        }
      },
      done: function (e, data) {
        var html = '<a href="javascript:deleteDeviceImg(\'<?php echo $device_id; ?>\')" class="fancybox-close" style="top: -20px; right: -3px;" title="Resmi Sil"></a>' +
          '<a class="fancybox effect7 fancyUpload" href="/uploads/' + data.result.files[0].name + '" title="Cihaz Resmi">' +
          '	<img class="img-responsive img-effect" id="uploaded_image" src="/uploads/' + data.result.files[0].name + '" alt="">' +
          '</a>';

        $('#progress .progress-bar').css("background-color", "#5cb85c");
        $("#progress .progress-bar").css("background-image", "");
        $('#progress .progress-bar').html("Resim Başarıyla Yüklendi.");
        $(".imageDiv").html(html);
        $.ajax({
          type: 'POST',
          url: 'tx_saveDeviceImg.php',
          data: {
            deviceId: '<?php echo $device_id; ?>',
            image_path: 'uploads/' + data.result.files[0].name
          },
          success: function (response) {
            $('#progress .progress-bar').html("Resmin Başarı ile Kaydedildi.");
            setTimeout("$('#progress .progress-bar').css('width','0%')", "4000");
          },
          error: function (request, error) {
            $('#progress .progress-bar').html("Resmin kaydedilmesi esnasında bir hata oluştu.");
            $('#progress .progress-bar').css("background-color", "red");
            setTimeout("$('#progress .progress-bar').css('width','0%')", "4000");
          },
        });
      },
      progressall: function (e, data) {
        $("#progress .progress-bar").css("background-color", "#45b6af");
        $("#progress .progress-bar").css("background-image", "url(/lib/js/jquery_file_upload/img/progressbar.gif)");
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress .progress-bar').css('width', progress + '%');
        $('#progress .progress-bar').html(progress + "%");

      }
    }).prop('disabled', !$.support.fileInput)
      .parent().addClass($.support.fileInput ? undefined : 'disabled');
  });


</script>
<script src="jquery/jquery.maskedinput.min.js"></script>
<script src="/assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>
<script src="/assets/admin/pages/scripts/ui-alert-dialog-api.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/select2/select2.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/select2/lodash.min.js"></script>
<script src="/assets/global/plugins/select2/lodash/select2.min.js"></script>
<script src="/assets/global/plugins/select2/select2_locale_tr.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.tr.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>
<script src="/js/ui-toastr.js"></script>
<script src="/tooltipster/jquery.tooltipster.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
<script src="/js/bootbox.js" type="text/javascript"></script>
<script src="lib/js/jquery_file_upload/js/vendor/jquery.ui.widget.js"></script>
<script src="lib/js/jquery_file_upload/js/jquery.iframe-transport.js"></script>
<script src="lib/js/jquery_file_upload/js/jquery.fileupload.js"></script>
<script src="lib/js/jquery_file_upload/js/jquery.fileupload-process.js"></script>
<script src="lib/js/jquery_file_upload/js/jquery.fileupload-image.js"></script>

<?php
include('inc/bottom.php');
?>
<script type="text/javascript" src="/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js"></script>
