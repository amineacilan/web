<?php

include 'inc/header.php';
include 'inc/conn.php';

$id=$_GET['No'];
//echo $id;
$sor=mysql_query("SELECT * FROM musteriler WHERE No=$id"); 
//echo $sor;
$yaz = mysql_fetch_assoc($sor); 

$uyeid =$yaz['No'];
$uyeAd =$yaz['Adi']; 
$uyeSoyad =$yaz['Soyadi']; 
$uyeFirmasi =$yaz['Firmasi']; 
$uyeTel =$yaz['Telefon']; 

//var_dump($uyeid,$uyeFirmasi);

?>

<link href="btn.css" type="text/css" rel="stylesheet"/>

<div style = "" class="mdl-cell mdl-cell--8-col">
<div class="mdl-grid">
    <?php
    echo "SECMIS OLDUGUNUZ KISI BILGILERI : " , $uyeAd ,'---' , $uyeSoyad,'---' , $uyeFirmasi,'---' , $uyeTel;

    ?>
<form name="form2" method="get" action="guncelle_musteriler.php" class="">
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> 
          <input class="mdl-textfield__input " type="text" id="sample3" name="id"  value="<?php echo $uyeid ?>" size="400"> 
          <input class="mdl-textfield__input " type="text" id="sample3" name="isim"  value="<?php echo $uyeAd ?>" size="400"> 
          <label class="mdl-textfield__label" for="sample3">güncellenecek isim giriniz...</label>    
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> 
          <input class="mdl-textfield__input" type="text" id="sample3" name="soyisim" value="<?php echo $uyeSoyad ?>" size="40">
          <label class="mdl-textfield__label" for="sample3">güncellenecek soyisim giriniz...</label>    
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> 
          <input class="mdl-textfield__input" type="text" id="sample3" name="firmasi" value="<?php echo $uyeFirmasi ?>" size="40" >
          <label class="mdl-textfield__label" for="sample3">güncellenecek firma giriniz...</label>    
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> 
          <input class="mdl-textfield__input" type="text" id="sample3" name="tel_num" value="<?php echo $uyeTel ?>" size="40">
          <label class="mdl-textfield__label" for="sample3">güncellenecek telefon giriniz...</label>    
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> 
          <input type="submit" name="submit" class="mdl-button mdl-js-button mdl-js-ripple-effect" style="font-size:20px; color:#00BCD4" value="GÜNCELLE"/> 
        </div>
    </form>
</div>
</div>


<?php 
include 'inc/footer.php';
?>



