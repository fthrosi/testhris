<div class="nk-ibx-head">
    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <li>
                <a href="<?= site_url('inbox/approval_TM_ztm'); ?>" class="btn btn-icon btn-trigger"><em class="icon ni ni-undo"></em></a>
            </li>
        </ul>
    </div>
    <div>
        <ul class="nk-ibx-head-tools g-1">
            <li>
                <a href="#" class="btn btn-trigger btn-icon search-toggle toggle-search" data-target="search"><em class="icon ni ni-search"></em></a>
            </li>
            <li class="mr-n1 d-lg-none">
                <a href="<?= site_url('inbox/approval_TM_ztm'); ?>" class="btn btn-trigger btn-icon toggle" data-target="inbox-aside"><em class="icon ni ni-menu-alt-r"></em></a>
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
                <a class="nav-link active" href="#inbox_tm" role="tab" data-toggle="tab"><em
                        class="icon ni ni-inbox-in-fill"></em><span>Time-Off</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#inbox_tm_reject" role="tab" data-toggle="tab"><em
                        class="icon ni ni-cross-circle"></em><span>Rejected</span></a> <!-- TIME MANAGEMENT 2.0 -->
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#inbox_tm_approved" role="tab" data-toggle="tab"><em
                        class="icon ni ni-check-circle-cut"></em><span>Approved</span></a> <!-- TIME MANAGEMENT 2.0 -->
            </li>
            <!-- TIME MANAGEMENT 2.0 -->
            <?php if ($this->session->userdata('access_level') == '7' || $this->session->userdata('access_employee') == '12'){ ?>
                <li class="nav-item">
                    <a class="nav-link" href="#inbox_tm_hr" role="tab" data-toggle="tab"><em 
                        class="icon ni ni-users-fill"></em><span>HR Adjustments</span></a> 
                </li>
            <?php } ?>
            <!-- /////////////////// -->
            <?php if ($this->session->userdata('access_employee') == '12'){ ?>
                <li class="nav-item">
                    <a class="nav-link" href="#inbox_tm_hr_shift" role="tab" data-toggle="tab"><em 
                        class="icon ni ni-table-view-fill"></em><span>Check Shift</span></a> 
                </li>
            <?php } ?>
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane active" id="inbox_tm">
            <div class="card-inner">
                <div class="scroll">
                    <table class="table table-striped" id="list_approval_tm_cek">
                        <thead>
                            <?php
                            $actionHeaderTM = ($nik_user === '20180115') ? 'Req. Number Time Management' : 'Request Number';
                            $actionHeaderMDCR = ($nik_user === '20180115') ? 'Req. No Medical Claim' : '';
                            ?>
                            <tr>
                                <th style='width: 15%'>Employee ID</th>
                                <th style='width: 30%'>Complete Name</th>
                                <th style='width: 20%'><?= $actionHeaderTM ?></th>
                                <th style="width:15%"><?= $actionHeaderMDCR ?></th>
                                <th style='width: 20%'>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach($header_tm_cek as $key => $value){
                            // TIME MANAGEMENT 2.0
                            if ($value["is_status_divhead_hr"] == 7){
                                $tm_schedule = '_tm_schedule';
                            } else {
                                $tm_schedule = '';
                            }
                            $url = base_url('form/detail_approval'.$tm_schedule.'/'.$value["form_type"].'/'.encode_url($value["id"]));
                            if ($value["is_status_divhead_hr"] == 8){ 
                                $url = base_url('master/detail_approval/shift/'.encode_url($value["id"]));
                            }
                            //////////////////////
                            $nama = decrypt($value['complete_name']);
                            echo"
                            <tr class='SearchMDCR'>
                            <td>".$value['employee_id']."</td>
                            <td>".decrypt($value['complete_name'])."</td>
                            <td><a href='".$url."'>".$value['request_number']."</a></td>";

                            if($value['jenis_cuti'] == 'SAKIT' && $nik_user === '20180115'){
                                echo "
                                <td>
                                    <a 
                                        class='text-primary btn btn-icon btn-trigger'
                                        data-toggle='modal'
                                        data-target='#modalViewReqMDCR'
                                        data-offset='-4,0'
                                        id='{$value['request_number']}'
                                        onclick=\"view_req_mdcr_on_tm('{$value['request_number']}', '{$nama}', '{$value['employee_id']}')\"
                                    >
                                        <em class='icon ni ni-plus-medi-fill text-danger'></em>
                                    </a>
                                </td>";
                            }else{
                                echo "<td></td>";
                            }

                            echo"
                            <td>".status_color($value['is_status'])."</td>
                            </label>
                            </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="inbox_tm_reject">
            <div class="card-inner">
                <div class="scroll">
                    <table class="table table-striped" id="list_approval_tm_rejected">
                        <thead>
                            <tr>
                                <th style='width: 15%'>Employee ID</th>
                                <th style='width: 25%'>Complete Name</th>
                                <th style='width: 20%'>Request Number</th>
                                <th style='width: 20%'>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach($header_tm_rejected as $key => $value){
                            // TIME MANAGEMENT 2.0
                            if ($value["is_status_divhead_hr"] == 7){
                                $tm_schedule = '_tm_schedule';
                            } else {
                                $tm_schedule = '';
                            }
                            $url = base_url('form/detail_approval'.$tm_schedule.'/'.$value["form_type"].'/'.encode_url($value["id"]));
                            if ($value["is_status_divhead_hr"] == 8){ 
                                $url = base_url('master/detail_approval/shift/'.encode_url($value["id"]));
                            }
                            //////////////////////
                            echo"
                            <tr class='SearchMDCR'>
                            <td>".$value['employee_id']."</td>
                            <td>".decrypt($value['complete_name'])."</td>
                            <td><a href='".$url."'>".$value['request_number']."</a></td>
                            <td>".status_color($value['is_status'])."</td>
                            </label>
                            </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="inbox_tm_approved">
            <div class="card-inner">
                    <table class="table table-striped" id="list_approval_tm_approved">
                        <thead>
                            <tr>
                                <th style='width: 15%'>Employee ID</th>
                                <th style='width: 25%'>Complete Name</th>
                                <th style='width: 20%'>Request Number</th>
                                <th style='width: 20%'></th>
                                <th style='width: 20%'>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach($header_tm_approved as $key => $value){
                            // TIME MANAGEMENT 2.0
                            if ($value["is_status_divhead_hr"] == 7){
                                $tm_schedule = '_tm_schedule';
                            } else {
                                $tm_schedule = '';
                            }
                            $url = base_url('form/detail_approval'.$tm_schedule.'/'.$value["form_type"].'/'.encode_url($value["id"]));
                            if ($value["is_status_divhead_hr"] == 8){ 
                                $url = base_url('master/detail_approval/shift/'.encode_url($value["id"]));
                            }
                            //////////////////////
                            echo"
                            <tr class='SearchMDCR'>
                            <td>".$value['employee_id']."</td>
                            <td>".decrypt($value['complete_name'])."</td>
                            <td><a href='".$url."'>".$value['request_number']."</a></td>";
                            if ($value["is_status_admin_hr"] == 1){
                                echo "<td><span class='badge badge-pill badge-sm bg-teal-dim text-primary'>Checked By HR Support</td>";
                            } else {
                                echo "<td></td>";
                            }
                            echo"
                            <td>".status_color($value['is_status'])."</td>
                            </label>
                            </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
            </div>
        </div>

        <!-- TIME MANAGEMENT 2.0 -->
        <?php if ($this->session->userdata('access_level') == '7'){ ?>
            <div class="tab-pane" id="inbox_tm_hr">
                <div class="card-inner">
                        <table class="table table-striped" id="list_approval_tm_hr">
                            <thead>
                                <tr>
                                    <th style='width: 15%'>Employee ID</th>
                                    <th style='width: 25%'>Complete Name</th>
                                    <th style='width: 40%'>Request Number</th>
                                    <th style='width: 20%'>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach($header_tm_hr as $key => $value){
                                    if (substr($value["request_number"], 5, 4) == 'TMRS'){ 
                                        $url = base_url('master/detail_approval/relokasi/'.encode_url($value["id"]));
                                    } else {
                                        $url = base_url('form/detail_approval_hr_adjust/'.$value["form_type"].'/'.$value["request_number"]);
                                    }
                                    echo"
                                    <tr class='SearchMDCR'>
                                    <td>".$value['employee_id']."</td>
                                    <td>".decrypt($value['complete_name'])."</td>
                                    <td><a href='".$url."'>".$value['request_number']."</a></td>
                                    <td>".status_color($value['is_status'])."</td>
                                    </label>
                                    </tr>";
                                }
                            ?>
                            </tbody>
                        </table>
                </div>
            </div>         
        <?php } ?>
        <!-- //////////////////// -->

        <?php if ($this->session->userdata('access_employee') == '12'){ ?>
            <div class="tab-pane" id="inbox_tm_hr_shift">
                <div class="card-inner">
                        <table class="table table-striped" id="list_approval_tm_shift">
                            <thead>
                                <tr>
                                    <th style='width: 15%'>Employee ID</th>
                                    <th style='width: 25%'>Complete Name</th>
                                    <th style='width: 20%'>Request Number</th>
                                    <th style='width: 20%'></th>
                                    <th style='width: 20%'>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach($header_tm_shift as $key => $value){
                                    if ($value["is_status_divhead_hr"] == 8){ 
                                        $url = base_url('master/detail_approval/shift/'.encode_url($value["id"]));
                                    } else {
                                        $url = base_url('form/detail_approval_tm_schedule/'.$value["form_type"].'/'.encode_url($value["id"]));
                                    }
                                    echo"
                                    <tr class='SearchMDCR'>
                                    <td>".$value['employee_id']."</td>
                                    <td>".decrypt($value['complete_name'])."</td>
                                    <td><a href='".$url."'>".$value['request_number']. "</a><i><b class='text-danger'> ".$value['form_notes']."</b></i></td>"; 
                                    if ($value["is_status_admin_hr"] == 1){
                                        echo "<td><span class='badge badge-pill badge-sm bg-teal-dim text-primary'>Checked By HR Support</td>";
                                    } else {
                                        echo "<td></td>";
                                    }
                                    echo"
                                    <td>".status_color($value['is_status'])."</td>
                                    </label>
                                    </tr>";
                                }
                            ?>
                            </tbody>
                        </table>
                </div>
            </div>         
        <?php } ?>
    </div>
    </div>
</div>


<!-- MODAL CHECK MDCR 2026 -->
 <!-- //////////////////////////////////////////// MODAL //////////////////////////////////////////// -->
<div class="modal fade" tabindex="-1" id="modalViewReqMDCR">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body">
                <h5 class="title">List of Medical Claim</h5>
                    <div class="card card-preview">
                        <div class="tab-content">
                
                                <div class="card-inner">
                                <div class="pb-2" id='nama_request_mdcr'>
                                    <h4></h4>
                                </div>
                                <table class="nowrap table view_req_mdcr_on_tm-table table-striped" width="100%" id="view_req_mdcr_on_tm">
                                    <thead>
                                        <tr>
                                            <th style='width: 10%'>No</th>
                                            <th style='width: 55%'>Request Number</th>
                                            <th style='width: 20%'>Status</th>
                                            <th style='width: 15%'>Action</th>
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
    </div>
</div>