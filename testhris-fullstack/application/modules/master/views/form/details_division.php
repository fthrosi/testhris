<?php if ($division_status['is_status'] == 3) {
    $show = 'none';

} else {
    $show = '';
} ?>

<div class="nk-ibx-head">
    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <li class="ml-n2">
                <a href="<?= site_url('inbox/hr_division'); ?>" class="btn btn-icon btn-tooltip" title="Back">
                    <em class="icon ni ni-arrow-left"></em>
                    Back
                </a>
            </li>
            <li class="ml-n2" style="display: <?=$show?>">
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">
                        <em class="icon ni ni-more-v"></em> Response
                    </a>
                    <div class="dropdown-menu">
                        <ul class="link-list-opt no-bdr">
                            <input type="hidden" name="performance_division_id" id="performance_division_id" value="<?=$division_status['id']?>">
                            <li><a class="dropdown-item" onclick="return responseDivision(this.id);" id="Confirm"><span>Confirm</span></a></li>
                            <li><a class="dropdown-item" onclick="return responseDivision(this.id);" id="Revised"><span>Revise</span></a></li>
                        </ul>
                    </div>
                </div>
            </li>
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
            <table class="datatable-init-export nowrap table" data-export-title="Export Data" id="tableDivHead" data-ajaxsource="<?= site_url('inbox/read_hr_review/'.str_replace(array('%20', '&'), array(' ', '-'), $division_status['division_name'])); ?>">
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

