<div class="nk-ibx-head">
    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <li>
                <!-- <a href="<?= site_url('inbox/hr_division'); ?>" class="btn btn-icon btn-trigger"><em class="icon ni ni-undo"></em></a> -->
            </li>
        </ul>
    </div>
    <div>
        <ul class="nk-ibx-head-tools g-1">
            <li>
                <a href="#" class="btn btn-trigger btn-icon search-toggle toggle-search" data-target="search"><em class="icon ni ni-search"></em></a>
            </li>
            <li class="mr-n1 d-lg-none">
                <a href="<?= site_url('inbox/hr_division'); ?>" class="btn btn-trigger btn-icon toggle" data-target="inbox-aside"><em class="icon ni ni-menu-alt-r"></em></a>
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
    
    <?php foreach ($division as $key => $value) { ?>
    <?php $url = base_url('dashboard/c_view/'.str_replace('&', '-', $value['division_name'])); ?>

    <div class="nk-ibx-item is-unread" onclick="location.href='<?=$url;?>'" style="display: show;">

        <div class="nk-ibx-item-elem nk-ibx-item-check">
            <div class="custom-control custom-control-sm custom-checkbox">
                <input type="checkbox" class="custom-control-input nk-dt-item-check" id="conversionItem02">
                <label class="custom-control-label" for="conversionItem02"></label>
            </div>
        </div>  
        <div class="nk-ibx-item-elem nk-ibx-item-user">
            <div class="user-card">
                <div class="user-name">
                     <div class="lead-text text-primary"><?= $value['updated_by'];?></div>
                </div>
            </div>
        </div>
        <div class="nk-ibx-item-elem nk-ibx-item-fluid">
            <div class="nk-ibx-context-group">
                <div class="nk-ibx-context-badges"></div>
                <div class="nk-ibx-context">
                    <span class="nk-ibx-context-text">
                        <span class="heading"><?= $value['division_name'];?> Division</span>
                    </span>
                </div>
            </div>
        </div>
        
        <div class="nk-ibx-item-elem nk-ibx-item-time">
            <div><?= status_division_text($value['is_status']);?></div>
        </div>
        <div class="nk-ibx-item-elem nk-ibx-item-attach">
        </div>
    </div>
    <?php } ?>

</div>


