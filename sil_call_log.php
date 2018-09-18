<?php
 include 'conn.php';

 //delete
 
/*
$ad = $_GET["isim"];
$tel = $_GET["tel_num"];
*/

$id=$_GET['id'];


$sql = "DELETE FROM call_log WHERE id=$id";
//echo $sql;
$sil = mysql_query($sql,$baglanti);      

if($sil){
    echo "Basarılı Bir Sekilde Silindi Kontrol Ediniz !";
}else{
    echo "Bir Sorun Olustu";
}
// Sorun Oluştu mu diye test edelim. Eğer sorun yoksa hata vermeyecektir
header('Location:kyt_getir.php');
?>