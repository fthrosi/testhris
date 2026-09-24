<div class="nk-ibx-head">
    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <li>
                 <h3 class="title"><span class="text-soft"><?=strtoupper(decrypt($this->session->userdata('division')));?></span> </h3>
                 <strong>EVALUATION PERIOD: <span class="text-primary"> Januari <?=$eval_year = date('Y') - 1;?> - Desember <?=$eval_year = date('Y') - 1;?></span></strong>
            </li>
        </ul>
    </div>
</div>

<div class="nk-ibx-reply nk-reply" data-simplebar>
    <br>
    <div class="nk-ibx-reply-group">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block">
                        <div class="row g-gs">
                            <div class="col-xxl-12">
                                <div class="row g-gs">
                                    <div class="col-sm-6">
                                        <div class="card card-bordered card-full">
                                            <div class="card-inner">
                                                <div class="card-title-group align-start mb-0">
                                                    <div class="card-title">
                                                        <h6 class="title">TOTAL TEAM MEMBERS</h6>
                                                    </div>
                                                    <div class="card-tools">
                                                        <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="Headcount"></em>
                                                    </div>
                                                </div>
                                                <div class="card-amount">
                                                    <span class="amount"><?=$totalEmployee;?></span>
                                                </div>
                                                <div class="invest-data">
                                                    <div class="invest-data-amount g-2">
                                                        <div class="invest-data-history">
                                                            <div class="title text-primary">Eligible for PA</div>
                                                            <div class="amount"><?=$eligible;?></div>
                                                        </div>
                                                        <div class="invest-data-history">
                                                            <div class="title text-danger">Not Eligible for PA</div>
                                                            <div class="amount"><?=$not_eligible;?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="card card-bordered">
                                            <div class="card-inner">
                                                <div class="card-title-group align-start mb-0">
                                                    <div class="card-title">
                                                        <h6 class="title">Total PA Submission</h6>
                                                    </div>
                                                </div>
                                                <div class="card-amount">
                                                    <span class="amount"><?=$fullapproved+$waiting+$revise;?></span>
                                                </div>
                                                <div class="invest-data">
                                                    <div class="invest-data-amount g-2">
                                                        <div class="invest-data-history">
                                                            <div class="title text-danger">Not Submitted Yet</div>
                                                           <div class="amount"><?=$unsubmitted;?>
                                                               <span class="sub-title">
                                                                    <a class="btn btn-icon btn-trigger text-soft" onclick="return viewNotSubmitted(this.id);" id="<?=decrypt($this->session->userdata('directorate'))?>"><em class="icon ni ni-eye"></em> View</a>
                                                                </span>
                                                           </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="card card-bordered">
                                            <div class="card-inner">
                                                <div class="card-title-group align-start mb-2">
                                                    <div class="card-title">
                                                        <h6 class="title">Full Approved</h6>
                                                    </div>
                                                    <div class="card-tools">
                                                        <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="Total PA Full Approved"></em>
                                                    </div>
                                                </div>
                                                <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                                    <div class="nk-sale-data">
                                                        <span class="amount"><?=$fullapproved;?></span>
                                                        <span class="sub-title">
                                                            <span class="text-soft">
                                                                Details on the table below
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="col-xxl-12">
                                <div class="row g-gs">
                                    <div class="col-lg-9">
                                        <div class="card card-bordered h-100">
                                            <div class="card-inner mb-n2">
                                                <div class="card-title-group">
                                                    <div class="card-title">
                                                        <h6 class="title">Summary Grade (Full Approved)</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="nk-tb-list is-loose traffic-channel-table">
                                                <div class="nk-tb-item nk-tb-head">
                                                    <div class="nk-tb-col nk-tb-sessions"><span>Score</span></div>
                                                    <div class="nk-tb-col nk-tb-channel"><span>Grade</span></div>
                                                    <div class="nk-tb-col nk-tb-sessions"><span>Total</span></div>
                                                   <!--  <div class="nk-tb-col nk-tb-sessions"><span>Actual % (vs Full Approved PA)</span></div>
                                                    <div class="nk-tb-col nk-tb-sessions"><span>HR Defined Percentage</span></div> -->
                                                    <div class="nk-tb-col nk-tb-sessions"></div>
                                                </div>
                                                <div class="nk-tb-item">
                                                     <div class="nk-tb-col nk-tb-channel">
                                                        <span class="tb-lead text-soft">9.1 - 10.0</span>
                                                    </div>
                                                    <div class="nk-tb-col nk-tb-channel">
                                                        <span class="tb-lead">A</span>
                                                    </div>
                                                     <div class="nk-tb-col nk-tb-channel">
                                                        <span class="tb-lead"><span class="badge badge-pill badge-sm badge-secondary"><?=$total_a;?></span></span>
                                                    </div>
                                                   <!--  <div class="nk-tb-col nk-tb-channel">
                                                        <span class="tb-lead text-primary ">
                                                            <?=round(($total_a/$fullapproved)*100, 2);?> %
                                                        </span>
                                                    </div>
                                                    <div class="nk-tb-col nk-tb-channel">
                                                        <span class="tb-lead ">5%</span>
                                                    </div> -->
                                                    <div class="nk-tb-col nk-tb-channel">
                                                        <a class="btn btn-icon btn-trigger text-primary" id="a" onclick="return gradeViewC(this.id)"><em class="icon ni ni-eye"></em> Details</a>
                                                    </div>
                                                </div>
                                                <div class="nk-tb-item">
                                                     <div class="nk-tb-col nk-tb-channel">
                                                        <span class="tb-lead text-soft">8.1 - 9.0</span>
                                                    </div>
                                                    <div class="nk-tb-col nk-tb-channel">
                                                        <span class="tb-lead">B</span>
                                                    </div>
                                                     <div class="nk-tb-col nk-tb-channel">
                                                        <span class="tb-lead"><span class="badge badge-pill badge-sm badge-secondary"><?=$total_b;?></span></span>
                                                    </div>
                                                    <!-- <div class="nk-tb-col nk-tb-channel">
                                                        <span class="tb-lead text-primary ">
                                                            <?=round(($total_b/$fullapproved)*100, 2);?> %
                                                        </span>
                                                    </div>
                                                    <div class="nk-tb-col nk-tb-channel">
                                                        <span class="tb-lead ">32%</span>
                                                    </div> -->
                                                    <div class="nk-tb-col nk-tb-channel">
                                                        <a class="btn btn-icon btn-trigger text-primary" id="b" onclick="return gradeViewC(this.id)"><em class="icon ni ni-eye"></em> Details</a>
                                                    </div>
                                                </div>
                                                <div class="nk-tb-item">
                                                     <div class="nk-tb-col nk-tb-channel">
                                                        <span class="tb-lead text-soft">6.9 - 8.0</span>
                                                    </div>
                                                    <div class="nk-tb-col nk-tb-channel">
                                                        <span class="tb-lead">C</span>
                                                    </div>
                                                     <div class="nk-tb-col nk-tb-channel">
                                                        <span class="tb-lead"><span class="badge badge-pill badge-sm badge-secondary"><?=$total_c;?></span></span>
                                                    </div>
                                                    <!-- <div class="nk-tb-col nk-tb-channel">
                                                        <span class="tb-lead text-primary ">
                                                            <?=round(($total_c/$fullapproved)*100, 2);?> %
                                                        </span>
                                                    </div>
                                                    <div class="nk-tb-col nk-tb-channel">
                                                        <span class="tb-lead ">43%</span>
                                                    </div> -->
                                                    <div class="nk-tb-col nk-tb-channel">
                                                        <a class="btn btn-icon btn-trigger text-primary" id="c" onclick="return gradeViewC(this.id)"><em class="icon ni ni-eye"></em> Details</a>
                                                    </div>
                                                </div>
                                                <div class="nk-tb-item">
                                                     <div class="nk-tb-col nk-tb-channel">
                                                        <span class="tb-lead text-soft">5.6 - 6.8</span>
                                                    </div>
                                                    <div class="nk-tb-col nk-tb-channel">
                                                        <span class="tb-lead">D</span>
                                                    </div>
                                                     <div class="nk-tb-col nk-tb-channel">
                                                        <span class="tb-lead"><span class="badge badge-pill badge-sm badge-secondary"><?=$total_d;?></span></span>
                                                    </div>
                                                    <!-- <div class="nk-tb-col nk-tb-channel">
                                                        <span class="tb-lead text-primary ">
                                                            <?=round(($total_d/$fullapproved)*100, 2);?> %
                                                        </span>
                                                    </div>
                                                    <div class="nk-tb-col nk-tb-channel">
                                                        <span class="tb-lead ">15%</span>
                                                    </div> -->
                                                    <div class="nk-tb-col nk-tb-channel">
                                                        <a class="btn btn-icon btn-trigger text-primary" id="d" onclick="return gradeViewC(this.id)"><em class="icon ni ni-eye"></em> Details</a>
                                                    </div>
                                                </div>
                                                <div class="nk-tb-item">
                                                     <div class="nk-tb-col nk-tb-channel">
                                                        <span class="tb-lead text-soft">0.0 - 5.5</span>
                                                    </div>
                                                    <div class="nk-tb-col nk-tb-channel">
                                                        <span class="tb-lead">E</span>
                                                    </div>
                                                     <div class="nk-tb-col nk-tb-channel">
                                                        <span class="tb-lead"><span class="badge badge-pill badge-sm badge-secondary"><?=$total_e;?></span></span>
                                                    </div>
                                                    <!-- <div class="nk-tb-col nk-tb-channel">
                                                        <span class="tb-lead text-primary ">
                                                            <?=round(($total_e/$fullapproved)*100, 2);?> %
                                                        </span>
                                                    </div>
                                                    <div class="nk-tb-col nk-tb-channel">
                                                        <span class="tb-lead ">5%</span>
                                                    </div> -->
                                                    <div class="nk-tb-col nk-tb-channel">
                                                        <a class="btn btn-icon btn-trigger text-primary" id="e" onclick="return gradeViewC(this.id)"><em class="icon ni ni-eye"></em> Details</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="card card-bordered">
                                            <div class="card-inner">
                                                <div class="card-title-group align-start mb-2">
                                                    <div class="card-title">
                                                        <h6 class="title">In Progress</h6>
                                                    </div>
                                                    <div class="card-tools">
                                                        <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="Total active PA Submission"></em>
                                                    </div>
                                                </div>
                                                <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                                    <div class="nk-sale-data">
                                                        <span class="amount"><?=$waiting+$revise;?></span>
                                                        <span class="sub-title">
                                                            <span class="text-soft">
                                                                Details on the table below
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card card-bordered">
                                            <div class="card-inner">
                                                <div class="card-title-group align-start mb-2">
                                                    <div class="card-title">
                                                        <h6 class="title">Total Division</h6>
                                                    </div>
                                                </div>
                                                <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                                    <div class="nk-sale-data">
                                                        <span class="amount"><?=$totalDivision;?></span>
                                                        <span class="sub-title">
                                                            <a class="btn btn-icon btn-trigger text-primary" onclick="return viewDivisionC();"><em class="icon ni ni-eye"></em> View</a>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card card-bordered">
                                            <div class="card-inner">
                                                <div class="card-title-group align-start mb-2">
                                                    <div class="card-title">
                                                        <h6 class="title">HR Confirmed</h6>
                                                    </div>
                                                </div>
                                                <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                                    <div class="nk-sale-data">
                                                        <span class="amount"><?=$totalConfirmed;?> Division</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>
    <div class="nk-ibx-reply-group">
        <div class="card card-preview">
            <div class="card-inner">
                <h5>Details PA & Plan Submission</h5>
                <?php 
                    if(empty($_REQUEST['filterDivision'])){
                        $_REQUEST['filterDivision'] = "all";
                    }
                ?>
                <form action = "" method = "post">
                <b>Filter Division</b> : 
                <select name = "filterDivision" class = "form-control" style = "width:30%" onchange = "this.form.submit()">
                    <option value = "all">All</option>
                    <?php 
                        foreach($division as $key => $val){
                            ?>
                            <option value = "<?php echo str_replace("#","@",$val); ?>" <?php if(str_replace("#","@",$val) == $_REQUEST['filterDivision']){ echo "selected";} ?> ><?php echo decrypt($val); ?></option>
                            <?php
                        }
                    ?>
                </select>
                </form>
            </div>
            <div class="card-inner">
                <table class="nowrap table tableDashboard" data-export-title="Export Data" id="tableHR" data-ajaxsource="<?= site_url('dashboard/read_c/all/'.$_REQUEST['filterDivision']); ?>">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Name</th>
                            <th>Division</th>
                            <th>Department</th>
                            <th>Position</th>
                            <th>Status</th>
                            <th>Direct Manager</th>
                            <th>Office Location</th>
                            <th>Join Date</th>
                            <th>Employment Type</th>
                            <th>Final Score</th>
                            <th>Grade</th>
                            <th>Full Approved Date</th>
                            <th>Request Number</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" data-backdrop="static" tabindex="-1" id="modalQuickView">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class = "title">Kurva Final Division <b id = "divisionShow"></b></h5>
                <input type = "hidden" id = "total_team">
                <table class = "table table-sm">
                    <thead>
                        <tr>
                            <th>Score</th>
                            <th>PA</th>
                            <th>Basic Line</th>
                            <th>Percentage</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>A</td>
                            <td><div id = "total_a"></div></td>
                            <input type = "hidden" id = "total_score_a" readonly>
                            <td><div id = "basic_a"></div></td>
                            <input type = "hidden" id = "basic_line_a" readonly>
                            <input type = "hidden" id = "min_line_a">
                            <input type = "hidden" id = "max_line_a">
                            <td>
                                5%
                                <input type = "hidden" id = "persentase_a" value = "5" readonly>
                            </td>
                            <td><div id = "note_a"></div></td>
                        </tr>
                        <tr>
                            <td>B</td>
                            <td><div id = "total_b"></div></td>
                            <input type = "hidden" id = "total_score_b" readonly>
                            <td><div id = "basic_b"></div></td>
                            <input type = "hidden" id = "basic_line_b" readonly>
                            <input type = "hidden" id = "min_line_b">
                            <input type = "hidden" id = "max_line_b">
                            <td>
                                32%
                                <input type = "hidden" id = "persentase_b" value = "32" readonly>
                            </td>
                            <td><div id = "note_b"></div></td>
                        </tr>
                        <tr>
                            <td>C</td>
                            <td><div id = "total_c"></div></td>
                            <input type = "hidden" id = "total_score_c" readonly>
                            <td><div id = "basic_c"></div></td>
                            <input type = "hidden" id = "basic_line_c" readonly>
                            <input type = "hidden" id = "min_line_c">
                            <input type = "hidden" id = "max_line_c">
                            <td>
                                43%
                                <input type = "hidden" id = "persentase_c" value = "43" readonly>
                            </td>
                            <td><div id = "note_c"></div></td>
                        </tr>
                        <tr>
                            <td>D</td>
                            <td><div id = "total_d"></div></td>
                            <input type = "hidden" id = "total_score_d" readonly>
                            <td><div id = "basic_d"></div></td>
                            <input type = "hidden" id = "basic_line_d" readonly>
                            <input type = "hidden" id = "min_line_d">
                            <input type = "hidden" id = "max_line_d">
                            <td>
                                15%
                                <input type = "hidden" id = "persentase_d" value = "15" readonly>
                            </td>
                            <td><div id = "note_d"></div></td>
                        </tr>
                        <tr>
                            <td>E</td>
                            <td><div id = "total_e"></div></td>
                            <input type = "hidden" id = "total_score_e" readonly>
                            <td><div id = "basic_e"></div></td>
                            <input type = "hidden" id = "basic_line_e" readonly>
                            <input type = "hidden" id = "min_line_e">
                            <input type = "hidden" id = "max_line_e">
                            <td>
                                5%
                                <input type = "hidden" id = "persentase_e" value = "5" readonly>
                            </td>
                            <td><div id = "note_e"></div></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan = "3"><div id = "totalall"></div></th>
                            <th></th>
                            <th><div id = "notekurva"></div></th>
                        </tr>
                    </tfoot>
                </table>
                <hr>
                <h5 class="title">Performance Score</h5>
                <form action="#" class="pt-2">
                    <div class="row gy-3 gx-gs">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label text-soft" for="edit-course-name">Name</label>
                                <div class="form-control-wrap">
                                    <b id="emp_name"></b> <i class="text-danger" id="final_score_title" style="display:none">*** New Employee</i>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label text-soft" for="edit-category">Position</label>
                                <div class="form-control-wrap">
                                    <b id="emp_position"></b>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label text-soft" for="edit-category">Join Date</label>
                                <div class="form-control-wrap">
                                    <b id="emp_join_date"></b>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label text-soft" for="edit-category">Employment Type</label>
                                <div class="form-control-wrap">
                                    <b id="emp_type"></b>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <br>
                            <label class="form-label" for="edit-category">Total Qualitative / KPIs</label>  
                            <table class="table table-striped" id="table_kpi_achievement">
                                <tr>
                                    <td class="w-60"><b>KPI Score</b></td>
                                    <td class="w-15"><b>85%</b></td>
                                    <td id="subtotal_kpi"></td>
                                    <td align="right" id="grandtotal_kpi"></td>
                                </tr>
                                <tr>
                                    <td><b>Qualitative Assesment Score</b></td>
                                    <td><b>15%</b></td>
                                    <td id="subtotal_qualitative"></td>
                                    <td align="right" id="grandtotal_qualitative"></td>
                                </tr>
                                <tr>
                                    <td><b>Pre Final Score</b></td>
                                    <td></td>
                                    <td></td>
                                    <td align="right" id="pre_final_score"></td>
                                </tr>
                                <tr id="tr_final_score">
                                    <td><b>Final Score</b></td>
                                    <td></td>
                                    <td></td>
                                    <td align="right">
                                        <input type="number" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="5" min="1" max="10" onchange="return calculate_final_score_dashboard();" onClick="return calculate_final_score_dashboard();" onKeyUp="return calculate_final_score_dashboard();" placeholder="Score" name="final_score" id="final_score">
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Grade</b></td>
                                    <td></td>
                                    <td></td>
                                    <td align="right" id="grade"></td>
                                </tr>
                                <tr id="alert_fs" style="display: none;">
                                    <input type = "hidden" id = "id_pa">
                                    <input type = "hidden" id = "division_encrypt"> 
                                    <td colspan="3"><p class="text-danger">Please enter final score less than or equal to 10.</p></td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-12">
                            <div class="form-group">
                                <input type="hidden" name="req_id_modal" id="req_id_modal">
                                <input type="hidden" name="access_employee" id="access_employee" value = "<?= $this->session->userdata('access_employee') ?>">
                                <a onclick="return save_final_score_dashboard_c();" class="btn btn-dim btn-block btn-primary"><span id="update-final">Update Final Score</span></a>
                                <a class="btn btn-dim btn-block btn-secondary" onclick = "return reset_final_score_dummy()" data-dismiss="modal" aria-label="Close"><span id="">Close</span></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modalCdivision">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                
                <h5 class="title"><?=decrypt($this->session->userdata('directorate'));?></h5>
                <!-- <strong><a class="text-primary" href="<?= site_url('dashboard/c_division');?>">Click here to view division details</a></strong> -->
                <br>
               <table class="table table-striped">
                   <thead>
                       <tr>
                           <td>No.</td>
                           <td>Division Name</td>
                           <td>Division Head</td>
                           <td>Updated By</td>
                           <td>HR Status</td>
                       </tr>
                   </thead>
                   <tbody id="tableViewDivision">
                       
                   </tbody>
               </table>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" id="modalNotSubmit">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Not Submitted Yet</h5>
                <br>
               <table class="table table-striped">
                   <thead>
                       <tr>
                           <td>No.</td>
                           <td>Employee Name</td>
                           <td>Division</td>
                           <td>Position</td>
                           <td>Status</td>
                           <!-- <td>PA Status</td> -->
                       </tr>
                   </thead>
                   <tbody id="tableNotSubmit">
                       
                   </tbody>
               </table>
            </div>
        </div>
    </div>
</div>