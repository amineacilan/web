<?php

//////////////İzleme yetkisi durdurma//////////////
if ($session_type != 'admin')
{
  setcookie('gritter', 'popup', time() + 60 * 60 * 2);   /////2 Saatte 1 defa gösterilecek hatırlatma/////

  $result = mysql_query("SELECT payment_state FROM measuring_device_settings WHERE measuring_device_id = '$d_info->SerialNumber' ", $connection);

  if (($result) && ($row = mysql_fetch_assoc($result)) && ($row['payment_state'] == 'close'))
  {
    if ((!isset($_COOKIE['gritter'])) && ($amount < 1))
    {
      ?>
      <script>
        $(function () {
          $.gritter.add({
            title: 'Bakiyeniz azaldı!',
            text: 'Bakiyenizi kısa zaman içerisinde yükseltmelisiniz. Yükleme yapmak için <a href="serverPackets.php" style="color:#ccc">buraya</a> tıklayınız.',
            image: '/images/logo.jpg',
            sticky: false
          });
          return false;
        });

        $.extend($.gritter.options, {
          position: 'bottom-right',
          fade_in_speed: 'medium',
          fade_out_speed: 2000,
          time: 8000
        });
      </script>
      <?php

    }
    header("Location: /errorPage.php");
    /* die('<p align="center" style="margin-top:150px; color:red"><b>Cihazınızın ödemesi yapılmadığından izleme yetkiniz durdurulmuştur.</b>
      <br/><input class="btn blue" type="button" value="Ödeme Yap" onclick="window.open(\'managePayments.php\', \'_self\')"/>'); */
  }
}