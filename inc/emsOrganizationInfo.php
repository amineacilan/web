<?php
$organizatonLinkClass = $componentLinkClass = $templateLinkClass = $reportLinkClass = $billLinkClass = '';
$harmonicsLinkClass = $loadProfileLinkClass = $controlLinkClass = $settingsLinkClass = $userCommDeviceLinkClass = '';

switch ($activePage) {
  case 'emsOrganizationForm':
    $organizatonLinkClass = 'active';
    break;
  case 'emsComponentType':
    $componentLinkClass = 'active';
    break;
  case 'emsTemplateForm':
    $templateLinkClass = 'active';
    break;
}
?>
<div class="">
  <div class="portlet box blue">
    <div class="portlet-title">
      <div class="caption">
        Organizasyon Tanımlama
      </div>
    </div>
    <div class="portlet-body">
      <div class="tabbable-custom nav-justified">
        <ul class="nav nav-tabs nav-justified">
          <li class="<?php echo $organizatonLinkClass; ?>" id="firstTab">
            <a>
              1. Adım </a>
          </li>
          <li class="<?php echo $componentLinkClass; ?>" id="secondTab">
            <a>
              2. Adım </a>
          </li>
          <li class="<?php echo $templateLinkClass; ?>" id="thirdTab">
            <a>
              3. Adım </a>
          </li>
        </ul>