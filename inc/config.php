<?php

/*
  $ip = $_SERVER ['REMOTE_ADDR'];

  //if ($ip != "78.188.170.253")
  {
  header("Location: /construction.php");
  exit();
  }
 */
$modemLogDrive = 'C:';

$config_domain = 'enerjitakibi.com';
$config_title = 'SmartPower Enerji İzleme Sistemi';

$web_root = 'http://www.enerjitakibi.com';  // Port numarası varsa eklenecek -> 'http://osos.karamanosb.org.tr:8080'

$dbName = 'smartpower_db';
$dbUser = 'sp_website';
$dbPwd = 'x3ABC7421';

$rootFolder = $_SERVER['DOCUMENT_ROOT'];

switch ($rootFolder) {
  case 'C:/inetpub/vhosts/enerjitakibi_test.com':
    $config_domain = '212.68.54.165';
    $web_root = '212.68.54.165';
    $config_title = 'TEST - SMARTPOWER ENERJİ İZLEME SİSTEMİ';
    $dbName = 'smartpower_test_db';
    break;

  case 'C:/WORKS/Web/sp_new':
    $config_domain = '127.0.0.1';
    $web_root = '127.0.0.1';
    $config_title = 'LOCAL - SMARTPOWER ENERJİ İZLEME SİSTEMİ';
    $dbName = 'smartpower_test_db';
    $modemLogDrive = 'D:';
    break;

  case 'C:/wamp/www':
    //    error_reporting(E_ALL ^ E_NOTICE);
    //    ini_set('display_errors', 1);
    $config_domain = '192.168.1.111';
    $web_root = '192.168.1.111';
    $config_title = 'MRROBOT - SMARTPOWER ENERJİ İZLEME SİSTEMİ';
    $dbName = 'smartpower_db';
    //    $dbUser = 'root';
    //    $dbPwd = 'mrrobot';
    $modemLogDrive = 'D:';
    break;
}

// Mail Server Settings
$smtp_email = 'info@enerjitakibi.com';
$smtp_server = 'mail.enerjitakibi.com';
$smtp_user = 'info@enerjitakibi.com';
$smtp_pass = 'Gruparge2010';

$meterSupport = true;
$reactiveRelaySupport = true;
$analyzerSupport = true;
$gensetSupport = true; //Jeneratör
$temperatureSensorSupport = true; //sıcaklık sensörü
$analogSensorSupport = true; //analog sensör
$pulseCounterSupport = true; //sayıcı

$deviceBasedAuthSupport = true; //Cihaz bazlı yetkilendirme

$gasMeterSupport = true;
$flowMeterSupport = false;
$ioSupport = true;
$transformerSupport = false;
$paymentSupport = true;
$supportSupport = true;
$blogSupport = true;
$demoSupport = true;
$smsSupport = true;
$billSupport = true;
$mapSupport = true;
$contactSupport = true;
$maintenanceSupport = true;
$webPushSupport = true;
$datatablePaginateEnable = true; //Datatable Sayfalama aktif mi?
$subscriberNoSupport = false; //Sayaç sayfasında Tesisat No gösterilsin mi?
$currentValueDisplay = 0;  // 0: her ikisini de göster , 1:sadece ham değeri göster, 2:sadece çarpanlı değeri göster
$voltageValueDisplay = 0;  // 0: her ikisini de göster , 1:sadece ham değeri göster, 2:sadece çarpanlı değeri göster
$showConsumptionOnDataPage = true;
$fileUpload = true;
$emailCheckControl = false; //Kullanıcı oluştururken eposta adresi çalışıyor mu kontrolü
$passwordsVisible = true; // true => Tüm şifreler admin tarafından görünür
/// sayaç sayfsası için \\\
$cityDisplay = false;
$countryDisplay = false;
$sozlesmeGucuDisplay = false;
$demandDisplay = false;
$subcriberStatus = false;
$adminDeparmantSupport = false;
$gasMeterMaxMinData = false; // Anasayfada Doğal Gaz Sayaçlarının max. min. çekiş limitleri alarm tablosunu göstermek için.
/* E-POSTA Alarmları Desteği */
$alarmlightingSupport = false;
/* SMS Alarmları Desteği */
$alarmVoltageSmsSupport = false;
$alarmCurrentUnstableSmsSupport = false;
$alarmlightingSmsSupport = true;
$co2referance = "http://www.cevreciyiz.com/sayfa/1/23/karbon-sayaci";
$co2Value = 0.462;
//  Anasayfadaki bigi kutucuklarının gösterimi için yapılan flag dizisi
//  0 : Modem
//  1 : Cihaz
//  2 : Kullanıcı
//  3 : Son Çalışma Zamanı(Reaktif değerlerin hesaplanması)
//  4 : Son 24 saatte giriş yapan kullanıcı sayısı
//  5 : Servis Durumu
$dashboardStatDisplay = array(1, 1, 1, 1, 1, 1);

$baseMeter = '';

// date_default_timezone_set('Europe/Istanbul');
date_default_timezone_set('Asia/Kuwait');

// Multibyte encoding: UTF-8
// This is required for mb_* functions work correctly
mb_internal_encoding('UTF-8');
