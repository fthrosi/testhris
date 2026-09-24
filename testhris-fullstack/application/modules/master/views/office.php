<ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
    <li class="nav-item">
        <a class="nav-link active" href="#office_location" data-toggle="tab"><em class="icon ni ni-calendar-fill"></em><span>Set Up Office Location</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#temp_relocation" role="tab" data-toggle="tab"><em class="icon ni ni-user-circle-fill"></em><span>Set Up Temporary Relocation</span></a>
    </li>
</ul><!-- .nav-tabs -->

<div class="nk-ibx-reply nk-reply" data-simplebar>
<div class="card card-preview">
    <div class="tab-content">
        <div class="tab-pane active"  id="office_location">
            <div class="card-inner">
                <div class="btn-group">
                    <h4>Office Locations</h4>
				</div>
                <span>
                    <a class="text-primary btn btn-icon" data-toggle="modal" data-target="#modalTambahOffice" data-offset="-4,0"><em class="icon ni ni-plus-circle"></em> Tambah Office
                    </a>
                </span>
                <!-- <table class="nowrap table office-table table-striped" id="table_office" data-export-title="Export Data" data-ajaxsource="<?= site_url('master/read/office/'); ?>"> -->
                <table class="nowrap table office-table table-striped" id="table_office">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>PA Code</th>
                            <th>Personnel Area</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Address</th>
                            <th>Lattitude</th>
                            <th>Longitude</th>
                            <th>Radius (m)</th>
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
        <div class="tab-pane table-responsive"  id="temp_relocation">
            <div class="card-inner">
                <div class="btn-group">
                    <h4>Temporary Relocation</h4>
                </div>
                <hr>
                <table class="nowrap table employee-table table-striped" id="table_relocation" data-export-title="Export Data" data-ajaxsource="<?= site_url('master/read/relocation/'); ?>">
                <!-- <table class="nowrap table relocation-table table-striped" id="table_relocation"> -->
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Full Name</th>
                            <th>Original PA</th>
                            <th>Relocated PA</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <br>
                <hr>
                <br>
            </div>
            <div class="card-inner">
                <div class="btn-group">
                    <h4>Request Temporary Relocation</h4>
                </div>
                <span>
                    <a class="text-primary btn btn-icon" data-toggle="modal" data-target="#modalTambahRelokasi" data-offset="-4,0"><em class="icon ni ni-plus-circle"></em> Tambah Relokasi
                    </a>
                </span>
                <hr>
                <table class="nowrap table employee-table table-striped" id="table_reloc_req" data-export-title="Export Data" data-ajaxsource="<?= site_url('master/req_reloc_table/'); ?>">
                <!-- <table class="nowrap table relocation-table table-striped" id="table_relocation"> -->
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Request Number</th>
                            <th>Full Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
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

<!-- //////////////////////////////////////////Modal//////////////////////////////////// -->

<!-- /////////////////////////////////////////////Modal Tambah////////////////////////////////////// -->

<div class="modal fade" tabindex="-1" id="modalTambahOffice">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Tambah Office</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Kode PA</label>
                                <input type="text" class="form-control" placeholder="Kode PA (Maks. 4)" name="kode_tambah_office" id="kode_tambah_office" maxlength="4">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Personnel Area</label>
                                <input type="text" class="form-control" placeholder="Personnel Area (Maks. 99)" name="nama_tambah_office" id="nama_tambah_office" maxlength="99">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Start Date</label>
                                <div class="form-control-wrap">        
                                    <input type="text" class="form-control date-picker" name="start_date_tambah_office" id="start_date_tambah_office">    
                                </div>    
                                <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">End Date</label>
                                <div class="form-control-wrap">        
                                    <input type="text" class="form-control date-picker" name="end_date_tambah_office" id="end_date_tambah_office">    
                                </div>    
                                <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Alamat</label>
                                <textarea class="form-control" placeholder="Alamat (Maks. 255)" name="alamat_tambah_office" id="alamat_tambah_office" maxlength="255"></textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Lattitude</label>
                                <input type="text" class="form-control" placeholder="Lattitude" name="lat_tambah_office" id="lat_tambah_office">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Longitude</label>
                                <input type="text" class="form-control" placeholder="Longitude" name="long_tambah_office" id="long_tambah_office">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Radius</label>
                                <input type="text" class="form-control" placeholder="Radius (m)" name="radius_tambah_office" id="radius_tambah_office">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary tambah_office" id="tambah_office">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modalTambahRelokasi">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Tambah Relokasi Sementara</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Employee</label>
                                <div class="form-control-wrap">        
                                    <select class="form-select" name="employee_tambah_relokasi" id="employee_tambah_relokasi">
                                        <option value=" ">Select Employee</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Employee ID</label>
                                <input type="text" class="form-control" name="nik_tambah_relokasi" id="nik_tambah_relokasi" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="nama_tambah_relokasi" id="nama_tambah_relokasi" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Original PA</label>
                                <input type="text" class="form-control" name="pa_awal_tambah_relokasi" id="pa_awal_tambah_relokasi" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Relocated PA</label>
                                <div class="form-control-wrap">        
                                    <select class="form-select" name="pa_akhir_tambah_relokasi" id="pa_akhir_tambah_relokasi">
                                        <option value="">Select Location</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Start Date</label>
                                <div class="form-control-wrap">        
                                    <input type="text" class="form-control date-picker" name="start_date_tambah_relokasi" id="start_date_tambah_relokasi">    
                                </div>    
                                <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">End Date</label>
                                <div class="form-control-wrap">        
                                    <input type="text" class="form-control date-picker" name="end_date_tambah_relokasi" id="end_date_tambah_relokasi">    
                                </div>    
                                <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal">Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary tambah_relokasi" id="tambah_relokasi">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ////////////////////////////////////////Modal Ubah///////////////////////////////////// -->

<div class="modal fade" role="dialog" id="modalEditOffice">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Edit Office</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                    <input type="hidden" class="form-control" required name="id_edit_office" id="id_edit_office">
                    <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Kode PA</label>
                                <input type="text" class="form-control" placeholder="Kode PA (Maks. 4)" name="kode_edit_office" id="kode_edit_office" maxlength="4">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Personnel Area</label>
                                <input type="text" class="form-control" placeholder="Personnel Area (Maks. 99)" name="nama_edit_office" id="nama_edit_office" maxlength="99">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Start Date</label>
                                <div class="form-control-wrap">        
                                    <input type="text" class="form-control date-picker" name="start_date_edit_office" id="start_date_edit_office">    
                                </div>    
                                <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">End Date</label>
                                <div class="form-control-wrap">        
                                    <input type="text" class="form-control date-picker" name="end_date_edit_office" id="end_date_edit_office">    
                                </div>    
                                <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Alamat</label>
                                <textarea class="form-control" placeholder="Alamat (Maks. 255)" name="alamat_edit_office" id="alamat_edit_office" maxlength="255"></textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Lattitude</label>
                                <input type="text" class="form-control" placeholder="Lattitude" name="lat_edit_office" id="lat_edit_office">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Longitude</label>
                                <input type="text" class="form-control" placeholder="Longitude" name="long_edit_office" id="long_edit_office">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Radius</label>
                                <input type="text" class="form-control" placeholder="Radius (m)" name="radius_edit_office" id="radius_edit_office">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary ubah_office" id="ubah_office">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modalEditRelokasi">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Edit Relokasi Sementara</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                    <input type="hidden" class="form-control" required name="id_edit_relokasi" id="id_edit_relokasi">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Employee ID</label>
                                <input type="text" class="form-control" name="nik_edit_relokasi" id="nik_edit_relokasi" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="nama_edit_relokasi" id="nama_edit_relokasi" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Original PA</label>
                                <input type="text" class="form-control" name="pa_awal_edit_relokasi" id="pa_awal_edit_relokasi" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Relocated PA</label>
                                <div class="form-control-wrap">        
                                    <select class="form-select" name="pa_akhir_edit_relokasi" id="pa_akhir_edit_relokasi">
                                        <option value="">Select Location</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Start Date</label>
                                <div class="form-control-wrap">        
                                    <input type="text" class="form-control date-picker" name="start_date_edit_relokasi" id="start_date_edit_relokasi">    
                                </div>    
                                <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">End Date</label>
                                <div class="form-control-wrap">        
                                    <input type="text" class="form-control date-picker" name="end_date_edit_relokasi" id="end_date_edit_relokasi">    
                                </div>    
                                <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal">Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary ubah_relokasi" id="ubah_relokasi">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
