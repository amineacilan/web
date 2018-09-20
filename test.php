<div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
    
    <?php
    include 'header.php';
    include 'conn.php';
    include 'screen_setting.php';
    include 'menu.php';
   
    $musteriler = mysql_query("SELECT `No`,Adi,Soyadi,Firmasi,Telefon FROM musteriler");
    ?>
      <main class="mdl-layout__content mdl-color--grey-100">
        <div class="mdl-grid demo-content">
        <table class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp">
  <thead>

<div class="container">
<form action="ekle_musteriler.php" method= "get">
       <input type="text"  name="isim" value="" placeholder="isim giriniz"/><br>
       <input type="text"  name="soyisim" value="" placeholder="soyisim giriniz"/><br>
       <input type="text"  name="firmasi" value="" placeholder="firma giriniz"/><br>
       <input type="number" name="tel_num" value="" placeholder="telefon numarasi giriniz"/>
       <input type="submit" name="submit" value="EKLE"/> 
       <input type="reset" value="SIFIRLA"/>
        <br>
       </form>
</div>
    
    </body>
</html>

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

</html>


<?php
//<button type="button" class="btn btn-primary">ekle</button>
//include 'getir_musteriler.php';
include 'footer.php'; ?>