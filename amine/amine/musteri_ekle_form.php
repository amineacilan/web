 <?php

    include 'inc/header.php';
    include 'inc/conn.php';
    $musteriler = mysql_query("SELECT `No`,Adi,Soyadi,Firmasi,Telefon FROM musteriler ORDER BY musteriler.`No` DESC");

    ?>
    
    <link href="btn.css" type="text/css" rel="stylesheet"/>
    
    <div style = "" class="mdl-cell mdl-cell--4-col">
  <div class="mdl-grid">
    <form name="form2" method="get" action="ekle_musteriler.php" class="">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> 
              <input class="mdl-textfield__input " type="text" id="sample3" name="isim"  value="<?php echo $uyeAd ?>" size="400"> 
              <label class="mdl-textfield__label" for="sample3">isim giriniz...</label>    
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> 
              <input class="mdl-textfield__input" type="text" id="sample3" name="soyisim" value="<?php echo $uyeAd ?>" size="40">
              <label class="mdl-textfield__label" for="sample3">soyisim giriniz...</label>    
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> 
              <input class="mdl-textfield__input" type="text" id="sample3" name="firmasi" value="<?php echo $uyeAd ?>" size="40" >
              <label class="mdl-textfield__label" for="sample3">firma giriniz...</label>    
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> 
              <input class="mdl-textfield__input" type="text" id="sample3" name="tel_num" value="<?php echo $uyeAd ?>" size="40">
              <label class="mdl-textfield__label" for="sample3">telefon giriniz...</label>    
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> 
              <input type="submit" name="submit" class="mdl-button mdl-js-button mdl-js-ripple-effect" style="font-size:20px; color:#00BCD4" value="KAYIT EKLE"/> 
            </div>
        </form>
    </div>
  </div>


<?php 
include 'inc/footer.php';
?>