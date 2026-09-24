<ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
    <li class="nav-item">
        <a class="nav-link active" href="#time_off" data-toggle="tab"><em class="icon ni ni-clock-fill"></em><span>Set Up Time-Off</span></a>
    </li>
</ul><!-- .nav-tabs -->

<div class="nk-ibx-reply nk-reply" data-simplebar>
<div class="card card-preview">
    <div class="tab-content">
        
            <div class="tab-pane active"  id="time_management">
            <div class="card-inner">
                
            <div class="btn-group">
						<h4>Type of Time-Off</h4>
				</div>
                <span>
                    <a class="text-primary btn btn-icon" data-toggle="modal" data-target="#modalTambahTimeOff" data-offset="-4,0"><em class="icon ni ni-plus-circle"></em> Tambah Time-Off
                    </a>
                </span>
                <table class="nowrap table time_off-table table-striped" id="table_time_off" data-export-title="Export Data" data-ajaxsource="<?= site_url('master/read/time_off/'); ?>">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Company Name</th>
                            <th>Company Code</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Description</th>
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

<!-- /////////////////////////////////////////////Modal Tambah Pagu Rawat Jalan////////////////////////////////////// -->

<div class="modal fade" tabindex="-1" id="modalTambahTimeOff">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Tambah Time-Off</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Nama Time-Off</label>
                                <input type="text" class="form-control" placeholder="Nama Time-Off (Maks. 99)" name="nama_tambah_time_off" id="nama_tambah_time_off" maxlength="99">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Kode Time-Off</label>
                                <input type="text" class="form-control" placeholder="Kode Time-Off (Maks. 10)" name="kode_tambah_time_off" id="kode_tambah_time_off" maxlength="10">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Nama Perusahaan</label>   
                                <div class="form-control-wrap company_name">        
                                    <select class="form-select" name="company_name_tambah_time_off" id="company_name_tambah_time_off">
                                        <option value="PT. Infrastruktur Bisnis Sejahtera" id="IBS" selected>PT. Infrastruktur Bisnis Sejahtera</option>
                                        <option value="PT. Teknovatus Solusi Sejahtera" id="TSS">PT. Teknovatus Solusi Sejahtera</option>
                                        <option value="PT. Bintang Timur Persada" id="BTP">PT. Bintang Timur Persada</option>
                                        <option value="PT. Tekno Infrastruktur Sukses" id="TIS">PT. Tekno Infrastruktur Sukses</option>
                                        <option value="PT. Integra Putra Mandiri" id="IPM">PT. Integra Putra Mandiri</option>
                                        <option value="PT. Elang Nusantara Air" id="ENA">PT. Elang Nusantara Air</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Kode Perusahaan</label>   
                                <div class="form-control-wrap company_code">        
                                    <select class="form-select" name="company_code_tambah_time_off" id="company_code_tambah_time_off" disabled>
                                        <option value="1200" id="kodeIBS" selected>1200</option>
                                        <option value="1300" id="kodeTSS">1300</option>
                                        <option value="1700" id="kodeBTP">1700</option>
                                        <option value="1800" id="kodeTIS">1800</option>
                                        <option value="2000" id="kodeIPM">2000</option>
                                        <option value="2100" id="kodeENA">2100</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                    <label class="form-label">Start Date</label>    
                                    <div class="form-control-wrap">        
                                        <input type="text" class="form-control date-picker" name="start_date_tambah_time_off" id="start_date_tambah_time_off">    
                                    </div>    
                                    <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                    </div>
                                    <br>
                                    <label class="form-label">End Date</label>    
                                    <div class="form-control-wrap">        
                                        <input type="text" class="form-control date-picker" name="end_date_tambah_time_off" id="end_date_tambah_time_off" disabled>    
                                    </div>    
                                    <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                    </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Deskripsi Time-Off</label>
                                <textarea class="form-control" placeholder="Deskripsi Time-Off (Maksimum input karakter: 99)" name="deskripsi_tambah_time_off" id="deskripsi_tambah_time_off" maxlength="99" onkeyup="inputCountDescTO()"></textarea>
                                <p id="counter_deskripsi">99/99</p>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary tambah_time_off" id="tambah_time_off">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ////////////////////////////////////////Modal Ubah///////////////////////////////////// -->

<div class="modal fade" role="dialog" id="modalEditTimeOff">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Edit Time-Off</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                    <input type="hidden" class="form-control" required name="id_edit_time_off" id="id_edit_time_off">
                    <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Nama Time-Off</label>
                                <input type="text" class="form-control" placeholder="Nama Time-Off" name="nama_edit_time_off" id="nama_edit_time_off">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Kode Time-Off</label>
                                <input type="text" class="form-control" placeholder="Kode Time-Off" name="kode_edit_time_off" id="kode_edit_time_off">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Nama Perusahaan</label>   
                                <div class="form-control-wrap company_name_edit">        
                                    <select class="form-select" name="company_name_edit_time_off" id="company_name_edit_time_off" disabled>
                                        <option value="PT. Inti Bangun Sejahtera, Tbk." id="IBST_edit">PT. Inti Bangun Sejahtera, Tbk.</option>
                                        <option value="PT. Infrastruktur Bisnis Sejahtera" id="IBS_edit">PT. Infrastruktur Bisnis Sejahtera</option>
                                        <option value="PT. Teknovatus Solusi Sejahtera" id="TSS_edit">PT. Teknovatus Solusi Sejahtera</option>
                                        <option value="PT. Bintang Timur Persada" id="BTP_edit">PT. Bintang Timur Persada</option>
                                        <option value="PT. Tekno Infrastruktur Sukses" id="TIS_edit">PT. Tekno Infrastruktur Sukses</option>
                                        <option value="PT. Integra Putra Mandiri" id="IPM_edit">PT. Integra Putra Mandiri</option>
                                        <option value="PT. Elang Nusantara Air" id="ENA_edit">PT. Elang Nusantara Air</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Kode Perusahaan</label>   
                                <div class="form-control-wrap company_code_edit">        
                                    <select class="form-select" name="company_code_edit_time_off" id="company_code_edit_time_off" disabled>
                                        <option value="1100" id="kodeIBST_edit">1100</option>
                                        <option value="1200" id="kodeIBS_edit">1200</option>
                                        <option value="1300" id="kodeTSS_edit">1300</option>
                                        <option value="1700" id="kodeBTP_edit">1700</option>
                                        <option value="1800" id="kodeTIS_edit">1800</option>
                                        <option value="2000" id="kodeIPM_edit">2000</option>
                                        <option value="2100" id="kodeENA_edit">2100</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                    <label class="form-label">Start Date</label>    
                                    <div class="form-control-wrap">        
                                        <input type="text" class="form-control date-picker" name="start_date_edit_time_off" id="start_date_edit_time_off" required>    
                                    </div>    
                                    <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                    </div>
                                    <br>
                                    <label class="form-label">End Date</label>    
                                    <div class="form-control-wrap">        
                                        <input type="text" class="form-control date-picker" name="end_date_edit_time_off" id="end_date_edit_time_off" required>    
                                    </div>    
                                    <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                    </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Deskripsi Time-Off</label>
                                <textarea class="form-control" placeholder="Deskripsi Time-Off" name="deskripsi_edit_time_off" id="deskripsi_edit_time_off"></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary ubah_time_off" id="ubah_time_off">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
