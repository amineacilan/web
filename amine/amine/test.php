
    
    <?php
   
   include 'inc/header.php';
   include 'inc/conn.php';
   
    $musteriler = mysql_query("SELECT `No`,Adi,Soyadi,Firmasi,Telefon FROM musteriler");
    ?>
      
       


<form action="ekle_musteriler.php" method= "get">
       <input type="text"  name="isim" value="" placeholder="isim giriniz"/><br>
       <input type="text"  name="soyisim" value="" placeholder="soyisim giriniz"/><br>
       <input type="text"  name="firmasi" value="" placeholder="firma giriniz"/><br>
       <input type="number" name="tel_num" value="" placeholder="telefon numarasi giriniz"/>
       <input type="submit" name="submit" value="EKLE"/> 
       <input type="reset" value="SIFIRLA"/>
        <br>
       </form>

    
  





<?php
//<button type="button" class="btn btn-primary">ekle</button>
//include 'getir_musteriler.php';
include 'footer.php'; ?>