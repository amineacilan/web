<?php

include ('../inc/func.php');

class serviceStatus
{

  public $corret;
  public $finishTime;

}




$getDomain = "http://" . getParamUrl("host", "POST", "") . ":4444";
//echo $getDomain;
//exit();
$start = microtime(true);
//echo $start;
$service = file_get_contents($getDomain);
$end = microtime(true);

$finish = round(1000 * ($end - $start), 0);

if ($service == '<html><body><h1>Tebrikler! Test Basarili ...</h1>GrupArGe SmartPower servisine erisilebiliyor.</body></html>')
{
  $serviceStatus->correct = 1;
  $serviceStatus->service = $service;
  $serviceStatus->finishTime = $finish;
}
else
{
  $serviceStatus->correct = 0;
  $serviceStatus->service = $service;

  $serviceStatus->finishTime = $finish;
}

echo json_encode($serviceStatus);
?>