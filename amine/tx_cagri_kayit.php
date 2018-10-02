<?php
include 'conn.php';
include 'header.php';

   

//insert

$cihaz_no = $_GET["cihaz_no"];
$musteri= $_GET["musteri"];
$arama_neden = $_GET["arama_nedeni"];
$yapilan_islem = $_GET["yapilan_islemler"];
$tamamlanma_drm = $_GET["tamamlanma_drm"];
$sql = "INSERT INTO call_log (cihaz_no,musteri_id,arama_nedeni,yapilan_islem,tamamlanma_durumu) 
VALUES ('$cihaz_no',$musteri,'$arama_neden','$yapilan_islem','$tamamlanma_drm')";
echo $sql;
$ekle = mysql_query($sql, $baglanti);
var_dump($ekle, $baglanti);     // hata kontrolü için; 

if ($ekle) {
    echo "Basarılı Bir Sekilde Eklendi Kontrol Ediniz !";
} else {
    echo "Bir Sorun Olustu";
}
// Sorun Oluştu mu diye test edelim. Eğer sorun yoksa hata vermeyecektir
header('Location:cagri_kayit.php');

?>