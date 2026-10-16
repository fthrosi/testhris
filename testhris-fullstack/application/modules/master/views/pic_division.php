<ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
    <li class="nav-item">
        <a class="nav-link active" href="#question" role="tab" data-toggle="tab"><em class="icon ni ni-user-circle-fill"></em><span>Notice Period</span></a>
    </li>
</ul>

<div class="nk-ibx-reply nk-reply" data-simplebar>
    <div class="card card-preview responsive-table">
        <div class="tab-content">
                <div class="tab-pane table-responsive active" id="question">
                    <div class="card-inner">
                        <div class="btn-group">
                            <h4>DATA DIVISION PIC</h4>
                        </div>
                        <hr>
                        <span>
                            <a class="text-primary btn btn-icon btn-add-pic-div" data-toggle="modal" data-target="#modalPicDivision" data-offset="-4,0"><em class="icon ni ni-plus-circle"></em> Add Division Pic
                            </a>
                        </span>
                        <br>
                        <table class="nowrap table picdiv-table table-striped display" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Nik</th>
                                    <th>Division</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modalPicDivision">
    <input type="hidden" id="edit_pic_division_id" name="edit_pic_division_id">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Add Division PIC</h5>
                <form action="#" id="form_pic_division" data-mode="add" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="pic_employee">Employee</label>   
                                <div class="form-control-wrap">        
                                    <select required class="form-select select-search_pic_division" name="pic_employee" id="pic_employee">
                                        <option value="">Select employee for PIC</option>
                                        <?php foreach($employee as $e){ ?>
                                            <?php
                                                $name = str_replace("||","'", decrypt($e['complete_name']));
                                                $display_name = $e['nik'] . ' - ' . $name;
                                            ?>
                                            <option value="<?= $e['nik'] ?>"><?= $display_name ?></option>
                                        <?php } ?>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="pic_division">Divisi</label>   
                                <div class="form-control-wrap">        
                                    <select required class="form-select select-search_pic_division" name="pic_division" id="pic_division">
                                        <option value="">Select Division</option>
                                        <?php foreach($division as $d){ ?>
                                            <option value="<?= $d['id'] ?>"><?= $d['name'] ?></option>
                                        <?php } ?>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                    <label class="form-label">Start Date</label>    
                                    <div class="form-control-wrap">        
                                        <input required type="text" class="form-control date-picker" name="start_date_pic_division" id="start_date_pic_division">    
                                    </div>    
                                    <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                    </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">End Date</label>    
                                <div class="form-control-wrap">        
                                    <input type="text" class="form-control date-picker" name="end_date_pic_division" id="end_date_pic_division">    
                                </div>    
                                <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button type="button" class="btn btn-primary" id="save_pic_division">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>