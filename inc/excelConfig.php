<?php
set_time_limit(120);
//// titles //////////////
$title_meter_last_data = "SAYAÇ SON ENDEKSLER";
$title_device_consumption = "TÜKETİM RAPORU";
$title_list_meters = "SAYAÇ LİSTESİ";
$title_list_alarms = "ALARM LİSTESİ";
$title_list_users ="KULLANICI LİSTESİ";

$dateDayFormat = '%d.%m.%Y';    ////////excel tablolarındaki tarih formatı///////
$dateTimeFormat = '%H:%M:%S';    ////////excel tablolarındaki saat formatı///////
$dateFormat = '%H:%M:%S (%d.%m.%Y)';    ////////excel tablolarındaki Tarih formatı///////
$demandDateFormat = '%H:%M (%d.%m.%Y)';    ////////excel tablolarındaki Tarih formatı///////
$excelBorder = 1;  ///////////excel tablolarında border olacak mı ? ( 1 veya 0 )///////////////
////////////en üstteki tanımlama başlıkları css'i//////////////////////////////////////////////
$topTitleCss = 
array(
'font'  => array(
		'bold'  => true,
		'size'  => 11
),
'fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_SOLID,
		'startcolor' => array(
				'rgb' => 'C3DA80'
		)
));

//////////// üstteki tanımlama başlıkları karşısındaki değerler için css////////////////////
$topDescriptionCss = 
array(
'font'  => array(
		'bold'  => true,
		'size'  => 11
),
'fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_SOLID,
		'startcolor' => array(
				'rgb' => 'B28ECB'
		)
));

//////////// tanımlama ile tablo arasındaki boşluk için css////////////////////
$spaceCss = 
array(
'font'  => array(
		'bold'  => false
),
'fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_SOLID,
		'startcolor' => array(
				'rgb' => 'A3C0D5'
		)
));

//////////// tablo başlıkları için css////////////////////
$tableTitleCss = 
array(
'font'  => array(
		'bold'  => true,
		'color' => array('rgb' => 'A31515')
),
'fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_SOLID,
		'startcolor' => array(
				'rgb' => '35DABB',
		)
));

//////////// tablo alt başlıkları için css////////////////////
$tableSubTitleCss = 
array(
'font'  => array(
		'bold'  => false,
		'color' => array('rgb' => 'E44207')
),
'fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_SOLID,
		'startcolor' => array(
				'rgb' => '35DABB',
		)
));

//////////// tablo verileri için css////////////////////
$tableDataCss = 
array(
'font'  => array(
		'bold'  => false,
		'color' => array('rgb' => '1E69B3')
),
'fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_SOLID,
		'startcolor' => array(
				'rgb' => 'FFFFD6',
		)
));


