<!-- END CONTAINER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="/assets/global/plugins/respond.min.js"></script>
<script src="/assets/global/plugins/excanvas.min.js"></script>
<![endif]-->

<script type="text/javascript" src="/assets/global/plugins/jquery-migrate-1.2.1.min.js"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script type="text/javascript" src="/assets/global/plugins/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/jquery.blockui.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/jquery.cokie.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/uniform/jquery.uniform.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- END CORE PLUGINS -->
<script type="text/javascript" src="/assets/global/scripts/metronic.min.js"></script>
<script type="text/javascript" src="/assets/admin/layout/scripts/layout.js"></script>
<script type="text/javascript" src="/assets/admin/layout/scripts/quick-sidebar.js"></script>
<script>
    $(document).attr('title',config_title);
    jQuery(document).ready(function () {
    Metronic.init(); // init metronic core components
    Layout.init(); // init current layout
    QuickSidebar.init(); // init quick sidebar

    var menuStateClass = $(".page-sidebar-menu")[0].className;
    if (menuStateClass == 'page-sidebar-menu') {
      $('#menuCompanyLogo').height(55);
      $('#menuCompanyLogo').width(60);
      $('#menuBlogLogo').height(55);
      $('#menuBlogLogo').width(60)
    } else if (menuStateClass == 'page-sidebar-menu page-sidebar-menu-closed')
    {
      $('#menuCompanyLogo').height(22);
      $('#menuCompanyLogo').width(24);
      $('#menuBlogLogo').height(22);
      $('#menuBlogLogo').width(24);
    }

    $(".sidebar-toggler").click(function () {
      var menuStateClass = $(".page-sidebar-menu")[0].className;
      if (menuStateClass == 'page-sidebar-menu') {
        $('#menuCompanyLogo').height(22);
        $('#menuCompanyLogo').width(24);
        $('#menuBlogLogo').height(22);
        $('#menuBlogLogo').width(24);
      } else if (menuStateClass == 'page-sidebar-menu page-sidebar-menu-closed')
      {
        $('#menuCompanyLogo').height(55);
        $('#menuCompanyLogo').width(60);
        $('#menuBlogLogo').height(55);
        $('#menuBlogLogo').width(60);
      }
    });

    $("#menuCompanylink").mouseenter(function () {
      var menuStateClass = $(".page-sidebar-menu")[0].className;
      if (menuStateClass == 'page-sidebar-menu page-sidebar-menu-closed')
      {
        $('#menuCompanyLogo').height(55);
        $('#menuCompanyLogo').width(60);
      }
    });

    $("#menuCompanylink").mouseleave(function () {
      var menuStateClass = $(".page-sidebar-menu")[0].className;
      if (menuStateClass == 'page-sidebar-menu page-sidebar-menu-closed')
      {
        $('#menuCompanyLogo').height(22);
        $('#menuCompanyLogo').width(24);
      }
    });

    $("#menuBloglink").mouseenter(function () {
      var menuStateClass = $(".page-sidebar-menu")[0].className;
      if (menuStateClass == 'page-sidebar-menu page-sidebar-menu-closed')
      {
        $('#menuBlogLogo').height(55);
        $('#menuBlogLogo').width(60)
      }
    });

    $("#menuBloglink").mouseleave(function () {
      var menuStateClass = $(".page-sidebar-menu")[0].className;
      if (menuStateClass == 'page-sidebar-menu page-sidebar-menu-closed')
      {
        $('#menuBlogLogo').height(22);
        $('#menuBlogLogo').width(24);
      }
    });
  });
</script>
</div></div>
<div class="page-footer">
  <div class="page-footer-inner">
    <?php echo date('Y'); ?> &copy; <a href='http://www.gruparge.com' style='color:#98a6ba;' target='_blank' >Grup Arge Enerji ve Kontrol Sistemleri</a>
  </div>
  <div class="page-footer-tools">
    <span class="go-top">
      <i class="fa fa-angle-up"></i>
    </span>
  </div>
</div>
<div id="modalDiv" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-default">Kapat</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>