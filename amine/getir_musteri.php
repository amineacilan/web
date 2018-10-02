<?php
 include 'conn.php';


$sql="SELECT * FROM musteriler";
  //  echo $sql;
$result = mysql_query($sql,$baglanti);
//var_dump($result);
while($row= mysql_fetch_array($result))
{
    //var_dump($row);
    $id=$row['No'];
    $x=$row['Adi'];
   // $xyz=$row['Soyadi'];
   // $xyz=$row['Firmasi'];
   // $xyz=$row['Telefon'];
echo $row['Adi'] . '---' .$row['Soyadi'] .'---'."   ".$row['Firmasi'] . '---'.$row['Telefon'] . '---'. "<a href='sil.php?No=$id'>SIL</a>"."   "."<a href='guncelle_form.php?No=$id'>GUNCELLE</a><br>";
}

?>