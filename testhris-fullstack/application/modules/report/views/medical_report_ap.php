<style>
	div.dataTables_wrapper div.dataTables_filter {
		margin-bottom: 10px;
	}
</style>

<div class="nk-ibx-head">
	<div class="nk-ibx-head-actions">
		<ul class="nk-ibx-head-tools g-1">
			<li>
				<a href="<?= site_url('report/medical_reports_ap'); ?>" class="btn btn-icon btn-trigger"><em class="icon ni ni-undo"></em></a>
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
		
		<div class="tab-content">

			<div class="tab-pane active" id="inbox_mdcr_process_fi">
				<div class="card-inner">
					<table class="nowrap table table-striped" id="list_mdcr_group_ap">
						<thead>
							<tr>
								<th style='width: 30%'>Request Number Grouping</th>
								<th style='width: 50%'>Status</th>
								<th style='width: 20%'>Action</th>
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

<div class="modal fade" tabindex="-1" id="modalDefault">    
	<div class="modal-dialog modal-lg" role="document">        
		<div class="modal-content">            
			<a href="#" class="close" data-dismiss="modal" aria-label="Close">                
				<em class="icon ni ni-cross"></em>            
			</a>            
			
			<div class="modal-header">                
				<h5 class="modal-title">Detail Grouping</h5>            
			</div>            
			 
			<div class="modal-body">                
				<div id="content-modal">

				</div>            
			</div>            
			
			<div class="modal-footer bg-light">                
				<!-- <span class="sub-text">Modal Footer Text</span> -->
			</div>        
		</div>    
	</div>
</div>

<div id="mod_resume_no_req_to_fi"></div>