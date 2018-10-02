 
    <?php

    include 'inc/header.php';
    include 'inc/conn.php';
    $musteriler = mysql_query("SELECT `No`,Adi,Soyadi,Firmasi,Telefon FROM musteriler ORDER BY musteriler.`No` DESC");

    ?>
    
    <link href="btn.css" type="text/css" rel="stylesheet"/>
    
  <div style = "" class="mdl-cell mdl-cell--6-col"> 
    <div class="mdl-grid">
        <form action="tx_cagri_kayit.php">
            <div class="mdl-textfield mdl-js-textfield getmdl-select">
              <input  value="" class="mdl-textfield__input" id="musteri" readonly/>
              <input value="" type="hidden" name="musteri"/>
              <label class="mdl-textfield__label" for="musteri">Önce müşteri seçiniz</label>
              <ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu" for="musteri">
              <?php
                  while ($row2 = mysql_fetch_array($musteriler)) {
                    $id2 = $row2['No'];
                    $Adi2 = $row2['Adi'];
                    $Soyadi2 = $row2['Soyadi'];
                    $Firmasi2 = $row2['Firmasi'];
                    $Telefon2 = $row2['Telefon'];
                ?>
                <li class="mdl-menu__item" data-val="<?= $id2 ?>"><?= $Adi2 ?>&nbsp<?= $Soyadi2 ?>&nbsp<?= $Firmasi2 ?>&nbsp<?= $Telefon2 ?></li>
                  <?
                  }
                  ?>
              </ul>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> 
              <input class="mdl-textfield__input " type="text" id="sample3" name="cihaz_no"  value="<?php echo $uyeAd ?>" size="400"> 
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
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> 
              <input type="submit" name="submit" class="mdl-button mdl-js-button mdl-js-ripple-effect" style="font-size:20px; color:#00BCD4" value="KAYIT EKLE"/> 
            </div>
        </form>
    </div>
  </div>
  <div style = "" class="mdl-cell mdl-cell--4-col">
  <div class="mdl-grid">
  <div style = "" class="mdl-cell mdl-cell--12-col">
      <form name="form2" method="get" action="kyt_getir.php" class="">
        <input type="submit" name="submit" class="mdl-button mdl-js-button mdl-js-ripple-effect" style="font-size:20px; color:#00BCD4" value="GÖSTER"/> 
      </form>
      </div>
      </div>
  </div>



  






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