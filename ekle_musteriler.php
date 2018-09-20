    <?php
    include 'conn.php';

    echo "isminiz ", $_GET["isim"] ."<br>". "telefon numaraniz ", $_GET["tel_num"] ."<br>"; 

//insert

$ad = $_GET["isim"];
$soyad = $_GET["soyisim"];
$firma = $_GET["firmasi"];
$tel = $_GET["tel_num"];
$sql="INSERT INTO musteriler (Adi,Soyadi,Firmasi,Telefon) VALUES ('$ad','$soyad','$firma','$tel')";
    echo $sql;
$ekle = mysql_query($sql,$baglanti);
      var_dump($ekle,$baglanti);     // hata kontrolü için; 

if($ekle){
    echo "Basarılı Bir Sekilde Eklendi Kontrol Ediniz !";
}else{
    echo "Bir Sorun Olustu";
}
// Sorun Oluştu mu diye test edelim. Eğer sorun yoksa hata vermeyecektir
header('Location:test.php');

    ?>