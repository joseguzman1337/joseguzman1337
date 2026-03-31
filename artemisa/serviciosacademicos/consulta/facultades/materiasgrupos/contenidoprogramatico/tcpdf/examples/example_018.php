<?php
//============================================================+
// File name   : example_018.php
// Begin       : 2008-03-06
// Last Update : 2011-10-01
//
// Description : Example 018 for TCPDF class
//               RTL document with Persian language
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               Manor Coach House, Church Hill
//               Aldershot, Hants, GU12 4RQ
//               UK
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: RTL document with Persian language
 * @author Nicola Asuni
 * @since 2008-03-06
 */

require_once('../config/lang/eng.php');
require_once('../tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 018');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 018', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language dependent data:
$lg = Array();
$lg['a_meta_charset'] = 'UTF-8';
$lg['a_meta_dir'] = 'rtl';
$lg['a_meta_language'] = 'fa';
$lg['w_page'] = 'page';

//set some language-dependent strings
$pdf->setLanguageArray($lg);

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 12);

// add a page
$pdf->AddPage();

// Persian and English content
$htmlpersian = '<span color="#660000">Persian example:</span><br />Ø³ÙØ§Ù Ø¨Ø§ÙØ§Ø®Ø±Ù ÙØ´Ú©Ù PDF ÙØ§Ø±Ø³Û Ø¨Ù Ø·ÙØ± Ú©Ø§ÙÙ Ø­Ù Ø´Ø¯. Ø§ÛÙÙ ÛÚ© ÙÙÙÙØ´.<br />ÙØ´Ú©Ù Ø­Ø±Ù \"Ú\" Ø¯Ø± Ø¨Ø¹Ø¶Û Ú©ÙÙØ§Øª ÙØ§ÙÙØ¯ Ú©ÙÙÙ ÙÛÚÙ ÙÛØ² Ø¨Ø± Ø·Ø±Ù Ø´Ø¯.<br />ÙÚ¯Ø§Ø±Ø´ Ø­Ø±ÙÙ ÙØ§Ù Ù Ø§ÙÙ Ù¾Ø´Øª Ø³Ø± ÙÙ ÙÛØ² ØªØµØ­ÛØ­ Ø´Ø¯.<br />Ø¨Ø§ ØªØ´Ú©Ø± Ø§Ø²  "Asuni Nicola" Ù ÙØ­ÙØ¯ Ø¹ÙÛ Ú¯Ù Ú©Ø§Ø± Ø¨Ø±Ø§Û Ù¾Ø´ØªÛØ¨Ø§ÙÛ Ø²Ø¨Ø§Ù ÙØ§Ø±Ø³Û.';
$pdf->WriteHTML($htmlpersian, true, 0, true, 0);

// set LTR direction for english translation
$pdf->setRTL(false);

$pdf->SetFontSize(10);

// print newline
$pdf->Ln();

// Persian and English content
$htmlpersiantranslation = '<span color="#0000ff">Hi, At last Problem of Persian PDF Solved completely. This is a example for it.<br />Problem of "jeh" letter in some word like "ÙÛÚÙ" (=special) fix too.<br />The joining of laa and alf letter fix now.<br />Special thanks to "Nicola Asuni" and "Mohamad Ali Golkar" for Persian support.</span>';
$pdf->WriteHTML($htmlpersiantranslation, true, 0, true, 0);

// Restore RTL direction
$pdf->setRTL(true);

// set font
$pdf->SetFont('aefurat', '', 18);

// print newline
$pdf->Ln();

// Arabic and English content
$pdf->Cell(0, 12, 'Ø¨ÙØ³ÙÙÙ Ø§ÙÙÙÙ Ø§ÙØ±ÙÙØ­ÙÙÙÙ Ø§ÙØ±ÙÙØ­ÙÙÙÙ',0,1,'C');
$htmlcontent = 'ØªÙÙÙ Ø¨ÙØ­ÙØ¯ Ø§ÙÙÙ Ø­ÙÙ ÙØ´ÙÙØ© Ø§ÙÙØªØ§Ø¨Ø© Ø¨Ø§ÙÙØºØ© Ø§ÙØ¹Ø±Ø¨ÙØ© ÙÙ ÙÙÙØ§Øª Ø§ÙÙ<span color="#FF0000">PDF</span> ÙØ¹ Ø¯Ø¹Ù Ø§ÙÙØªØ§Ø¨Ø© <span color="#0000FF">ÙÙ Ø§ÙÙÙÙÙ Ø¥ÙÙ Ø§ÙÙØ³Ø§Ø±</span> Ù<span color="#009900">Ø§ÙØ­Ø±ÙÙØ§Øª</span> .<br />ØªÙ Ø§ÙØ­Ù Ø¨ÙØ§Ø³Ø·Ø© <span color="#993399">ØµØ§ÙØ­ Ø§ÙÙØ·Ø±ÙÙ Ù Asuni Nicola</span>  . ';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);

// set LTR direction for english translation
$pdf->setRTL(false);

// print newline
$pdf->Ln();

$pdf->SetFont('aealarabiya', '', 18);

// Arabic and English content
$htmlcontent2 = '<span color="#0000ff">This is Arabic "Ø§ÙØ¹Ø±Ø¨ÙØ©" Example With TCPDF.</span>';
$pdf->WriteHTML($htmlcontent2, true, 0, true, 0);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_018.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
