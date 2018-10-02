<?php
include_once 'menu.php';
include('/../customize/customize.php');
if (isset($session_type) !== true)
{
  header('Location: /login.php');
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="tr">
  <!--<![endif]-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <?php
    if ($webPushSupport)
    {
      ?>
      <!-- Add to homescreen for Chrome on Android -->
      <meta name="theme-color" content="#0093dd" />
    <link rel="manifest" href="/PWApp/manifest.json">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

  <?php } ?>
  <!--    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
      <meta content="width=device-width, initial-scale=1" name="viewport"/>-->
  <!--<link href="/assets/global/plugins/font-awesome/css/fonts.googleapis.css" rel="stylesheet" type="text/css"/>-->
  <link rel="stylesheet" type="text/css" href="/assets/global/plugins/font-awesome-4.7.0/css/fonts.googleapis.local.min.css"/>
  <link rel="stylesheet" type="text/css" href="/assets/global/plugins/font-awesome-4.7.0/css/font-awesome.min.css"/>
  <link rel="stylesheet" type="text/css" href="/assets/global/plugins/simple-line-icons/simple-line-icons.min.css"/>
  <link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap/css/bootstrap.min.css"/>
  <link rel="stylesheet" type="text/css" href="/assets/global/plugins/uniform/css/uniform.default.min.css"/>
  <link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"/>
  <link rel="stylesheet" type="text/css" href="/assets/global/plugins/gritter/css/jquery.gritter.min.css"/>
  <link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.min.css"/>
  <link rel="stylesheet" type="text/css" href="/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.min.css"/>
  <link rel="stylesheet" type="text/css" href="/assets/global/plugins/jqvmap/jqvmap/jqvmap.min.css"/>
  <link rel="stylesheet" type="text/css" href="/assets/admin/pages/css/tasks.min.css"/>
  <link rel="stylesheet" type="text/css" href="/assets/global/css/components.min.css"/>
  <link rel="stylesheet" type="text/css" href="/assets/global/css/plugins.min.css"/>
  <link rel="stylesheet" type="text/css" href="/assets/admin/layout/css/layout.min.css"/>
  <link rel="stylesheet" type="text/css" href="/assets/admin/layout/css/themes/blue.css" id="style_color" />
  <link rel="stylesheet" type="text/css" href="/lib/js/TabStylesInspiration/css/tabs.min.css" />
  <link rel="stylesheet" type="text/css" href="/lib/icon/icomoon/style.css"/>
  <!-- <title><?php echo $config_title; ?></title> -->

  <meta name="keywords" content="enerjitakibi, enerji takibi, enerji izleme, sayaç izleme, uzaktan sayaç okuma, uzaktan izleme, kompanzasyon takibi, gruparge, grup arge, makel, köhler, kohler, kombi sayaç, elektrik sayacı, electricity meter, energy monitoring, remote monitoring, OSOS, otomatik sayaç izleme sistemi, uzaktan erişim, SmartGrid, SmartPower" />
  <link rel="SHORTCUT ICON" href="/favicon.ico"/>
  <link rel="stylesheet" href="/jquery-ui/css/ui-lightness/jquery-ui.min.css"/>
  <link rel="stylesheet" type="text/css" href="/css/oldStyle.min.css"/>
  <?php
  if (isset($useControlCss) && ($useControlCss == true))
  {
    ?>
    <link rel="stylesheet" type="text/css" href="/css/control.min.css" />
    <?php
  }
  ?>
  <script type="text/javascript" src="/assets/global/plugins/jquery-1.11.0.min.js"></script>
  <script type="text/javascript" src="/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js"></script>
  <script type="text/javascript" src="/jquery-ui/jquery.ui.datepicker-tr.js"></script>
  <?php
  if (isset($useFunctionsJs) && ($useFunctionsJs == true))
  {
    ?>
    <script src="/js/functions.js"></script>
    <?php
  }

  if (isset($useDateFormatJs) && ($useDateFormatJs == true))
  {
    ?>
    <script src="/js/date.format.min.js"></script>
    <?php
  }

  if (isset($useControlJs) && ($useControlJs == true))
  {
    ?>
    <script src="/js/control.js"></script>
    <?php
  }

  $mobileResult = mysql_query("SELECT * FROM user_preferences WHERE user_id=$session_user_id AND user_type='$session_type' AND parameter_id=2 AND value=1", $connection);

  if (mysql_fetch_array($mobileResult))
  {
    ?>
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <?php
  }
  ?>
</head>
<style>
  .menu-icon
  {
    width: 20px;
    height: 14px;
    margin-right: 3px!important;
    margin-left: 2px!important;
  }

  .building-item {
    color: #000000;
  }

  .comsumption-item {
    color: #C12C2C;
  }

  .compensation-item {
    color: #BE578A;
  }

  .io-item {
    color: #4DB3A2;
  }

  .temperature-item {
    color: #F7CA18;
  }

  .gas-item {
    color: #4C87B9;
  }

  .water-item {
    color: #00D8FD;
  }

  .page-breadcrumb.breadcrumb
  {
    margin-top: 0px;
  }
  @media (min-width: 768px) {
    .pull-right-sm {
      float: right;
    }
  }
  @media (min-width: 992px) {
    .pull-right-md {
      float: right;
    }
  }
  @media (min-width: 1200px) {
    .pull-right-lg {
      float: right;
    }
  }
  .daterangepicker
  {
    background: #cce5ff!important;
  }
  #dashboard-report-range.active{ color:white;}
  <?php echo $header_css; ?>
</style>
<body class="page-header-fixed page-quick-sidebar-over-content">
  <?php
  if ($_COOKIE ['ses'] != '')
  {
    $query = getParamUrl('query', 'GET', '');
    ?>
  <div class="page-header navbar navbar-fixed-top">
    <div class="page-header-inner">
      <div class="page-logo" id="logo_div">
        <a href="/index.php"> <img id="logo_img" src= '<?php echo $header_logo ?>' class="logo-default"></a>
        <span id="logo_span"><b><?php echo $server_name ?></b></span>
        <div class="menu-toggler sidebar-toggler hide"></div>
      </div>
      <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
      <div class="top-menu">
        <ul class="nav navbar-nav pull-right">
          <?php
          if (($session_type == 'admin') || ($real_session_type == 'admin'))
          {
            if ($_SESSION['virtualUserId'] != 0)
            {
              ?>
              <li class="dropdown dropdown-extended">
                <a href="javascript:;" onclick="virtualUserRemove();"><!--email_off--> <?php echo $session_email; ?> <!--/email_off--><i class="fa fa-times-circle" ></i></a>
              </li>

              <script>
                function virtualUserRemove()
                {
                  $.ajax({
                    type: 'POST',
                    url: '/inc/setSessionVariable.php',
                    data: {timestamp: $.now(), varName: 'virtualUserId'},
                    success: function () {
                      location.reload(true);
                    },
                    error: function (response) {
                      console.log(response);
                    }
                  });
                }
              </script>
              <?php
            }
            if ($_SERVER['SCRIPT_NAME'] != '/inc/virtualUserLogin.php')//sayfa adı buysa tekrar tekrar yönlendirme yapmaması için kontrol
            {
              ?>
              <li class="dropdown dropdown-extended">
                <a href="javascript:;" onclick="javascript:$('#goToPageForm').submit();" class="dropdown-toggle" data-hover="dropdown" data-close-others="true">
                  <i class="fa fa-eye" style="color: #02E4E4;"></i>
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <a href="javascript:;" onclick="javascript:$('#goToPageForm').submit();" >
                      <i class="fa fa-eye" style="color: #02E4E4;"></i> Kullanıcının Gözünden Bak
                    </a>
                  </li>
                </ul>

                <form action="/inc/virtualUserLogin.php" method="POST" id="goToPageForm">
                  <input type="hidden" name="goToPage" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/>
                </form>
              </li>

              <?php
            }
          }
          if ($session_type !== 'admin')
          {
            include $rootFolder . '/ems/notifications.php';
          }

          if ($blogSupport == true)
          {
            ?>
            <li class="dropdown dropdown-extended">
              <a href="http://www.enerjitakibi.com/blog/" target='_blank' class="dropdown-toggle" data-hover="dropdown" data-close-others="true">
                <i class="fa fa-rss" style="color: #02A6E4;"></i>
              </a>
              <ul class="dropdown-menu">
                <li>
                  <a href="http://www.enerjitakibi.com/blog/" target='_blank'><i class="fa fa-rss" style="color: #02A6E4;"></i> SmartPower
                    Blog
                  </a>
                </li>
              </ul>
            </li>
            <?php
          }

          if ($supportSupport == true)
          {
            if ($session_type == 'admin')
            {
              include $rootFolder . '/support/supportPublicAdmin.php';
            }
            else
            {
              include $rootFolder . '/support/supportPublicUser.php';
            }
          }
          ?>
          <li class="dropdown dropdown-user">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
              <img alt="" class="img-circle" src="/assets/admin/layout/img/user_icon_grey.png">
              <span class="username"> <?php echo ($virtualUserId == '') ? $session_email : $real_session_email; ?> </span>
              <i class="fa fa-angle-down"></i>
            </a>
            <ul class="dropdown-menu">
              <li>
                <a href="/userProfile/userSettings.php"> <i class="icon-user"></i>
                  Profil
                </a>
              </li>
              <li class="divider"></li>
              <li>
                <a href="/tx_logout.php"> <i class="icon-key"></i>
                  Çıkış
                </a>
              </li>
            </ul>
          </li>
        </ul>
        <!--<a class="btn btn-default btn-sm yellow" style='margin-top:10px'  href="javascript:addFavorites()"> Sık Kullanılanlar</a>-->
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="page-container">
    <div class="page-sidebar-wrapper">
      <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
          <li class="sidebar-toggler-wrapper">
          <div class="sidebar-toggler hidden-phone"></div>
          </li>
          <li class="sidebar-search-wrapper">
            <form class="sidebar-search" action="/search.php" method="GET">
              <a href="javascript:;" class="remove"> <i class="icon-close"></i>
              </a>
              <div class="input-group">
                <input type="text" class="form-control" id="query" name="query" autocomplete="on" placeholder="Arama...">
                <span class="input-group-btn">
                  <a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
                </span>
              </div>
            </form>
          </li>
          <?php
          for ($index = 0; $index < count($arrMenu); $index ++) {
            ?>
            <li class='<?php echo $arrMenu[$index]->class; ?>' id="sidebarLi<?php echo $arrMenu[$index]->id; ?>">
              <a href='<?php echo $arrMenu[$index]->link; ?>'>
                <i class='<?php echo $arrMenu[$index]->icon; ?>'></i>
                <span class="title"><?php echo $arrMenu[$index]->displayName; ?></span>
                <?php echo $arrMenu[$index]->arrow; ?>
                <?php echo $arrMenu[$index]->selected; ?>
              </a>
              <?php
              if (count($arrMenu [$index]->SubMenu) > 0)
              {
                echo '<ul class="sub-menu">';
              }

              for ($subI = 0; $subI < count($arrMenu [$index]->SubMenu); $subI ++) {
                ?>
              <li class='<?php echo $arrMenu[$index]->SubMenu[$subI]->class; ?>' id="submenuLi<?php echo $index . $subI; ?>">
                <a href='<?php echo $arrMenu[$index]->SubMenu[$subI]->link; ?>'>
                  <i class='<?php echo $arrMenu[$index]->SubMenu[$subI]->icon; ?>'></i>
                  <span class="title">
                    <?php echo $arrMenu[$index]->SubMenu[$subI]->displayName; ?>
                  </span>
                </a></li>

              <?php
            }
            if (count($arrMenu [$index]->SubMenu) > 0)
            {
              echo '</ul>';
            }
            ?>
            </li>
            <?php
          }
          ?>
          <li><a href="http://www.gruparge.com" id="menuCompanylink" target='_blank' align="center"> <br>
              <img id="menuCompanyLogo"  src="/assets/admin/layout/img/gruparge_logo_b.png" width="60" height="55" style="display: block; margin-left: auto; margin-right: auto;"> <br>
              <span class="title"><p class="title text-center">
                  <small>Grup Arge <br> Enerji ve Kontrol Sistemleri
                  </small>
                </p></span> <span class="selected"></span>
            </a></li>
        </ul>
      </div>
    </div>
    <div class="page-content-wrapper">
      <div class="page-content">
        <?php include_once 'title_path.php'; ?>
        <div class="row">
          <?php
        }
        ?>
        <script>
          var datatablePaginateEnable = <?php echo json_encode($datatablePaginateEnable); ?>;
          var config_title = "<?php echo $config_title; ?>";
        </script>