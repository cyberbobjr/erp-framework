<?php
/**
 * @var \App\View\AppView $this
 */
require_once ROOT . '/vendor/autoload.php';

$mpdf = new mPDF('win-1252', 'A4', '', '', 5, 5, 10, 0, 10, 10);
$mpdf->useSubstitutions = FALSE; // optional - just as an example
$mpdf->useOnlyCoreFonts = TRUE;
$mpdf->CSSselectMedia = 'mpdf';
$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML($this->fetch('content'));
$mpdf->Output(APP . 'PDF' . DS . $filename . '.pdf', 'F');
?>
<?php
/*
require_once ROOT . DS . 'vendor' . DS . 'tecnick.com' . DS . 'tcpdf' . DS . 'tcpdf.php';

$pdf = new TCPDF('P', 'pt', PDF_PAGE_FORMAT, TRUE, 'UTF-8', FALSE);

$pdf->SetCreator(PDF_CREATOR);

$pdf->setPrintHeader(FALSE);
$pdf->setPrintFooter(FALSE);

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(10, 10, 10, 10);

$pdf->SetAutoPageBreak(TRUE, 10);

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}
$pdf->AddPage();
$pdf->writeHTML($this->fetch('content'), true);

$pdf->Output('stock.pdf', 'I');*/
?>