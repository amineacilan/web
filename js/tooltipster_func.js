function initTooltipster()
{
  $('.tooltipOld:not(.tooltipstered)').tooltipster({
    arrow: false,
    contentAsHTML: true,
    delay: 50,
    offsetX: -10,
    offsetY: -30,
    position: 'right',
    theme: 'tooltipster-punk'
  });
}