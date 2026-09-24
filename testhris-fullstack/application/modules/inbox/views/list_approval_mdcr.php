<style>
.scroll{
  width: 100%;
  background: silver;
  padding: 5px;
  overflow: scroll;
  height: 100%;
  
  /*script tambahan khusus untuk IE */
  scrollbar-face-color: #CE7E00; 
  scrollbar-shadow-color: #FFFFFF; 
  scrollbar-highlight-color: #6F4709; 
  scrollbar-3dlight-color: #11111; 
  scrollbar-darkshadow-color: #6F4709; 
  scrollbar-track-color: #FFE8C1; 
  scrollbar-arrow-color: #6F4709;
}

div.dataTables_wrapper div.dataTables_filter {
    margin-bottom: 10px;
}

div.dataTables_processing {
  background: transparent !important;
  border: none !important;
  box-shadow: none !important;
  z-index: 9999;
}

</style>
<div class="nk-ibx-head">
    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <li>
                <a href="<?= site_url('inbox/approval_mdcr'); ?>" class="btn btn-icon btn-trigger"><em class="icon ni ni-undo"></em></a>
            </li>
        </ul>
    </div>
    <div>
        <ul class="nk-ibx-head-tools g-1">
            <li>
                <a href="#" class="btn btn-trigger btn-icon search-toggle toggle-search" data-target="search"><em class="icon ni ni-search"></em></a>
            </li>
            <li class="mr-n1 d-lg-none">
                <a href="<?= site_url('inbox/approval_mdcr'); ?>" class="btn btn-trigger btn-icon toggle" data-target="inbox-aside"><em class="icon ni ni-menu-alt-r"></em></a>
            </li>
        </ul>
    </div>
    <div class="search-wrap" data-search="search">
        <div class="search-content">
            <a onclick="return clearSearchMdcr()" class="search-back btn btn-icon toggle-search" data-target="search">
                <em class="icon ni ni-arrow-left"></em>
            </a>
            
            <input type="text" onkeyup="search_approval_mdcr()" id="search_approval_mdcr" class="form-control border-transparent form-focus-none" placeholder="Search request">
            
            <button class="search-submit btn btn-icon"><em class="icon ni ni-search"></em></button>
        </div>
    </div>
</div>

<div class="nk-ibx-list" data-simplebar>


<div class="tab-content">
<div>
    <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
        <li class="nav-item">
            <a class="nav-link active" href="#inbox_mdcr" role="tab" data-toggle="tab"><em
                    class="icon ni ni-user-circle-fill"></em><span>MDCR</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#inbox_mdcr_waitinglist" role="tab" data-toggle="tab"><em
                    class="icon ni ni-archived-fill"></em><span>Waiting List</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#inbox_mdcr_revise" role="tab" data-toggle="tab"><em
                    class="icon ni ni-archived-fill"></em><span>Revise</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#inbox_mdcr_reject" role="tab" data-toggle="tab"><em
                    class="icon ni ni-archived-fill"></em><span>Reject</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#inbox_mdcr_approved" role="tab" data-toggle="tab"><em
                    class="icon ni ni-archived-fill"></em><span>Approved</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#inbox_mdcr_process_fi" role="tab" data-toggle="tab"><em
                    class="icon ni ni-archived-fill"></em><span>Process FI</span></a>
        </li>
    </ul>
</div>
<div class="tab-content">
  <div class="tab-pane active" id="inbox_mdcr">
    <div class="card-inner">
  			<table class="nowrap table table-striped" id="list_request_to_hr_mdcr" data-ajaxsource="<?= site_url('form/get_request_to_hr_mdcr'); ?>">
  			<thead>
                <tr>
                            <th style='width: 20%'>Employee ID</th>
                            <th style='width: 30%'>Complete Name</th>
                            <th style='width: 50%'>Request Number</th>
                </tr>
          </thead>
  				<tbody>
  				</tbody> 
  			</table>
    </div>
  </div>
    <div class="tab-pane" id="inbox_mdcr_waitinglist">
        <div class="card-inner">
				<table class="nowrap table table-striped" id="list_approval_mdcr_waitinglist" data-ajaxsource="<?= site_url('form/get_waitinglist_mdcr'); ?>">
					<thead>
                        <tr>
							<th>All <input type="checkbox" class="check11"></th>
							<th style='width: 10%'>Employee ID</th>
                            <th style='width: 30%'>Complete Name</th>
							<th style='width: 20%'>Cost Center</th>
							<th style='width: 40%'>Request Number</th>
                        </tr>
                    </thead>
					<tbody>					
					</tbody>
				</table>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-danger grouping_req_mdcr">Grouping</button>
        </div>
    </div>
    <div class="tab-pane" id="inbox_mdcr_revise">
        <div class="card-inner">
                <table class="nowrap table table-striped" id="list_approval_mdcr_revised" data-ajaxsource="<?= site_url('form/get_revise_mdcr'); ?>">
					<thead>
                        <tr>
							<th style='width: 20%'>Employee ID</th>
							<th style='width: 30%'>Complete Name</th>
							<th style='width: 50%'>Request Number</th>
                        </tr>
                    </thead>
					<tbody>					
					</tbody>
				</table>
        </div>
    </div>
    <div class="tab-pane" id="inbox_mdcr_reject">
        <div class="card-inner">
                <table class="nowrap table table-striped" id="list_approval_mdcr_rejected"  data-ajaxsource="<?= site_url('form/get_reject_mdcr'); ?>">
					<thead>
                        <tr>
							<th style='width: 20%'>Employee ID</th>
							<th style='width: 30%'>Complete Name</th>
							<th style='width: 50%'>Request Number</th>
                        </tr>
                    </thead>
					<tbody>
					</tbody>
				</table>
        </div>
    </div>
    <div class="tab-pane" id="inbox_mdcr_approved">
        <div class="card-inner">
                <table class="nowrap table table-striped" id="list_approval_mdcr_approved" data-ajaxsource="<?= site_url('form/get_approved_mdcr'); ?>">
					<thead>
                        <tr>
							<th style='width: 20%'>Employee ID</th>
							<th style='width: 30%'>Complete Name</th>
							<th style='width: 25%'>Request Number</th>
							<th style='width: 25%'>Request Number Grouping</th>
                        </tr>
                    </thead>
					<tbody>					
					</tbody>
				</table>
        </div>
    </div>
    <div class="tab-pane" id="inbox_mdcr_process_fi">
        <div class="card-inner">
                <table class="nowrap SearchMDCR table table-striped" id="list_mdcr_proccess_fi" data-ajaxsource="<?= site_url('form/get_doc_mdcr_fi'); ?>">
					<thead>
                        <tr>
							<th style='width: 40%'>Request Number Grouping</th>
							<th style='width: 30%'>Status</th>
							<th style='width: 30%'>Action</th>
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


<!-- ////////////////////////////////////////Modal Ubah///////////////////////////////////// -->

<!-- <div class="modal fade" role="dialog" id="modalResumeNoReqToFI">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Resume Medical Clime To FI</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                    
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> -->

<div id="mod_resume_no_req_to_fi"></div>