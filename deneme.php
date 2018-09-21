<?php 
include 'inc/header.php';
include 'inc/conn.php';

?>


<table><tr><td>asdasdas</td></tr></table>


  &nbsp;CİHAZ NO :   <input type="text"  name="cihaz_no" class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" value="<?php echo $uyeAd ?>" size="40" placeholder="Cihaz Numarası Giriniz"/><br>
    &nbsp;ARAMA NEDENİ:&nbsp; <input type="text"  name="arama_nedeni" class="style1" value="<?php echo $uyeAd ?>" size="40" placeholder="Arama Nedenini Giriniz"/><br>
    &nbsp;YAPILAN İŞLEMLER : &nbsp; <input type="text"  name="yapilan_islemler" class="txtbox100" value="<?php echo $uyeAd ?>" size="40" placeholder="Yapılan İşlem Giriniz"/><br>
    &nbsp;TAMAMLANMA DURUMU :&nbsp; <input type="text"  name="tamamlanma_drm" class="txtbox100" value="<?php echo $uyeAd ?>" size="40" placeholder="Tamamlanma Durumunu Giriniz"/><br>
    

    <input type="submit" name="submit" class="tb5" value="KAYIT EKLE"/> 



















<?php 
include 'inc/footer.php';
?>