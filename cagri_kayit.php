 
    <?php
    include 'inc/header.php';
    include 'inc/conn.php';

    $musteriler = mysql_query("SELECT `No`,Adi,Soyadi,Firmasi,Telefon FROM musteriler");
    ?><link href="btn.css" type="text/css" rel="stylesheet"/>
      <div class="mdc-layout-grid">
        <div class="mdc-layout-grid">
          <div class="mdc-layout-grid__inner">
            <div class="mdc-layout-grid__cell">
              
            </div>
            
        </div>
       
      </div>
        <table class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp">
  <thead>

<form id="form1" name="cagri_kayit" method="get" action="tx_cagri_kayit.php"> 
  <label> 
  &nbsp; MÜŞTERİ SEÇİNİZ:
  <select name="musteri" id="musteri" style="width:500px; display:block;" > 
   <option value="">Önce müşteri seçiniz></option>&nbsp;

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
//<div class="clearfix">  </div>
?> 

    </select> 
    <div class="mdl-layout">
      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> 
      <input class="mdl-textfield__input" type="text" id="sample3" name="cihaz_no" value="<?php echo $uyeAd ?>" size="40">
      <label class="mdl-textfield__label" for="sample3">CİHAZ NO...</label>    
      </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> 
      <input class="mdl-textfield__input" type="text" id="sample3" name="arama_nedeni" value="<?php echo $uyeAd ?>" size="40">
      <label class="mdl-textfield__label" for="sample3">ARAMA NEDENİ...</label>    
      </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> 
      <input class="mdl-textfield__input" type="text" id="sample3" name="yapilan_islemler" value="<?php echo $uyeAd ?>" size="40" >
      <label class="mdl-textfield__label" for="sample3">YAPILAN İŞLEMLER...</label>    
      </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> 
      <input class="mdl-textfield__input" type="text" id="sample3" name="tamamlanma_drm" value="<?php echo $uyeAd ?>" size="40">
      <label class="mdl-textfield__label" for="sample3">TAMAMLANMA DURUMU...</label>    
      </div>
    
  <input type="submit" name="submit" class="mdl-button mdl-js-button mdl-js-ripple-effect" value="KAYIT EKLE"/> 
  
</form>

<form name="form2" method="get" action="kyt_getir.php">
<button type="submit" class="mdl-button mdl-js-button mdl-js-ripple-effect"  >GÖSTER</button>
&nbsp;

</div>

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