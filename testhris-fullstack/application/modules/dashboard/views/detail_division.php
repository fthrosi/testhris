<?php if ($division_status['is_status'] == 3 || $division_status['is_status'] == 1) {
    $show = 'none';

} else {
    $show = '';
} ?>

<div class="nk-ibx-head">
    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <li class="ml-n2">
                <a href="<?= site_url('dashboard/c_division'); ?>" class="btn btn-icon btn-tooltip" title="Back">
                    <em class="icon ni ni-arrow-left"></em>
                    Back
                </a>
            </li>
            &nbsp;
            <?php if ($division_status['division_name'] == 'Regional Central'): ?>
            <li class="ml-n2" style="display: <?=$show?>">
                <a onclick="return responseDivision(this.id)" id="submit_to_hr_ops" class="btn btn-icon btn-tooltip" title="Submit to HR">
                    <em class="icon ni ni-send"></em>
                    Submit to HR
                </a>
            </li>
            <?php endif ?>
        </ul>
    </div>
</div>

<div class="nk-ibx-reply nk-reply" data-simplebar>

    <div class="nk-ibx-reply-head">
        <div>
            <h4 class="title ff-base"><?=strtoupper($division_status['division_name']);?> <span class="text-soft">DIVISION</span></h4>
        </div>
        <ul class="d-flex g-1">
            <li class="d-none d-sm-block" id="request_status"> 
                <?php if (!empty($division_status)) {
                    echo status_division($division_status['is_status']);
                } else {
                    echo status_division(0);
                }?>    
            </li>
        </ul>
    </div>

    <div class="card card-preview">
        <div class="card-inner">
            <div class="nk-block">
                <div class="row g-gs">
                    
                    <div class="col-lg-6 col-xxl-6">
                        <div class="card card-bordered h-100">
                            <div class="card-inner mb-n2">
                                <div class="card-title-group">
                                    <div class="card-title card-title-sm">
                                        <h6 class="title">PA & Plan Submision Progress </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-tb-list is-loose traffic-channel-table">
                                <div class="nk-tb-item nk-tb-head">
                                    <div class="nk-tb-col nk-tb-sessions"><span></span></div>
                                    <div class="nk-tb-col nk-tb-channel"><span>Total</span></div>
                                    <div class="nk-tb-col nk-tb-sessions"><span></span></div>
                                </div>
                                <div class="nk-tb-item">
                                     <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead text-primary">Waiting Approval</span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead"><?=$total_inprogress;?></span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead"></span>
                                    </div>
                                </div>
                                <div class="nk-tb-item">
                                     <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead text-primary">Revise</span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead"><?=$total_revise;?></span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead"></span>
                                    </div>
                                </div>
                                <div class="nk-tb-item">
                                     <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead text-success"><span class="badge badge-success">Full Approved</span></span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead"><?=$total_approved;?></span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="text-soft"><i>Check on the table below</i></span>
                                    </div>
                                </div>
                                <div class="nk-tb-item">
                                     <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">Total PA Submission</span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead"><span class="badge badge-pill badge-sm badge-soft"><?=($total_approved + $total_revise + $total_inprogress);?></span></span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead"></span>
                                    </div>
                                </div>
                                 <div class="nk-tb-item">
                                     <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">Total Team Member</span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead"><span class="badge badge-pill badge-sm badge-primary"><?=$total_team;?></span></span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-xxl-6">
                        <div class="card card-bordered h-100">
                            <div class="card-inner mb-n2">
                                <div class="card-title-group">
                                    <div class="card-title card-title-sm">
                                        <h6 class="title">Summary Grade</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-tb-list is-loose traffic-channel-table">
                                <div class="nk-tb-item nk-tb-head">
                                    <div class="nk-tb-col nk-tb-sessions"><span>Score</span></div>
                                    <div class="nk-tb-col nk-tb-channel"><span>Grade</span></div>
                                    <div class="nk-tb-col nk-tb-sessions"><span>Total</span></div>
                                    <div class="nk-tb-col nk-tb-sessions"><span>HR Defined Percentage</span></div>
                                </div><!-- .nk-tb-head -->
                                <div class="nk-tb-item">
                                     <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">9.1 - 10.0</span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">A</span>
                                    </div>
                                     <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead"><span class="badge badge-pill badge-sm badge-soft"><?=$total_a;?></span></span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">5%</span>
                                    </div>
                                </div>
                                <div class="nk-tb-item">
                                     <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">8.1 - 9.0</span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">B</span>
                                    </div>
                                     <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead"><span class="badge badge-pill badge-sm badge-soft"><?=$total_b;?></span></span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">32%</span>
                                    </div>
                                </div>
                                <div class="nk-tb-item">
                                     <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">6.9 - 8.0</span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">C</span>
                                    </div>
                                     <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead"><span class="badge badge-pill badge-sm badge-soft"><?=$total_c;?></span></span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">43%</span>
                                    </div>
                                </div>
                                <div class="nk-tb-item">
                                     <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">5.6 - 6.8</span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">D</span>
                                    </div>
                                     <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead"><span class="badge badge-pill badge-sm badge-soft"><?=$total_d;?></span></span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">15%</span>
                                    </div>
                                </div>
                                <div class="nk-tb-item">
                                     <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">0.0 - 5.5</span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">E</span>
                                    </div>
                                     <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead"><span class="badge badge-pill badge-sm badge-soft"><?=$total_e;?></span></span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">5%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="card card-preview">
        <div class="card-inner">
            <table class="datatable-init-export nowrap table" data-export-title="Export Data" data-ajaxsource="<?= site_url('dashboard/read_c_division/'.str_replace('&', '-', $division_status['division_name'])); ?>">
                <thead>
                    <tr>
                        <th>NIK</th>
                        <th>Name</th>
                        <th>Division</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Direct Manager</th>
                        <th>Office Location</th>
                        <th>Join Date</th>
                        <th>Employment Type</th>
                        <th>Final Score</th>
                        <th>Grade</th>
                        <th>Status</th>
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


<div class="modal fade" tabindex="-1" id="modalQuickView">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Final Score</h5>
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
                                        <input type="number" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="5" min="1" max="10" onchange="return calculate_final_score();" onClick="return calculate_final_score();" onKeyUp="return calculate_final_score();" placeholder="Score" name="final_score" id="final_score">
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Grade</b></td>
                                    <td></td>
                                    <td></td>
                                    <td align="right" id="grade"></td>
                                </tr>
                                <tr id="alert_fs" style="display: none;">
                                    <td colspan="3"><p class="text-danger">Please enter final score less than or equal to 10.</p></td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-12">
                            <div class="form-group">
                                <input type="hidden" name="req_id_modal" id="req_id_modal">
                                <a onclick="return save_final_score_dashboard_c();" class="btn btn-dim btn-block btn-primary"><span id="update-final">Update Final Score</span></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
