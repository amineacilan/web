<?php

// K/K Bedeli Hesabı
function K_K($tuketim_aktif, $birim_fiyat_KK)
{
//  $birim_fiyat_KK = 0;
  return $birim_fiyat_KK * $tuketim_aktif;
}

// Per.Sat.Hiz.Bd. Bedeli Hesabı
function per_sat_hiz($tuketim_aktif, $perSat)
{
//  $birim_fiyat_per_sat = 0.008377;
  return $perSat * $tuketim_aktif;
}

//PSH (Say.Oku.) Bd. Bedeli Hesabı
function psh($ratio_voltage, $sayOkuma)
{
  return $sayOkuma;
}

//İle.Sis.Kul.Bd. Bedeli Hesabı
function ile_sis_kul($tuketim_aktif, $ileSis)
{
//  $birim_fiyat_ile_sis = 0.008903;
  return $ileSis * $tuketim_aktif;
}

//Dağıtım Bedeli Hesabı
function dagitim_bd($tuketim_aktif, $ratio_voltage, $dagitim)
{
//  $birim_fiyat_dagitim = ($ratio_voltage <= 1) ? (0.022347) : (0.014305);
  return $dagitim * $tuketim_aktif;
}

//İletim Bedeli (Tüketim Payı) Hesabı
function iletim_bd_tukekim_payi($previous_month_consumption, $iletim_bd_tuketim_payi_birim_fiyat)
{
  /* Önceki dönemin tüketimi * belirlenen birim fiyat */
  return $previous_month_consumption * $iletim_bd_tuketim_payi_birim_fiyat;
}

function yekdem_farki($previous_month_consumption, $yekdem_birim_fiyat)
{
  /* Önceki dönemin tüketimi * belirlenen birim fiyat */
  return $previous_month_consumption * $yekdem_birim_fiyat;
}

//İletim Bedeli (Guc Payı) Hesabı
function iletim_bd_guc_payi($sozlesme_gucu, $iletim_bd_guc_payi_birim_fiyat)
{
  /* Sözleşme gücü * belirlenen birim fiyat */
  return $sozlesme_gucu * $iletim_bd_guc_payi_birim_fiyat;
}

//Güç Tutarı Hesabı
function power_guc($inoperativeLoss, $transformerLossUnitCost, $startDate, $endDate)
{
  $hourDiff = ((strtotime($endDate) - strtotime($startDate)) / (60 * 60));
  return $inoperativeLoss * $hourDiff * $transformerLossUnitCost;
}

//Enerji Fonu Hesabı
function enerji_fon($toplamTuketimTutari, $energyFund)
{
//  $yuzde1 = 0.01;

  return $toplamTuketimTutari * $energyFund * 0.01;
}

//TRT Payı Hesabı
function trt($toplamTuketimTutari, $trtShare)
{
//  $yuzde2 = 0.02;

  return $toplamTuketimTutari * $trtShare * 0.01;
}

//Elektrik Tüketim Vergisi Hesabı
function elek_tuk($toplamTuketimTutari, $energyConsumptionTax)
{
//  $yuzde5 = 0.05;

  return $toplamTuketimTutari * $energyConsumptionTax * 0.01;
}

//KDV Hesabı
function kdv_value($fatura_tutari)
{
  $vergi_orani = 0.18;

  return $fatura_tutari * $vergi_orani;
}
