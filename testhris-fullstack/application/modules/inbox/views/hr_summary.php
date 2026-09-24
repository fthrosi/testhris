<div class="nk-ibx-head">
    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <li>
                <a href="<?= site_url('inbox/hrd'); ?>" class="btn btn-icon btn-trigger"><em class="icon ni ni-undo"></em></a>
            </li>
        </ul>
    </div>
    <div>
        <ul class="nk-ibx-head-tools g-1">
            <li>
                <a href="#" class="btn btn-trigger btn-icon search-toggle toggle-search" data-target="search"><em class="icon ni ni-search"></em></a>
            </li>
            <li class="mr-n1 d-lg-none">
                <a href="<?= site_url('inbox/hrd'); ?>" class="btn btn-trigger btn-icon toggle" data-target="inbox-aside"><em class="icon ni ni-menu-alt-r"></em></a>
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
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Performance Appraisal & Plan.</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Evaluation Period Januari 2020 - Desember 2020</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nk-block">
                        <div class="card card-bordered card-stretch">
                            <div class="card-inner-group">
                                <div class="card-inner p-0">
                                    <table class="nk-tb-list nk-tb-ulist">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head">
                                                <th class="nk-tb-col nk-tb-col-check"></th>
                                                <th class="nk-tb-col"><span class="sub-text">Division Name</span></th>
                                                <th class="nk-tb-col tb-col-lg"><span class="sub-text">Div. Head</span></th>
                                                <th class="nk-tb-col tb-col-lg"><span class="sub-text">Total</span></th>
                                                <th class="nk-tb-col tb-col-xxl"><span class="sub-text">Status</span></th>
                                                <th class="nk-tb-col tb-col-md"><span class="sub-text">Progress</span></th>
                                                <th class="nk-tb-col nk-tb-col-tools text-right"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="nk-tb-item">
                                                <td class="nk-tb-col nk-tb-col-check">
                                                </td>
                                                <td class="nk-tb-col">
                                                    <a href="html/project-kanban.html" class="project-title">
                                                        <div class="user-avatar sq bg-primary"><span>IT</span></div>
                                                        <div class="project-info">
                                                            <h6 class="title">Information Technology</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="nk-tb-col tb-col-lg">
                                                    <span>Marcus Santosa</span>
                                                </td>
                                                <td class="nk-tb-col tb-col-lg">
                                                    <ul class="project-users g-1">
                                                        <li>
                                                            <div class="user-avatar bg-light sm"><span>12</span></div>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td class="nk-tb-col tb-col-xxl">
                                                    <span>Progress</span>
                                                </td>
                                                <td class="nk-tb-col tb-col-md">
                                                    <div class="project-list-progress">
                                                        <div class="progress progress-pill progress-md bg-light">
                                                            <div class="progress-bar" data-progress="93.5"></div>
                                                        </div>
                                                        <div class="project-progress-percent">93.5%</div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col nk-tb-col-tools">
                                                    <ul class="nk-tb-actions gx-1">
                                                        <li>
                                                            <div class="drodown">
                                                                <a href="#" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="html/project-kanban.html"><em class="icon ni ni-eye"></em><span>View</span></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr class="nk-tb-item">
                                                <td class="nk-tb-col nk-tb-col-check">
                                                </td>
                                                <td class="nk-tb-col">
                                                    <a href="html/project-kanban.html" class="project-title">
                                                        <div class="user-avatar sq bg-danger"><span>PI</span></div>
                                                        <div class="project-info">
                                                            <h6 class="title">Project Implementation</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="nk-tb-col tb-col-lg">
                                                    <span>Muhammad Ichsan</span>
                                                </td>
                                                <td class="nk-tb-col tb-col-lg">
                                                    <ul class="project-users g-1">
                                                        <li>
                                                            <div class="user-avatar bg-light sm"><span>100</span></div>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td class="nk-tb-col tb-col-xxl">
                                                    <span>Progress</span>
                                                </td>
                                                <td class="nk-tb-col tb-col-md">
                                                    <div class="project-list-progress">
                                                        <div class="progress progress-pill progress-md bg-light">
                                                            <div class="progress-bar" data-progress="23.5"></div>
                                                        </div>
                                                        <div class="project-progress-percent">23.5%</div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col nk-tb-col-tools">
                                                    <ul class="nk-tb-actions gx-1">
                                                        <li>
                                                            <div class="drodown">
                                                                <a href="#" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="html/project-kanban.html"><em class="icon ni ni-eye"></em><span>View</span></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr class="nk-tb-item">
                                                <td class="nk-tb-col nk-tb-col-check">
                                                </td>
                                                <td class="nk-tb-col">
                                                    <a href="html/project-kanban.html" class="project-title">
                                                        <div class="user-avatar sq bg-warning"><span>PMO</span></div>
                                                        <div class="project-info">
                                                            <h6 class="title">Project Management    </h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="nk-tb-col tb-col-lg">
                                                    <span>Haryo Dwi</span>
                                                </td>
                                                <td class="nk-tb-col tb-col-lg">
                                                    <ul class="project-users g-1">
                                                        <li>
                                                            <div class="user-avatar bg-light sm"><span>7</span></div>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td class="nk-tb-col tb-col-xxl">
                                                    <span>Progress</span>
                                                </td>
                                                <td class="nk-tb-col tb-col-md">
                                                    <div class="project-list-progress">
                                                        <div class="progress progress-pill progress-md bg-light">
                                                            <div class="progress-bar" data-progress="50"></div>
                                                        </div>
                                                        <div class="project-progress-percent">50%</div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col nk-tb-col-tools">
                                                    <ul class="nk-tb-actions gx-1">
                                                        <li>
                                                            <div class="drodown">
                                                                <a href="#" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="html/project-kanban.html"><em class="icon ni ni-eye"></em><span>View</span></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr class="nk-tb-item">
                                                <td class="nk-tb-col nk-tb-col-check">
                                                </td>
                                                <td class="nk-tb-col">
                                                    <a href="html/project-kanban.html" class="project-title">
                                                        <div class="user-avatar sq bg-purple"><span>FA</span></div>
                                                        <div class="project-info">
                                                            <h6 class="title">Finance Accounting</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="nk-tb-col tb-col-lg">
                                                    <span>Susana Alatas</span>
                                                </td>
                                                <td class="nk-tb-col tb-col-lg">
                                                    <ul class="project-users g-1">
                                                        <li>
                                                            <div class="user-avatar bg-light sm"><span>40</span></div>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td class="nk-tb-col tb-col-xxl">
                                                    <span>Progress</span>
                                                </td>
                                                <td class="nk-tb-col tb-col-md">
                                                    <div class="project-list-progress">
                                                        <div class="progress progress-pill progress-md bg-light">
                                                            <div class="progress-bar" data-progress="75"></div>
                                                        </div>
                                                        <div class="project-progress-percent">75%</div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col nk-tb-col-tools">
                                                    <ul class="nk-tb-actions gx-1">
                                                        <li>
                                                            <div class="drodown">
                                                                <a href="#" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="html/project-kanban.html"><em class="icon ni ni-eye"></em><span>View</span></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table><!-- .nk-tb-list -->
                                </div><!-- .card-inner -->
                            </div><!-- .card-inner-group -->
                        </div><!-- .card -->
                    </div><!-- .nk-block -->
                </div>
            </div>
        </div>
    </div>
</div>


