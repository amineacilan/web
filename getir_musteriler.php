

    <?php
    include 'inc/header.php';
    include 'inc/conn.php';
    $sql = "SELECT * FROM musteriler";
    $result = mysql_query($sql, $baglanti);
    ?>
        <table class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp" >
          <thead>
            <tr>
              <th class="mdl-data-table__cell--non-numeric">Id</th>
              <th>Ad</th>
              <th>Soyad</th>
              <th>Firma</th>
              <th>Telefon</th>
              <th>SİL</th>
              <th>GÜNCELLE</th>
            </tr>
          </thead>
          <tbody>
  <?php 
  $sql = "SELECT * FROM musteriler";
  $result = mysql_query($sql, $baglanti);
  while ($row = mysql_fetch_array($result)) {
    $id = $row['No'];
    $Adi = $row['Adi'];
    $Soyadi = $row['Soyadi'];
    $Firmasi = $row['Firmasi'];
    $Telefon = $row['Telefon'];
    $No = $row['No'];
    ?>
    <tr>
      <td class="mdl-data-table__cell--non-numeric"><? echo $id ?></td>
      <td><? echo $Adi ?></td>      
      <td><? echo $Soyadi ?></td>
      <td><? echo $Firmasi ?></td>
      <td><? echo $Telefon ?></td>
      <td><a href="http://192.168.1.111:8080/amine/sil_musteriler.php?No=<? echo $No ?>"><i class="material-icons">delete</i></a></td>
      <td><a href="http://192.168.1.111:8080/amine/guncelle_form_musteriler.php?No=<? echo $No ?>"><i class="material-icons">edit</i></a></td>
    </tr>
   <?php 
}
?>  
  </tbody>
</table>

<?php 
include 'inc/footer.php';
?>


