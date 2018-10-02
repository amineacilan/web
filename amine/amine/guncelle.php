<html>
<head>  <meta charset="utf-8"></head>
</html>

<?php
 include 'conn.php';

 echo "merhaba";
 
$id=$_POST['id'];
$isim=$_POST["isim"];
$soyisim=$_POST["soyisim"];
$firmasi=$_POST["firmasi"];
$tel=$_POST["tel_num"];

//var_dump($id,$isim,$soyisim,$firmasi,$tel);

 $sql="UPDATE musteriler SET Adi='$isim', Soyadi='$soyisim', Firmasi='$firmasi', Telefon=$tel WHERE No=$id";

    // echo $sql;
 $guncelle = mysql_query($sql,$baglanti);
   // var_dump($guncelle,$baglanti);     // hata kontrolü için; 
 
 if($guncelle){
     echo "Basarili Bir Sekilde Guncellendi Kontrol Ediniz !";
 }else{
     echo "Bir Sorun Olustu ";
 }

 header('Location:test.php');


?>