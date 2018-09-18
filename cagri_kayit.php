<?php include 'header.php';
include 'conn.php';

$musteriler = mysql_query("SELECT `No`,Adi,Soyadi,Firmasi,Telefon FROM musteriler");
?> 
<form id="form1" name="cagri_kayit" method="get" action="tx_cagri_kayit.php"> 
  <label> 
   musteri seçiniz:
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
  Cihaz No :&nbsp;   <input type="text"  name="cihaz_no" class="txtbox100" value="<?php echo $uyeAd ?>" placeholder="cihaz numarası giriniz"/><br>
    Arama Nedeni :&nbsp; <input type="text"  name="arama_nedeni" class="txtbox100" value="<?php echo $uyeAd ?>" placeholder="arama nedenini giriniz"/><br>
    Yapılan İşlemler : &nbsp; <input type="text"  name="yapilan_islemler" class="txtbox100" value="<?php echo $uyeAd ?>" placeholder="yapılan işlem giriniz"/><br>
    Tamamlanma Durumu :&nbsp; <input type="text"  name="tamamlanma_drm" class="txtbox100" value="<?php echo $uyeAd ?>" placeholder="tamamlanma durumunu giriniz"/><br>
    <input type="submit" name="submit" value="Kayıt Ekle"/> 
</form>

<form name="form2" method="get" action="kyt_getir.php">
<input type="submit" name="submit2" value="Kayıtları Göster"/> 
</form>

 <?php 


$id = $_GET['No'];

$sor = mysql_query("SELECT * FROM call_log WHERE id=$id"); 
//echo $sor;
$yaz = mysql_fetch_assoc($sor);
//echo "$Adi2";
?>

<html>

<head>
<style> 
.txtbox100{ 
font-family:Verdana; 
font-size:12px; 
width:220px; 
} 
</style> 
</head>

<body>
   

</body>
</html>