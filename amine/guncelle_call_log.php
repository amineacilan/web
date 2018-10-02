<html>
<head>  <meta charset="utf-8"></head>
</html>

<?php
 include 'conn.php';

 echo "merhaba";
 
$id=$_GET['id'];
$musteri_id=$_GET["musteri_id"];
$cihaz_no=$_GET["cihaz_no"];
$arama_nedeni=$_GET["arama_nedeni"];
$yapilan_islem=$_GET["yapilan_islem"];
$tamamlanma_durumu=$_GET["tamamlanma_durumu"];

var_dump($id,$musteri_id,$cihaz_no,$arama_nedeni,$yapilan_islem,$tamamlanma_durumu);

 $sql="UPDATE call_log SET cihaz_no='$cihaz_no', arama_nedeni='$arama_nedeni', yapilan_islem='$yapilan_islem', tamamlanma_durumu=$tamamlanma_durumu WHERE id=$id";
     echo $sql;
     
     $guncelle = mysql_query($sql,$baglanti);
     // var_dump($guncelle,$baglanti);     // hata kontrolü için; 
   
 if($guncelle){
     echo "Basarili Bir Sekilde Guncellendi Kontrol Ediniz !";
 }else{
     echo "Bir Sorun Olustu ";
 }

 //header('Location:kyt_getir.php');


?>