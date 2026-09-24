<style>
    .swal-wide{
    width:500px !important;
}
</style>
<ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
    <li class="nav-item">
        <a class="nav-link active" href="#medical_type_of_reimbursment" data-toggle="tab"><em class="icon ni ni-plus-medi-fill"></em><span>Set Up Type of Reimbursment</span></a>
    </li>
</ul><!-- .nav-tabs -->

<div class="nk-ibx-reply nk-reply" data-simplebar>
<div class="card card-preview">
    <div class="tab-content">
        
            <div class="tab-pane active" id="medical_type_of_reimbursment">
            <div class="card-inner">
                
            <div class="btn-group">
						<h4>GRANDPARENT</h4>
				</div>
                <span>
                    <!-- <a class="text-primary btn btn-icon" data-toggle="modal" data-target="#modalTambahGrandParent" data-offset="-4,0"><em class="icon ni ni-plus-circle"></em> Tambah Grandparent
                    </a> -->
                </span>
                <table class="nowrap table grandparent-table table-striped" id="table_grandparent" data-export-title="Export Data" data-ajaxsource="<?= site_url('master/read/grandparent/'); ?>">
                    <thead>
                        <tr>
                            <th>Grandparent</th>
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
            <div class="btn-group">
						<h4>PARENT</h4>
				</div>
                <span>
                    <a class="text-primary btn btn-icon" data-toggle="modal" data-target="#modalTambahParent" data-offset="-4,0"><em class="icon ni ni-plus-circle"></em> Tambah Parent
                    </a>
                </span>
                <table class="nowrap table parent-table table-striped" id="table_parent" data-export-title="Export Data" data-ajaxsource="<?= site_url('master/read/parent/'); ?>">
                    <thead>
                        <tr>
                            <th>Grandparent</th>
                            <th>Parent</th>
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
            <div class="btn-group">
						<h4>CHILD</h4>
				</div>
                <span>
                    <a class="text-primary btn btn-icon" data-toggle="modal" data-target="#modalTambahChild" data-offset="-4,0"><em class="icon ni ni-plus-circle"></em> Tambah Child
                    </a>
                </span>
                <table class="nowrap table child-table table-striped" id="table_child" data-export-title="Export Data" data-ajaxsource="<?= site_url('master/read/child/'); ?>">
                    <thead>
                        <tr>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Grandparent</th>
                            <th>Parent</th>
                            <th>Child</th>
                            <th>Claim Percentage</th>
                            <th>Claim Value</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <br>
                <hr>
            <div class="btn-group">
						<h4>EFEKTIFITAS KUITANSI</h4>
				</div>
                <span>
                    <a class="text-primary btn btn-icon" data-toggle="modal" data-target="#modalTambahEKuitansi" data-offset="-4,0"><em class="icon ni ni-plus-circle"></em> Tambah Hari
                    </a>
                </span>
                <table class="nowrap table e_kuitansi-table table-striped" id="table_e_kuitansi" data-ajaxsource="<?= site_url('master/read/efektifitas_kuitansi/'); ?>">
                    <thead>
                        <tr>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Days</th>
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

<!-- /////////////////////////////////////////////Modal Tambah Grandparent////////////////////////////////////// -->

<div class="modal fade" tabindex="-1" id="modalTambahGrandParent">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Tambah Grandparent</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Grandparent</label>
                                <input type="text" class="form-control" required placeholder="Grandparent" name="grandparent_tambah" id="grandparent_tambah">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <input type="text" class="form-control" placeholder="Description" name="description_grandparent_tambah" id="description_grandparent_tambah">
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary tambah_grandparent" id="tambah_grandparent">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- /////////////////////////////////////////////Modal Tambah Parent////////////////////////////////////// -->

<div class="modal fade modalTambahParent" tabindex="-1" id="modalTambahParent">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Tambah Parent</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="kpi-objective">Grandparent</label>
                                <!-- <a class="text-primary btn btn-icon btn-trigger test" id="test">
                                    <em class="icon ni ni-reload"></em></a> -->
                                <div class="form-control-wrap">        
                                    <select class="form-select parent_grandparent_tambah" name="parent_grandparent_tambah" placeholder="Select Grandparent" id="parent_grandparent_tambah">
                                                <option value="">Select Grandparent</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Parent</label>
                                <input type="text" class="form-control" placeholder="Parent" name="parent_tambah" id="parent_tambah">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <input type="text" class="form-control" placeholder="Description" name="description_parent_tambah" id="description_parent_tambah">
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary tambah_parent" id="tambah_parent">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- /////////////////////////////////////////////Modal Tambah Child////////////////////////////////////// -->

<div class="modal fade" tabindex="-1" id="modalTambahChild">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Tambah Child</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                        <div class="col-6">
                            <div class="form-group">
                                    <label class="form-label">Start Date</label>    
                                    <div class="form-control-wrap">        
                                        <input type="text" class="form-control date-picker" name="start_date_tambah_child" id="start_date_tambah_child">    
                                    </div>    
                                    <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                    </div>
                                    <br>
                                    <label class="form-label">End Date</label>    
                                    <div class="form-control-wrap">        
                                        <input type="text" class="form-control date-picker" name="end_date_tambah_child" id="end_date_tambah_child">    
                                    </div>    
                                    <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                    </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="kpi-objective">Grandparent</label>
                                <!-- <a class="text-primary btn btn-icon btn-trigger test" id="test">
                                    <em class="icon ni ni-reload"></em></a>   -->
                                <div class="form-control-wrap">        
                                    <select class="form-select child_grandparent_tambah" name="child_grandparent_tambah" placeholder="Select Grandparent" id="child_grandparent_tambah">
                                                <option value="">Select Grandparent</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="kpi-objective">Parent</label>
                                <!-- <a class="text-primary btn btn-icon btn-trigger test" id="test">
                                    <em class="icon ni ni-reload"></em></a>    -->
                                <div class="form-control-wrap">        
                                    <select class="form-select child_parent_tambah" name="child_parent_tambah" placeholder="Select Parent" id="child_parent_tambah">
                                                <option value="">Select Parent</option>
                                    </select>     
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Child</label>
                                <input type="text" class="form-control" placeholder="Child" name="child_tambah" id="child_tambah">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Claim Percentage</label>
                                <input type="number" min="1" max="100" class="form-control" min="1" value="100" placeholder="Claim Percentage" name="claim_percentage_child_tambah" id="claim_percentage_child_tambah">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Claim Value</label>
                                <input type="number" class="form-control" min="1" placeholder="Claim Value" name="claim_value_child_tambah" id="claim_value_child_tambah">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <input type="text" class="form-control" placeholder="Description" name="description_child_tambah" id="description_child_tambah">
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary tambah_child" id="tambah_child">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- /////////////////////////////////////////////Modal Tambah Efektif Kuitansi////////////////////////////////////// -->

<div class="modal fade" tabindex="-1" id="modalTambahEKuitansi">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Tambah Hari Efektif</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Hari</label>
                                <input type="number" class="form-control" min="1" placeholder="Hari Efektifitas" name="efektif_kuitansi_tambah" id="efektif_kuitansi_tambah">
                            </div>
                        </div>
                        <div class="form-group">
                                    <label class="form-label">Start Date</label>    
                                    <div class="form-control-wrap">        
                                        <input type="text" class="form-control date-picker" name="start_date_tambah_efektif_kuitansi" id="start_date_tambah_efektif_kuitansi">    
                                    </div>    
                                    <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                    </div>
                                    <br>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary tambah_efektifitas_kuitansi" id="tambah_efektifitas_kuitansi">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<!-- ////////////////////////////////////////Modal Ubah///////////////////////////////////// -->
<!-- /////////////////////////////////////////////Modal Ubah Grandparent////////////////////////////////////// -->

<div class="modal fade" tabindex="-1" id="modalEditGrandParent">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Edit Grandparent</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                    <input type="hidden" class="form-control" required name="id_grandparent_edit" id="id_grandparent_edit">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Grandparent</label>
                                <input type="text" class="form-control" required placeholder="Grandparent" name="grandparent_edit" id="grandparent_edit">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <input type="text" class="form-control" placeholder="Description" name="description_grandparent_edit" id="description_grandparent_edit">
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary ubah_grandparent" id="ubah_grandparent">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- /////////////////////////////////////////////Modal Edit Parent////////////////////////////////////// -->

<div class="modal fade modalEditParent" tabindex="-1" id="modalEditParent">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Edit Parent</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                    <input type="hidden" class="form-control" required name="id_parent_edit" id="id_parent_edit">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="kpi-objective">Grandparent</label>
                                <div class="form-control-wrap">        
                                    <select class="form-select parent_grandparent_edit" name="parent_grandparent_edit" placeholder="Select Grandparent" id="parent_grandparent_edit">
                                            <option value="">Select Parent</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Parent</label>
                                <input type="text" class="form-control" placeholder="Parent" name="parent_edit" id="parent_edit">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <input type="text" class="form-control" placeholder="Description" name="description_parent_edit" id="description_parent_edit">
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary ubah_parent" id="ubah_parent">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- /////////////////////////////////////////////Modal Edit Child////////////////////////////////////// -->

<div class="modal fade" tabindex="-1" id="modalEditChild">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Edit Child</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                    <input type="hidden" class="form-control" required name="id_child_edit" id="id_child_edit">
                        <div class="col-6">
                            <div class="form-group">
                                    <label class="form-label">Start Date</label>    
                                    <div class="form-control-wrap">        
                                        <input type="text" class="form-control date-picker" name="start_date_edit_child" id="start_date_edit_child">    
                                    </div>    
                                    <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                    </div>
                                    <br>
                                    <label class="form-label">End Date</label>    
                                    <div class="form-control-wrap">        
                                        <input type="text" class="form-control date-picker" name="end_date_edit_child" id="end_date_edit_child">    
                                    </div>    
                                    <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                    </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="kpi-objective">Grandparent</label>
                                <!-- <a class="text-primary btn btn-icon btn-trigger test" id="test">
                                    <em class="icon ni ni-reload"></em></a>   -->
                                <div class="form-control-wrap">        
                                    <select class="form-select child_grandparent_edit" name="child_grandparent_edit" placeholder="Select Grandparent" id="child_grandparent_edit">
                                                <option value="">Select Grandparent</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="kpi-objective">Parent</label>
                                <!-- <a class="text-primary btn btn-icon btn-trigger test" id="test">
                                    <em class="icon ni ni-reload"></em></a>    -->
                                <div class="form-control-wrap">        
                                    <select class="form-select child_parent_edit" name="child_parent_edit" placeholder="Select Parent" id="child_parent_edit">
                                                <option value="">Select Parent</option>
                                    </select>     
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Child</label>
                                <input type="text" class="form-control" placeholder="Child" name="child_edit" id="child_edit">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Claim Percentage</label>
                                <input type="number" min="1" max="100" class="form-control" min="1" value="100" placeholder="Claim Percentage" name="claim_percentage_child_edit" id="claim_percentage_child_edit">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Claim Value</label>
                                <input type="number" class="form-control" min="1" placeholder="Claim Value" name="claim_value_child_edit" id="claim_value_child_edit">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <input type="text" class="form-control" placeholder="Description" name="description_child_edit" id="description_child_edit">
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary ubah_child" id="ubah_child">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

