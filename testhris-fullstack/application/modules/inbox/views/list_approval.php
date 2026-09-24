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
</style>
<div class="nk-ibx-head">
    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <li>
                <a href="<?= site_url('inbox/approval'); ?>" class="btn btn-icon btn-trigger"><em class="icon ni ni-undo"></em></a>
            </li>
        </ul>
    </div>
    <div>
        <ul class="nk-ibx-head-tools g-1">
            <li>
                <a href="#" class="btn btn-trigger btn-icon search-toggle toggle-search" data-target="search"><em class="icon ni ni-search"></em></a>
            </li>
            <li class="mr-n1 d-lg-none">
                <a href="<?= site_url('inbox/approval'); ?>" class="btn btn-trigger btn-icon toggle" data-target="inbox-aside"><em class="icon ni ni-menu-alt-r"></em></a>
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
    <?php 
    foreach ($header as $key => $value) { 
        if($value['form_type'] === 'EC'){
            $is_status_step = (int)$value['status_step'] === 0 ? 1 : ((int)$value['status_step'] === 1 ? 3 : ((int)$value['status_step'] === 2 ? 2 : 8));
        }
        if(substr($value['request_number'],5,3) != "KPI" and substr($value['request_number'],5,4) != "PLAN"){ 
            
        ///////////////////////////// START TIME MANAGEMENT 2024 ////////////////////////////////////
        if ($value["is_status_admin_hr"] == 7 && $value["form_type"] == 'TM'){
            if (substr($value["request_number"], 5, 4) == 'TMRS'){
                $url = base_url('master/detail_approval/relokasi/' . encode_url($value["id"]));
            } else {
                $url = base_url('form/detail_approval_hr_adjust/'.$value["form_type"].'/'.$value["request_number"]);
            }
        } else if ($value["is_status_divhead_hr"] == 7 && $value["form_type"] == 'TM'){
            $url = base_url('form/detail_approval_tm_schedule/'.$value["form_type"].'/'.encode_url($value["id"]));
        } else if ($value["is_status_divhead_hr"] == 8 && $value["form_type"] == 'TM'){ 
            $url = base_url('master/detail_approval/shift/'.encode_url($value["id"]));
        } else if ($value["form_type"] === 'EC'){
            if($value["approval_type"] === 'RESIGNATION_LETTER'){
                $url = base_url('inbox/detail_req_resignation_letter/'.encode_url($value["id"]));
            }else{
                $url = base_url('form/home_exit_clearance/'.encode_url($value["id"]));
            }
        } else {
        ///////////////////////////// END TIME MANAGEMENT 2024 ////////////////////////////////////
            $url = base_url('form/detail_approval/'.$value["form_type"].'/'.encode_url($value["id"])); 
        }
        // $url = base_url('form/detail_approval/'.$value["form_type"].'/'.encode_url($value["id"])); ?>

        <div class="nk-ibx-item is-unread" onclick="location.href='<?=$url;?>'" style="display: show;">
            <div class="nk-ibx-item-elem">
                <div class="user-card">
                        <div class="lead-text text-primary"><?= ($value['employee_id']);?></div>
                        <div class="lead-text text-primary">&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;</div>
                        <div class="lead-text text-primary"><?= decrypt($value['complete_name']);?></div>
                        <div class="lead-text text-primary">&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;</div>
                        <div class="lead-text text-primary"><?= $value['request_number'];?></div>
                </div>
            </div>
            <div class="nk-ibx-item-elem nk-ibx-item-fluid">
                <div class="nk-ibx-context-group">
                    <div class="nk-ibx-context-badges"></div>
                    <div class="nk-ibx-context">
                        <span class="nk-ibx-context-text">
                            <!-- <span class="heading">Performance Appraisal & Plan </span>
                            - Evaluation period: <?= $value['evaluation_period_start'];?>  - <?= $value['evaluation_period_end'];?> 
                            <span class="text-soft">[<?= $value['request_number'];?>]</span>  -->
                        </span>
                    </div>
                </div>
            </div>
            
            <?php if ($value['form_type'] === 'EC'): ?>
                <div class="nk-ibx-item-elem nk-ibx-item-time">
                    <div><?= status_text($is_status_step);?></div>
                </div>
            <?php else: ?>
                <div class="nk-ibx-item-elem nk-ibx-item-time">
                    <div><?= status_text($value['is_status']);?></div>
                </div>
            <?php endif; ?>
            <div class="nk-ibx-item-elem nk-ibx-item-attach">
            </div>
        </div>

        <?php 
        }else{
            $url = base_url('inbox/viewpa/'.encode_url($value["idpa"]));
        ?>

        <div class="nk-ibx-item is-unread" onclick="location.href='<?=$url;?>'" style="display: show;">
    
            <div class="nk-ibx-item-elem">
                    <div class="user-card">
                            <div class="lead-text text-primary"><?= ($value['employee_id']);?></div>
                            <div class="lead-text text-primary">&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;</div>
                            <div class="lead-text text-primary"><?= decrypt($value['employee_name']);?></div>
                            <div class="lead-text text-primary">&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;</div>
                            <div class="lead-text text-primary"><?= $value['request_number'];?></div>
                    </div>
                </div>
            <div class="nk-ibx-item-elem nk-ibx-item-fluid">
                <div class="nk-ibx-context-group">
                    <div class="nk-ibx-context-badges"></div>
                    <div class="nk-ibx-context">
                        <span class="nk-ibx-context-text">
                            <span class="heading">Performance Appraisal & Plan </span>
                            - Evaluation period: <?= $value['evaluation_period_start'];?>  - <?= $value['evaluation_period_end'];?> 
                            <span class="text-soft">[<?= $value['request_number'];?>]</span> 
                        </span>
                    </div>
                </div>
            </div>
            <div class="nk-ibx-item-elem nk-ibx-item-time">
                <div><?= status_text($value['is_status']);?></div>
            </div>
            <div class="nk-ibx-item-elem nk-ibx-item-attach">
            </div>
        </div>
    <?php
        }
    }
    ?>
</div>


