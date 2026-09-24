<div class="nk-ibx-head">
    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <li>
                <a href="<?= site_url('inbox/pa_management/'.$year); ?>" class="btn btn-icon btn-trigger"><em class="icon ni ni-undo"></em></a>
            </li>
        </ul>
    </div>
    <div>
        <ul class="nk-ibx-head-tools g-1">
            <li>
                <a href="#" class="btn btn-trigger btn-icon search-toggle toggle-search" data-target="search"><em class="icon ni ni-search"></em></a>
            </li>
            <li class="mr-n1 d-lg-none">
                <a href="<?= site_url('inbox/pa_management/'.$year); ?>" class="btn btn-trigger btn-icon toggle" data-target="inbox-aside"><em class="icon ni ni-menu-alt-r"></em></a>
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

<div class="card-inner">
    <div class = "row">
    <div class = "col-md-3">
        <strong>Select Period</strong>
        <select name = "periodpasearch" class = "form-control" onchange="location = this.value;">
            <?php for($i = date("Y",strtotime("now - 1 year")); $i >= 2023; $i--){ ?>
                <option value = "inbox/pa_management/<?= $i; ?>" <?= ($year == $i) ? "selected" : "" ?>><?= $i; ?></option>
            <?php } ?>
        </select>
    </div>
    </div>
</div>

<!-- <div class="nk-ibx-list" data-simplebar> -->
<div class="nk-ibx-list" style="margin: auto; width: 100%;">
    <?php 
    foreach ($header as $key => $value) { ?>
    <?php $url = base_url('inbox/viewpa/'.encode_url($value["idpa"]).'/'.$year); 
    if($value['created_by'] != ""){
    ?>

    <div class="nk-ibx-item" onclick="location.href='<?=$url;?>'">

        <!-- <div class="nk-ibx-item-elem nk-ibx-item-check">
            <div class="custom-control custom-control-sm custom-checkbox">
                <input type="checkbox" class="custom-control-input nk-dt-item-check" id="conversionItem02">
                <label class="custom-control-label" for="conversionItem02"></label>
            </div>
        </div>   -->
        <div class="nk-ibx-item-user" style="margin: auto;">
            <div class="user-card">
                    <div class="lead-text text-primary">
                         <?= $value['employee_id'];?> || <?= decrypt($value['employee_name']);?>
                    </div>
            </div>
        </div>
        <div class="nk-ibx-item-elem" style="margin: auto;">
            <div class="user-card">
                <div>
                        <!-- <strong>PA : <?=date("Y",strtotime($value['evaluation_period_start']));?></strong> -->
                        <strong>
                            Evaluation period: <?= $value['evaluation_period_start'];?>  - <?= $value['evaluation_period_end'];?>  
                        </strong>
                </div>
            </div>
        </div>

        <div class="nk-ibx-item-elem" style="margin: auto;">
            <div class="user-card">
                <div>
                        <?= $value['request_number'];?>
                </div>
            </div>
        </div>
        <div class="nk-ibx-item-elem" style="margin: auto;">
            <div><?= status_text($value['is_status']);?></div>
        </div>
    </div>
    <?php } } ?>

</div>


