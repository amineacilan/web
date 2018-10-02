<?php

class menu
{

  public $id;
  public $pageName;
  public $displayName;
  public $link;
  public $icon;
  public $parentId;
  public $class = '';
  public $selected = '';
//submenu varsa alttakiler doldurulacak.
  public $arrow = '';
  public $SubMenu = [];

}

class submenu
{

  public $displayName;
  public $pageName;
  public $link;
  public $icon;
  public $class;

}

$arrMenu = [];

if ($session_type == 'admin')
{
  $menu_user_type = 'admin';
}
else
{
  $menu_user_type = 'public';
}

/* $viewMode = $_COOKIE['viewMode'];

  if ($viewMode === 'new')
  {
  $viewChangeInfo = 'Şimdilik eski görünüme ';
  $menuOption = 'menu_new';
  }
  else
  {
  $viewChangeInfo = 'Yeni işletme görünümünü denediniz mi? ';
  $menuOption = 'menu';
  } */
$menuOption = 'menu';

$sql_query_menu = 'SELECT * FROM ' . $menuOption . ' Where parent_id = 0 AND group_name = ' . '"' . $menu_user_type . '"' . ' ORDER BY rank';
$sql_menu = mysql_query($sql_query_menu);

$menu_count = 0;

while ($menu_row = mysql_fetch_assoc($sql_menu)) {
  if ($menu_row['page_name'] === 'listMeters' && $meterSupport === false)
  {
    continue;
  }

  if ($menu_row['page_name'] === 'listRelays' && $reactiveRelaySupport === false)
  {
    continue;
  }

  if ($menu_row['page_name'] === 'listAnalyzers' && $analyzerSupport === false)
  {
    continue;
  }



  if ($menu_row['page_name'] === 'flowMeters' && $flowMeterSupport === false)
  {
    continue;
  }

  if ($menu_row['page_name'] === 'IO' && $ioSupport === false)
  {
    continue;
  }

  if ($menu_row['page_name'] === 'payment' && $paymentSupport === false)
  {
    continue;
  }


  if ($menu_row['page_name'] === 'support' && $supportSupport === false)
  {
    continue;
  }

  if ($menu_row['page_name'] === 'map' && $mapSupport === false)
  {
    continue;
  }

  if ($menu_row['page_name'] === 'contact' && $contactSupport === false)
  {
    continue;
  }

  if ($menu_row['page_name'] === 'emsBuilding' && $buildingPagePrm != '1' && $session_type !== 'admin')
  {
    continue;
  }

  if ($menu_row['page_name'] === 'payment' && $userPaymentAlertActive != '1' && $session_type !== 'admin')
  {
    continue;
  }

  if (($menu_row['page_name'] === 'listDepars' && $transformerPagePrm != '1' && $session_type !== 'admin') || ($menu_row['page_name'] === 'listDepars' && !$transformerSupport))
  {
    continue;
  }

  $menu = new menu ();
  $menu->id = $menu_row['id'];
  $menu->pageName = $menu_row['page_name'];
  $menu->displayName = $menu_row['display_name'];
  $menu->link = $menu_row['link'];
  $menu->icon = $menu_row['icon'];
  $menu->parentId = $menu_row['parent_id'];

  if ($pageName == $menu->pageName)
  {
    $menu->class = 'active';
    $menu->selected = '<span class="selected"></span>';
  }

  $sql_query_sub_menu = 'SELECT * FROM ' . $menuOption . ' Where parent_id = ' . $menu->id . ' AND group_name = ' . '"' . $menu_user_type . '" ORDER BY rank';
  $sql_sub_menu = mysql_query($sql_query_sub_menu);

  $sub_menu_count = 0;

  $arrowCount = 0;

  while ($sub_menu_row = mysql_fetch_assoc($sql_sub_menu)) {
    if ($sub_menu_row['page_name'] === 'maintenance' && $maintenanceSupport === false)
    {
      continue;
    }

    if ($sub_menu_row['page_name'] === 'listMeters' && $meterSupport === false)
    {
      continue;
    }

    if ($sub_menu_row['page_name'] === 'listRelays' && $reactiveRelaySupport === false)
    {
      continue;
    }

    if ($sub_menu_row['page_name'] === 'listAnalyzers' && $analyzerSupport === false)
    {
      continue;
    }

    if ($sub_menu_row['page_name'] === 'listGenerator' && $gensetSupport === false)
    {
      continue;
    }

    if ($sub_menu_row['page_name'] === 'sensorList' && $temperatureSensorSupport === false)
    {
      continue;
    }

    if ($sub_menu_row['page_name'] === 'analogSensorList' && $analogSensorSupport === false)
    {
      continue;
    }

    if ($sub_menu_row['page_name'] === 'pulseCounterList' && $pulseCounterSupport === false)
    {
      continue;
    }

    if ($sub_menu_row['page_name'] === 'listGasMeters' && (($gasMeterPagePrm != 1 && $session_type !== 'admin') || ($gasMeterSupport === false && $session_type == 'admin')))
    {
      continue;
    }

    $submenu = new submenu ();
    $submenu->pageName = $sub_menu_row['page_name'];
    $submenu->displayName = $sub_menu_row['display_name'];
    $submenu->link = $sub_menu_row['link'];
    $submenu->icon = $sub_menu_row['icon'];

    $menu->SubMenu[$sub_menu_count] = $submenu;

    if ($arrowCount == 0)
    {
      if ($pageName == $submenu->pageName)
      {
        $menu->class = 'active';
        $submenu->class = 'active';
        $menu->arrow = '<span class="arrow open"></span>';
        $menu->selected = '<span class="selected"></span>';
        $arrowCount++;
      }
      else
      {
        $menu->arrow = '<span class="arrow"></span>';
      }
    }

    $sub_menu_count++;
  }

  $arrMenu[$menu_count] = $menu;
  $menu_count++;
}
