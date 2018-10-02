<?php

include 'inc/header.php';
include 'inc/conn.php';

$id=$_GET['No'];
//echo $id;
$sor=mysql_query("SELECT * FROM call_log WHERE id=$id"); 
//echo $sor;
$yaz = mysql_fetch_assoc($sor); 

$id =$yaz['id'];
$musteri_id =$yaz['musteri_id']; 
$cihaz_no =$yaz['cihaz_no']; 
$arama_nedeni =$yaz['arama_nedeni']; 
$yapilan_islem =$yaz['yapilan_islem']; 
$tamamlanma_durumu =$yaz['tamamlanma_durumu']; 


?>

<link href="btn.css" type="text/css" rel="stylesheet"/>

<div style = "" class="mdl-cell mdl-cell--8-col">
<div class="mdl-grid">
    <?php
echo "SECMIS OLDUGUNUZ MUŞTERİ ID'Sİ : " , $musteri_id ;
    ?>
<form name="form2" method="get" action="guncelle_call_log.php" class="">

<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> 
          <input class="mdl-textfield__input " type="text" id="sample3" name="id"  value="<?php echo $uyeid ?>" size="400"> 
          <input class="mdl-textfield__input " type="text" id="sample3" name="isim"  value="<?php echo $uyeAd ?>" size="400"> 
          <label class="mdl-textfield__label" for="sample3">güncellenecek isim giriniz...</label>    
        </div>


<input type="hidden" name="id" value="<?php echo $id ?>">
       <input type="hidden" name="musteri_id" value="<?php echo $musteri_id ?>">
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> 
          <input class="mdl-textfield__input " type="text" id="sample3" name="cihaz_no"  value="<?php echo $cihaz_no ?>" size="400"> 
          <label class="mdl-textfield__label" for="sample3">güncellenecek cihaz no giriniz...</label>    
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> 
          <input class="mdl-textfield__input" type="text" id="sample3" name="arama_nedeni" value="<?php echo $arama_nedeni ?>" size="40">
          <label class="mdl-textfield__label" for="sample3">güncellenecek arama nedeni giriniz...</label>    
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> 
          <input class="mdl-textfield__input" type="text" id="sample3" name="yapilan_islem" value="<?php echo $yapilan_islem ?>" size="40" >
          <label class="mdl-textfield__label" for="sample3">güncellenecek yapılan işlem giriniz...</label>    
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> 
          <input class="mdl-textfield__input" type="text" id="sample3" name="tamamlanma_durumu" value="<?php echo $tamamlanma_durumu ?>" size="40">
          <label class="mdl-textfield__label" for="sample3">güncellenecek tamamlanma durumu giriniz...</label>    
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> 
        <input type="reset" value="SIFIRLA"/>
        <input type="submit" name="submit" class="mdl-button mdl-js-button mdl-js-ripple-effect" style="font-size:20px; color:#00BCD4" value="GÜNCELLE"/> 
        </div>
    </form>
</div>
</div>


<?php 
include 'inc/footer.php';
?>


