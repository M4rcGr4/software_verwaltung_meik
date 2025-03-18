<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
include 'inc/controller.php';
include 'TCPDF-main/tcpdf.php';

// Daten zu Exponat holen
$data = get_exponat($_SESSION['exp_id'])[0];
       
// Extend the TCPDF class to create custom Header and Footer
class MEIKPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file = './images/CI/Logo/PNG/rechteckig/blau-transparent/isc blau-transparent 500x232.png';
        $this->Image($image_file, 0, 0, 50, 23, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(0, 15, 'Datenblatt zu Exponat', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // MEIK
        $this->Cell(0, 10, '© MEIK - Museum zur Entwicklung der Kommunikations - und Informationstechnik - Alle Rechte vorbehalten', 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MEIKPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('MEIK Gruppe 4');
$pdf->SetTitle('Exponat "'.$data['Titel'].'"');
$pdf->SetSubject($data['Titel']);
$pdf->SetKeywords('MEIK, Exponat');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// Set some content to print
$kategorie=show_kategorie($data['Kat_ID'])[0]['Bezeichnung'];
$html = '<div class="datenblatt">
        <div class="header">
            <h1>Datenblatt zu Exponat '.$data['Exp-Nr'].'</h1>
            <p><strong>Kategorie:</strong> '.$kategorie.'</p>
        </div>
        <div class="content">
            <p><strong>Exponatname:</strong> '.$data['Titel'].'</p>
            <p><strong>Beschreibung:</strong><br>'.$data['Beschreibung'].'</p>
            <p><strong>Baujahr:</strong> '.$data['Baujahr'].'</p>
            <p><strong>Hersteller:</strong> '.$data['Hersteller'].'</p>
            <p><strong>Herkunft:</strong> '.$data['Herkunft'].'</p>
            <p><strong>Originaler Preis:</strong> '.$data['OrigPreis'].' <strong>aktueller Wert:</strong> '.$data['Wert'].'</p>
        </div>
        <div class="footer">
            <p>© MEIK - Museum zur Entwicklung der Kommunikations - und Informationstechnik - Alle Rechte vorbehalten</p>
        </div>
    </div>';


// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('meik_exponat_'.$data['Exp-Nr'].'_'.$data['Titel'], 'D');
