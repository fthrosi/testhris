<ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
    <li class="nav-item">
        <a class="nav-link active" href="#medical_plafon" data-toggle="tab"><em class="icon ni ni-sign-cc-alt"></em><span>Set Up Medical Plafon</span></a>
    </li>
</ul><!-- .nav-tabs -->

<div class="nk-ibx-reply nk-reply" data-simplebar>
<div class="card card-preview">
    <div class="tab-content">
        
            <div class="tab-pane active" id="medical_plafon">
            <div class="card-inner">
                
            <div class="btn-group">
						<h4>RAWAT JALAN</h4>
				</div>
                <span>
                    <a class="text-primary btn btn-icon" data-toggle="modal" data-target="#modalTambahPaguRawatJalan" data-offset="-4,0"><em class="icon ni ni-plus-circle"></em> Tambah Pagu Rawat Jalan
                    </a>
                </span>
                <table class="nowrap table pagu_rawat_jalan-table table-striped" id="table_pagu_rawat_jalan" data-export-title="Export Data" data-ajaxsource="<?= site_url('master/read/pagu_rawat_jalan/'); ?>">
                    <thead>
                        <tr>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Grade</th>
                            <th>Jumlah Maksimal Per Tahun</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <br>
                <hr>
                <br>
            <div class="btn-group">
						<h4>RAWAT INAP</h4>
				</div>
                <span>
                    <a class="text-primary btn btn-icon" data-toggle="modal" data-target="#modalTambahPaguRawatInap" data-offset="-4,0"><em class="icon ni ni-plus-circle"></em> Tambah Pagu Rawat Inap
                    </a>
                </span>
                <table class="nowrap table pagu_rawat_inap-table table-striped" id="table_pagu_rawat_inap" data-export-title="Export Data" data-ajaxsource="<?= site_url('master/read/pagu_rawat_inap/'); ?>">
                    <thead>
                        <tr>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Grade</th>
                            <th>Harga Kamar Maks / Hari</th>
                            <th>Jumlah Maksimal Per Tahun</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <br>
                <hr>
                <br>
            <div class="btn-group">
						<h4>MATERNITY</h4>
				</div>
                <span>
                    <a class="text-primary btn btn-icon" data-toggle="modal" data-target="#modalTambahPaguMaternity" data-offset="-4,0"><em class="icon ni ni-plus-circle"></em> Tambah Pagu Maternity
                    </a>
                </span>
                <table class="nowrap table pagu_maternity-table table-striped" id="table_pagu_maternity" data-export-title="Export Data" data-ajaxsource="<?= site_url('master/read/pagu_maternity/'); ?>">
                    <thead>
                        <tr>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Melahirkan</th>
                            <th>Grade</th>
                            <th>Jumlah Maksimal Per Tahun</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <br>
                <hr>
                <br>
            <div class="btn-group">
						<h4>KACA MATA</h4>
				</div>
                <span>
                    <a class="text-primary btn btn-icon" data-toggle="modal" data-target="#modalTambahPaguKacamata" data-offset="-4,0"><em class="icon ni ni-plus-circle"></em> Tambah Pagu Kacamata
                    </a>
                </span>
                <table class="nowrap table pagu_kacamata-table table-striped" id="table_pagu_kacamata" data-export-title="Export Data" data-ajaxsource="<?= site_url('master/read/pagu_kacamata/'); ?>">
                    <thead>
                        <tr>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Grade</th>
                            <th>Harga Lensa One Focus / 1 Tahun</th>
                            <th>Harga Lensa Two Focus / 1 Tahun</th>
                            <th>Harga Frame Kacamata / 2 Tahun</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <br>
                <hr>
            </div>
            </div>
    </div>
</div>
</div>


<!-- //////////////////////////////////////////Modal//////////////////////////////////// -->

<!-- /////////////////////////////////////////////Modal Tambah Pagu Rawat Jalan////////////////////////////////////// -->

<div class="modal fade" tabindex="-1" id="modalTambahPaguRawatJalan">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Tambah Pagu Rawat Jalan</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                        <div class="col-6">
                            <div class="form-group">
                                <!-- <label class="form-label">Periode</label>
                                <input type="text" class="form-control" required min="1" placeholder="Periode" name="periode_tambah_rawat_jalan" id="periode_tambah_rawat_jalan"> -->
                                    <label class="form-label">Start Date</label>    
                                    <div class="form-control-wrap">        
                                        <input type="text" class="form-control date-picker" name="start_date_tambah_rawat_jalan" id="start_date_tambah_rawat_jalan">    
                                    </div>    
                                    <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                    </div>
                                    <br>
                                    <label class="form-label">End Date</label>    
                                    <div class="form-control-wrap">        
                                        <input type="text" class="form-control date-picker" name="end_date_tambah_rawat_jalan" id="end_date_tambah_rawat_jalan">    
                                    </div>    
                                    <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                    </div>
                                
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="kpi-objective">Grade</label>   
                                <div class="form-control-wrap">        
                                    <select class="form-select" name="grade_tambah_rawat_jalan" id="grade_tambah_rawat_jalan">
                                    <option value="GOL A">GOL A</option>
                                    <option value="GOL B">GOL B</option>
                                    <option value="GOL C">GOL C</option>
                                    <option value="GOL D">GOL D</option>
                                    <option value="GOL E">GOL E</option>
                                    <option value="GOL F">GOL F</option>
                                    <option value="GOL G">GOL G</option>
                                    <option value="GOL H">GOL H</option>
                                    <option value="GOL I">GOL I</option>
                                    <option value="GOL J">GOL J</option>
                                    <option value="GOL K">GOL K</option>
                                    <option value="GOL L">GOL L</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Jumlah Maksimal Per Tahun</label>
                                <input type="number" class="form-control" required min="1" placeholder="Jumlah Maksimal Per Tahun" name="pagu_tahun_tambah_rawat_jalan" id="pagu_tahun_tambah_rawat_jalan">
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary tambah_pagu_rawat_jalan" id="tambah_pagu_rawat_jalan">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- /////////////////////////////////////////////Modal Tambah Pagu Rawat Inap////////////////////////////////////// -->

<div class="modal fade" tabindex="-1" id="modalTambahPaguRawatInap">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Tambah Pagu Rawat Inap</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                        <div class="col-6">
                            <div class="form-group">
                                <!-- <label class="form-label">Periode</label>
                                <input type="text" class="form-control" required min="1" placeholder="Periode" name="periode_tambah_rawat_inap" id="periode_tambah_rawat_inap"> -->
                                    <label class="form-label">Start Date</label>    
                                    <div class="form-control-wrap">        
                                        <input type="text" class="form-control date-picker" name="start_date_tambah_rawat_inap" id="start_date_tambah_rawat_inap">    
                                    </div>    
                                    <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                    </div>
                                    <br>
                                    <label class="form-label">End Date</label>    
                                    <div class="form-control-wrap">        
                                        <input type="text" class="form-control date-picker" name="end_date_tambah_rawat_inap" id="end_date_tambah_rawat_inap">    
                                    </div>    
                                    <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                    </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="kpi-objective">Grade</label>   
                                <div class="form-control-wrap">        
                                    <select class="form-select" name="grade_tambah_rawat_inap" id="grade_tambah_rawat_inap">
                                    <option value="GOL A">GOL A</option>
                                    <option value="GOL B">GOL B</option>
                                    <option value="GOL C">GOL C</option>
                                    <option value="GOL D">GOL D</option>
                                    <option value="GOL E">GOL E</option>
                                    <option value="GOL F">GOL F</option>
                                    <option value="GOL G">GOL G</option>
                                    <option value="GOL H">GOL H</option>
                                    <option value="GOL I">GOL I</option>
                                    <option value="GOL J">GOL J</option>
                                    <option value="GOL K">GOL K</option>
                                    <option value="GOL L">GOL L</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Harga Kamar Maks / Hari</label>
                                <input type="number" class="form-control" required min="1" placeholder="Harga Kamar Maks / Hari" name="pagu_kamar_tambah_rawat_inap" id="pagu_kamar_tambah_rawat_inap">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Jumlah Maksimal Per Tahun</label>
                                <input type="number" class="form-control" required min="1" placeholder="Jumlah Maksimal Per Tahun" name="pagu_tahun_tambah_rawat_inap" id="pagu_tahun_tambah_rawat_inap">
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary tambah_pagu_rawat_inap" id="tambah_pagu_rawat_inap">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- /////////////////////////////////////////////Modal Tambah Pagu Maternity////////////////////////////////////// -->

<div class="modal fade" tabindex="-1" id="modalTambahPaguMaternity">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Tambah Pagu Maternity</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                        <div class="col-6">
                            <div class="form-group">
                                <!-- <label class="form-label">Periode</label>
                                <input type="text" class="form-control" required min="1" placeholder="Periode" name="periode_tambah_rawat_inap" id="periode_tambah_rawat_inap"> -->
                                    <label class="form-label">Start Date</label>    
                                    <div class="form-control-wrap">        
                                        <input type="text" class="form-control date-picker" name="start_date_tambah_maternity" id="start_date_tambah_maternity">    
                                    </div>    
                                    <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                    </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                    <label class="form-label">End Date</label>    
                                    <div class="form-control-wrap">        
                                        <input type="text" class="form-control date-picker" name="end_date_tambah_maternity" id="end_date_tambah_maternity">    
                                    </div>    
                                    <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                    </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="kpi-objective">Melahirkan</label>   
                                <div class="form-control-wrap">        
                                    <select class="form-select" name="melahirkan_tambah_maternity" id="melahirkan_tambah_maternity">
                                    <option value="Normal">Normal</option>
                                    <option value="Caesar">Caesar</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="kpi-objective">Grade</label>   
                                <div class="form-control-wrap">        
                                    <select class="form-select" name="grade_tambah_maternity" id="grade_tambah_maternity">
                                    <option value="GOL A">GOL A</option>
                                    <option value="GOL B">GOL B</option>
                                    <option value="GOL C">GOL C</option>
                                    <option value="GOL D">GOL D</option>
                                    <option value="GOL E">GOL E</option>
                                    <option value="GOL F">GOL F</option>
                                    <option value="GOL G">GOL G</option>
                                    <option value="GOL H">GOL H</option>
                                    <option value="GOL I">GOL I</option>
                                    <option value="GOL J">GOL J</option>
                                    <option value="GOL K">GOL K</option>
                                    <option value="GOL L">GOL L</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Jumlah Maksimal Per Tahun</label>
                                <input type="number" class="form-control" required min="1" placeholder="Jumlah Maksimal Per Tahun" name="pagu_tahun_tambah_maternity" id="pagu_tahun_tambah_maternity">
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary tambah_pagu_maternity" id="tambah_pagu_maternity">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- /////////////////////////////////////////////Modal Tambah Pagu Kacamata////////////////////////////////////// -->

<div class="modal fade" tabindex="-1" id="modalTambahPaguKacamata">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Tambah Pagu Kacamata</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                        <div class="col-6">
                            <div class="form-group">
                                <!-- <label class="form-label">Periode</label>
                                <input type="text" class="form-control" required min="1" placeholder="Periode" name="periode_tambah_kacamata" id="periode_tambah_kacamata"> -->
                                <label class="form-label">Start Date</label>    
                                <div class="form-control-wrap">        
                                    <input type="text" class="form-control date-picker" name="start_date_tambah_kacamata" id="start_date_tambah_kacamata">    
                                </div>    
                                <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                </div>
                                <br>
                                <label class="form-label">End Date</label>    
                                <div class="form-control-wrap">        
                                    <input type="text" class="form-control date-picker" name="end_date_tambah_kacamata" id="end_date_tambah_kacamata">    
                                </div>    
                                <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="kpi-objective">Grade</label>   
                                <div class="form-control-wrap">        
                                    <select class="form-select" name="grade_tambah_kacamata" id="grade_tambah_kacamata">
                                    <option value="GOL A">GOL A</option>
                                    <option value="GOL B">GOL B</option>
                                    <option value="GOL C">GOL C</option>
                                    <option value="GOL D">GOL D</option>
                                    <option value="GOL E">GOL E</option>
                                    <option value="GOL F">GOL F</option>
                                    <option value="GOL G">GOL G</option>
                                    <option value="GOL H">GOL H</option>
                                    <option value="GOL I">GOL I</option>
                                    <option value="GOL J">GOL J</option>
                                    <option value="GOL K">GOL K</option>
                                    <option value="GOL L">GOL L</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <h6>Harga Lensa Per 1 Tahun</h6>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Harga Lensa One Focus</label>
                                <input type="number" class="form-control" required min="1" placeholder="Harga Lensa One Focus" name="pagu_lensa_one_focus_tambah_kacamata" id="pagu_lensa_one_focus_tambah_kacamata">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Harga Lensa Two Focus</label>
                                <input type="number" class="form-control" required min="1" placeholder="Harga Lensa Two Focus" name="pagu_lensa_two_focus_tambah_kacamata" id="pagu_lensa_two_focus_tambah_kacamata">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <h6>Harga Frame Per 2 Tahun</h6>
                                <hr>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Harga Frame Kacamata Per 2 Tahun</label>
                                <input type="number" class="form-control" required min="1" placeholder="Harga Frame Kacamata Per 2 Tahun" name="pagu_frame_tambah_kacamata" id="pagu_frame_tambah_kacamata">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary tambah_pagu_kacamata" id="tambah_pagu_kacamata">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>





<!-- ////////////////////////////////////////Modal Ubah///////////////////////////////////// -->

<div class="modal fade" role="dialog" id="modalEditPaguRawatJalan">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Edit Pagu Rawat Jalan</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                    <input type="hidden" class="form-control" required name="id_edit_rawat_jalan" id="id_edit_rawat_jalan">
                        <div class="col-6">
                            <div class="form-group">
                                <!-- <label class="form-label">Periode</label>
                                <input type="text" class="form-control" required min="1" placeholder="Periode" name="periode_edit_rawat_jalan" id="periode_edit_rawat_jalan"> -->
                                <div class="form-control-wrap">        
                                    <input type="text" class="form-control date-picker" name="start_date_edit_rawat_jalan" id="start_date_edit_rawat_jalan">    
                                </div>    
                                <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                </div>
                                <br>
                                <label class="form-label">End Date</label>    
                                <div class="form-control-wrap">        
                                    <input type="text" class="form-control date-picker" name="end_date_edit_rawat_jalan" id="end_date_edit_rawat_jalan">    
                                </div>    
                                <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="grade-objective">Grade</label>   
                                <div class="form-control-wrap">        
                                    <select class="form-select" name="grade_edit_rawat_jalan" disabled id="grade_edit_rawat_jalan">    
                                    <option value="GOL A">GOL A</option>
                                    <option value="GOL B">GOL B</option>
                                    <option value="GOL C">GOL C</option>
                                    <option value="GOL D">GOL D</option>
                                    <option value="GOL E">GOL E</option>
                                    <option value="GOL F">GOL F</option>
                                    <option value="GOL G">GOL G</option>
                                    <option value="GOL H">GOL H</option>
                                    <option value="GOL I">GOL I</option>
                                    <option value="GOL J">GOL J</option>
                                    <option value="GOL K">GOL K</option>
                                    <option value="GOL L">GOL L</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Jumlah Maksimal Per Tahun</label>
                                <input type="number" class="form-control" required min="1" placeholder="Jumlah Maksimal Per Tahun" name="pagu_tahun_edit_rawat_jalan" id="pagu_tahun_edit_rawat_jalan">
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary ubah_pagu_rawat_jalan" id="ubah_pagu_rawat_jalan">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" id="modalEditPaguRawatInap">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Edit Pagu Rawat Inap</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                    <input type="hidden" class="form-control" required name="id_edit_rawat_inap" id="id_edit_rawat_inap">
                        <div class="col-6">
                            <div class="form-group">
                                <!-- <label class="form-label">Periode</label>
                                <input type="text" class="form-control" required min="1" placeholder="Periode" name="periode_edit_rawat_inap" id="periode_edit_rawat_inap"> -->
                                <div class="form-control-wrap">        
                                    <input type="text" class="form-control date-picker" name="start_date_edit_rawat_inap" id="start_date_edit_rawat_inap">    
                                </div>    
                                <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                </div>
                                <br>
                                <label class="form-label">End Date</label>    
                                <div class="form-control-wrap">        
                                    <input type="text" class="form-control date-picker" name="end_date_edit_rawat_inap" id="end_date_edit_rawat_inap">    
                                </div>    
                                <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="kpi-objective">Grade</label>   
                                <div class="form-control-wrap">        
                                    <select class="form-select" name="grade_edit_rawat_inap" disabled id="grade_edit_rawat_inap">
                                    <option value="GOL A">GOL A</option>
                                    <option value="GOL B">GOL B</option>
                                    <option value="GOL C">GOL C</option>
                                    <option value="GOL D">GOL D</option>
                                    <option value="GOL E">GOL E</option>
                                    <option value="GOL F">GOL F</option>
                                    <option value="GOL G">GOL G</option>
                                    <option value="GOL H">GOL H</option>
                                    <option value="GOL I">GOL I</option>
                                    <option value="GOL J">GOL J</option>
                                    <option value="GOL K">GOL K</option>
                                    <option value="GOL L">GOL L</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Harga Kamar Maks / Hari</label>
                                <input type="number" class="form-control" required min="1" placeholder="Harga Kamar Maks / Hari" name="pagu_kamar_edit_rawat_inap" id="pagu_kamar_edit_rawat_inap">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Jumlah Maksimal Per Tahun</label>
                                <input type="number" class="form-control" required min="1" placeholder="Jumlah Maksimal Per Tahun" name="pagu_tahun_edit_rawat_inap" id="pagu_tahun_edit_rawat_inap">
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary ubah_pagu_rawat_inap" id="ubah_pagu_rawat_inap">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modalEditPaguMaternity">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Edit Pagu Maternity</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                    <input type="hidden" class="form-control" required name="id_edit_maternity" id="id_edit_maternity">
                        <div class="col-6">
                            <div class="form-group">
                                <!-- <label class="form-label">Periode</label>
                                <input type="text" class="form-control" required min="1" placeholder="Periode" name="periode_edit_rawat_inap" id="periode_edit_rawat_inap"> -->
                                <label class="form-label">Start Date</label>    
                                <div class="form-control-wrap">        
                                    <input type="text" class="form-control date-picker" name="start_date_edit_maternity" id="start_date_edit_maternity">    
                                </div>    
                                <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">End Date</label>    
                                <div class="form-control-wrap">        
                                    <input type="text" class="form-control date-picker" name="end_date_edit_maternity" id="end_date_edit_maternity">    
                                </div>    
                                <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="melahirkan_edit_maternity">Melahirkan</label>   
                                <div class="form-control-wrap">        
                                    <select class="form-select" disabled name="melahirkan_edit_maternity" id="melahirkan_edit_maternity">
                                    <option value="Normal">Normal</option>
                                    <option value="Caesar">Caesar</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="grade_edit_maternity">Grade</label>   
                                <div class="form-control-wrap">        
                                    <select class="form-select" name="grade_edit_maternity" disabled id="grade_edit_maternity">
                                    <option value="GOL A">GOL A</option>
                                    <option value="GOL B">GOL B</option>
                                    <option value="GOL C">GOL C</option>
                                    <option value="GOL D">GOL D</option>
                                    <option value="GOL E">GOL E</option>
                                    <option value="GOL F">GOL F</option>
                                    <option value="GOL G">GOL G</option>
                                    <option value="GOL H">GOL H</option>
                                    <option value="GOL I">GOL I</option>
                                    <option value="GOL J">GOL J</option>
                                    <option value="GOL K">GOL K</option>
                                    <option value="GOL L">GOL L</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Jumlah Maksimal Per Tahun</label>
                                <input type="number" class="form-control" required min="1" placeholder="Jumlah Maksimal Per Tahun" name="pagu_tahun_edit_maternity" id="pagu_tahun_edit_maternity">
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary ubah_pagu_maternity" id="ubah_pagu_maternity">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modalEditPaguKacamata">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Edit Pagu Kacamata</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                    <input type="hidden" class="form-control" required name="id_edit_kacamata" id="id_edit_kacamata">
                        <div class="col-6">
                            <div class="form-group">
                                <!-- <label class="form-label">Periode</label>
                                <input type="text" class="form-control" required min="1" placeholder="Periode" name="periode_edit_kacamata" id="periode_edit_kacamata"> -->
                                <div class="form-control-wrap">        
                                    <input type="text" class="form-control date-picker" name="start_date_edit_kacamata" id="start_date_edit_kacamata">    
                                </div>    
                                <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                </div>
                                <br>
                                <label class="form-label">End Date</label>    
                                <div class="form-control-wrap">        
                                    <input type="text" class="form-control date-picker" name="end_date_edit_kacamata" id="end_date_edit_kacamata">    
                                </div>    
                                <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="kpi-objective">Grade</label>   
                                <div class="form-control-wrap">        
                                    <select class="form-select" name="grade_edit_kacamata" disabled id="grade_edit_kacamata">
                                    <option value="GOL A">GOL A</option>
                                    <option value="GOL B">GOL B</option>
                                    <option value="GOL C">GOL C</option>
                                    <option value="GOL D">GOL D</option>
                                    <option value="GOL E">GOL E</option>
                                    <option value="GOL F">GOL F</option>
                                    <option value="GOL G">GOL G</option>
                                    <option value="GOL H">GOL H</option>
                                    <option value="GOL I">GOL I</option>
                                    <option value="GOL J">GOL J</option>
                                    <option value="GOL K">GOL K</option>
                                    <option value="GOL L">GOL L</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <h6>Harga Lensa Per 1 Tahun</h6>
                                <hr>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Harga Lensa One Focus</label>
                                <input type="number" class="form-control" required min="1" placeholder="Harga Lensa One Focus" name="pagu_lensa_one_focus_edit_kacamata" id="pagu_lensa_one_focus_edit_kacamata">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Harga Lensa Two Focus</label>
                                <input type="number" class="form-control" required min="1" placeholder="Harga Lensa Two Focus" name="pagu_lensa_two_focus_edit_kacamata" id="pagu_lensa_two_focus_edit_kacamata">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <h6>Harga Frame Per 2 Tahun</h6>
                                <hr>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Harga Frame Kacamata Per 2 Tahun</label>
                                <input type="number" class="form-control" required min="1" placeholder="Harga Frame Kacamata Per 2 Tahun" name="pagu_frame_edit_kacamata" id="pagu_frame_edit_kacamata">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary ubah_pagu_kacamata" id="ubah_pagu_kacamata">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>