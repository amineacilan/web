<html>
<head>

<center> <strong> <em> <font size= 14px> <font color="#33FF33">>--- ANA EKRAN ---< </em></strong> </center><center>
<meta charset="utf-8">
</head>

<body>
</body>
</html>


<?php 
include 'conn.php';
include 'header.php';
include 'menu.php';

 ?>

<form name="main_göster" method="get" action="kyt_getir.php">
<input type="submit" name="submit_main_cagri_göster" value="TÜM rILARI GÖSTER"/> 
</form>

<form name="main_ekle" method="get" action="cagri_kayit.php">
<input type="submit" name="submit_main_cagri_ekle" value="YENİ ÇAĞRI EKLE"/> 
</form>

<form name="main_musteri_ekle" method="get" action="test.php">
<input type="submit" name="submit_main_musteri_ekle" value="YENİ MÜŞTERİ EKLE"/> 
</form>

<form name="main_musteri_göster" method="get" action="getir_musteriler.php">
<input type="submit" name="submit_main_cagri_göster" value="TÜM MÜŞTERİLERİ GÖSTER"/> 
</form>