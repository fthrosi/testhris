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
        <a class="nav-link active" href="#time_off" data-toggle="tab"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-phone" viewBox="0 0 16 16">
        <path d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
        <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
        </svg>&nbsp;&nbsp;<span>Apps Versions</span></a>
    </li>
</ul><!-- .nav-tabs -->

<div class="nk-ibx-reply nk-reply" data-simplebar>
<div class="card card-preview">
    <div class="tab-content table-responsive">
            <div class="tab-pane active"  id="time_management">
            <div class="card-inner">
                
            <div class="btn-group">
						<h4>Apps Versions</h4>
				</div>
                <?php
                $nik = $this->session->userdata('employee_id');
                if($this->session->userdata('access_level') == '7' || $nik == '20180026' || $nik == '20180076'){
                ?>
                <span>
                    <a class="text-primary btn btn-icon" data-toggle="modal" data-target="#modalAddVersions" data-offset="-4,0"><em class="icon ni ni-plus-circle"></em> Add Versions
                    </a>
                </span>
                <?php 
                }    
                ?>
                <br>
                <br>
                <table class="table arv-table table-bordered table-responsive" id="arv" data-ajaxsource="<?= site_url('master/arv/read/arv/'); ?>">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Versions Numbers</th>
                            <th>OS (Operating System)</th>
                            <th>Release Date</th>
                            <th>Version Description Document</th>
                            <th>Download</th>
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
<div class="modal fade" tabindex="-1" id="modalAddVersions">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Add Versions</h5>
                <form action="#" class="pt-2 form-validate is-alter" id="AddVersions">
                    <div class="row gy-3 gx-gs">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Versions Numbers</label>
                                <input type="text" class="form-control" autocomplete="off" placeholder="Versions Numbers" name="versions_numbers" id="versions_numbers" maxlength="10">
                                <p><i>Exp : 4.9.011 (Major.Minor.Revision)</i></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">OS (Operating System)</label>   
                                <div class="form-control-wrap company_name">        
                                    <select class="form-select" name="operating_system" id="operating_system">
                                        <option value="Android" id="Android" selected>Android</option>
                                        <option value="iOS" id="iOS">iOS</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Version Description Document</label>
                                <textarea class="form-control" placeholder="Version Description Document (Max input : 255)" name="vdd" id="vdd" maxlength="255" onkeyup="inputCountVDD()"></textarea>
                                <p id="counter_VDD">255/255</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Upload Application</label>
                            <div class="custom-file">  
                                <input type="file" class="custom-file-input" name="upload_application" id="upload_application"> 
                                <label class="custom-file-label" for="upload_application">Choose file</label>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary add_versions" id="add_versions">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>