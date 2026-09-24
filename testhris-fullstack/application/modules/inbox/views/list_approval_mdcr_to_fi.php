<style>
    div.dataTables_wrapper div.dataTables_filter {
        margin-bottom: 10px;
    }
</style>
<div class="nk-ibx-head">
    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <li>
                <a href="<?= site_url('inbox/approval_mdcr_to_fi'); ?>" class="btn btn-icon btn-trigger"><em class="icon ni ni-undo"></em></a>
            </li>
        </ul>
    </div>
    <div>
        <ul class="nk-ibx-head-tools g-1">
            <li>
                <a href="#" class="btn btn-trigger btn-icon search-toggle toggle-search" data-target="search"><em class="icon ni ni-search"></em></a>
            </li>
            <li class="mr-n1 d-lg-none">
                <a href="<?= site_url('inbox/approval_mdcr_to_fi'); ?>" class="btn btn-trigger btn-icon toggle" data-target="inbox-aside"><em class="icon ni ni-menu-alt-r"></em></a>
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
            <a class="nav-link active" href="#inbox_mdcr_process_fi" role="tab" data-toggle="tab"><em
                    class="icon ni ni-archived-fill"></em><span>Process FI</span></a>
        </li>
    </ul>
</div>
<div class="tab-content">
    <div class="tab-pane active" id="inbox_mdcr_process_fi">
        <div class="card-inner">
                <table class="nowrap table table-striped" id="list_mdcr_group" data-ajaxsource="<?= site_url('form/get_doc_mdcr_div_hr_fi'); ?>">
					<thead>
                        <tr>
                            <th style='width: 30%'>Request Number Grouping</th>
							<th style='width: 30%'>Status</th>
							<th style='width: 40%'>Action</th>
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

<div id="mod_resume_no_req_to_fi"></div>