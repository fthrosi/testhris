<div class="nk-ibx-reply nk-reply" data-simplebar>
<div class="card card-preview">
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="card-inner">
                <div class="pb-4 d-flex">
                    <div class="pl-0 col-2">
                        <div class="form-group">
                            <label class="form-label">Status</label>   
                            <div class="form-control-wrap">        
                                <select class="form-select" name="tm_report_status" id="tm_report_status">
                                    <option value="active" selected>Active</option>
                                    <option value="leaving">Leaving</option>
                                </select>    
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-label">Select Branch</label>   
                            <div class="form-control-wrap">        
                                <select class="form-select" name="tm_report_branch" id="tm_report_branch">
                                    <option value=""></option>
                                </select>    
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label class="form-label">Balance Type</label>   
                            <div class="form-control-wrap">        
                                <select class="form-select" name="tm_report_balance_type" id="tm_report_balance_type">
                                    <option value="all">All</option>
                                    <option value="plus">Plus</option>
                                    <option value="minus">Minus</option>
                                </select>    
                            </div>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label class="form-label">Employee</label>   
                            <div class="form-control-wrap employee">        
                                <select class="form-select" name="tm_report_employee[]" id="tm_report_employee" multiple="multiple">

                                </select>    
                            </div>
                        </div>
                    </div>
                    <input type="hidden" value="<?=$this->session->userdata('company_code')?>" id="company_code" name="company_code">
                </div>
                <table class="nowrap table tm_report-table table-striped" id="table_tm_report">
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Employee Name</th>
                            <th>Company Name</th>
                            <th>Balance</th>
                            <th>Period</th>
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
                                            <th>No</th>
                                            <th>Created At</th>
                                            <th>Name</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Total</th>
                                            <th>Change Log</th>
                                            <th>Status</th>
                                            <th>Documents</th>
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