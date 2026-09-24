<ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
    <li class="nav-item">
        <a class="nav-link active" href="#mul_div" data-toggle="tab"><em class="icon ni ni-users-fill"></em><span>Multiple Divisions</span></a>
    </li>
</ul><!-- .nav-tabs -->

<div class="nk-ibx-reply nk-reply" data-simplebar>
<div class="card card-preview">
    <div class="tab-content">
        
            <div class="tab-pane active" id="mul_div">
            <div class="card-inner">
                <div class="btn-group">
						<h4>Division Responsible</h4>
				</div>
                <span>
                    <a class="text-primary btn btn-icon" data-toggle="modal" data-target="#modalTambahMulDivision" data-offset="-4,0" id="getEmployeeToDivisions"><em class="icon ni ni-plus-circle"></em> Add
                    </a>
                </span>
                <br>
                <br>
                <table class="nowrap table mulDiv-table table-striped" data-export-title="Export Data" id="table_list_mul_div" data-ajaxsource="<?= site_url('master/read/mulDiv/'); ?>">
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Division</th>
                            <th>Years</th>
                            <!-- <th>Created At</th> -->
                            <th>Action</th>
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


<!-- /////////////////////////////////////////////Modal Tambah Division////////////////////////////////////// -->

<div class="modal fade" tabindex="-1" id="modalTambahMulDivision">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <form action="#" id="form_tambah_mul_div" class="pt-2 form-validate is-alter">
            <div class="modal-body modal-body-md">
                <h5 class="title">Division Responsible</h5>
                <br>
                <div class="row gy-3 gx-gs">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label" for="Employee-objective">Employee</label>   
                            <div class="form-control-wrap">        
                                <select class="form-select select-search_user_division" data-ui="lg" name="full_name_tambah_mul_div" id="full_name_tambah_mul_div">
                                    <option value="">Select Employee</option>
                                </select>    
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Employee ID</label>
                            <input type="text" class="form-control" readonly placeholder="Employee ID" name="employee_id_tambah" id="employee_id_tambah">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label" for="Employee-objective">Division</label>   
                            <div class="form-control-wrap">        
                                <select class="form-select select-search_division" data-ui="lg" name="tambah_divisi" id="tambah_divisi">
                                    <option value="">Select Division</option>
                                </select>    
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Year</label>   
                            <div class="form-control-wrap">        
                                <input type="text" class="form-control" name="year_picker" id="year_picker">    
                            </div>    
                        </div>
                    </div>
                </div>
                <hr>
                    <div class="col-12">
                        <div class="form-group">
                            <a id="cancel_tambah_rpm" class="btn btn-dim btn-danger" data-dismiss="modal"> Cancel</a>
                            <button type="button" class="btn btn-primary add_multi_divisions" id="add_multi_divisions"><span id="text-save-rpm">Add</span></button>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>