<?php
  
  $dbhost ="127.0.0.1";
  //Burasi Genellikle Localhost olur,ve localhostta çalıştıgımız içinde localhost olacak
  $dbkullanici = "root";
  //kullanici adi Localhostta Çalıştıgımız için burasida root olacak,eger bir host kıralasaydınız,Host şirketini verdigi kullanici adini yazacaktınız
  $dbsifre = "";
  //Localhostta Çalıştıgımız İçin burası boş olacak,Sizin Hostinginizde size verilen şifre neyse siz o şifreyi yazacaksınız
  $dbadi = "amine_test";
  //Az once Phpmyadmin'de "SANALKURS" adında bir veritabani oluşturduk ve  burayada onu yazıyoruz
  $baglanti = mysql_connect($dbhost,$dbkullanici,$dbsifre);
  mysql_select_db($dbadi);
  if(! $baglanti){
  //echo "Mysql baglantisi Saglanamadi"."<br>";
  }else{
  //echo "Veritabanina Baglandim"."<br>";
  }
  
//Yukarida $baglanti adında bir degişken oluşturduk ve mysql_connect dedik ,Yani Mysql'a bağlan dedik,sonra parantezlerimizi açarak içerisine 3 arguman girdik,"$dbhost,$dbuser,$dbpass" bunlar degişmez 3 lüdür biz her kodlamamzıda veritabaina baglanmak için bu 3 argumanlari yazacağız...:)
//Ve if kontrolu oluşturduk,Dedik ki eger veritabanina baglanamazsa "Mysql Baglantisi Sağlanamadi desin"
//else kontrolu ilede eger veritabanina baglanirsa "Veritabanina Baglandim Desin"

  ?>
