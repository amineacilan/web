 
    <?php
    include 'inc/header.php';
    include 'inc/conn.php';
   
    $musteriler = mysql_query("SELECT `No`,Adi,Soyadi,Firmasi,Telefon FROM musteriler");
    ?>
        <table class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp">
  <thead>

<form id="form1" name="cagri_kayit" method="get" action="tx_cagri_kayit.php"> 
  <label> 
  MÜŞTERİ SEÇİNİZ:
  <select name="musteri" id="musteri" > 
   <option value="">Önce müşteri seçiniz></option>

<?php  //tx_cagri_kayit.php

while ($row2 = mysql_fetch_array($musteriler)) {
  $id2 = $row2['No'];
  $Adi2 = $row2['Adi'];
  $Soyadi2 = $row2['Soyadi'];
  $Firmasi2 = $row2['Firmasi'];
  $Telefon2 = $row2['Telefon'];
  ?> 
  <option value="<?= $id2 ?>"><?= $id2 ?>-><?= $Adi2 ?>-><?= $Soyadi2 ?>-><?= $Firmasi2 ?>-><?= $Telefon2 ?>  </option> 
<?
}

?> 
    </select> 
  </label> <br>
  CİHAZ NO :&nbsp;   <input type="text"  name="cihaz_no" class="txtbox100" value="<?php echo $uyeAd ?>" placeholder="Cihaz Numarası Giriniz"/><br>
    ARAMA NEDENİ:&nbsp; <input type="text"  name="arama_nedeni" class="txtbox100" value="<?php echo $uyeAd ?>" placeholder="Arama Nedenini Giriniz"/><br>
    YAPILAN İŞLEMLER : &nbsp; <input type="text"  name="yapilan_islemler" class="txtbox100" value="<?php echo $uyeAd ?>" placeholder="Yapılan İşlem Giriniz"/><br>
    TAMAMLANMA DURUMU :&nbsp; <input type="text"  name="tamamlanma_drm" class="txtbox100" value="<?php echo $uyeAd ?>" placeholder="Tamamlanma Durumunu Giriniz"/><br>
    <input type="submit" name="submit" value="Kayıt Ekle"/> 
</form>

<form name="form2" method="get" action="kyt_getir.php">
<button type="submit" class="tb5"  >göster</button>

<button type="submit" class="btn1"  >Success</button>
</form>

 <?php 
//<input type="submit" name="submit2" value="Kayıtları Göster"/> 

$id = $_GET['No'];

$sor = mysql_query("SELECT * FROM call_log WHERE id=$id"); 
//echo $sor;
$yaz = mysql_fetch_assoc($sor);
//echo "$Adi2";
?>

<?php 
include 'inc/footer.php';
?>