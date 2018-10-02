<html>
<head>  <meta charset="utf-8"></head>
</html>

<?php
 include 'conn.php';

 echo "merhaba";
 
$id=$_GET['id'];
$isim=$_GET["isim"];
$soyisim=$_GET["soyisim"];
$firmasi=$_GET["firmasi"];
$tel=$_GET["tel_num"];

var_dump($id,$isim,$soyisim,$firmasi,$tel);

 $sql="UPDATE musteriler SET Adi='$isim', Soyadi='$soyisim', Firmasi='$firmasi', Telefon=$tel WHERE No=$id";

     echo $sql;
 $guncelle = mysql_query($sql,$baglanti);
   // var_dump($guncelle,$baglanti);     // hata kontrolü için; 
 
 if($guncelle){
     echo "Basarili Bir Sekilde Guncellendi Kontrol Ediniz !";
 }else{
     echo "Bir Sorun Olustu ";
 }

 header('Location:getir_musteriler.php');


?>