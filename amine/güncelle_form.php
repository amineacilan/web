<?php

$id=$_GET['id'];
var_dump($id);
$sor=mysql_query("SELECT * FROM call_log WHERE id=$id"); 
$yaz = mysql_fetch_assoc($sor); 

$uyeid =$yaz['id'];
$uyeAd =$yaz['ad']; 
$uyeTel =$yaz['telefon']; 

if($sor){
    echo "Basarılı Bir Sekilde Guncellendi Kontrol Ediniz !";
}else{
    echo "Bir Sorun Olustu";
}

/*
$sql = "SELECT * FROM call_log WHERE id=$id";

$guncelle = mysql_query($sql,$baglanti);      

if($guncelle){
    echo "Basarılı Bir Sekilde Guncellendi Kontrol Ediniz !";
}else{
    echo "Bir Sorun Olustu";
}
*/


?>


