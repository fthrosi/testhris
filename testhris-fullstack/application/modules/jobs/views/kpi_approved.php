<?php

echo  '

<style>

table {
    border-collapse: collapse;
}

th, td {
    padding: 5px;
}

.title {
    text-align: center;
}

</style>

<body>

<table width="100%">
    <tr>
        <td align="left">
            <img src="' . FCPATH  . 'assets/images/' . $logo . '" height="40">
        </td>
    </tr>
</table>

<h2 class="title">PERFORMANCE APPRAISAL</h2>

<h4 class="title">
Evaluation Period: Januari ' . $eval_year . ' - Desember ' . $eval_year . '
</h4>

<p class="title">
' . $header['request_number'] . '
</p>

<br>

<!-- I. PERSONAL DETAILS -->
<table width="100%" cellpadding="5" style="line-height:1.5;">

<tr>
    <td colspan="4" bgcolor="#d9d9d9" style="border-bottom:1px solid #000000;">
        <b>I. PERSONAL DETAILS</b>
    </td>
</tr>

<tr>
    <td width="18%" valign="top" style="border-bottom:1px solid #000000; text-align:left; vertical-align:top;">
        <b>Name / Employee ID</b>
    </td>

    <td width="42%" valign="top" style="border-bottom:1px solid #000000; text-align:left; vertical-align:top;">
        ' . decrypt($employee['complete_name']) . ' / ' . $employee['nik'] . '
    </td>

    <td width="15%" valign="top" style="border-bottom:1px solid #000000; text-align:left; vertical-align:top;">
        <b>Evaluation Period</b>
    </td>

    <td width="25%" valign="top" style="border-bottom:1px solid #000000; text-align:left; vertical-align:top;">
        Januari ' . $eval_year . ' - Desember ' . $eval_year . '
    </td>
</tr>

<tr>
    <td width="18%" valign="top" style="border-bottom:1px solid #000000; text-align:left; vertical-align:top;">
        <b>Position</b>
    </td>

    <td width="42%" valign="top" style="border-bottom:1px solid #000000; text-align:left; vertical-align:top;">
        ' . decrypt($employee['position']) . '
    </td>

    <td width="15%" valign="top" style="border-bottom:1px solid #000000; text-align:left; vertical-align:top;">
        <b>Join Date</b>
    </td>

    <td width="25%" valign="top" style="border-bottom:1px solid #000000; text-align:left; vertical-align:top;">
        ' . date("Y-m-d", strtotime(decrypt($employee['join_date']))) . '
    </td>
</tr>

<tr>
    <td width="18%" valign="top" style="border-bottom:1px solid #000000; text-align:left; vertical-align:top;">
        <b>Department</b>
    </td>

    <td width="42%" valign="top" style="border-bottom:1px solid #000000; text-align:left; vertical-align:top;">
        ' . decrypt($header['departement']) . '
    </td>

    <td width="15%" valign="top" style="border-bottom:1px solid #000000; text-align:left; vertical-align:top;">
        <b>Employment Type</b>
    </td>

    <td width="25%" valign="top" style="border-bottom:1px solid #000000; text-align:left; vertical-align:top;">
        ' . decrypt($employee['employee_subgroup']) . '
    </td>
</tr>

<tr>
    <td width="18%" valign="top" style="border-bottom:1px solid #000000; text-align:left; vertical-align:top;">
        <b>Division</b>
    </td>

    <td width="42%" valign="top" style="border-bottom:1px solid #000000; text-align:left; vertical-align:top;">
        ' . decrypt($employee['division']) . '
    </td>

    <td width="15%" valign="top" style="border-bottom:1px solid #000000; text-align:left; vertical-align:top;">
        <b>Office Location</b>
    </td>

    <td width="25%" valign="top" style="border-bottom:1px solid #000000; text-align:left; vertical-align:top;">
        ' . decrypt($employee['personnel_area']) . '
    </td>
</tr>

<tr>
    <td width="18%" valign="top" style="border-bottom:1px solid #000000; text-align:left; vertical-align:top;">
        <b>Div. Head / C-Level</b>
    </td>

    <td width="42%" valign="top" style="border-bottom:1px solid #000000; text-align:left; vertical-align:top;">
        ' . decrypt($header['direct_manager']) . '
    </td>

    <td width="15%" style="border-bottom:1px solid #000000;"></td>
    <td width="25%" style="border-bottom:1px solid #000000;"></td>
</tr>

</table>

<br><br>

<!-- II. KPI ACHIEVEMENT -->

<table width="100%" cellpadding="5">
<tr>
    <td bgcolor="#d9d9d9">
        <b>II. KPI ACHIEVEMENT</b>
    </td>
</tr>
</table>
<hr>
<table border="1" width="100%" cellpadding="3">
<tr>
	<th width="5%" style="text-align:center; font-weight:bold; text-transform:capitalize;">No</th>
	<th width="15%" style="text-align:center; font-weight:bold; text-transform:capitalize;">Objective</th>
	<th width="35%" style="text-align:center; font-weight:bold; text-transform:capitalize;">Measurement</th>
	<th width="6%" style="text-align:center; font-weight:bold; text-transform:capitalize;">Target</th>
	<th width="10%" style="text-align:center; font-weight:bold; text-transform:capitalize;">Achievement</th>
	<th width="10%" style="text-align:center; font-weight:bold; text-transform:capitalize;">Target vs Achievement</th>
	<th width="6%" style="text-align:center; font-weight:bold; text-transform:capitalize;">Score</th>
	<th width="7%" style="text-align:center; font-weight:bold; text-transform:capitalize;">Weight</th>
	<th width="6%" style="text-align:center; font-weight:bold; text-transform:capitalize;">Total</th>
</tr>

';

$no = 1;

foreach ($detail_kpi as $value) {

    echo  '

    <tr>

        <td>' . $no . '</td>

        <td>
            ' . nl2br(htmlspecialchars(decrypt($value['objective']))) . '
        </td>

        <td>
            ' . nl2br(htmlspecialchars(decrypt($value['measurement']))) . '
        </td>

        <td>
            ' . decrypt($value['target_per_year']) . '
        </td>

        <td>
            ' . decrypt($value['achievement']) . '
        </td>

        <td>
            ' . decrypt($value['target_vs_achievement']) . '
        </td>

        <td>
            ' . (($value['score'] == '' OR $value['score'] == '0')
                ? '0'
                : decrypt($value['score'])) . '
        </td>

        <td>
            ' . (($value['time'] == '' OR $value['time'] == '0')
                ? '0'
                : decrypt($value['time'])) . '%
        </td>

        <td>
            ' . (($value['total'] == '' OR $value['total'] == '0')
                ? '0'
                : decrypt($value['total'])) . '
        </td>

    </tr>

    ';

    $no++;
}

echo  '

<tr>
    <td colspan="7" align="right">
        <b>Total Weight</b>
    </td>

    <td colspan="2">
        <b>
            ' . (($header['sub_total_weight'] == '' OR $header['sub_total_weight'] == '0')
                ? '0'
                : decrypt($header['sub_total_weight'])) . '%
        </b>
    </td>
</tr>

<tr>
    <td colspan="8" align="right">
        <b>Total KPI Score</b>
    </td>

    <td>
        <b>
            ' . (($header['sub_total_kpi'] == '' OR $header['sub_total_kpi'] == '0')
                ? '0'
                : decrypt($header['sub_total_kpi'])) . '
        </b>
    </td>
</tr>

</table>
<br><br>
<br pagebreak="true"/>

<table width="100%">
    <tr>
        <td align="left">
            <img src="' . FCPATH  . '/assets/images/' . $logo . '" height="40">
        </td>
    </tr>
</table>

<h2 class="title">PERFORMANCE APPRAISAL</h2>

<h4 class="title">
Evaluation Period: Januari ' . $eval_year . ' - Desember ' . $eval_year . '
</h4>

<p class="title">
' . $header['request_number'] . '
</p>

<br>

<!-- III. QUALITATIVE ASSESMENT -->
<table width="100%" cellpadding="5">
<tr>
    <td bgcolor="#d9d9d9">
        <b>III. QUALITATIVE ASSESMENT</b>
    </td>
</tr>
</table>
<hr>
<table border="1" width="100%">

<tr>
	<th width="16%" style="text-align:center; font-weight:bold; text-transform:capitalize;">Competencies</th>
	<th width="8%" style="text-align:center; font-weight:bold; text-transform:capitalize;">Weight</th>
	<th width="8%" style="text-align:center; font-weight:bold; text-transform:capitalize;">Score (1-10)</th>
	<th width="8%" style="text-align:center; font-weight:bold; text-transform:capitalize;">Score vs Weight</th>
	<th width="15%" style="text-align:center; font-weight:bold; text-transform:capitalize;">Weak (1-5)</th>
	<th width="15%" style="text-align:center; font-weight:bold; text-transform:capitalize;">Moderate (6-7)</th>
	<th width="15%" style="text-align:center; font-weight:bold; text-transform:capitalize;">Strong (8-9)</th>
	<th width="15%" style="text-align:center; font-weight:bold; text-transform:capitalize;">Exceptional (10)</th>
</tr>

<tr>
    <td>Work Efficiency</td>
    <td class="center">15%</td>
    <td class="center">' . (($header['work_efficiency'] == '' || $header['work_efficiency'] == '0' || decrypt($header['work_efficiency']) == '0') ? '0' : decrypt($header['work_efficiency'])) . '</td>
    <td class="center">' . (($header['work_efficiency_result'] == '' || $header['work_efficiency_result'] == '0' || decrypt($header['work_efficiency_result']) == '0') ? '0' : decrypt($header['work_efficiency_result'])) . '</td>
    <td>Unable to complete assigned work.</td>
    <td>Able to complete most assigned work</td>
    <td>Able to complete all assigned work</td>
    <td>Consistently delivers additional work.</td>
</tr>

<tr>
    <td>Work Quality</td>
    <td class="center">15%</td>
    <td class="center">' . (($header['work_quality'] == '' || $header['work_quality'] == '0' || decrypt($header['work_quality']) == '0') ? '0' : decrypt($header['work_quality'])) . '</td>
    <td class="center">' . (($header['work_quality_result'] == '' || $header['work_quality_result'] == '0' || decrypt($header['work_quality_result']) == '0') ? '0' : decrypt($header['work_quality_result'])) . '</td>
    <td>Work quality is below expectations</td>
    <td>Work quality meets expectations</td>
    <td>Work quality meets and sometimes exceeds expectations</td>
    <td>Work quality consistently exceeds expectations</td>
</tr>

<tr>
    <td>Communication</td>
    <td class="center">10%</td>
    <td class="center">' . (($header['communication'] == '' || $header['communication'] == '0' || decrypt($header['communication']) == '0') ? '0' : decrypt($header['communication'])) . '</td>
    <td class="center">' . (($header['communication_result'] == '' || $header['communication_result'] == '0' || decrypt($header['communication_result']) == '0') ? '0' : decrypt($header['communication_result'])) . '</td>
    <td>Weak delivery and content</td>
    <td>Moderate delivery and content</td>
    <td>Good delivery and adequate content</td>
    <td>Excellent delivery and very adequate content</td>
</tr>

<tr>
    <td>Planning and Organizing</td>
    <td class="center">10%</td>
    <td class="center">' . (($header['planing'] == '' || $header['planing'] == '0' || decrypt($header['planing']) == '0') ? '0' : decrypt($header['planing'])) . '</td>
    <td class="center">' . (($header['planing_result'] == '' || $header['planing_result'] == '0' || decrypt($header['planing_result']) == '0') ? '0' : decrypt($header['planing_result'])) . '</td>
    <td>Lacks ability to plan. Lacks ability to set priorities.</td>
    <td>Shows some ability to plan. Shows some ability to set priorities. Shows some ability to organize work tasks.</td>
    <td>Able to plan. Able to set priorities. Able to organize work tasks.</td>
    <td>Shows high skiils in planning and priority setting. Very organized in accomplishing work tasks.</td>
</tr>

<tr>
    <td>Problem Solving</td>
    <td class="center">10%</td>
    <td class="center">' . (($header['problem_solving'] == '' || $header['problem_solving'] == '0' || decrypt($header['problem_solving']) == '0') ? '0' : decrypt($header['problem_solving'])) . '</td>
    <td class="center">' . (($header['problem_solving_result'] == '' || $header['problem_solving_result'] == '0' || decrypt($header['problem_solving_result']) == '0') ? '0' : decrypt($header['problem_solving_result'])) . '</td>
    <td>Unable to identify the real problems and the causes of the problems.</td>
    <td>Able to identify the real problems or the causes of the problems</td>
    <td>Able to identify the real problems or the causes of the problems. Able to solve problems with good results.</td>
    <td>Able to identify the real problems or the causes of the problems. Able to solve problems systematically and analytically with significant results and has a back-up plan.</td>
</tr>

<tr>
    <td>Team Work</td>
    <td class="center">10%</td>
    <td class="center">' . (($header['team_work'] == '' || $header['team_work'] == '0' || decrypt($header['team_work']) == '0') ? '0' : decrypt($header['team_work'])) . '</td>
    <td class="center">' . (($header['team_work_result'] == '' || $header['team_work_result'] == '0' || decrypt($header['team_work_result']) == '0') ? '0' : decrypt($header['team_work_result'])) . '</td>
    <td>Does not consider the effect of personal work on others.</td>
    <td>Considers the effect of personal work on others</td>
    <td>Considers the effect of personal work on others. Willing to stretch him/herself to achieve team goals.</td>
    <td>Considers the effect of personal work on others. Willing to stretch him/herself to achieve team goals.Able to mediate differences in team.</td>
</tr>

<tr>
    <td>Potential</td>
    <td class="center">10%</td>
    <td class="center">' . (($header['potential'] == '' || $header['potential'] == '0' || decrypt($header['potential']) == '0') ? '0' : decrypt($header['potential'])) . '</td>
    <td class="center">' . (($header['potential_result'] == '' || $header['potential_result'] == '0' || decrypt($header['potential_result']) == '0') ? '0' : decrypt($header['potential_result'])) . '</td>
    <td>Lacks capacity to learn. Lacks capacity to take new responsibilities.</td>
    <td>Shows capacity to learn. Shows capacity to take new responsibilities.</td>
    <td>Shows strong capacity to learn. Shows strong capacity to take new responsibilities.</td>
    <td>Shows very strong capacity to learn. Shows very strong capacity to take new and challenging responsibilities.Excel in constrained situations.</td>
</tr>

<tr>
    <td>Initiative</td>
    <td class="center">10%</td>
    <td class="center">' . (($header['initiative'] == '' || $header['initiative'] == '0' || decrypt($header['initiative']) == '0') ? '0' : decrypt($header['initiative'])) . '</td>
    <td class="center">' . (($header['initiative_result'] == '' || $header['initiative_result'] == '0' || decrypt($header['initiative_result']) == '0') ? '0' : decrypt($header['initiative_result'])) . '</td>
    <td>Waits for instructions to do the job. Prefers to stay in the comfort zone/status quo rather than initiate the change.</td>
    <td>Does the job as instructed. Initiates change occasionally.</td>
    <td>Does the job more than instructed. Frequently initiates changes that create a positive impact in the current situation.</td>
    <td>Actively initiate ideas that add value to the current situation and with innovation.</td>
</tr>

<tr>
    <td>Leadership</td>
    <td class="center">10%</td>
    <td class="center">' . (($header['leadership'] == '' || $header['leadership'] == '0' || decrypt($header['leadership']) == '0') ? '0' : decrypt($header['leadership'])) . '</td>
    <td class="center">' . (($header['leadership_result'] == '' || $header['leadership_result'] == '0' || decrypt($header['leadership_result']) == '0') ? '0' : decrypt($header['leadership_result'])) . '</td>
    <td>Unable to Lead people</td>
    <td>Able to manage people to achieve work goals.</td>
    <td>Able to manage people to achieve work goals. Sets clear directions for others.</td>
    <td>Able to lead a team to achieve excellent team results. Visionary</td>
</tr>

<tr>
    <td colspan="3" class="left"><b>Total Qualitative Assessment Score</b></td>
    <td class="center"><b>' . (($header['sub_total_qualitative'] == '' || $header['sub_total_qualitative'] == '0' || decrypt($header['sub_total_qualitative']) == '0') ? '0' : decrypt($header['sub_total_qualitative'])) . '</b></td>
    <td colspan="4"></td>
</tr>

</table>

<br><br>

<table width="100%" cellpadding="5">

<tr>
    <td colspan="4" bgcolor="#d9d9d9">
        <b>IV. TOTAL</b>
    </td>
</tr>

<tr>
    <td width="40%" style="border-bottom:1px solid #000;">Total KPI Score</td>
    <td width="15%" align="center" style="border-bottom:1px solid #000;">85%</td>
    <td width="20%" align="center" style="border-bottom:1px solid #000;">' . (($header['sub_total_kpi'] == '' || $header['sub_total_kpi'] == '0' || decrypt($header['sub_total_kpi']) == '0') ? '0' : decrypt($header['sub_total_kpi'])) . '</td>
    <td width="25%" align="center" style="border-bottom:1px solid #000;">' . (($header['grand_total_kpi'] == '' || $header['grand_total_kpi'] == '0' || decrypt($header['grand_total_kpi']) == '0') ? '0' : decrypt($header['grand_total_kpi'])) . '</td>
</tr>

<tr>
    <td width="40%" style="border-bottom:1px solid #000;">Total Qualitative Assessment Score</td>
    <td width="15%" align="center" style="border-bottom:1px solid #000;">15%</td>
    <td width="20%" align="center" style="border-bottom:1px solid #000;">' . (($header['sub_total_qualitative'] == '' || $header['sub_total_qualitative'] == '0' || decrypt($header['sub_total_qualitative']) == '0') ? '0' : decrypt($header['sub_total_qualitative'])) . '</td>
    <td width="25%" align="center" style="border-bottom:1px solid #000;">' . (($header['grand_total_qualitative'] == '' || $header['grand_total_qualitative'] == '0' || decrypt($header['grand_total_qualitative']) == '0') ? '0' : decrypt($header['grand_total_qualitative'])) . '</td>
</tr>

<tr>
    <td width="40%" style="border-bottom:1px solid #000;"><b>Pre-Final Score</b></td>
    <td width="15%" style="border-bottom:1px solid #000;"></td>
    <td width="20%" style="border-bottom:1px solid #000;"></td>
    <td width="25%" align="center" style="border-bottom:1px solid #000;"><b>' . (($header['pre_final_score'] == '' || $header['pre_final_score'] == '0' || decrypt($header['pre_final_score']) == '0') ? '0' : decrypt($header['pre_final_score'])) . '</b></td>
</tr>

<tr>
    <td width="40%" style="border-bottom:1px solid #000;"><b>Final Score</b></td>
    <td width="15%" style="border-bottom:1px solid #000;"></td>
    <td width="20%" style="border-bottom:1px solid #000;"></td>
    <td width="25%" align="center" style="border-bottom:1px solid #000;"><b>' . (($header['final_score'] == '' || $header['final_score'] == '0' || decrypt($header['final_score']) == '0.000') ? '0' : decrypt($header['final_score'])) . '</b></td>
</tr>

</table>

<br><br>

<br pagebreak="true"/>

<table width="100%">
    <tr>
        <td align="left">
            <img src="' . FCPATH . 'assets/images/' . $logo . '" height="40">
        </td>
    </tr>
</table>

<h2 class="title">PERFORMANCE APPRAISAL</h2>

<h4 class="title">
Evaluation Period: Januari ' . $eval_year . ' - Desember ' . $eval_year . '
</h4>

<p class="title">
' . $header['request_number'] . '
</p>

<br>

<!-- V. DEVELOPMENT PLAN & RECOMMENDATION -->
<table width="100%" cellpadding="5">
<tr>
    <td bgcolor="#d9d9d9">
        <b>V. DEVELOPMENT PLAN & RECOMMENDATION</b>
    </td>
</tr>
</table>
<hr>
<table border="1" width="100%">

<tr>
	<td colspan="3" align="justify">
		Please use this section to identify development that sustains, improves and builds performance, and enables the employee to contribute to organizational effectiveness. This section should be used to identify which area that needs to be improved and detail development activities, and should be completed by the supervisor in collaboration with the employee.
	</td>
</tr>
<tr bgcolor="#f0eded">
	<td colspan="3" align="justify">
		AREA FOR IMPROVEMENT (Competency, Technical Skill, Soft Skill, Leadership, etc)
	</td>
</tr>
<tr>
	<td colspan="3" width="100%" valign="top" align="justify" style="line-height:1.5; min-height:60;">
	<br>
		' . nl2br(htmlspecialchars(decrypt($header['area_improvement']))) . '
	<br>
	</td>
</tr>
<tr bgcolor="#f0eded">
	<td colspan="3" align="justify">
		DEVELOPMENT PLAN (Training, On The Job Training)
	</td>
</tr>
<tr bgcolor="#f2f2f2">
    <th width="20%" style="text-align:center; font-weight:bold; text-transform:capitalize;">Category</th>
    <th width="30%" style="text-align:center; font-weight:bold; text-transform:capitalize;">Training Name</th>
    <th width="50%" style="text-align:center; font-weight:bold; text-transform:capitalize;">Description</th>
</tr>

';

foreach ($training as $key) {

    $category = '';

    if ($key['category'] == encrypt('soft')) {
        $category = 'Soft Skill';
    } else {
        $category = 'Hard Skill';
    }

    echo  '

    <tr>

        <td>
            ' . $category . '
        </td>

        <td>
            ' . decrypt($key['training_name']) . '
        </td>

        <td>
            ' . decrypt($key['training_desc']) . '
        </td>

    </tr>

    ';
}

echo  '

</table>

<br><br>

<!-- VI. COMMENTS & ACKNOWLEDGEMENT -->

<table width="100%" cellpadding="5">
<tr>
    <td bgcolor="#d9d9d9">
        <b>VI. COMMENTS & ACKNOWLEDGEMENT</b>
    </td>
</tr>
</table>
<hr>

<table border="1" width="100%">
<tr>
    <td colspan="3" align="justify">
		The employee and the superior may add any relevant comments before signing the performance evaluation. By signing the
		evaluation the employee indicates that he/she has participated in a performance appraisal meeting; the signature does not indicate
		agreement or disagreement. If there is disagreement with the superior’s evaluation of an employee’s performance, the employee
		may explain that disagreement in the comments section.
    </td>
</tr>

<tr>
	<td colspan="3">
		<b>Employee</b>
	</td>
</tr>
<tr>
	<td colspan="3" width="100%" valign="top" align="justify" style="line-height:1.5; min-height:60;">
	<br>
		' . nl2br(htmlspecialchars(decrypt($header['comment_employee']))) . '
	<br>
	</td>
</tr>

<tr>
	<td colspan="3">
		<b>Direct Superior/ Manager/Division Head (1)</b>
	</td>
</tr>
<tr>
	<td colspan="3" width="100%" valign="top" align="justify" style="line-height:1.5; min-height:60;">
	<br>
		' . nl2br(htmlspecialchars(decrypt($header['comment_head_1']))) . '
	<br>
	</td>
</tr>

<tr>
	<td colspan="3">
		<b>Direct Superior/ Manager/Division Head (2)</b>
	</td>
</tr>
<tr>
	<td colspan="3" width="100%" valign="top" align="justify" style="line-height:1.5; min-height:60;">
	<br>
		' . nl2br(htmlspecialchars(decrypt($header['comment_head_2']))) . '
	<br>
	</td>
</tr>

</table>

<br><br>
<br pagebreak="true"/>
';

echo  '
<!-- VII. PERFORMANCE PLAN -->

<table width="100%">
    <tr>
        <td align="left">
            <img src="' . FCPATH . 'assets/images/' . $logo . '" height="40">
        </td>
    </tr>
</table>

<h2 class="title">PERFORMANCE PLAN</h2>

<h4 class="title">
Evaluation Period: Januari ' . ($eval_year + 1) . ' - Desember ' . ($eval_year + 1) . '
</h4>

<p class="title">
' . $header['request_number'] . '
</p>

<br>

<table border="1" width="100%" cellpadding="5">

<tr>
    <th width="5%"  style="text-align:center; font-weight:bold; text-transform:capitalize;"><b>#</b></th>
    <th width="25%" style="text-align:center; font-weight:bold; text-transform:capitalize;"><b>Performance Objective</b></th>
    <th width="35%" style="text-align:center; font-weight:bold; text-transform:capitalize;"><b>KPI Measurement</b></th>
    <th width="10%" style="text-align:center; font-weight:bold; text-transform:capitalize;"><b>Weight %</b></th>
    <th width="15%" style="text-align:center; font-weight:bold; text-transform:capitalize;"><b>Unit</b></th>
    <th width="10%" style="text-align:center; font-weight:bold; text-transform:capitalize;"><b>Target ' . ($eval_year + 1) . '</b></th>
</tr>

<tr>
    <td colspan="6"><b>FINANCIAL PERSPECTIVE</b></td>
</tr>
';

$no = 1;
foreach ($additional as $key) {
    if ($key['plan_perspective'] == encrypt('financial_perspective')) {

        echo  '
        <tr>
            <td align="center">' . $no . '</td>
            <td>' . nl2br(htmlspecialchars(decrypt($key['objective']))) . '</td>
            <td>' . nl2br(htmlspecialchars(decrypt($key['measurement']))) . '</td>
            <td align="center">' . decrypt($key['time']) . '</td>
            <td>' . decrypt($key['unit']) . '</td>
            <td>' . decrypt($key['target']) . '</td>
        </tr>
        ';
        $no++;
    }
}

echo  '
<tr>
    <td colspan="6"><b>CUSTOMER PERSPECTIVE</b></td>
</tr>
';

$no = 1;
foreach ($additional as $key) {
    if ($key['plan_perspective'] == encrypt('cust_perspective')) {

        echo  '
        <tr>
            <td align="center">' . $no . '</td>
            <td>' . nl2br(htmlspecialchars(decrypt($key['objective']))) . '</td>
            <td>' . nl2br(htmlspecialchars(decrypt($key['measurement']))) . '</td>
            <td align="center">' . decrypt($key['time']) . '</td>
            <td>' . decrypt($key['unit']) . '</td>
            <td>' . decrypt($key['target']) . '</td>
        </tr>
        ';
        $no++;
    }
}

echo  '
<tr>
    <td colspan="6"><b>INTERNAL PROCESS</b></td>
</tr>
';

$no = 1;
foreach ($additional as $key) {
    if ($key['plan_perspective'] == encrypt('intern_perspective')) {

        echo  '
        <tr>
            <td align="center">' . $no . '</td>
            <td>' . nl2br(htmlspecialchars(decrypt($key['objective']))) . '</td>
            <td>' . nl2br(htmlspecialchars(decrypt($key['measurement']))) . '</td>
            <td align="center">' . decrypt($key['time']) . '</td>
            <td>' . decrypt($key['unit']) . '</td>
            <td>' . decrypt($key['target']) . '</td>
        </tr>
        ';
        $no++;
    }
}

echo  '
<tr>
    <td colspan="6"><b>LEARNING & GROWTH</b></td>
</tr>
';

$no = 1;
foreach ($additional as $key) {
    if ($key['plan_perspective'] == encrypt('learn_perspective')) {

        echo  '
        <tr>
            <td align="center">' . $no . '</td>
            <td>' . nl2br(htmlspecialchars(decrypt($key['objective']))) . '</td>
            <td>' . nl2br(htmlspecialchars(decrypt($key['measurement']))) . '</td>
            <td align="center">' . decrypt($key['time']) . '</td>
            <td>' . decrypt($key['unit']) . '</td>
            <td>' . decrypt($key['target']) . '</td>
        </tr>
        ';
        $no++;
    }
}

echo  '
<tr>
    <td colspan="3" align="right"><b>Total Weight (%)</b></td>
    <td colspan="3">' . (($header['plan_total_weight'] == "" || $header['plan_total_weight'] == encrypt('0')) ? '0' : decrypt($header['plan_total_weight'])) . '</td>
</tr>

</table>

<br><br>
<br pagebreak="true"/>
';

echo  '
<!-- VIII. APPROVAL SUMMARY -->
<table width="100%">
    <tr>
        <td align="left">
            <img src="' . FCPATH . 'assets/images/' . $logo . '" height="40">
        </td>
    </tr>
</table>
<h3 align="center"><b>APPROVAL SUMMARY</b></h3>
<p align="center"><b>Evaluation Period: Januari ' . $eval_year . ' - Desember ' . $eval_year . '</b></p>
<p align="center">' . $header['request_number'] . '</p>

<br>

<table border="0" width="100%" cellpadding="6">

<tr>
    <td width="33%"><b>Prepared by employee</b></td>
    <td width="33%"><b>Reviewed & approved by (Line Manager)</b></td>
    <td width="34%"><b>Approved by (Indirect Superior)</b></td>
</tr>

<tr>

    <!-- PREPARED BY -->
    <td height="120" valign="top" align="center">
        <br><br>
        <i>Approval is generated by system.<br>No signature are required.</i>
    </td>
';

$line_manager = null;
$indirect_superior = null;

/* =========================
   SPLIT DATA APPROVAL
========================= */
foreach ($approval as $value) {
    if ($value['approval_priority'] == 1) {
        $line_manager = $value;
    }

    if ($value['approval_priority'] == 2) {
        $indirect_superior = $value;
    }
}

/* =========================
   LINE MANAGER COLUMN
========================= */

if ($line_manager['approval_status'] == '' || $line_manager['approval_status'] == 'In Progress') {

		echo  '
		<td height="120" valign="top" align="center">
			<br><br><i>Not Yet Approved</i>
		</td>
		';

} else {

	echo  '
	<td height="120" valign="top" align="center">
		<br><br><i>Approval is generated by system.<br>No signature are required.</i>
	</td>
	';
}

/* =========================
   INDIRECT SUPERIOR COLUMN 
========================= */

if ($count_approval == 2) {

    if ($indirect_superior) {

        if ($indirect_superior['approval_status'] == '' || $indirect_superior['approval_status'] == 'In Progress') {

            echo  '
            <td height="120" valign="top" align="center">
                <br><br><i>Not Yet Approved</i>
            </td>
            ';

        } else {

            echo  '
            <td height="120" valign="top" align="center">
                <br><br><i>Approval is generated by system.<br>No signature are required.</i>
            </td>
            ';
        }

    } else {

        // 🔥 FALLBACK: kalau tidak ada approval 2, isi sama line manager
        echo  '
        <td height="120" valign="top" align="center">
            <br><br><i>Approval is same as Line Manager.<br>No signature are required.</i>
        </td>
        ';
    }

} else {

    // fallback kalau hanya 1 approval
    if ($line_manager['approval_status'] == '' || $line_manager['approval_status'] == 'In Progress') {

            echo  '
            <td height="120" valign="top" align="center">
                <br><br><i>Not Yet Approved</i>
            </td>
            ';

        } else {

            echo  '
            <td height="120" valign="top" align="center">
                <br><br><i>Approval is generated by system.<br>No signature are required.</i>
            </td>
            ';
        }
}

echo  '

</tr>

<tr>

    <!-- NAME ROW -->
    <td valign="top">
        <b>Name:</b> ' . decrypt($employee['complete_name']) . '<br>
        <b>Date:</b> ' . str_replace('.000', '', $header['created_at']) . '
    </td>
';

/* LINE MANAGER NAME */
if ($line_manager) {

    echo  '
    <td valign="top">
        <b>Name:</b> ' . $line_manager['approval_alias'] . '<br>
        <b>Date:</b> ' . str_replace('.000', '', $line_manager['updated_at']) . '
    </td>
    ';
}

/* INDIRECT SUPERIOR NAME (FIX FALLBACK) */
if ($indirect_superior) {

    echo  '
    <td valign="top">
        <b>Name:</b> ' . $indirect_superior['approval_alias'] . '<br>
        <b>Date:</b> ' . str_replace('.000', '', $indirect_superior['updated_at']) . '
    </td>
    ';

} else if ($line_manager) {

    // 🔥 fallback sama dengan line manager
    echo  '
    <td valign="top">
        <b>Name:</b> ' . $line_manager['approval_alias'] . '<br>
        <b>Date:</b> ' . str_replace('.000', '', $line_manager['updated_at']) . '
    </td>
    ';
}

echo '

</tr>

</table>

';