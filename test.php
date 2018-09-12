<?php include 'header.php';?>

<div class="container">
<form action="ekle.php" method= "get">
       <input type="text"  name="isim" value="" placeholder="isim giriniz"/><br>
       <input type="text"  name="soyisim" value="" placeholder="soyisim giriniz"/><br>
       <input type="text"  name="firmasi" value="" placeholder="firma giriniz"/><br>
       <input type="number" name="tel_num" value="" placeholder="telefon numarasi giriniz"/>
    
       <button type="button" class="btn btn-primary">ekle</button>
        <br>
       </form>
</div>
    


    </body>
</html>

<?php
include 'getir.php';
include 'footer.php';?>