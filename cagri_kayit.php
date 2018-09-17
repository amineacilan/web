<?php include 'header.php';
include 'conn.php';
 
$musteriler=mysql_query("SELECT `No`,Adi,Soyadi,Firmasi,Telefon FROM musteriler"); //var_dump($musteriler);
?> 
<form id="form1" name="cagri_kayit" method="get" action=""> 
  <label> 
   musteri seçiniz: <select name="select" id="select"> 
  
<?php  
while(list($No2,$Adi2,$Soyadi2,$Firmasi2,$Telefon2)=mysql_fetch_array($musteriler))
 { print($list[0]);
?> 
<option value="<?=$Soyadi2?>"><?=$Adi2?>-><?=$Soyadi2?>-><?=$Firmasi2?>-><?=$Telefon2?>  </option> 
<? } 

    </select> 
  </label> 
</form>
 
 <?php  
 echo "$Adi2";
 ?>
