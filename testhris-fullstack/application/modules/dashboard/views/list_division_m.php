<div class="nk-ibx-head">
    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <li class="ml-n2">
                <a href="<?= site_url('dashboard/m'); ?>" class="btn btn-icon btn-tooltip" title="Back">
                    <em class="icon ni ni-arrow-left"></em>
                    Back to Summary
                </a>
            </li>
        </ul>
    </div>
</div>
<br>

<div class="nk-ibx-reply nk-reply" data-simplebar>
    <div class="nk-ibx-reply-group">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block">
                        <div class="row g-gs">

                            <div class="col-xxl-12">
                                <div class="row g-gs">
                                    <div class="col-sm-3">
                                        <div class="card card-bordered">
                                            <div class="card-inner">
                                                <div class="card-title-group align-start mb-2">
                                                    <div class="card-title">
                                                        <h6 class="title text-soft">Total Division</h6>
                                                    </div>
                                                </div>
                                                <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                                    <div class="nk-sale-data">
                                                        <span class="amount">
                                                           <?=$totalDivision;?>
                                                        </span>
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
                                                        <h6 class="title text-soft">HR Confirmed</h6>
                                                    </div>
                                                </div>
                                                <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                                    <div class="nk-sale-data">
                                                        <span class="amount text-primary">
                                                           <?=$hr_confirm;?>
                                                        </span>
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
                                                        <h6 class="title text-soft">In Progress</h6>
                                                    </div>
                                                </div>
                                                <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                                    <div class="nk-sale-data">
                                                        <span class="amount">
                                                            <?=$submitted+$revise;?>
                                                        </span>
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
                                                        <h6 class="title text-soft">Not Submitted Yet</h6>
                                                    </div>
                                                </div>
                                                <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                                    <div class="nk-sale-data">
                                                        <span class="amount text-danger">
                                                            <?=$draft;?>
                                                        </span>
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
                <h5 class="card-title">ALL DIVISION</h5>
                 <strong>EVALUATION PERIOD: <span class="text-primary"> Januari <?=$eval_year = date('Y') - 1;?> - Desember <?=$eval_year = date('Y') - 1;?></span></strong>
            </div>
            <div class="card-inner">
                <table class="nowrap table m-table" data-export-title="Export Data" data-ajaxsource="<?= site_url('dashboard/read_all_division'); ?>">
                <thead>
                    <tr>
                        <th>Division Name</th>
                        <th>Division Head</th>
                        <th>HR Status</th>
                        <th>Response by</th>
                        <th>Response at</th>
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

<div class="modal fade" tabindex="-1" id="modalQuickView">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
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
                                <a onclick="return save_final_score_dashboard();" class="btn btn-dim btn-block btn-primary"><span id="update-final">Update Final Score</span></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


