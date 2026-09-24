<div class="nk-ibx-head">
    <div class="nk-ibx-head-actions">
    </div>
    <div>
        <ul class="nk-ibx-head-tools g-1">
            <li>
                <a href="#" class="btn btn-trigger btn-icon search-toggle toggle-search" data-target="search"><em class="icon ni ni-search"></em></a>
            </li>
            <li class="mr-n1 d-lg-none">
                <a href="<?= site_url('home/request'); ?>" class="btn btn-trigger btn-icon toggle" data-target="inbox-aside"><em class="icon ni ni-menu-alt-r"></em></a>
            </li>
        </ul>
    </div>
    <div class="search-wrap" data-search="search">
        <div class="search-content">
            <a onclick="return clearSearch()" class="search-back btn btn-icon toggle-search" data-target="search">
                <em class="icon ni ni-arrow-left"></em>
            </a>
            
            <input type="text" onkeyup="search_approval()" id="search_approval" class="form-control border-transparent form-focus-none" placeholder="Search request">
            
            <button class="search-submit btn btn-icon"><em class="icon ni ni-search"></em></button>
        </div>
    </div>
</div>

<div class="nk-ibx-list" data-simplebar>
    <div class="tab-content">
        <div>
            <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                <li class="nav-item">
                    <a class="nav-link active" href="#submission_mdcr" role="tab" data-toggle="tab"><em
                            class="icon ni ni-plus-medi-fill"></em><span>Medical<br>Reimbursement</span></a>
                </li>
                <!-- /////////////////////////////////// START TIME MANAGEMENT 2024//////////////////////////////////////////// -->
                <!-- <li class="nav-item" style="display:<?=$display?>;"> -->
                <li class="nav-item">
                    <a class="nav-link" href="#submission_tm" role="tab" data-toggle="tab"><em
                            class="icon ni ni-clock-fill"></em><span>Time<br>Management</span></a>
                </li>
                <!-- /////////////////////////////////// END TIME MANAGEMENT 2024//////////////////////////////////////////// -->
                <li class="nav-item">
                    <a class="nav-link" href="#submission_pa" role="tab" data-toggle="tab"><em
                            class="icon ni ni-file-check-fill"></em><span>Performance<br>Appraisal</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#submission_ec" role="tab" data-toggle="tab"><em
                            class="icon ni ni-file-check-fill"></em><span>Exit<br>Clearence</span></a>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="submission_mdcr">
                <?php foreach ($header_mdcr as $key => $value) { 
                /////////////////////////////////// START TIME MANAGEMENT 2024////////////////////////////////////////////
                if (($value["is_status"] == '0' || $value["is_status"] == '4' || $value["is_status"] == '1' || $value["is_status"] == '2' || $value["is_status"] == '7')) {     
                    $url = base_url('form/detail/'.$value["form_type"].'/'.encode_url($value["id"]));    
                } else {
                    $url = base_url('form/detail_full_approve/'.$value["form_type"].'/'.encode_url($value["id"]));
                }  
                ?>
            
                <div class="nk-ibx-item is-unread" style="display: show;">
                    <div class="nk-ibx-item-elem nk-ibx-item-check">
                        <div class="custom-control custom-control-sm custom-checkbox">
                            <?php if ($value['is_status'] == 0): ?>
                                <a onclick="return delete_draft(this.id);" id="<?=$value['id']?>" class="btn btn-sm btn-icon btn-trigger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><em class="icon ni ni-trash"></em></a>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="nk-ibx-item-elem nk-ibx-item-star" onclick="location.href='<?=$url;?>'">
                        <div class="asterisk"></div>
                    </div>
                    <div class="nk-ibx-item-elem nk-ibx-item-user" onclick="location.href='<?=$url;?>'">
                        <div class="user-card">
                            <div class="user-name">
                                <?= str_replace(".000","",$value['created_at']);?>
                            </div>
                        </div>
                    </div>
                    <div class="nk-ibx-item-elem nk-ibx-item-user" onclick="location.href='<?=$url;?>'">
                        <div class="user-card">
                            <div class="user-name">
                                <?php
                                if($value['is_status_admin_hr'] == 1 && $value['is_status_progress'] == NULL){
                                    echo "<div class='bg-teal-dim text-primary is-dim'>Checked By HR Support</div>";
                                }elseif($value['is_status_admin_hr'] == 1 && $value['is_status_progress'] != NULL && $value['is_status_progress'] != ""){
                                    echo status_mdcr_color($value['is_status_progress']);
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="nk-ibx-item-elem nk-ibx-item-fluid" onclick="location.href='<?=$url;?>'">
                        <div class="nk-ibx-context-group">
                            <div class="nk-ibx-context-badges"><?= status_text($value['is_status']);?></div>
                            <div></div>
                                <div class="lead-text"><?= $value['request_number'];?></div>
                            <div class="nk-ibx-context">
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php } ?>
            </div>
             <!-- /////////////////////////////////// START EXIT CLEARANCE 2024//////////////////////////////////////////// -->
            <div class="tab-pane" id="submission_ec">
                <?php foreach ($header_ec as $key => $value) { 
                    switch ((int) $value["current_step"]){
                        case 1:
                            $url = base_url('form/detail/'.$value["form_type"].'/'.encode_url($value["id"]));
                            break;
                        case 2:
                            $url = base_url('inbox/detail_req_resignation_letter/'.encode_url($value["id"]));
                            break;
                        case 3:
                            $url = base_url('form/home_exit_clearance/'.encode_url($value["id"]));
                            break;
                        case 4:
                            $url = base_url('form/home_exit_clearance/'.encode_url($value["id"]));
                            break;
                        case 5:
                            $url = base_url('form/home_exit_clearance/'.encode_url($value["id"]));
                            break;
                        default:
                            $url = base_url('form/detail/'.$value["form_type"].'/'.encode_url($value["id"]));
                            break;
                    }
                
                ?>
            
                <div class="nk-ibx-item is-unread" style="display: show;">
                    <div class="nk-ibx-item-elem nk-ibx-item-check">
                        <div class="custom-control custom-control-sm custom-checkbox">
                            <?php if ($value['is_status'] == 0): ?>
                                <a onclick="return delete_draft(this.id);" id="<?=$value['id']?>" class="btn btn-sm btn-icon btn-trigger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><em class="icon ni ni-trash"></em></a>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="nk-ibx-item-elem nk-ibx-item-star" onclick="location.href='<?=$url;?>'">
                        <div class="asterisk"></div>
                    </div>
                    <div class="nk-ibx-item-elem nk-ibx-item-user" onclick="location.href='<?=$url;?>'">
                        <div class="user-card">
                            <div class="user-name">
                                <?= str_replace(".000","",$value['created_at']);?>
                            </div>
                        </div>
                    </div>
                    <div class="nk-ibx-item-elem nk-ibx-item-user" onclick="location.href='<?=$url;?>'">
                        <div class="user-card">
                            <div class="user-name">
                                <?php
                                if($value['is_status_admin_hr'] == 1){
                                    echo "<div class='bg-teal-dim text-primary is-dim'>Checked By HR Support</div>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="nk-ibx-item-elem nk-ibx-item-fluid" onclick="location.href='<?=$url;?>'">
                        <div class="nk-ibx-context-group">
                            <div class="nk-ibx-context-badges"><?= status_text($value['status']);?></div>
                            <div></div>
                                <div class="lead-text"><?= $value['request_number'];?></div>
                        </div>
                    </div>
                </div>
                
                <?php } ?>
            </div>
             <!-- /////////////////////////////////// START TIME MANAGEMENT 2024//////////////////////////////////////////// -->
             <div class="tab-pane" id="submission_tm">
                <?php foreach ($header_tm as $key => $value) { 
                    
                    if ($value["form_type"] == 'TM'){
                        if (substr($value["request_number"], 5, 4) == 'TMRS'){
                            $url = base_url('master/detail_approval/relokasi/' . encode_url($value["id"]));
                        } else if (substr($value["request_number"], 5, 4) == 'TMHR'){
                            $url = base_url('form/detail_approval_hr_adjust/TM/' . $value['request_number']);
                        } else if (substr($value["request_number"], 5, 4) == 'TMSH'){
                            $url = base_url('form/detail_approval_tm_schedule/TM/' . encode_url($value['id']));
                        } else if (substr($value["request_number"], 5, 4) == 'TMSF'){
                            $url = base_url('master/detail_approval/shift/' . encode_url($value['id']));
                        } else {
                            // $url = base_url('form/overview/TM');
                            $url = base_url('form/detail_approval/'.$value["form_type"].'/'.encode_url($value["id"]));
                        }
                    } else if (($value["is_status"] == '0' || $value["is_status"] == '4' || $value["is_status"] == '1' || $value["is_status"] == '2' || $value["is_status"] == '7') && $value["form_type"] != 'TM') { 
                        
                        $url = base_url('form/detail/'.$value["form_type"].'/'.encode_url($value["id"]));
                        
                    } else {
                        $url = base_url('form/detail_full_approve/'.$value["form_type"].'/'.encode_url($value["id"]));
                    }  
                
                ?>
            
                <div class="nk-ibx-item is-unread" style="display: show;">
                    <div class="nk-ibx-item-elem nk-ibx-item-check">
                        <div class="custom-control custom-control-sm custom-checkbox">
                            <?php if ($value['is_status'] == 0): ?>
                                <a onclick="return delete_draft(this.id);" id="<?=$value['id']?>" class="btn btn-sm btn-icon btn-trigger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><em class="icon ni ni-trash"></em></a>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="nk-ibx-item-elem nk-ibx-item-star" onclick="location.href='<?=$url;?>'">
                        <div class="asterisk"></div>
                    </div>
                    <div class="nk-ibx-item-elem nk-ibx-item-user" onclick="location.href='<?=$url;?>'">
                        <div class="user-card">
                            <div class="user-name">
                                <?= str_replace(".000","",$value['created_at']);?>
                            </div>
                        </div>
                    </div>
                    <div class="nk-ibx-item-elem nk-ibx-item-user" onclick="location.href='<?=$url;?>'">
                        <div class="user-card">
                            <div class="user-name">
                                <?php
                                if($value['is_status_admin_hr'] == 1){
                                    echo "<div class='bg-teal-dim text-primary is-dim'>Checked By HR Support</div>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="nk-ibx-item-elem nk-ibx-item-fluid" onclick="location.href='<?=$url;?>'">
                        <div class="nk-ibx-context-group">
                            <div class="nk-ibx-context-badges"><?= status_text($value['is_status']);?></div>
                            <div></div>
                                <div class="lead-text"><?= $value['request_number'];?></div>
                            <div class="nk-ibx-context">
                                <!-- <span class="nk-ibx-context-text">
                                    <span class="heading">Performance Appraisal & Plan </span>
                                    - Evaluation period: <?= $value['evaluation_period_start'];?>  - <?= $value['evaluation_period_end'];?> 
                                </span> -->
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php } ?>
            </div>
            <!-- /////////////////////////////////// END TIME MANAGEMENT 2024//////////////////////////////////////////// -->

            
            <div class="tab-pane" id="submission_pa">
                <?php
                foreach ($header_pa as $key => $value) { 
                        if(!empty($this->input->post('periodPA'))){
                            $period = $this->input->post('periodPA');
                        }else{
                            $period = "";
                        }
                        $pa = $this->home_model->getMyRequestPA($value['id'],$period);
                        
                        foreach($pa as $k => $v){
                            
                            if ($v["is_status"] == '0' || $v["is_status"] == '2' || $v["is_status"] == '7') { 

                                if ($v["new_employee_flag"] == '1') {
                                    $url = base_url('form/detailpa/PLAN/'.encode_url($v["id"]));
                                } else {
                                    $url = base_url('form/detailpa/KPI/'.encode_url($v["id"]));
                                }

                            } else {
                                $url = base_url('home/request/view/'.encode_url($v["id"]).'/'.$v['form_type']);
                            } 
                            ?>
                            <div class="nk-ibx-item is-unread" style="display: show;">
                            <div class="nk-ibx-item-elem nk-ibx-item-check">
                                <div class="custom-control custom-control-sm custom-checkbox">
                                    
                                    <?php if ($v['is_status'] == 0): ?>
                                        <a onclick="return delete_draft_pa(this.id);" id="<?=$v['id']?>" class="btn btn-sm btn-icon btn-trigger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><em class="icon ni ni-trash"></em></a>
                                    <?php endif ?>
                                </div>
                            </div>
                            <div class="nk-ibx-item-elem nk-ibx-item-star" onclick="location.href='<?=$url;?>'">
                                <div class="asterisk"></div>
                            </div>
                            <div class="nk-ibx-item-elem nk-ibx-item-user" onclick="location.href='<?=$url;?>'">
                                <div class="user-card">
                                    <div class="user-name">
                                        <?= str_replace(".000","",$v['created_at']);?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="nk-ibx-item-elem nk-ibx-item-user" onclick="location.href='<?=$url;?>'">
                                    <div class="user-card">
                                        <div class="user-name">
                                        <span class="nk-ibx-context-text">
                                            <?php
                                                if($this->input->post('periodPA') == date("Y",strtotime($v['evaluation_period_start']))){
                                                    echo "<div class='bg-teal-dim text-warning is-dim'>Evaluation period: ".$v['evaluation_period_start']." - ".$v['evaluation_period_end']."</div>";
                                                }else{
                                                    echo "Evaluation period: ".$v['evaluation_period_start']." - ".$v['evaluation_period_end'];
                                                }
                                            ?>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            <div class="nk-ibx-item-elem nk-ibx-item-fluid" onclick="location.href='<?=$url;?>'">
                                <div class="nk-ibx-context-group">
                                    <div class="nk-ibx-context-badges"><?= status_text($v['is_status']);?></div>
                                    <div class="lead-text"><?= $v['request_number'];?></div>
                                    
                                </div>
                            </div>
                            <div class="nk-ibx-item-elem nk-ibx-item-fluid" onclick="location.href='<?=$url;?>'">
                                <div class="nk-ibx-context">
                                        <span class="nk-ibx-context-text">
                                            <span class="heading">Performance Appraisal & Plan</span>
                                        </span>
                                    </div>
                            </div>
                            </div>
                            <?php

                        }
                }
                    
                ?>
            </div>
        </div>
    </div>
</div>


