
    <?php
    include 'inc/header.php';
    include 'inc/conn.php';
    ?>


        <table  class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp" style="display: block; overflow-x: auto; overflow-y: auto; white-space: nowrap; align-items: center;">
          <thead>
            <tr>
              <th style="font-size:20px; color:#00BCD4" class="mdl-data-table__cell--non-numeric">Id</th>
              <th style="font-size:20px; color:#00BCD4">Ad</th>
              <th style="font-size:20px; color:#00BCD4">Soyad</th>
              <th style="font-size:20px; color:#00BCD4">Firma</th>
              <th style="font-size:20px; color:#00BCD4">Telefon</th>
              <th style="font-size:20px; color:#00BCD4">İslem Tarihi</th>
              <th style="font-size:20px; color:#00BCD4">Cihaz No</th>
              <th style="font-size:20px; color:#00BCD4">Arama Nedeni</th>
              <th style="font-size:20px; color:#00BCD4">Yapılan İşlem</th>
              <th style="font-size:20px; color:#00BCD4">Tamamlanma Durumu</th>
              <th style="font-size:20px; color:#00BCD4">SİL</th>
              <th style="font-size:20px; color:#00BCD4">GÜNCELLE</th>
            </tr>
          </thead>
          <tbody>
  <?php 
  $sql = "SELECT call_log.`id`,musteriler.`No`, musteriler.`Adi`, musteriler.`Soyadi`,musteriler.`Firmasi`,musteriler.`Telefon`, call_log.`islem_tarihi`,call_log.`cihaz_no`,call_log.`arama_nedeni`,call_log.`yapilan_islem`,call_log.`tamamlanma_durumu`
  FROM call_log INNER JOIN musteriler ON call_log.musteri_id=musteriler.No ORDER BY call_log.`id` DESC";
  $result = mysql_query($sql, $baglanti);
  while ($row2 = mysql_fetch_array($result)) {
    
    $id = $row2['id'];
    $musteri_adı = $row2['Adi'];
    $musteri_soyadı = $row2['Soyadi'];
    $musteri_firma = $row2['Firmasi'];
    $musteri_telefon = $row2['Telefon'];
    $islem_tarihi = $row2['islem_tarihi'];
    $cihaz_no = $row2['cihaz_no'];
    $arama_nedeni = $row2['arama_nedeni'];
    $yapilan_islem = $row2['yapilan_islem'];
    $tamamlanma_durumu = $row2['tamamlanma_durumu'];
    ?>
    <tr>
      <td style="font-size:15px; color:#006dd4" class="mdl-data-table__cell--non-numeric"><? echo $id ?></td>     
      <td style="font-size:15px;"><? echo $musteri_adı ?></td>
      <td style="font-size:15px;"><? echo $musteri_soyadı ?></td>
      <td style="font-size:15px;"><? echo $musteri_firma ?></td>
      <td style="font-size:15px;"><? echo $musteri_telefon ?></td>
      <td style="font-size:15px;"><? echo $islem_tarihi ?></td>
      <td style="font-size:15px;"><? echo $cihaz_no ?></td>
      <td style="font-size:15px;"><? echo $arama_nedeni ?></td>
      <td style="font-size:15px;"><? echo $yapilan_islem ?></td>
      <td style="font-size:15px;"><? echo $tamamlanma_durumu ?></td>
      <td><a href="http://192.168.1.111:8080/amine/sil_call_log.php?No=<? echo $id ?>"><i class="material-icons">delete</i></a></td>
      <td><a href="http://192.168.1.111:8080/amine/guncelle_form_call_log.php?No=<? echo $id ?>"><i class="material-icons">edit</i></a></td>
    </tr>
   <?php 
}
?>  
  </tbody>
</table>


<?php 
include 'inc/footer.php';
?>



    <?php
    /*
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
        $tamamlanma_durumu = $row2['tamamlanma_durumu'];

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
    */
    ?>
