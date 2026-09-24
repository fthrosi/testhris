<ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
    <li class="nav-item">
        <a class="nav-link active" href="#users" data-toggle="tab"><em class="icon ni ni-users-fill"></em><span>Users</span></a>
    </li>
</ul><!-- .nav-tabs -->

<div class="nk-ibx-reply nk-reply" data-simplebar>
<div class="card card-preview">
    <div class="tab-content">
        
            <div class="tab-pane active" id="users">
            <div class="card-inner">
                <div class="btn-group">
						<h4>User</h4>
				</div>
                <span>
                    <a class="text-primary btn btn-icon" data-toggle="modal" data-target="#modalTambahUser" data-offset="-4,0" id="getEmployeeToUsers"><em class="icon ni ni-plus-circle"></em> Tambah User
                    </a>
                </span>
                <table class="nowrap table users-table table-striped" data-export-title="Export Data" id="table_users" data-ajaxsource="<?= site_url('master/read/users/'); ?>">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Employee ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Role</th>
                            <th>Access Level</th>
                            <th>Verification Status</th>
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

<div class="modal fade" tabindex="-1" id="modalTambahUser">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Tambah User</h5>
                <form action="#" id="form_tambah_users" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="Employee-objective">Employee</label>   
                                <div class="form-control-wrap">        
                                    <select class="form-select select-search_user_hris" data-ui="lg" name="full_name_tambah_users" id="full_name_tambah_users">
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
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" readonly placeholder="Email" name="email_tambah" id="email_tambah">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Phone Number</label>
                                <input type="phone" class="form-control" readonly placeholder="Phone Number" name="phone_tambah" id="phone_tambah">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Password</label>
                                <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password_tambah">
                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                    </a>
                                <input autocomplete="new-password" type="password" class="form-control form-control" required value="12345" id="password_tambah" name="password_tambah" placeholder="Enter password">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="kpi-objective">Role</label>   
                                <div class="form-control-wrap">        
                                    <select class="form-select" name="role_tambah" id="role_tambah">
                                    <option value="1">Employee</option>
                                    <option value="12">Admin</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Access Level</label>   
                                <div class="form-control-wrap">        
                                    <select class="form-select" name="access_tambah" id="access_tambah">
                                    <option value="1">Staff</option>
                                    <option value="2">Super Visor</option>
                                    <option value="3">Manager</option>
                                    <option value="4">Dept Head</option>
                                    <option value="5">Div Head</option>
                                    <option value="6">Secretary</option>
                                    <option value="7">Chief</option>
                                    <option value="8">Admin</option>
                                    <option value="9">Div Head HR</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="kpi-objective">Verification Status</label>   
                                <div class="form-control-wrap">        
                                    <select class="form-select" name="verification_tambah" id="verification_tambah">
                                    <option value="0">Employee</option>
                                    <option value="1">Manager</option>
                                    <option value="2">Admin</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary tambah_user" id="tambah_user">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- /////////////////////////////////////////////Modal Edit User////////////////////////////////////// -->

<div class="modal fade" tabindex="-1" id="modalEditUser">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">DATA USER</h5>
                <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                    <li class="nav-item">
                        <a class="nav-link active" href="#edituser" role="tab" data-toggle="tab"><em class="icon ni ni-user-circle-fill"></em><span>EDIT USER</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#passuser" role="tab" data-toggle="tab"><em class="icon ni ni-lock"></em><span>PASSWORD</span></a>
                    </li>
                </ul>

                <input type="hidden" class="form-control" readonly name="edit_id_user" id="edit_id_user">
                
                <div class="tab-content">
                    <div class="tab-pane table-responsive active" id="edituser">
                        <div class="card-inner">
                            <div class="btn-group">

                            <form action="#" id="form_edit_users" class="pt-2 form-validate is-alter">
                                <div class="row gy-3 gx-gs">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label" for="Employee-objective">Employee</label>   
                                            <div class="form-control-wrap">        
                                                <input type="text" class="form-control" readonly placeholder="Employee ID" name="edit_employee_name" id="edit_employee_name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Employee ID</label>
                                            <input type="text" class="form-control" readonly placeholder="Employee ID" name="edit_employee_id" id="edit_employee_id">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" readonly placeholder="Email" name="edit_email" id="edit_email">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Phone Number</label>
                                            <input type="phone" class="form-control" readonly placeholder="Phone Number" name="edit_phone" id="edit_phone">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label" for="kpi-objective">Role</label>   
                                            <div class="form-control-wrap">        
                                                <select class="form-select" name="edit_role" id="edit_role">
                                                <option value="1">Employee</option>
                                                <option value="2">Div Head</option>
                                                <option value="3">Directorate</option>
                                                <option value="4">Directorate CEO</option>
                                                <option value="11">HR</option>
                                                <option value="13">Vision AP/FI</option>
                                                <option value="12">Admin</option>
                                                </select>    
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Access Level</label>   
                                            <div class="form-control-wrap">        
                                                <select class="form-select" name="edit_access" id="edit_access">
                                                <option value="1">Staff</option>
                                                <option value="2">Super Visor</option>
                                                <option value="3">Manager</option>
                                                <option value="4">Dept Head</option>
                                                <option value="5">Div Head</option>
                                                <option value="6">Secretary</option>
                                                <option value="7">Chief</option>
                                                <option value="8">Admin</option>
                                                <option value="9">Div Head HR</option>
                                                </select>    
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label" for="kpi-objective">Verification Status</label>   
                                            <div class="form-control-wrap">        
                                                <select class="form-select" name="edit_verification" id="edit_verification">
                                                <option value="0">Employee</option>
                                                <option value="1">Manager</option>
                                                <option value="2">Admin</option>
                                                </select>    
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <a href="#" class="btn btn-danger" data-dismiss="modal">Cancel</a>
                                            <button data-dismiss="modal" type="button" class="btn btn-primary edit_user" id="edit_user">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            </div>
                            <hr>
                        </div>
                    </div>
                    <div class="tab-pane table-responsive" id="passuser">
                        <div class="card-inner">
                            <form action="#" id="form_password_user" class="pt-2 form-validate is-alter">
                                <div class="row gy-3 gx-gs">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">New Password</label>   
                                                <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch sm" data-target="new_reset_password">
                                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                    </a>
                                                <input autocomplete="new-password" type="password" class="form-control form-control" required id="new_reset_password" name="new_reset_password" placeholder="Enter password">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Password Confirmation</label>
                                            <input type="password" class="form-control" placeholder="Password Confirmation" required name="confirm_reset_password" id="confirm_reset_password">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <a href="#" class="btn btn-danger" data-dismiss="modal">Cancel</a>
                                            <button data-dismiss="modal" type="button" class="btn btn-primary reset_password" id="reset_password">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>                            
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>