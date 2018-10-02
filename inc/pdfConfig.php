<?php

set_time_limit(120);
$styles = ' .sp_column_header
						{
							color : #13919E;
						}
						.baseTitle
						{
							color:#13919E;
							font-weight:bold;
							font-size:35px;
							float:left;
						}
						.line
						{
							width:100%;
							border-bottom: solid #91BAF2 1px;
						}
						.desc_title
						{
							font-weight: bold;
							width: 70px;
						}
						.pdfYellow
						{
							background-color: #F5F5DF;
						}
						.pdfGreen
						{
							background-color: #DFF5ED;
						}
						.pdfBlue
						{
							background-color: #BEE5ED;
						}';

$line = '<div class="line"></div>';
$HFline = '<div style="height:1px; width:100%; border-bottom: solid #960C0C 1px;"></div>';

if (($rowUser = mysql_fetch_assoc(mysql_query("SELECT company_name, company_logo FROM user WHERE id = $session_user_id", $connection))) && ($rowUser["company_logo"] != ""))
{
  $companyName = $rowUser["company_name"];
  $companyLogo = "/" . $rowUser["company_logo"];
}
else
{
  $companyName = 'GRUP ARGE ENERJİ VE KONTROL SİSTEMLERİ';
  $companyLogo = '/assets/admin/layout/img/gruparge_logo_b.png';
}
$pdfHeader = '<table>
							<tr>
								<td>
									<br><br>
									<div style="color:#169ef4; font-weight:bold; font-size:35px; float:left;">' . $companyName . '</div>
								</td>
								<td align="right">
									<img src="' . $companyLogo . '" width="60" height="55" style="float:right; height: 55px; width: 60px;">
								</td>
							</tr>
						</table>
						' . $HFline . '<br><br>';

$pdfFooter = '<div>
								' . $HFline . '
								<table>
									<tr>
										<td colspan="2" align="left">%%%</td>
										<td colspan="6" align="right">Bu rapor <span style="color: #169ef4; font-weight: bold;">' . date("d.m.Y H:i") . '</span> tarihinde
											<span style="color: #169ef4; font-weight: bold;">SmartPOWER</span>
											üzerinden oluşturuldu.
										</td>
									</tr>
								</table>
							</div>';

$hideError = '<br><br>
							<span style="color:#fff; background-color:#fff;" class="desc_title">üğıişçöIÜĞİŞÇÖ</span>
							<span style="color:#fff; background-color:#fff;">üğıişçöIÜĞİŞÇÖ</span><br><br>';

class MYPDF extends TcpdfCharts
{

  var $htmlHeader;
  var $htmlFooter;

  public function setHtmlHeader($htmlHeader)
  {
    $this->htmlHeader = $htmlHeader;
  }

  public function setHtmlFooter($htmlFooter)
  {
    $this->htmlFooter = $htmlFooter;
  }

  public function Header()
  {
    $this->SetFont('DejaVuSans', '', 8);
    $this->writeHTMLCell(
      $w = 0, $h = 0, $x = '', $y = '', $this->htmlHeader, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);
  }

  public function Footer()
  {
    $this->SetFont('DejaVuSans', '', 8);
    $this->htmlFooter = str_replace("%%%", $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), $this->htmlFooter);
    // $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'L', 0, '', 0, false, 'T', 'M');
    $this->writeHTMLCell(
      $w = 0, $h = 0, $x = '', $y = '', $this->htmlFooter, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);
  }

}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, "utf-8", false);
// $pdf=new TcpdfCharts(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, "utf-8", false);
// $pdf=new MYPDF('P','pt','Letter',true,'UTF-8',false);
$pdf->setHtmlHeader($pdfHeader);
$pdf->setHtmlFooter($pdfFooter);
// $pdf->SetCompression(false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($config_title);
$pdf->SetTitle("Rapor");
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setLanguageArray($l);
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER + 5);
$pdf->SetFont('DejaVuSans', '', 8, '', true);
$pdf->AddPage();
