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
    foreach ($header as $key => $value) { ?>
    <?php $url = base_url('form/detail_approval/'.$value["form_type"].'/'.encode_url($value["id"])); ?>

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
        
        <div class="nk-ibx-item-elem nk-ibx-item-time">
            <div><?= status_text($value['is_status']);?></div>
        </div>
        <div class="nk-ibx-item-elem nk-ibx-item-attach">
        </div>
    </div>
    <?php } ?>

</div>


