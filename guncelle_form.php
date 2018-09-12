<?php
 include 'conn.php';

$id=$_GET['No'];

$sor=mysql_query("SELECT * FROM musteriler WHERE No=$id"); 
//echo $sor;
$yaz = mysql_fetch_assoc($sor); 

$uyeid =$yaz['No'];
$uyeAd =$yaz['Adi']; 
$uyeSoyad =$yaz['Soyadi']; 
$uyeFirmasi =$yaz['Firmasi']; 
$uyeTel =$yaz['Telefon']; 

//var_dump($uyeAd,$uyeFirmasi);

echo "SECMIS OLDUGUNUZ KISI BILGILERI : " , $uyeAd ,'---' , $uyeSoyad,'---' , $uyeFirmasi,'---' , $uyeTel;
?>

<html>
    <head>
    
    </head>
    <body>
       
       <form action="guncelle.php" method= "POST">
        <input type="hidden" name="id" value="<?php echo $uyeid ?>">
       <input type="text"  name="isim" value="<?php echo $uyeAd ?>" placeholder="guncellenecek isim giriniz"/><br>
       <input type="text"  name="soyisim" value="<?php echo $uyeSoyad ?>" placeholder="guncellenecek soyisim giriniz"/><br>
       <input type="text"  name="firmasi" value="<?php echo $uyeFirmasi ?>" placeholder="guncellenecek firma ismi giriniz"/><br>
       <input type="number" name="tel_num" value="<?php echo $uyeTel ?>" placeholder="guncellenecek telefon numarasi giriniz"/>
       <input type="submit" name="submit" value="degistir"/>
        <br>
       </form>

    </body>
</html>




