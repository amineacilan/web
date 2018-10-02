
    <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
    
    <?php
    include 'screen_setting.php';
    include 'menu.php';
    include 'conn.php';
    ?>
      <main class="mdl-layout__content mdl-color--grey-100">
        <div class="mdl-grid demo-content">
        <table class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp">
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
      
        </div>
      </main>
    </div>
      <a href="https://github.com/google/material-design-lite/blob/mdl-1.x/templates/dashboard/" target="_blank" id="view-source" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored mdl-color-text--white">View Source</a>
    <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
  </body>
</html>
