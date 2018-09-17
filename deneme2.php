<select name="il"  
  <option  value="<?=$il_id ?>"> <?php echo "İl Seçiniz"; ?> </option>
             <?php
  
 $iller= @mysql_query("SELECT * FROM il", $baglanti);
$i=1;
 while ($il_liste = @mysql_fetch_row($iller))
 { 
 
 ?> 
        <option  value="<?php print($il_liste[0]);  ?>"> <?php print($il_liste[1]); ?> </option>
       
  <?php       
 }
  $i++;
 ?>
        </select>
         <input type="hidden" name="il_id"  value="<?php print($il_liste[0]);  ?>"/>