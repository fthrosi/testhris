<?php
// dumper($header);
?>
<html lang="en">

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
	<?php 
	$logon = "logo_ibsw.png";
	?>
    <main role="main" class="container">
		<br>
		<div style="page-break-after: always">
	        <div class="row">
	          <table>
	              <tr>
	                  <th><img src="<?=base_url()?>/assets/images/<?= $logon; ?>" style="max-height:75px;"></th>
	              </tr>
	          </table>
	        </div>
	        <div class="col-12">
		        <h5 class="text-center"><b>PERFORMANCE APPRAISAL</b></h5>
		        <h6 class="text-center"><strong>Evaluation Period: Januari <?=$eval_year;?> - Desember <?=$eval_year;?></strong></h6>
		        <p class="text-center"><?= $header['request_number'] ?></p>
		    </div>

	      	<!-- Personal Detail -->
	        <table class="table">
		     	<tr>
					<td style="border-bottom: 1px solid #000000" colspan=5 align="left" valign=bottom bgcolor="#FFFFFF">
						<b><font size=4>I. PERSONAL DETAILS</font></b>
					</td>
				</tr>
				<tr>
					<td></td>
					<td colspan=1 align="left" valign=bottom bgcolor="#FFFFFF"><b><font size=3>Name/Employee ID</font></b></td>
					<td align="left" valign=middle bgcolor="#FFFFFF"><font size=3><?=decrypt($employee['complete_name']) .' / '. $employee['nik']?></font></td>
					<td colspan=1 align="left" valign=middle bgcolor="#FFFFFF"><b><font size=3>Evaluation Period</font></b></td>
					<td colspan=4 align="left" valign=middle bgcolor="#FFFFFF"><font size=3>Januari <?=$eval_year;?> - Desember <?=$eval_year;?></font></td>
					</tr>
				<tr>
				<tr>
					<td></td>
					<td colspan=1 align="left" valign=middle bgcolor="#FFFFFF"><b><font size=3>Position</font></b></td>
					<td align="left" valign=middle bgcolor="#FFFFFF"><font size=3><?=decrypt($employee['position'])?></font></td>
					<td colspan=1 align="left" valign=middle bgcolor="#FFFFFF"><b><font size=3>Join Date</font></b></td>
					<td colspan=4 align="left" valign=middle bgcolor="#FFFFFF" sdval="42870" sdnum="1033;1033;D-MMM-YY"><font size=3><?=date("Y-m-d",strtotime(decrypt($employee['join_date'])))?></font></td>
					</tr>
				<tr>
					<td></td>
					<td colspan=1 align="left" valign=middle bgcolor="#FFFFFF"><b><font size=3>Departement</font></b></td>
					<td align="left" valign=middle bgcolor="#FFFFFF"><font size=3><?=decrypt($header['departement'])?></font></td>
					<td colspan=1 align="left" valign=middle bgcolor="#FFFFFF"><b><font size=3>Employment Type</font></b></td>
					<td colspan=4 align="left" valign=middle bgcolor="#FFFFFF"><font size=3><?=decrypt($employee['employee_subgroup'])?></font></td>
					</tr>
				<tr>
					<td></td>
					<td colspan=1 align="left" valign=middle bgcolor="#FFFFFF"><b><font size=3>Division</font></b></td>
					<td align="left" valign=middle bgcolor="#FFFFFF"><font size=3><?=decrypt($employee['division'])?></font></td>
					<td colspan=1 align="left" valign=middle bgcolor="#FFFFFF"><b><font size=3>Office Location</font></b></td>
					<td colspan=4 align="left" valign=middle bgcolor="#FFFFFF"><font size=3><?=decrypt($employee['personnel_area'])?></font></td>
					</tr>
				<tr>
					<td></td>
					<td colspan=1 align="left" valign=middle bgcolor="#FFFFFF"><b><font size=3>Div. Head / C-Level</font></b></td>
					<td colspan=1 align="left" valign=middle bgcolor="#FFFFFF"><font size=3><?=decrypt($header['direct_manager'])?></font></td>
					<td align="left" valign=middle bgcolor="#FFFFFF"><font size=3></font></td>
					<td align="left" valign=middle bgcolor="#FFFFFF"><font size=3></font></td>
				</tr>
			</table>
	        <!-- KPI -->
	    	<table class="table table-striped">
	    		<thead>
	        	<tr>
					<td style="border-bottom: 1px solid #000000" colspan=9 align="left" valign=bottom bgcolor="#FFFFFF">
						<b><font size=4>II. KPI ACHIEVEMENT</font></b>
					</td>
				</tr>
				<tr>
					<th>No</th>	
					<th>OBJECTIVE</th>
					<th>MEASUREMENT</th>
					<th style="font-size: 13px;">TARGET/YEAR</th>
					<th style="font-size: 13px;">ACHIEVEMENT</th>
					<th style="font-size: 13px;">TARGET VS ACHIEVEMENT</th>
					<th style="font-size: 13px;">SCORE</th>
					<th style="font-size: 13px;">WEIGHT</th>
					<th style="font-size: 13px;">TOTAL</th>
				</tr>
				</thead>
				<tbody style="font-size: 11px;">

				<?php $no=1; foreach ($detail_kpi as $key => $value) { ?>
				<tr>
					<td><font color="#000000"><?=$no;?></td>
					<td><font color="#000000"><?=decrypt($value['objective'])?></font></td>
					<td><font color="#000000"><?=decrypt($value['measurement'])?></font></td>
					<td><font color="#000000"><?=decrypt($value['target_per_year'])?></font></td>
					<td><font color="#000000"><?=decrypt($value['achievement'])?></font></td>
					<td><font color="#000000"><?=decrypt($value['target_vs_achievement'])?></font></td>
					<td><font color="#000000"><?php if($value['score'] == "" or $value['score'] == '0'){ echo $value['score']; }else{ echo decrypt($value['score']); }?></font></td>
					<td><font color="#000000"><?php if($value['time'] == "" or $value['time'] == '0'){ echo $value['time']; }else{ echo decrypt($value['time']); }?>%</font></td>
					<td><font color="#000000"><?php if($value['total'] == "" or $value['total'] == '0'){ echo $value['total']; }else{ echo decrypt($value['total']); }?></font></td>
				</tr>
				<?php $no++;} ?> 
				</tbody>
				<tfoot>
				<tr>
					<td class="text-secondary" colspan="7" align="right"><b>Total Weight</b></td>
					<td><b><?php if($header['sub_total_weight'] == "" or $header['sub_total_weight'] == '0'){ echo $header['sub_total_weight']; }else{ echo decrypt($header['sub_total_weight']); }?>%</b></td>
				</tr>
				<tr>
					<td class="text-secondary" colspan="8" align="right"><b>Total KPI Score</b></td>
					<td><b><?php if($header['sub_total_kpi'] == "" or $header['sub_total_kpi'] == '0'){ echo $header['sub_total_kpi']; }else{ echo decrypt($header['sub_total_kpi']); }?></b></td>
				</tr>
				</tfoot>
			</table>
        </div>

		<div style="page-break-after: always">
	        <div class="row">
	          <table>
	              <tr>
	                  <th><img src="<?=base_url()?>/assets/images/<?= $logon; ?>" style="max-height:75px;"></th>
	              </tr>
	          </table>
	        </div>
	        
	        <div class="col-12">
		        <h5 class="text-center"><b>PERFORMANCE APPRAISAL</b></h5>
		        <h6 class="text-center"><strong>Evaluation Period: Januari <?=$eval_year?> - Desember <?=$eval_year;?></strong></h6>
		        <p class="text-center"><?= $header['request_number'] ?></p>

		    </div>
		    <!-- Qualitative -->
			<table class="table table-striped">
	            <thead>
	            	<tr>
						<td colspan="8">
							<b><font size=4>III. QUALITATIVE ASSESMENT</font></b>
						</td>
	            	</tr>
	                <tr>
	                    <th>COMPETENCIES</th>
	                    <th>WEIGHT</th>
	                    <th>SCORE (1-10)</th>
	                    <th>Score vs Weight</th>
	                    <th>Weak (1-5)</th>
	                    <th>Moderate (6-7)</th>
	                    <th>Strong (8-9)</th>
	                    <th>Exceptional (10)</th>
	                </tr>
	            </thead>
	            <tbody style="font-size: 11px;">
	                <tr id="tr_1">
	                    <td>Work Efficiency</td>
	                    <td>
	                        15%
	                    </td>
	                    <td>
							<?php echo ($header['work_efficiency'] == '' or $header['work_efficiency'] == '0') ? '0' : decrypt($header['work_efficiency']); ?>
	                    </td>
	                    <td>
							<?php echo ($header['work_efficiency_result'] == '' or $header['work_efficiency_result'] == '0') ? '0' : decrypt($header['work_efficiency_result']); ?>
	                    </td>
	                    <td><small>Unable to complete assigned work.</small></small></td>
	                    <td><small>Able to complete most assigned work</small></td>
	                    <td><small>Able to complete all assigned work</small></td>
	                    <td><small>Consistently delivers additional work.</small></td>
	                </tr>
	                <tr id="tr_2">
	                    <td>Work Quality</td>
	                    <td>15%</td>
	                    <td>
							<?php echo ($header['work_quality'] == '' or $header['work_quality'] == '0') ? '0' : decrypt($header['work_quality']); ?>
						</td>
	                    <td>
							<?php echo ($header['work_quality_result'] == '' or $header['work_quality_result'] == '0') ? '0' : decrypt($header['work_quality_result']); ?>
						</td>
	                    <td><small>Work quality is below expectations</small></td>
	                    <td><small>Work quality meets expectations</small></td>
	                    <td><small>Work quality meets and sometimes exceeds expectations</small></td>
	                    <td><small>Work quality consistently exceeds expectations</small></td>
	                </tr>
	                <tr id="tr_3">
	                    <td>Communication</td>
	                    <td>
	                        10%
	                    </td>
	                    <td>
							<?php echo ($header['communication'] == '' or $header['communication'] == '0') ? '0' : decrypt($header['communication']); ?>
	                    </td>
	                    <td>
							<?php echo ($header['communication_result'] == '' or $header['communication_result'] == '0') ? '0' : decrypt($header['communication_result']); ?>
	                    </td>
	                    <td><small>Weak delivery and content</small></td>
	                    <td><small>Moderate delivery and content</small></td>
	                    <td><small>Good delivery and adequate content</small></td>
	                    <td><small>Excellent delivery and very adequate content</small></td>
	                </tr>
	               	<tr id="tr_4">
	                    <td>Planning and Organizing</td>
	                    <td>
	                        10%
	                    </td>
	                    <td>
							<?php echo ($header['planing'] == '' or $header['planing'] == '0') ? '0' : decrypt($header['planing']); ?>
	                    </td>
	                    <td>
							<?php echo ($header['planing_result'] == '' or $header['planing_result'] == '0') ? '0' : decrypt($header['planing_result']); ?>
	                    </td>
	                    <td><small>Lacks ability to plan. Lacks ability to set priorities.</small></td>
	                    <td><small>Shows some ability to plan. Shows some ability to set priorities. Shows some ability to organize work tasks.</small></td>
	                    <td><small>Able to plan. Able to set priorities. Able to organize work tasks.</small></td>
	                    <td><small>Shows high skiils in planning and priority setting. Very organized in accomplishing work tasks.</small></td>
	                </tr>
	                <tr id="tr_5">
	                    <td>Problem Solving</td>
	                    <td>
	                        10%
	                    </td>
	                    <td>
							<?php echo ($header['problem_solving'] == '' or $header['problem_solving'] == '0') ? '0' : decrypt($header['problem_solving']); ?>
	                    </td>
	                    <td>
							<?php echo ($header['problem_solving_result'] == '' or $header['problem_solving_result'] == '0') ? '0' : decrypt($header['problem_solving_result']); ?>
	                    </td>
	                    <td><small>Unable to identify the real problems and the causes of the problems.</small></td>
	                    <td><small>Able to identify the real problems or the causes of the problems</small></td>
	                    <td><small>Able to identify the real problems or the causes of the problems. Able to solve problems with good results.</small></td>
	                    <td><small>Able to identify the real problems or the causes of the problems. Able to solve problems systematically and analytically with significant results and has a back-up plan.</small></td>
	                </tr>
	                <tr id="tr_6">
	                    <td>Team Work</td>
	                    <td>
	                        10%
	                    </td>
	                    <td>
							<?php echo ($header['team_work'] == '' or $header['team_work'] == '0') ? '0' : decrypt($header['team_work']); ?>
	                    </td>
	                    <td>
							<?php echo ($header['team_work_result'] == '' or $header['team_work_result'] == '0') ? '0' : decrypt($header['team_work_result']); ?>
	                    </td>
	                    <td><small>Does not consider the effect of personal work on others.</small></td>
	                    <td><small>Considers the effect of personal work on others</small></td>
	                    <td><small>Considers the effect of personal work on others. Willing to stretch him/herself to achieve team goals.</small></td>
	                    <td><small>Considers the effect of personal work on others. Willing to stretch him/herself to achieve team goals.Able to mediate differences in team.</small> </td>
	                </tr>
	                <tr id="tr_7">
	                    <td>Potential</td>
	                    <td>
	                        10%
	                    </td>
	                    <td>
							<?php echo ($header['potential'] == '' or $header['potential'] == '0') ? '0' : decrypt($header['potential']); ?>
	                    </td>
	                    <td>
							<?php echo ($header['potential_result'] == '' or $header['potential_result'] == '0') ? '0' : decrypt($header['potential_result']); ?>
	                    </td>
	                    <td><small>Lacks capacity to learn. Lacks capacity to take new responsibilities.</small></td>
	                    <td><small>Shows capacity to learn. Shows capacity to take new responsibilities.</small></td>
	                    <td><small>Shows strong capacity to learn. Shows strong capacity to take new responsibilities.</small></td>
	                    <td><small>Shows very strong capacity to learn. Shows very strong capacity to take new and challenging responsibilities.Excel in constrained situations.</small></td>
	                </tr>
	                <tr id="tr_8">
	                    <td>Initiative</td>
	                    <td>
	                        10%
	                    </td>
	                    <td>
							<?php echo ($header['initiative'] == '' or $header['initiative'] == '0') ? '0' : decrypt($header['initiative']); ?>
	                    </td>
	                    <td>
							<?php echo ($header['initiative_result'] == '' or $header['initiative_result'] == '0') ? '0' : decrypt($header['initiative_result']); ?>
	                    </td>
	                    <td><small>Waits for instructions to do the job. Prefers to stay in the comfort zone/status quo rather than initiate the change.</small></td>
	                    <td><small>Does the job as instructed. Initiates change occasionally.</small></td>
	                    <td><small>Does the job more than instructed. Frequently initiates changes that create a positive impact in the current situation.</small></td>
	                    <td><small>Actively initiate ideas that add value to the current situation and with innovation.</small></td>
	                </tr>
	                <tr id="tr_9">
	                    <td>Leadership</td>
	                    <td>
	                        10%
	                    </td>
	                    <td>
							<?php echo ($header['leadership'] == '' or $header['leadership'] == '0') ? '0' : decrypt($header['leadership']); ?>
	                    </td>
	                    <td>
							<?php echo ($header['leadership_result'] == '' or $header['leadership_result'] == '0') ? '0' : decrypt($header['leadership_result']); ?>
	                    </td>
	                    <td><small>Unable to Lead people</small></td>
	                    <td><small>Able to manage people to achieve work goals.</small></td>
	                    <td><small>Able to manage people to achieve work goals. Sets clear directions for others.</small></td>
	                    <td><small>Able to lead a team to achieve excellent team results. Visionary</small></td>
	                </tr> 
	            </tbody>
	            <tfoot>
	                <tr>
	                    <td colspan="3" class="text-secondary">
	                        <b>Total Qualitative Assesment Score</b>
	                    </td>
	                    <td class="lead-text">
	                        <b><?php  echo ($header['sub_total_qualitative'] == '' or $header['sub_total_qualitative'] == '0') ? '0' : decrypt($header['sub_total_qualitative']);?></b>
	                    </td>
	                </tr>
	            </tfoot>
	        </table>

	        <table class="table table-striped">
	        	<thead>
	        		<tr>
						<td colspan="4" align="left">
							<b><font size=4>IV. TOTAL</font></b>
						</td>
					</tr>
	        	</thead>
	        	<tbody style="font-size: 13px">
		        	<tr>
		        		<td>Total KPI Score</td>
		        		<td>85%</td>
		        		<td>
							<?php echo ($header['sub_total_kpi'] == '' or $header['sub_total_kpi'] == '0') ? '0' : decrypt($header['sub_total_kpi']); ?>
						</td>
		        		<td>
							<?php echo ($header['grand_total_kpi'] == '' or $header['grand_total_kpi'] == '0') ? '0' : decrypt($header['grand_total_kpi']); ?>
						</td>
		        	</tr>
		        	<tr>
		        		<td>Total Qualitative Asessment Score</td>
		        		<td>15%</td>
		        		<td>
							<?php echo ($header['sub_total_qualitative'] == '' or $header['sub_total_qualitative'] == '0') ? '0' : decrypt($header['sub_total_qualitative']); ?>
						</td>
		        		<td>
							<?php echo ($header['grand_total_qualitative'] == '' or $header['grand_total_qualitative'] == '0') ? '0' : decrypt($header['grand_total_qualitative']); ?>
						</td>
		        	</tr>
		        	<tr>
		        		<td>Pre Final Score</td>
		        		<td></td>
		        		<td></td>
		        		<td>
							<?php echo ($header['pre_final_score'] == '' OR $header['pre_final_score'] == '0') ? '0' : decrypt($header['pre_final_score']); ?>
						</td>
		        	</tr>
		        	<tr>
		        		<td><b>Final Score</b></td>
		        		<td></td>
		        		<td></td>
		        		<td><b>
						<?php echo ($header['final_score'] == '' AND $header['final_score'] == 0 AND decrypt($header['final_score']) == '0.000') ? '0' : decrypt($header['final_score']); ?>
							
						</b></td>
		        	</tr>
		        	<!-- <tr>
		        		<td><b>Grade</b></td>
		        		<td></td>
		        		<td></td>
		        		<td>
		        			<b>
		        			<?php 
		        				if($header['final_score'] == '' or $header['final_score'] == 0 or $header['final_score'] == '0.000'){ $score = '0'; }else{
									$score = decrypt($header['final_score']);
								} 
			        			if ($score <= 5.5) {
			        				$grade = 'E';
			        			} elseif ($score >= 5.6 && $score < 6.9) {
			        				$grade = 'D';
			        			} elseif ($score >= 6.9 && $score < 8.1) {
			        				$grade = 'C';
			        			}elseif ($score >= 8.1 && $score < 9.1) {
			        				$grade = 'B';
			        			}elseif ($score >= 9.1 || $score == 10) {
			        				$grade = 'A';
			        			}
		        				echo $grade;
		        			?>
		        			</b>
		        		</td>
		        	</tr> -->
	        	</tbody>
	        </table>
        </div>

        <div style="page-break-after: always">
        	<br>
	        <div class="row">
	          <table>
	              <tr>
	                  <th><img src="<?=base_url()?>/assets/images/<?= $logon; ?>" style="max-height:75px;"></th>
	              </tr>
	          </table>
	        </div>
	        
	        <div class="col-12">
		        <h5 class="text-center"><b>PERFORMANCE APPRAISAL</b></h5>
		        <h6 class="text-center"><strong>Evaluation Period: Januari <?=$eval_year;?> - Desember <?=$eval_year;?></strong></h6>
		        <p class="text-center"><?= $header['request_number'] ?></p>
		         
		    </div>

		    <table class="table table-striped">
	    		<thead>
	        	<tr>
					<td style="border-bottom: 1px solid #000000" colspan=9 align="left" valign=bottom bgcolor="#FFFFFF">
						<b><font size=4>V. DEVELOPMENT PLAN & RECOMENDATION</font></b>
					</td>
				</tr>
				<tr>
					<td>Please use this section to identify development that sustains, improves and builds performance, and enables the employee to contribute to organizational effectiveness.  This section should be used to identify which area that needs to be improved and detail development activities, and should be completed by the supervisor in collaboration with the employee. </td>
				</tr>
				</thead>
				<tbody style="font-size: 13px;">
					<tr>
						<td>AREA FOR IMPROVEMENT (Competency, Technical Skill, Soft Skill, Leadership, etc)</td>
					</tr>
					<tr>
						<td><textarea rows="5" class="form-control" style = "height:120px"><?=decrypt($header['area_improvement'])?></textarea></td>
					</tr>
					<tr>
						<td>DEVELOPMENT PLAN (Training, On The Job Training)</td>
					</tr>
					<tr>
						<td>
							<table class="table table-bordered" style="font-size: 13px;">
								<thead>
									<tr>
										<th class="w-5">Category</th>
										<th class="w-20">Training Name</th>
										<th class="w-40">Description</th>
									</tr>
								</thead>
								<tbody id="training_table" style="font-size: 13px;">
									<?php foreach ($training as $key) { ?>
										<tr id='kpi_training_row-<?= $key['id']; ?>'>
											<td id='kpi_training_cat-<?= $key['id']; ?>'>
												<!-- <a onclick='delete_training_row(<?= $key["id"]; ?>)' class="btn btn-icon btn-trigger"><em class="icon ni ni-cross-circle-fill"></em> -->
												<b id='kpi_training_category-<?= $key["id"]; ?>'>
													
													<?php if ($key["category"] == encrypt('soft')) {
														echo 'Soft Skill';
													} else {
														echo 'Hard Skill';
													} ?>
														
												</b>
												</a>
												<br>
											</td>
											<td id="kpi_training_name-<?= $key['id']; ?>">
												<b id="kpi_training_name-<?= $key['id']; ?>"><?= decrypt($key['training_name']); ?></b>
											</td>
											<td id="kpi_training_desc-<?= $key['id']; ?>" class="text-left">
												<b id="kpi_training_desc-<?= $key['id']; ?>"><?= decrypt($key['training_desc']); ?></b>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>

			<table class="table table-striped">
	    		<thead>
		        	<tr>
						<td style="border-bottom: 1px solid #000000" colspan=9 align="left" valign=bottom bgcolor="#FFFFFF">
							<b><font size=4>VI. COMMENTS & ACKNOWLEDGEMENT</font></b>
						</td>
					</tr>
					<tr>
						<td>The employee and the superior may add any relevant comments before signing the performance evaluation. By signing the evaluation the employee indicates that he/she has participated in a performance appraisal meeting; the signature does not indicate agreement or disagreement. If there is disagreement with the superior’s evaluation of an employee’s performance, the employee may explain that disagreement in the comments section.</td>
					</tr>
				</thead>
				<tbody style="font-size: 13px;">
					<tr>
						<td>Employee</td>
					</tr>
					
					<tr>
						<td><textarea rows="2" class="form-control"><?=decrypt($header['comment_employee'])?></textarea></td>
					</tr>
					<tr>
						<td>Direct Superior/ Manager/Division Head (1)</td>
					</tr>
					<tr>
						<td><textarea rows="2" class="form-control"><?=decrypt($header['comment_head_1'])?></textarea></td>
					</tr>
					<tr>
						<td>Direct Superior/ Manager/Division Head (2)</td>
					</tr>
					<tr>
						<td><textarea rows="2" class="form-control"><?=decrypt($header['comment_head_2'])?></textarea></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div style="page-break-after: always">
			<div class="row">
	          <table>
	              <tr>
	                  <th><img src="<?=base_url()?>/assets/images/<?= $logon; ?>" style="max-height:75px;"></th>
	              </tr>
	          </table>
	        </div>
	        
	        <div class="col-12">
		        <h5 class="text-center"><b>PERFORMANCE PLAN</b></h5>
		        <h6 class="text-center"><b>Evaluation Period: Januari <?=$eval_year+1;?> - Desember <?=$eval_year+1;?></b></h6>
		        <p class="text-center"><?= $header['request_number'] ?></p>
		    </div>

		    <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th class="w-20">Performance Objective</th>
                        <th class="w-20">KPI Measurement</th>
                        <th class="w-15">Weight %</th>
                        <th class="text-left">Unit</th>
                        <th class="w-15 text-secondary text-left">Target <?= $nextYear = $eval_year+1; ?></th>
                    </tr>
                    <tr>
                        <th colspan="2" class="text-secondary text-left">
                            Financial Perspective
                        </th>
                        <th colspan="4"></th>
                    </tr>
                </thead>
                <tbody id="financial_perspective" style="font-size: 13px;">
                    <?php $no = 1;
                    foreach ($additional as $key) { 
                    if ($key['plan_perspective'] == encrypt('financial_perspective')) { ?>
                        <tr id='plan_row-<?= $key['id']; ?>'>
                            <td>
                                <?=$no;?>
                            </td>
                            <td scope="row">
                                <span id="kpi_plan_objective-<?= $key['id']; ?>"><?= decrypt($key['objective']); ?></span>
                            </td>
                            <td scope="row">
                                <span id="kpi_plan_measurement-<?= $key['id']; ?>"><?= decrypt($key['measurement']); ?></span>
                            </td>
                            <td scope="row">
                                <span id="kpi_plan_time-<?= $key['id']; ?>"><?= decrypt($key['time']); ?></span>
                            </td>
                            <td scope="row">
                                <span id="kpi_plan_unit-<?= $key['id']; ?>"><?= decrypt($key['unit']); ?></span>
                            </td>
                            <td scope="row">
                                <span id="kpi_plan_target-<?= $key['id']; ?>"><?= decrypt($key['target']); ?></span>
                            </td>
                        </tr>
                    <?php $no++; }  } ?>
                </tbody>

                <thead>
                    <tr>
                        <th colspan="2" class="text-secondary text-left">
                            Customer Perspective
                        </th>
                        <th colspan="4"></th>
                    </tr>
                </thead>
                <tbody id="cust_perspective" style="font-size: 13px;">
                    <?php $no = 1;
                    foreach ($additional as $key) { 
                    if ($key['plan_perspective'] == encrypt('cust_perspective')) { ?>
                        <tr id='plan_row-<?= $key['id']; ?>'>
                            <td>
                                <?=$no;?>
                            </td>
                            <td scope="row">
                                <span id="kpi_plan_objective-<?= $key['id']; ?>"><?= decrypt($key['objective']); ?></span>
                            </td>
                            <td scope="row">
                                <span id="kpi_plan_measurement-<?= $key['id']; ?>"><?= decrypt($key['measurement']); ?></span>
                            </td>
                            <td scope="row">
                                <span id="kpi_plan_time-<?= $key['id']; ?>"><?= decrypt($key['time']); ?></span>
                            </td>
                            <td scope="row">
                                <span id="kpi_plan_unit-<?= $key['id']; ?>"><?= decrypt($key['unit']); ?></span>
                            </td>
                            <td scope="row">
                                <span id="kpi_plan_target-<?= $key['id']; ?>"><?= decrypt($key['target']); ?></span>
                            </td>
                        </tr>
                    <?php $no++; }  } ?>
                </tbody>

                <thead>
                    <tr>
                        <th colspan="2" class="text-secondary text-left">
                            Internal Process
                        </th>
                        <th colspan="4"></th>
                    </tr>
                </thead>
                <tbody id="intern_perspective" style="font-size: 13px;">
                    <?php $no = 1;
                    foreach ($additional as $key) { 
                    if ($key['plan_perspective'] == encrypt('intern_perspective')) { ?>
                        <tr id='plan_row-<?= $key['id']; ?>'>
                            <td>
                                <?=$no;?>
                            </td>
                            <td scope="row">
                                <span id="kpi_plan_objective-<?= $key['id']; ?>"><?= decrypt($key['objective']); ?></span>
                            </td>
                            <td scope="row">
                                <span id="kpi_plan_measurement-<?= $key['id']; ?>"><?= decrypt($key['measurement']); ?></span>
                            </td>
                            <td scope="row">
                                <span id="kpi_plan_time-<?= $key['id']; ?>"><?= decrypt($key['time']); ?></span>
                            </td>
                            <td scope="row">
                                <span id="kpi_plan_unit-<?= $key['id']; ?>"><?= decrypt($key['unit']); ?></span>
                            </td>
                            <td scope="row">
                                <span id="kpi_plan_target-<?= $key['id']; ?>"><?= decrypt($key['target']); ?></span>
                            </td>
                        </tr>
                    <?php $no++; }  } ?>
                </tbody>

                <thead>
                    <tr>
                        <th colspan="2" class="text-secondary text-left">
                            Learning & Growth
                        </th>
                        <th colspan="4"></th>
                    </tr>
                </thead>
                <tbody id="learn_perspective" style="font-size: 13px;">
                    <?php $no = 1;
                    foreach ($additional as $key) { 
                    if ($key['plan_perspective'] == encrypt('learn_perspective')) { ?>
                        <tr id='plan_row-<?= $key['id']; ?>'>
                            <td>
                                <?=$no;?>
                            </td>
                            <td scope="row">
                                <span id="kpi_plan_objective-<?= $key['id']; ?>"><?= decrypt($key['objective']); ?></span>
                            </td>
                            <td scope="row">
                                <span id="kpi_plan_measurement-<?= $key['id']; ?>"><?= decrypt($key['measurement']); ?></span>
                            </td>
                            <td scope="row">
                                <span id="kpi_plan_time-<?= $key['id']; ?>"><?= decrypt($key['time']); ?></span>
                            </td>
                            <td scope="row">
                                <span id="kpi_plan_unit-<?= $key['id']; ?>"><?= decrypt($key['unit']); ?></span>
                            </td>
                            <td scope="row">
                                <span id="kpi_plan_target-<?= $key['id']; ?>"><?= decrypt($key['target']); ?></span>
                            </td>
                        </tr>
                    <?php $no++; }  } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2"></td>
                        <td class="text-secondary">
                            <b>Total Weight(%)</b>
                        </td>
                        <td colspan="3" class="text-left">
                            <input type="text" disabled size="5" value="<?php echo ($header['plan_total_weight'] == encrypt('0') or $header['plan_total_weight'] == "") ? 0 : decrypt($header['plan_total_weight']); ?>" name="plan_total_weight" id="plan_total_weight">
                        </td>
                    </tr>
                </tfoot>
           </table>
		</div>

		<div style="page-break-inside: avoid">
			<div class="row">
	          <table>
	              <tr>
	                  <th><img src="<?=base_url()?>/assets/images/<?= $logon; ?>" style="max-height:75px;"></th>
	              </tr>
	          </table>
	        </div>
	        <br>
	        
	        <div class="col-12">
		        <h5 class="text-center"><b>APPROVAL SUMMARY</h5>
		        <h6 class="text-center"><strong>Evaluation Period: Januari <?=$eval_year;?> - Desember <?=$eval_year;?></strong></h6>
		        <p class="text-center"><?= $header['request_number'] ?></p>
		    </div>
		    <br><br>
		    <table class="table table-borderless">
		    	<tr>
		    		<td><b>Prepared by employee</b></td>
		    		<td><b>Reviewed & approved by (Line Manager)</b></td>
		    		<td><b>Approved by (Indirect Superior)</b></td>
		    	</tr>
		    	<tr>
		    		<td style="height: 120px;font-size: 13px;"><br><br><center><i>Approval is generated by system. <br>No signature are required.</center></i></td>
					<?php 
					foreach ($approval as $key => $value) { 
						?>
				    		<?php 
								if ($count_approval == 2) { 
							?>
			    			<?php 
								if($value['approval_priority'] == 1 && ($value['approval_status'] == 'In Progress' || $value['approval_status'] == '')){
							?>
								<td style="height: 120px;font-size: 13px;"><br><br><center><i>Not Yet Approved</center></i></td>
							<?php 
								}elseif($value['approval_priority'] == 1 && $value['approval_status'] == 'Approved'){
							?>
								<td style="height: 120px;font-size: 13px;"><br><br><center><i>Approval is generated by system2. <br>No signature are required.</center></i></td>
							<?php
								}
							?>
							<?php
								if($value['approval_priority'] == 2 && ($value['approval_status'] == 'In Progress' || $value['approval_status'] == '')){
							?>
								<td style="height: 120px;font-size: 13px;"><br><br><center><i>Not Yet Approved</center></i></td>
							<?php
								}elseif($value['approval_priority'] == 2 && $value['approval_status'] == 'Approved'){
							?>
								<td style="height: 120px;font-size: 13px;"><br><br><center><i>Approval is generated by system3. <br>No signature are required.</center></i></td>
							<?php
								}
							?>
						
				    	<?php } else { ?>

				    		<?php if($value['approval_priority'] == 1 && ($value['approval_status'] == 'In Progress' && $value['approval_status'] == '')){?>
								<td style="height: 120px;font-size: 13px;"><br><br><center><i>Not Yet Approved</center></i></td>
							<?php
								}elseif($value['approval_priority'] == 1 && $value['approval_status'] == 'Approved'){
							?>
								<td style="height: 120px;font-size: 13px;"><br><br><center><i>Approval is generated by system. <br>No signature are required.</center></i></td>
							<?php
								}
							?>
							<?php
								if($value['approval_priority'] == 1 && ($value['approval_status'] == 'In Progress' && $value['approval_status'] == '')){
							?>
								<td style="height: 120px;font-size: 13px;"><br><br><center><i>Not Yet Approved</center></i></td>
							<?php
								}elseif($value['approval_priority'] == 1 && $value['approval_status'] == 'Approved'){
							?>
								<td style="height: 120px;font-size: 13px;"><br><br><center><i>Approval is generated by system. <br>No signature are required.</center></i></td>
							<?php
								}
							?>

						<?php } ?> 

					<?php } ?> 
		    		
		    	</tr>
		    	<tr>
		    		<td><b>Name:</b> <?=decrypt($employee['complete_name'])?> <br><b>Date:</b> <?= str_replace('.000', '', $header['created_at'])?> </td>

			    	<?php 
					foreach ($approval as $key => $value) { 
						?>
				    	<?php if ($count_approval == 2) { ?>
			    		
					    	<?php if ($value['approval_priority'] == 1): ?>
				    		<td><b>Name:</b> <?=$value['approval_alias']?> <br> <b>Date:</b> <?= str_replace('.000', '', $value['updated_at'])?> </td>
					    	<?php endif ?>

					    	<?php if ($value['approval_priority'] == 2): ?>
				    		<td><b>Name:</b> <?=$value['approval_alias']?> <br><b>Date:</b> <?= str_replace('.000', '', $value['updated_at'])?> </td>
					    	<?php endif ?>
						
				    	<?php } else { ?>

				    		<?php if ($value['approval_priority'] == 1): ?>
				    		<td><b>Name:</b> <?=$value['approval_alias']?> <br><b>Date:</b> <?= str_replace('.000', '', $value['updated_at'])?> </td>
					    	<?php endif ?>

					    	<?php if ($value['approval_priority'] == 1): ?>
				    		<td><b>Name:</b> <?=$value['approval_alias']?> <br><b>Date:</b> <?= str_replace('.000', '', $value['updated_at'])?> </td>
					    	<?php endif ?>

						<?php } ?> 

					<?php } ?> 
		    	</tr>
		    	
		    </table>
		</div>

    </main>
</body>

</html>