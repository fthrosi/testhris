<div class="nk-ibx-head">
    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <li>
                <?php
                    $nik = $InfoEmployee[0]->nik;
                    $time = date("H");
                    $timezone = date("e");
                    if ($time < "12") {
                        $say = "Good Morning";
                    } else if ($time >= "12" && $time < "17") {
                        $say = "Good Afternoon";
                    } else if ($time >= "17" && $time < "19") {
                        $say = "Good Evening";
                    } else if ($time >= "19") {
                        $say = "Good Night";
                    }
                ?>
                <h5>
		                <b>					
							<?= $say.", ".decrypt($InfoEmployee[0]->complete_name) ?>
                        </b>
				                <br>
			
                </h5>
					                <?= "It's ".$today = date("l, M j Y"); ?>
				                <!-- <a href="<?= site_url('dashboard'); ?>" class="btn btn-icon btn-trigger"><em class="icon ni ni-undo"></em></a> -->
            </li>
        </ul>
    </div>
    <div>

        <ul class="nk-ibx-head-tools g-1">
            <li class="mr-n1 d-lg-none">
                <a href="#" class="btn btn-trigger btn-icon toggle" data-target="inbox-aside"><em
                        class="icon ni ni-menu-alt-r"></em></a>
            </li>
        </ul>
    </div>
</div>

<ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
    <li class="nav-item">
        <a class="nav-link active" href="#info" data-toggle="tab"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
        </svg>&nbsp;&nbsp;<span>Informations</span></a>
    </li>
</ul><!-- .nav-tabs -->

<div class="nk-ibx-reply nk-reply" data-simplebar>
<div class="card card-preview">
    <div class="tab-content table-responsive">
            <div class="tab-pane active"  id="info_management">
            <div class="card-inner">
                
            <div class="btn-group">
						<h4>Employee Information</h4>
				</div>
                <?php
                $nik = $this->session->userdata('employee_id');
                if($this->session->userdata('access_level') == '7' || $nik == '20180026' || $nik == '20180076'){
                ?>
                <span>
                    <a class="text-primary btn btn-icon" data-toggle="modal" data-target="#modalAddInfo" data-offset="-4,0"><em class="icon ni ni-plus-circle"></em> Add Info
                    </a>
                </span>
                <?php 
                }    
                ?>
                <br>
                <br>
                <table class="table info-table table-bordered table-responsive" id="info" data-ajaxsource="<?= site_url('master/information/read/info/'); ?>">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Content of Information</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Created By</th>
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
<div class="modal fade" tabindex="-1" id="modalAddInfo">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Add Information</h5>
                <form action="#" class="pt-2 form-validate is-alter" id="AddInfo">
                    <div class="row gy-3 gx-gs">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Category</label>   
                                <div class="form-control-wrap category_info">        
                                    <select class="form-select" name="category_info" id="category_info">
                                        <option value="1" id="Information" selected>Information</option>
                                        <option value="2" id="Attention">Attention</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Content of Information</label>
                                <textarea class="form-control" placeholder="Content of Information (Min Input : 50, Max input : 150)" name="c_info" id="c_info" minlength="50" maxlength="150" onkeyup="inputCountInfo()"></textarea>
                                <p id="counter_info">150/150</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Start Date</label>    
                                <div class="form-control-wrap">        
                                    <input type="text" readonly class="form-control date-picker" name="start_date_info" id="start_date_info">    
                                </div>    
                                <label class="form-label">End Date</label>    
                                <div class="form-control-wrap">        
                                    <input type="text" readonly class="form-control date-picker" name="end_date_info" id="end_date_info">    
                                </div>    
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary add_info" id="add_info">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>