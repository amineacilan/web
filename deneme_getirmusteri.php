<div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
<span class="mdl-layout-title">ÇAĞRI KAYIT EKRANI</span>
    <?php
    include 'header.php';
    include 'conn.php';
    include 'screen_setting.php';
   // include 'menu.php';
    
     
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
echo $row['Adi'] . '---' .$row['Soyadi'] .'---'."   ".$row['Firmasi'] . '---'.$row['Telefon'] . '---'. "<a href='sil_musteriler.php?No=$id'>SIL</a>"."   "."<a href='guncelle_form_musteriler.php?No=$id'>GUNCELLE</a><br>";
}

    ?>
      <main class="mdl-layout__content mdl-color--grey-100">
        <div class="mdl-grid demo-content">
        <table class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp">
  <thead>
