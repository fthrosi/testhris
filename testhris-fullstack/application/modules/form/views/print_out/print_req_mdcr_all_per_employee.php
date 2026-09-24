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
$pdf->SetTitle('MDCR');
$pdf->SetSubject('MDCR');
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


$html = '
<table border="0">
	<tr>
		<td width="100%" align="center">
			<b><font size="14">Medical Control Sheets</font></b>
		</td>
	</tr>
</table>
<br>
<br>
<br>
<br>
<table border="0">
	<tr>
		<td width="10%">
			<font size="9">NIK</font>
		</td>
		<td width="1%" align="center">
			:
		</td>
		<td width="48%" colspan="5">
			<font size="9">'.$data_employee_current->nik.'</font>
		</td>
		<td width="20%">
			<font size="9">ENTTITLEMENT</font>
		</td>
		<td width="1%" align="center">
			:
		</td>
		<td width="10%" align="left">
			<font size="9">'.number_format($data_total_claim['pagu_jalan_tahun']).'</font>
		</td>
		<td width="10%" align="center" bgcolor="#ffb3b3">
			<font size="9">Out-Patient</font>
		</td>
	</tr>
	<tr>
		<td width="10%">
			<font size="9">Name</font>
		</td>
		<td width="1%" align="center">
			:
		</td>
		<td width="48%" colspan="5">
			<font size="9">'.decrypt($data_employee_current->complete_name).'</font>
		</td>
		<td width="20%">
			<font size="9"></font>
		</td>
		<td width="1%" align="center">
			:
		</td>
		<td width="10%" align="left">
			<font size="9">'.number_format($data_total_claim['pagu_inap_tahun']).'</font>
		</td>
		<td width="10%" align="center" bgcolor="#ffb3b3">
			<font size="9">In-Patient</font>
		</td>
	</tr>
	<tr>
		<td width="10%">
			<font size="9">Function / Grade</font>
		</td>
		<td width="1%" align="center">
			:
		</td>
		<td width="48%" colspan="5">
			<font size="9">'.decrypt($data_employee_current->position).' / '.decrypt($data_employee_current->employee_group).'</font>
		</td>
		<td width="20%">
			<font size="9"></font>
		</td>
		<td width="1%" align="center">
			:
		</td>
		<td width="10%" align="left">
			<font size="9">'.number_format($data_total_claim['pagu_optic_tahun']).'</font>
		</td>
		<td width="10%" align="center" bgcolor="#ffb3b3">
			<font size="9">Optic</font>
		</td>
	</tr>
	<tr>
		<td width="10%">
			<font size="9"></font>
		</td>
		<td width="1%" align="center">
		</td>
		<td width="48%" colspan="5">
			<font size="9"></font>
		</td>
		<td width="20%">
			<font size="9">JOIN DATE</font>
		</td>
		<td width="1%" align="center">
			:
		</td>
		<td width="10%" align="left">
			<font size="9">'.(DateTime::createFromFormat('Ymd', (decrypt($data_employee_current->join_date))))->format('d.m.Y').'</font>
		</td>
		<td width="10%" align="center">
			<font size="9"></font>
		</td>
	</tr>
	<tr>
		<td width="10%">
			<font size="9"></font>
		</td>
		<td width="1%" align="center">
		</td>
		<td width="48%" colspan="5">
			<font size="9"></font>
		</td>
		<td width="20%">
			<font size="9">EMPL. STATUS</font>
		</td>
		<td width="1%" align="center">
			:
		</td>
		<td width="10%" align="left">
			<font size="9">'.decrypt($data_employee_current->employee_subgroup).'</font>
		</td>
		<td width="10%" align="center">
			<font size="9"></font>
		</td>
	</tr>
	<tr>
		<td width="10%">
			<font size="9"></font>
		</td>
		<td width="1%" align="center">
		</td>
		<td width="48%" colspan="5">
			<font size="9"></font>
		</td>
		<td width="20%">
			<font size="9">YEAR</font>
		</td>
		<td width="1%" align="center">
			:
		</td>
		<td width="10%" align="left">
			<font size="9">'.$data_total_claim['year_created_at'].'</font>
		</td>
		<td width="10%" align="center">
			<font size="9"></font>
		</td>
	</tr>
</table>
<br>
<b><font size="12">Out-Patient</font></b>
<br>
<table border="1" width="100%">
								<thead>
								<tr align="center" bgcolor="#BABABA">
									<th width="5%" >No</th>
									<th width="10%" >Date</th>
									<th width="15%" >Type of Reimbursment</th>
									<th width="10%" >Name</th>
									<th width="10%" >Date</th>
									<th width="10%" >Nominal</th>
									<th width="10%" >Total Nominal</th>
									<th width="10%" >Reimbursment</th>
									<th width="10%" >Balance</th>
									<th width="10%" >Remark</th>
								</tr>
								<tr  align="center" bgcolor="#ffb3b3">
									<th colspan="8"><font size="8">Beginning Balance</font></th>
									<th><font size="8">'.number_format($data_total_claim['pagu_jalan_tahun']).'</font></th>
									<th></th>
								</tr>
								</thead>';
								$no=0;
								//dumper($data_claim);
								foreach($data_claim as $la){
								
								if ( ($la->tor_grandparent == 'Rawat Jalan') ){
									$no++;
		$html .= '
								<tbody>
									<tr align="center">
										<td width="5%"><font size="8">'.$no.'</font></td>
										<td width="10%"><font size="8">'.$la->create_date.'</font></td>
										<td width="15%"><font size="8">'.$la->tor_grandparent.' - '.$la->tor_parent.' - '.$la->tor_child.'</font></td>
										<td width="10%"><font size="8">'.$la->docter.'</font></td>
										<td width="10%"><font size="8">'.$la->tanggal_kuitansi.'</font></td>
										<td width="10%"><font size="8">'.number_format($la->total_kuitansi).'</font></td>
										<td width="10%"><font size="8"></font></td>
										<td width="10%"><font size="8"></font></td>
										<td width="10%"><font size="8"></font></td>
										<td width="10%"><font size="8"></font></td>
									</tr> 
									';
									}
								};
		$html .='
									<tr align="center">
										<td width="5%"><font size="8"></font></td>
										<td width="10%"><font size="8"></font></td>
										<td width="15%"><font size="8"></font></td>
										<td width="10%"><font size="8"></font></td>
										<td width="10%"><font size="8"></font></td>
										<td width="10%"><font size="8">'.number_format($data_total_claim['total_penggantian_rawat_jalan_per_request']).'</font></td>
										<td width="10%"><font size="8">'.number_format($data_total_claim['total_penggantian_rawat_jalan']).'</font></td>
										<td width="10%"><font size="8">'.number_format($data_total_claim['total_penggantian_rawat_jalan']).'</font></td>
										<td width="10%"><font size="8">'.number_format($data_total_claim['balancing_jalan_tahun']).'</font></td>
										<td width="10%"><font size="8"></font></td>
									</tr> 
								</tbody>
</table>
<br>
<br>
<b><font size="12">In-Patient</font></b>
<br>
<table border="1" width="100%">
								<thead>
								<tr align="center" bgcolor="#BABABA">
									<th width="5%" >No</th>
									<th width="10%" >Date</th>
									<th width="15%" >Type of Reimbursment</th>
									<th width="10%" >Name</th>
									<th width="10%" >Date</th>
									<th width="10%" >Nominal</th>
									<th width="10%" >Total Nominal</th>
									<th width="10%" >Reimbursment</th>
									<th width="10%" >Balance</th>
									<th width="10%" >Remark</th>
								</tr>
								<tr  align="center" bgcolor="#ffb3b3">
									<th colspan="8"><font size="8">Beginning Balance</font></th>
									<th><font size="8">'.number_format($data_total_claim['pagu_inap_tahun']).'</font></th>
									<th></th>
								</tr>
								</thead>';
								$no=0;
								foreach($data_claim as $la){
								
								if ( ($la->tor_grandparent == 'Rawat Inap') ){
									$no++;
		$html .= '
								<tbody>
									<tr align="center">
										<td width="5%"><font size="8">'.$no.'</font></td>
										<td width="10%"><font size="8">'.$la->tanggal_kuitansi.'</font></td>
										<td width="15%"><font size="8">'.$la->tor_grandparent.' - '.$la->tor_parent.' - '.$la->tor_child.'</font></td>
										<td width="10%"><font size="8">'.$la->docter.'</font></td>
										<td width="10%"><font size="8">'.$la->tanggal_kuitansi.'</font></td>
										<td width="10%"><font size="8">'.number_format($la->total_kuitansi).'</font></td>
										<td width="10%"><font size="8"></font></td>
										<td width="10%"><font size="8"></font></td>
										<td width="10%"><font size="8"></font></td>
										<td width="10%"><font size="8"></font></td>
									</tr> 
									';
									}
								};
		$html .='
									<tr align="center">
										<td width="5%"><font size="8"></font></td>
										<td width="10%"><font size="8"></font></td>
										<td width="15%"><font size="8"></font></td>
										<td width="10%"><font size="8"></font></td>
										<td width="10%"><font size="8"></font></td>
										<td width="10%"><font size="8">'.number_format($data_total_claim['total_penggantian_rawat_inap_per_request']).'</font></td>
										<td width="10%"><font size="8">'.number_format($data_total_claim['total_penggantian_rawat_inap']).'</font></td>
										<td width="10%"><font size="8">'.number_format($data_total_claim['total_penggantian_rawat_inap']).'</font></td>
										<td width="10%"><font size="8">'.number_format($data_total_claim['balancing_inap_tahun']).'</font></td>
										<td width="10%"><font size="8"></font></td>
									</tr> 
								</tbody>
</table>
<br>
<br>
<b><font size="12">Optic</font></b>
<br>
<table border="1" width="100%">
								<thead>
								<tr align="center" bgcolor="#BABABA">
									<th width="5%" >No</th>
									<th width="10%" >Date</th>
									<th width="15%" >Type of Reimbursment</th>
									<th width="10%" >Name</th>
									<th width="10%" >Date</th>
									<th width="10%" >Nominal</th>
									<th width="10%" >Total Nominal</th>
									<th width="10%" >Reimbursment</th>
									<th width="10%" >Balance</th>
									<th width="10%" >Remark</th>
								</tr>
								<tr  align="center" bgcolor="#ffb3b3">
									<th colspan="8"><font size="8">Beginning Balance</font></th>
									<th><font size="8">'.number_format($data_total_claim['pagu_optic_tahun']).'</font></th>
									<th></th>
								</tr>
								</thead>';
								$no=0;
								foreach($data_claim as $la){
								
								if ( ($la->tor_grandparent == 'Kacamata') ){
									$no++;
		$html .= '
								<tbody>
									<tr align="center">
										<td width="5%"><font size="8">'.$no.'</font></td>
										<td width="10%"><font size="8">'.$la->tanggal_kuitansi.'</font></td>
										<td width="15%"><font size="8">'.$la->tor_grandparent.' - '.$la->tor_parent.' - '.$la->tor_child.'</font></td>
										<td width="10%"><font size="8">'.$la->docter.'</font></td>
										<td width="10%"><font size="8">'.$la->tanggal_kuitansi.'</font></td>
										<td width="10%"><font size="8">'.number_format($la->total_kuitansi).'</font></td>
										<td width="10%"><font size="8"></font></td>
										<td width="10%"><font size="8"></font></td>
										<td width="10%"><font size="8"></font></td>
										<td width="10%"><font size="8"></font></td>
									</tr> 
									';
									}
								};
		$html .='
								<tbody>
									<tr align="center">
										<td width="5%"><font size="8"></font></td>
										<td width="10%"><font size="8"></font></td>
										<td width="15%"><font size="8"></font></td>
										<td width="10%"><font size="8"></font></td>
										<td width="10%"><font size="8"></font></td>
										<td width="10%"><font size="8">'.number_format($data_total_claim['total_penggantian_kacamata_per_request']).'</font></td>
										<td width="10%"><font size="8">'.number_format($data_total_claim['total_penggantian_kacamata']).'</font></td>
										<td width="10%"><font size="8">'.number_format($data_total_claim['total_penggantian_kacamata']).'</font></td>
										<td width="10%"><font size="8">'.number_format($data_total_claim['balancing_optic_tahun']).'</font></td>
										<td width="10%"><font size="8"></font></td>
									</tr> 
								</tbody>
</table>
<br>
<br>
<br>
<font size="8">Created by system - HRIS (Human Resources Information System).</font>
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