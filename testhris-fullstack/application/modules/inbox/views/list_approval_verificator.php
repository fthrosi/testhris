<!-- <h5>
    Haloooooo
</h5> -->
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
                <div class="card-inner" style="padding:0px; padding-top:0.5rem">
                    <div class="scroll">
                        <table class="table table-striped" id="list_approval_tm_cek">
                            <thead>
                                <tr>
                                    <th style='width: 20%'>Employee ID</th>
                                    <th style='width: 30%'>Complete Name</th>
                                    <th style='width: 25%'>Request Number</th>
                                    <th style='width: 25%'>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach($header_ec_cek as $key => $value){
                                $url = base_url('form/detailVerifycator/'.encode_url($value["id_form_request"]).'/'.encode_url($value["id_section"]));
                                
                                //////////////////////
                                echo"
                                <tr class='SearchMDCR'>
                                <td>".$value['employee_id']."</td>
                                <td>".$value['complete_name']."</td>
                                <td><a href='".$url."'>".$value['request_number']."</a></td>";
                                echo"
                                <td>".status_color($value['status'])."</td>
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
                <div class="card-inner" style="padding:0px; padding-top:0.5rem">
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
                                foreach($header_ec_rejected as $key => $value){
                                // TIME MANAGEMENT 2.0
                                $url = base_url('form/detailVerifycator/'.encode_url($value["id_form_request"]).'/'.encode_url($value["id_section"]));
                                //////////////////////
                                echo"
                                <tr class='SearchMDCR'>
                                <td>".$value['employee_id']."</td>
                                <td>".$value['complete_name']."</td>
                                <td><a href='".$url."'>".$value['request_number']."</a></td>
                                <td>".status_color($value['status'])."</td>
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
                <div class="card-inner" style="padding:0px; padding-top:0.5rem">
                        <table class="table table-striped" id="list_approval_tm_approved">
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
                                foreach($header_ec_approved as $key => $value){
        
                                $$url = base_url('form/detailVerifycator/'.encode_url($value["id_form_request"]).'/'.encode_url($value["id_section"]));
                                
                                //////////////////////
                                echo"
                                <tr class='SearchMDCR'>
                                <td>".$value['employee_id']."</td>
                                <td>".$value['complete_name']."</td>
                                <td><a href='".$url."'>".$value['request_number']."</a></td>";
                                echo"
                                <td>".status_color($value['status'])."</td>
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