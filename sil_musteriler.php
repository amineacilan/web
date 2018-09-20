<?php
 include 'conn.php';

 //delete
 
/*
$ad = $_GET["isim"];
$tel = $_GET["tel_num"];
*/

$id=$_GET['No'];
$abc=$_GET['isim'];

$sql = "DELETE FROM musteriler WHERE No=$id";
echo $sql;
$sil = mysql_query($sql,$baglanti);      

if($sil){
    echo "Basarılı Bir Sekilde Silindi Kontrol Ediniz !";
}else{
    echo "Bir Sorun Olustu";
}
// Sorun Oluştu mu diye test edelim. Eğer sorun yoksa hata vermeyecektir
header('Location:index.php');

?>