<?php
//============================================================+
// File name   : example_006.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 006 for TCPDF class
//               WriteHTML and RTL support
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+


//dumper($img);

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: WriteHTML and RTL support
 * @author Nicola Asuni
 * @since 2008-03-04
 */
		
//dumper(decrypt($header[0]->complete_name));
// create new PDF document

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$ns = str_replace("/","","");
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('PT. Infrastruktur Bisnis Sejahtera');
$pdf->SetTitle($request_number);
$pdf->SetSubject($request_number);
$pdf->SetKeywords('HRIS-MDCR,IBS');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, "10", PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
// ---------------------------------------------------------

// set font
$pdf->SetFont('Times', '', 11);

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)


// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// Print a table

// add a page
$pdf->AddPage('L', 'LEGAL');

if ($date_form != null || $date_form != '') {
	if (count($date_form) > 1) {
		$dt1 = $date_form[array_key_first($date_form)];
		$dt2 = $date_form[array_key_last($date_form)];
		$tgl = $dt1->dateonly.' s/d '.$dt2->dateonly;
	} else if (count($date_form) == 1) {
		$tgl = $date_form[0]->dateonly;
	} else {
		$tgl = '';
	}
} else {	
	$tgl = '';
}

// dumper($date_form[0]->dateonly);
// dumper($date_form[array_key_first($date_form)]);
$html = '
<table border="0">
	<tr>
		<td width="100%" align="right">
			<font size="8">FI Number : '. $request_number .'</font>
		</td>
	</tr>
</table>
<table border="0">
	<tr>
		<td width="100%" align="center">
			<b><font size="12">Recap Medical Reimbursement</font></b>
		</td>
	</tr>
</table>
<br>
Periode checked by HR : '.$tgl.'
<br>
<table border="1">
	<tr align="right">
		<td colspan="10" width="100%" align="left">
			PT. Infrastruktur Bisnis Sejahtera
		</td>
	</tr>
</table>
<br>';
$html .= '
<table border="1" width="100%">
								<thead>
								<tr align="center" bgcolor="#ffb3b3">
									<th width="3%" rowspan="2">No</th>
									<th width="13%" rowspan="2">Name</th>
									<th width="6%" rowspan="2">No Rekening Sinarmas</th>
									<th width="8%" rowspan="2">Cost Center</th>
									<th width="5%" rowspan="2">NIK</th>
									<th width="15%" colspan="2">Rawat Jalan</th>
									<th width="15%" colspan="2">Rawat Inap</th>
									<th width="15%" colspan="2">Kacamata</th>
									<th width="10%" rowspan="2">Total</th>
									<th width="10%" rowspan="2">Grand Total</th>
								</tr>
								<tr  align="center" bgcolor="#ffb3b3">
									<th>Total Claim</th>
									<th>Pembayaran Claim</th>
									<th>Total Claim</th>
									<th>Pembayaran Claim</th>
									<th>Total Claim</th>
									<th>Pembayaran Claim</th>
								</tr>
								</thead>';
		$no=0;
		$employee_id = 0;
		foreach($data_claim as $la){
			$c = 0;
			$gt = 0;
			if ($la->employee_id != $employee_id) {
				foreach ($data_claim as $cek) {
					if ($cek->employee_id == $la->employee_id) {
						$gt += $cek->total;
						$c += 1;
					}
				}
				$td = '<td width="10%" rowspan="'.$c.'"><strong><font size="8">'.number_format($gt).'</font></strong></td>';
			} else {
				$td ='';
			}
			$employee_id = $la->employee_id;

				// dumper('<td width="10%"><font size="8" rowspan="'.$c.'">'.number_format($gt).'</font></td>');
			$no++;
			$html .= '
					<tbody>
					  <tr align="center" vertical-align="middle;">
					  <td width="3%"><font size="8">'.$no.'</font></td>
					  <td width="13%"><font size="8">'.$la->complete_name.'</font></td>
					  <td width="6%"><font size="8">'.$la->bankn.'</font></td>
					  <td width="8%"><font size="8">'.$la->cost_center.'</font></td>
					  <td width="5%"><font size="8">'.$la->employee_id.'</font></td>
					  <td width="7.5%"><font size="8">'.number_format($la->claim_jalan).'</font></td>
					  <td width="7.5%"><font size="8">'.number_format($la->pembayaran_jalan).'</font></td>
					  <td width="7.5%"><font size="8">'.number_format($la->claim_inap).'</font></td>
					  <td width="7.5%"><font size="8">'.number_format($la->pembayaran_inap).'</font></td>
					  <td width="7.5%"><font size="8">'.number_format($la->claim_kacamata).'</font></td>
					  <td width="7.5%"><font size="8">'.number_format($la->pembayaran_kacamata).'</font></td>
					  <td width="10%"><font size="8">'.number_format($la->total).'</font></td>'.
					  $td
					  .'</tr> 
					</tbody>	

			';
		};
$html .='
		<tbody>
		  <tr align="center">
		  <td width="3%"><font size="8"></font></td>
		  <td width="13%"><font size="8"></font></td>
		  <td width="6%"><font size="8"></font></td>
		  <td width="8%"><font size="8"></font></td>
		  <td width="5%"><font size="8"></font></td>
		  <td width="7.5%"><font size="8"></font></td>
		  <td width="7.5%"><font size="8"></font></td>
		  <td width="7.5%"><font size="8"></font></td>
		  <td width="7.5%"><font size="8"></font></td>
		  <td width="7.5%"><font size="8"></font></td>
		  <td width="7.5%"><font size="8"></font></td>
		  <td width="10%"><font size="8"></font></td>
		  <td width="10%"><font size="8">'.number_format($total_data_claim).'</font></td>
		  </tr> 
		</tbody>

</table>
<br>
<br>
<br>
<font size="8">Created by system - Medclaim Online.</font>
';


// $html = $nosurat;
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output($ns, 'I');
//============================================================+
// END OF FILE
//============================================================+