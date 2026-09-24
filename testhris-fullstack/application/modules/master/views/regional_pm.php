<ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
    <li class="nav-item">
        <a class="nav-link active" href="#users" data-toggle="tab"><em class="icon ni ni-users-fill"></em><span>Regional Project Manager</span></a>
    </li>
</ul><!-- .nav-tabs -->

<div class="nk-ibx-reply nk-reply" data-simplebar>
<div class="card card-preview">
    <div class="tab-content">
        
            <div class="tab-pane active" id="users">
            <div class="card-inner">
                <div class="btn-group">
						<h4>Regional Project Manager</h4>
				</div>
                <span>
                    <a class="text-primary btn btn-icon" data-toggle="modal" data-target="#modalTambahRPM" data-offset="-4,0"><em class="icon ni ni-plus-circle"></em> Tambah
                    </a>
                </span>
                <table class="nowrap table table-striped" data-export-title="Export Data" id="table_list_rpm" data-ajaxsource="<?= site_url('master/read/rpm/'); ?>">
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Region</th>
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


<!-- /////////////////////////////////////////////Modal Tambah Users////////////////////////////////////// -->

<div class="modal fade" tabindex="-1" id="modalTambahRPM">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Tambah RPM</h5>
                <div class="row gy-3 gx-gs">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Employee ID</label>
                            <input type="number" oninput="maxLengthCheck(this)" maxlength="8" min="1" max="8" onkeypress="return isNumeric(event)" name="rpm_employee_id" id="rpm_employee_id" class="form-control" placeholder="Input NIK then press Enter">
                            <span class="text-danger" id="rpm_not_found"></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Full Name</label>
                            <input type="text" readonly class="form-control" placeholder="Full Name" name="rpm_full_name" id="rpm_full_name">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" readonly class="form-control" placeholder="Email" name="rpm_email" id="rpm_email">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Region</label>   
                            <div class="form-control-wrap">        
                                <select class="form-select" name="rpm_region" id="rpm_region">
                                <option value="">Select</option>
                                <option value="JABO">Jabodetabek</option>
                                <option value="WJ">West Java</option>
                                <option value="EJ">East Java</option>
                                <option value="CJ">Central Java</option>
                                <option value="SS">South Sumatera</option>
                                <option value="NS">North Sumatera</option>
                                <option value="SUL">Sulawesi</option>
                                <option value="KAL">Kalimantan</option>
                                </select>    
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="col-12">
                        <div class="form-group">
                            <a id="cancel_tambah_rpm" class="btn btn-dim btn-danger" data-dismiss="modal"> Cancel</a>
                            <button type="button" class="btn btn-primary add_rpm" id="add_rpm"><span id="text-save-rpm">Save</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>