<div class="nk-ibx-head">
    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <li>
                <a href="<?= site_url('report/attendance'); ?>" class="btn btn-icon btn-trigger"><em class="icon ni ni-arrow-left"></em></a>
            </li>
        </ul>
    </div>
    <div style="margin:0 auto;">
            <h4>Leave Balance Report</h4>
    </div>
</div>
<div class="nk-ibx-reply nk-reply" data-simplebar>
    <div class="card card-preview">
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="card-inner">
                    <div class="pb-4 d-flex">
                        <div class="pl-0 col-4">
                            <div class="form-group">
                                <label class="form-label">Department</label>   
                                <div class="form-control-wrap">        
                                    <select class="form-select" name="tm_report_head_department[]" id="tm_report_head_department" multiple="multiple">
                                        
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label class="form-label">Employee</label>   
                                <div class="form-control-wrap employee">        
                                    <select class="form-select" name="tm_report_head_employee[]" id="tm_report_head_employee" multiple="multiple">

                                    </select>    
                                </div>
                            </div>
                        </div> 
                    </div>
                    <table class="nowrap table tm_report-table table-striped" id="table_tm_report_head" data-ajaxsource="<?= site_url('report/tm_report_table_head'); ?>">
                        <thead>
                            <tr>
                                <th>Employee ID</th>
                                <th>Employee Name</th>
                                <th>Company Name</th>
                                <th>Department</th>
                                <th>Balance</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <br>
                    <hr>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- //////////////////////////////////////////// MODAL //////////////////////////////////////////// -->
<div class="modal fade" tabindex="-1" id="modalDetailBalance">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Balance Log</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="card card-preview">
                        <div class="tab-content">
                
                                <div class="card-inner">
                                <div class="pb-2" id='nama_detail_log'>
                                    <h4></h4>
                                </div>
                                <table class="nowrap table log_balance-table table-striped" id="table_detail_balance_log">
                                    <thead>
                                        <tr>
                                            <th>Created At</th>
                                            <th>Name</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Total</th>
                                            <th>Change Log</th>
                                            <th>Status</th>
                                            <th>Updated At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                </div>  
                        
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>