

    <?php
    include 'inc/header.php';
    include 'inc/conn.php';
    $sql = "SELECT * FROM musteriler";
    $result = mysql_query($sql, $baglanti);
    ?>
    <div style = "" class="mdl-cell mdl-cell--8-col"> 
    <div class="mdl-grid">
        <table class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp" >
          <thead>
            <tr>
              <th style="font-size:20px; color:#00BCD4" class="mdl-data-table__cell--non-numeric">Id</th>
              <th style="font-size:20px; color:#00BCD4">Ad</th>
              <th style="font-size:20px; color:#00BCD4">Soyad</th>
              <th style="font-size:20px; color:#00BCD4">Firma</th>
              <th style="font-size:20px; color:#00BCD4">Telefon</th>
              <th style="font-size:20px; color:#00BCD4">SİL</th>
              <th style="font-size:20px; color:#00BCD4">GÜNCELLE</th>
            </tr>
          </thead>
          <tbody>
            
  <?php 
  $sql = "SELECT * FROM musteriler ORDER BY musteriler.`No` DESC";
  $result = mysql_query($sql, $baglanti);
  while ($row = mysql_fetch_array($result)) {
    $Adi = $row['Adi'];
    $Soyadi = $row['Soyadi'];
    $Firmasi = $row['Firmasi'];
    $Telefon = $row['Telefon'];
    $No = $row['No'];
    ?>
    <tr>
      <td style="font-size:15px; color:#006dd4" class="mdl-data-table__cell--non-numeric"><? echo $No ?></td>
      <td style="font-size:15px;"><? echo $Adi ?></td>      
      <td style="font-size:15px;"><? echo $Soyadi ?></td>
      <td style="font-size:15px;"><? echo $Firmasi ?></td>
      <td style="font-size:15px;"><? echo $Telefon ?></td>
      <td><a href="http://192.168.1.111:8080/amine/sil_musteriler.php?No=<? echo $No ?>"><i class="material-icons">delete</i></a></td>
      <td><a href="http://192.168.1.111:8080/amine/guncelle_form_musteriler.php?No=<? echo $No ?>"><i class="material-icons">edit</i></a></td>
    </tr>
   <?php 
}
?>  
  </tbody>
</table>
</div>
  </div>

  <div style = "" class="mdl-cell mdl-cell--4-col">
  <div class="mdl-grid">
  <div style = "" class="mdl-cell mdl-cell--12-col">
      <form name="form2" method="get" action="musteri_ekle_form.php" class="">
        <input type="submit" name="submit" class="mdl-button mdl-js-button mdl-js-ripple-effect" style="font-size:20px; color:#00BCD4" value="MÜŞTERİ EKLE"/> 
      </form>
      </div>
      </div>
  </div>

<?php 
include 'inc/footer.php';
?>


