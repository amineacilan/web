<html>
<head>
<center> <strong> <em> <font size= 14px> <font color="#FFD700">>--- ÇAĞRI KAYIT EKRANI ---< </em></strong> </center><center>
</head>
<body>
</body>
</html>

<?php
include 'conn.php';
include 'header.php';
 // include 'ekle.php'


//$sql="SELECT * FROM call_log GROUP BY islem_tarihi";


$sql = "SELECT call_log.`id`,musteriler.`No`, musteriler.`Adi`, musteriler.`Soyadi`,musteriler.`Firmasi`,musteriler.`Telefon`, call_log.`islem_tarihi`,call_log.`cihaz_no`,call_log.`arama_nedeni`,call_log.`yapilan_islem`,call_log.`tamamlanma_durumu`
FROM call_log INNER JOIN musteriler ON call_log.musteri_id=musteriler.No ORDER BY musteriler.`No` DESC";

$result = mysql_query($sql, $baglanti);


echo '<table>';
echo "<tr>
<th align='center'>ID</th>
<th align='center'>MUŞTERİ ID</th>
<th align='center'>MUŞTERİ ADI</th>
<th align='center'>MUŞTERİ SOYADI</th>
<th align='center'>MUŞTERİ FİRMA</th>
<th align='center'>MUŞTERİ TELEFON</th>
<th align='center'>İŞLEM TARİHİ</th>
<th align='center'>CİHAZ NO</th>
<th align='center'>ARAMA NEDENİ</th>
<th align='center'>YAPILAN İŞLEM</th>
<th align='center'>TAMAMLANMA DURUMU</th>
<th align='center'>YAPILACAK İŞLEM</th>
<th align='center'>YAPILACAK İŞLEM</th>
 </tr>";
while ($row2 = mysql_fetch_array($result)) {

    $id = $row2['id'];
    $musteri_ıd = $row2['No'];
    $musteri_adı = $row2['Adi'];
    $musteri_soyadı = $row2['Soyadi'];
    $musteri_firma = $row2['Firmasi'];
    $musteri_telefon = $row2['Telefon'];
    $islem_tarihi = $row2['islem_tarihi'];
    $cihaz_no = $row2['cihaz_no'];
    $arama_nedeni = $row2['arama_nedeni'];
    $yapilan_islem = $row2['yapilan_islem'];
    $tamamlanma_durumu = $row2['tamamlanma_durumu'] ;


    //."<a href='sil.php?No=$id'>SIL</a>"; header('Location:cagri_kayit.php');
    echo " <tr>
    <td align='center'>$id</td>
    <td align='center'>$musteri_ıd</td> 
    <td align='center'>$musteri_adı</td> 
    <td align='center'>$musteri_soyadı</td>
    <td align='center'>$musteri_firma</td>
    <td align='center'>$musteri_telefon</td>
    <td align='center'>$islem_tarihi</td>
    <td align='center'>$cihaz_no</td>
    <td align='center'>$arama_nedeni</td>
    <td align='center'>$yapilan_islem</td>
    <td align='center'>$tamamlanma_durumu</td>
    <td> <a href='guncelle_form_call_log.php?id=$id'>GUNCELLE</a></td>
    <td> <a href='sil_call_log.php?id=$id'>SİL</a></td>
    </tr> ";

}
echo '<table>';

?>

<html>
<head>
</head>
<body>
    

</body>
</html>