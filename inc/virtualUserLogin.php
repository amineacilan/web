<?php
include ('config.php');
include ('conn.php');
include ('func.php');
$demoAuth = true;
include ('l_control.php');
include ('header.php');

if ($real_session_type != 'admin')
{
  if ($session_type != 'admin')
  {
    header('Location:/unAuthorized.php');
    exit();
  }
}


$virtualUserEmail = '';
$virtualUserIcon = 'fa fa-toggle-down';
$virtualUserLogout = 'javascript:;';

if ($virtualUserId != '')
{
  $virtualUserEmail = $session_email;
  $virtualUserIcon = 'fa fa-times';
  $virtualUserLogout = 'virtualUserLogin(\'\');';
}

$goToPage = getParamUrl('goToPage', 'POST', '');
?>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/select2/lodash/select2.css"/>
<style>
  .select2-container .select2-choice {
    min-height: 34px!important;
  }

  .form-control:focus
  {
    outline: none;
  }
</style>

<div class="col-md-6">
  <!-- BEGIN Portlet PORTLET-->
  <div class="portlet box blue-hoki">
    <div class="portlet-title">
      <div class="caption">
        <i class="fa fa-eye"></i>Kullanıcının Gözünden Bak</div>
      <div class="actions">
        <a href="javascript:;" onclick="virtualUserLogin();" class="btn btn-default btn-sm">
          <i class="fa fa-times"></i> Çıkış </a>
      </div>
    </div>
    <div class="portlet-body">
      <input class="checkboxDevice" id="userSearch" type="hidden"  style="width: 100%;"/>
    </div>
  </div>
</div>
<?php

class virtualUserInfo
{

  public $id;
  public $text;

}

if ($result = mysql_query('SELECT id,name,surname,company_name,email FROM user ORDER BY LOWER(CONCAT(name," ",surname)),company_name', $connection))
{
  while ($row = mysql_fetch_assoc($result)) {
    $userStr = trim(($row['name'] . ' ' . $row['surname'] . ' - ' . $row['company_name'] . ' - ' . $row['email']), ' -');
    $virtualUserObj = new virtualUserInfo();
    $virtualUserObj->id = $row['id'];
    $virtualUserObj->text = $userStr;
    $virtualUserArr[] = $virtualUserObj;
  }
}
?>
<script>

  var userDataArr = JSON.parse('<?php echo json_encode($virtualUserArr); ?>');
  var selectedUserId = '<?php echo $virtualUserId; ?>';

  $(document).ready(function () {
    $(".checkboxDevice").select2({
      multiple: false,
      language: "tr",
      allowClear: true,
      placeholder: "Kullanıcı seçiniz",
      initSelection: function (element, callback) {
        var selection = _.find(userDataArr, function (metric) {
          return metric.id === element.val();
        });
        callback(selection);
      },
      query: function (options) {
        var pageSize = 20;
        var startIndex = (options.page - 1) * pageSize;
        var filteredData = userDataArr;

        if (options.term && options.term.length > 0) {
          if (!options.context) {
            var term = options.term.toLowerCase();
            options.context = userDataArr.filter(function (metric) {
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
      }//query end
    }).select2("val", selectedUserId);

    $('.checkboxDevice').on('change', function () {
      console.log($("#userSearch").val());
      userId = $("#userSearch").val();
      virtualUserLogin(userId);
    });
  });//document ready end

  function virtualUserLogin(userId)
  {
    $.ajax({
      type: 'POST',
      url: '/inc/setSessionVariable.php',
      data: {timestamp: $.now(), varName: 'virtualUserId', val: userId},
      success: function () {
        window.location.href = '<?php echo $goToPage; ?>';
      },
      error: function (response) {
        console.log(response);
      }
    });
  }

  function userFilter()
  {
    var userText = $('#userSearch').val();
    if (userText.length == 0)
    {
      $('.virtualUser').show();
    } else
    {
      $('.virtualUser').each(function () {
        $(this).toggle(-1 != $(this).text().turkishToLower().indexOf(userText.turkishToLower()));
      });
    }
  }
</script>
<script src="/assets/global/plugins/select2/lodash.min.js"></script>
<script src="/assets/global/plugins/select2/lodash/select2.min.js"></script>
<script src="/assets/global/plugins/select2/select2_locale_tr.js" type="text/javascript"></script>
<?php
include ('bottom.php');
