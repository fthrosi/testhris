<div class="nk-ibx-head">
    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <li>
                <a href="<?= site_url('inbox'); ?>" class="btn btn-icon btn-trigger"><em class="icon ni ni-undo"></em></a>
            </li>
            <li>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-v"></em></a>
                    <div class="dropdown-menu">
                        <ul class="link-list-opt no-bdr">
                            <li><a class="dropdown-item" href="#"><em class="icon ni ni-eye"></em><span>Move to</span></a></li>
                            <li><a class="dropdown-item" href="#"><em class="icon ni ni-trash"></em><span>Delete</span></a></li>
                            <li><a class="dropdown-item" href="#"><em class="icon ni ni-archived"></em><span>Archive</span></a></li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div>
        <ul class="nk-ibx-head-tools g-1">
            <li>
                <a href="<?= site_url('inbox'); ?>" class="btn btn-trigger btn-icon search-toggle toggle-search" data-target="search"><em class="icon ni ni-search"></em></a>
            </li>
            <li class="mr-n1 d-lg-none">
                <a href="<?= site_url('inbox'); ?>" class="btn btn-trigger btn-icon toggle" data-target="inbox-aside"><em class="icon ni ni-menu-alt-r"></em></a>
            </li>
        </ul>
    </div>
    <div class="search-wrap" data-search="search">
        <div class="search-content">
            <a href="<?= site_url('inbox'); ?>" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
            <input type="text" onkeyup="search_approval()" id="search_approval" class="form-control border-transparent form-focus-none" placeholder="Search request">
            <button class="search-submit btn btn-icon"><em class="icon ni ni-search"></em></button>
        </div>
    </div>
</div>

<div class="nk-ibx-list" data-simplebar>
    <!-- List Request -->
    <div class="nk-ibx-item is-unread" onclick="location.href='<?= base_url() ?>inbox/view/form_kpi';" style="display: show;">
        <div class="nk-ibx-item-elem nk-ibx-item-check">
            <div class="custom-control custom-control-sm custom-checkbox">
                <input type="checkbox" class="custom-control-input nk-dt-item-check" id="conversionItem02">
                <label class="custom-control-label" for="conversionItem02"></label>
            </div>
        </div>
        <div class="nk-ibx-item-elem nk-ibx-item-star">
            <div class="asterisk"><a class="active" href="#"><em class="asterisk-off icon ni ni-star"></em><em class="asterisk-on icon ni ni-star-fill"></em></a></div>
        </div>
        <div class="nk-ibx-item-elem nk-ibx-item-user">
            <div class="user-card">
                <div class="user-avatar">
                    <img src="./images/avatar/b-sm.jpg" alt="">
                </div>
                <div class="user-name">
                    <div class="lead-text">Ricardo Salazar</div>
                </div>
            </div>
        </div>
        <div class="nk-ibx-item-elem nk-ibx-item-fluid">
            <div class="nk-ibx-context-group">
                <div class="nk-ibx-context-badges"><span class="badge badge-primary">Feedback</span></div>
                <div class="nk-ibx-context">
                    <span class="nk-ibx-context-text">
                        <span class="heading">Can we help you set up email forwording?</span> We’ve noticed you haven’t set up email forward </span>
                </div>
            </div>
        </div>
        <div class="nk-ibx-item-elem nk-ibx-item-attach">
            <a class="link link-light">
                <em class="icon ni ni-clip-h"></em>
            </a>
        </div>
        <div class="nk-ibx-item-elem nk-ibx-item-time">
            <div class="sub-text">10:00 AM</div>
        </div>
        <div class="nk-ibx-item-elem nk-ibx-item-tools">
            <div class="ibx-actions">
                <ul class="ibx-actions-hidden gx-1">
                    <li>
                        <a href="#" class="btn btn-sm btn-icon btn-trigger" data-toggle="tooltip" data-placement="top" title="Archive"><em class="icon ni ni-archived"></em></a>
                    </li>
                    <li>
                        <a href="#" class="btn btn-sm btn-icon btn-trigger" data-toggle="tooltip" data-placement="top" title="Delete"><em class="icon ni ni-trash"></em></a>
                    </li>
                </ul>
                <ul class="ibx-actions-visible gx-2">
                    <li>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <ul class="link-list-opt no-bdr">
                                    <li><a class="dropdown-item" href="#"><em class="icon ni ni-eye"></em><span>View</span></a></li>
                                    <li><a class="dropdown-item" href="#"><em class="icon ni ni-trash"></em><span>Delete</span></a></li>
                                    <li><a class="dropdown-item" href="#"><em class="icon ni ni-archived"></em><span>Archive</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>


