<div class="nk-ibx-head">
    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <li>
                <a href="<?= site_url('inbox/approval_resignation_letter'); ?>" class="btn btn-icon btn-trigger"><em class="icon ni ni-undo"></em></a>
            </li>
        </ul>
    </div>
    <div>
        <ul class="nk-ibx-head-tools g-1">
            <li>
                <a href="#" class="btn btn-trigger btn-icon search-toggle toggle-search" data-target="search"><em class="icon ni ni-search"></em></a>
            </li>
            <li class="mr-n1 d-lg-none">
                <a href="<?= site_url('inbox/approval_resignation_letter'); ?>" class="btn btn-trigger btn-icon toggle" data-target="inbox-aside"><em class="icon ni ni-menu-alt-r"></em></a>
            </li>
        </ul>
    </div>
    <!-- <div class="search-wrap" data-search="search">
        <div class="search-content">
            <a onclick="return clearSearchMdcr()" class="search-back btn btn-icon toggle-search" data-target="search">
                <em class="icon ni ni-arrow-left"></em>
            </a>
            
            <input type="text" onkeyup="search_approval_mdcr()" id="search_approval_mdcr" class="form-control border-transparent form-focus-none" placeholder="Search request">
            
            <button class="search-submit btn btn-icon"><em class="icon ni ni-search"></em></button>
        </div>
    </div> -->
</div>

<div class="nk-ibx-list" data-simplebar>
    <div class="tab-content">
        <div>
            <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                <li class="nav-item">
                    <a class="nav-link active" href="#inbox_ec" role="tab" data-toggle="tab"><em
                            class="icon ni ni-inbox-in-fill"></em><span>Exit Clearance</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#inbox_ec_reject" role="tab" data-toggle="tab"><em
                            class="icon ni ni-cross-circle"></em><span>Revised</span></a> <!-- TIME MANAGEMENT 2.0 -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#inbox_ec_approved" role="tab" data-toggle="tab"><em
                            class="icon ni ni-check-circle-cut"></em><span>Approved</span></a> <!-- TIME MANAGEMENT 2.0 -->
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="inbox_ec">
                <div class="card-inner">
                    <div class="scroll">
                        <table class="table table-striped" id="list_approval_tm_cek">
                            <thead>
                                <tr>
                                    <th style='width: 15%'>Employee ID</th>
                                    <th style='width: 25%'>Complete Name</th>
                                    <th style='width: 20%'>Request Number</th>
                                    <th style='width: 20%'>Status Resignation</th>
                                    <th style='width: 20%'>Status Exit Clearance</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach($header_ec_cek as $key => $value){
                                $url = base_url('inbox/detail_req_resignation_letter/'.encode_url($value["id"]));
                                
                                //////////////////////
                                echo"
                                <tr class='SearchMDCR'>
                                <td>".$value['employee_id']."</td>
                                <td>".decrypt($value['complete_name'])."</td>
                                <td><a href='".$url."'>".$value['request_number']."</a></td>";
                                echo"
                                <td>".status_color($value['status_resign'])."</td>
                                <td>".(!empty($value['status_exit']) ? status_color($value['status_exit']) : "")."</td>
                                </label>
                                </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="inbox_ec_reject">
                <div class="card-inner">
                    <div class="scroll">
                        <table class="table table-striped" id="list_approval_tm_rejected">
                            <thead>
                                <tr>
                                    <th style='width: 15%'>Employee ID</th>
                                    <th style='width: 25%'>Complete Name</th>
                                    <th style='width: 20%'>Request Number</th>
                                    <th style='width: 20%'>Status Request</th>
                                    <th style='width: 20%'>Status Step</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach($header_ec_rejected as $key => $value){
                                // TIME MANAGEMENT 2.0
                                $url = base_url('form/detail/EC/'.encode_url($value["id"]));
                                //////////////////////
                                echo"
                                <tr class='SearchMDCR'>
                                <td>".$value['employee_id']."</td>
                                <td>".decrypt($value['complete_name'])."</td>
                                <td><a href='".$url."'>".$value['request_number']."</a></td>
                                 <td>".status_color($value['status_resign'])."</td>
                                <td>".(!empty($value['status_exit']) ? status_color($value['status_exit']) : "")."</td>
                                </label>
                                </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="inbox_ec_approved">
                <div class="card-inner">
                        <table class="table table-striped" id="list_approval_tm_approved">
                            <thead>
                                <tr>
                                    <th style='width: 15%'>Employee ID</th>
                                    <th style='width: 25%'>Complete Name</th>
                                    <th style='width: 20%'>Request Number</th>
                                    <th style='width: 20%'>Status Request</th>
                                    <th style='width: 20%'>Status Step</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach($header_ec_approved as $key => $value){
        
                                $url = base_url('form/home_exit_clearance/'.encode_url($value["id"]));
                                
                                //////////////////////
                                echo"
                                <tr class='SearchMDCR'>
                                <td>".$value['employee_id']."</td>
                                <td>".decrypt($value['complete_name'])."</td>
                                <td><a href='".$url."'>".$value['request_number']."</a></td>";
                                echo"
                                <td>".status_color($value['status_resign'])."</td>
                                <td>".(!empty($value['status_exit']) ? status_color($value['status_exit']) : "")."</td>
                                </label>
                                </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                </div>
            </div>

        </div>
    </div>
</div>