<html>
<head>  <meta charset="utf-8"></head>
</html>

<?php
 include 'conn.php';

$id=$_GET['id'];

$sor=mysql_query("SELECT * FROM call_log WHERE id=$id"); 
//echo $sor;
$yaz = mysql_fetch_assoc($sor); 

$id =$yaz['id'];
$musteri_id =$yaz['musteri_id']; 
$cihaz_no =$yaz['cihaz_no']; 
$arama_nedeni =$yaz['arama_nedeni']; 
$yapilan_islem =$yaz['yapilan_islem']; 
$tamamlanma_durumu =$yaz['tamamlanma_durumu']; 

echo "SECMIS OLDUGUNUZ MUŞTERİ ID'Sİ : " , $musteri_id ;


//var_dump($uyeAd,$uyeFirmasi);
// <input type="hidden" name="id" value="<?php echo $uyeid ?>


<html>
    <head>
    
    </head>
    <body>
       
       <form action="guncelle_call_log.php" method= "GET">
      
       <input type="hidden" name="id" value="<?php echo $id ?>">
       <input type="hidden" name="musteri_id" value="<?php echo $musteri_id ?>">
       GÜNCELLENECEK CİHAZ NO GİRİNİZ: <input type="text"  name="cihaz_no" value="<?php echo $cihaz_no ?>" placeholder=""/><br>
       GÜNCEL ARAMA NEDENİ GİRİNİZ: <input type="text"  name="arama_nedeni" value="<?php echo $arama_nedeni ?>" placeholder="guncel arama nedeni giriniz"/><br>
       GÜNCEL YAPILAN İŞLEM GİRİNİZ: <input type="text"  name="yapilan_islem" value="<?php echo $yapilan_islem ?>" placeholder="guncel işlemi giriniz"/><br>
       TAMAMLANDI/TAMAMLANMADI: <input type="text" name="tamamlanma_durumu" value="<?php echo $tamamlanma_durumu ?>" placeholder="tamamlandı mı?"/>
       <input type="submit" name="submit" value="DEĞİŞTİR"/>
       <input type="reset" value="SIFIRLA"/>
        <br>
       </form>

    </body>
</html>