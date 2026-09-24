<style>

    .table-wrapper {
        position: relative;
        overflow: hidden; /* penting */
    }

    .loading-table {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.35); /* transparan biar masih keliatan */
        z-index: 10;
    }

    .loading-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .loading-text span {
        color: #fff;
        margin: 0 5px;
        display: inline-block;
        animation: blur-text 1.5s infinite alternate;
        font-size: clamp(10px, 3vw, 25px);
    }

    .loading-text span:nth-child(1) { animation: blur-text 1.5s 0s infinite alternate; }
    .loading-text span:nth-child(2) { animation: blur-text 1.5s 0.2s infinite alternate; }
    .loading-text span:nth-child(3) { animation: blur-text 1.5s 0.4s infinite alternate; }
    .loading-text span:nth-child(4) { animation: blur-text 1.5s 0.6s infinite alternate; }
    .loading-text span:nth-child(5) { animation: blur-text 1.5s 0.8s infinite alternate; }
    .loading-text span:nth-child(6) { animation: blur-text 1.5s 1s infinite alternate; }
    .loading-text span:nth-child(7) { animation: blur-text 1.5s 1.2s infinite alternate; }

    @keyframes blur-text {
    from { filter: blur(0px); }
    to { filter: blur(4px); }
    }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #b3b1b1;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .hidden {
            display: none;
        }
        .filter-group {
            margin-bottom: 10px;
        }

        .dt-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .dt-buttons .btn {
            white-space: nowrap;
            flex: 0 0 auto;
        }

        .dataTables_wrapper .dataTable {
            margin-top: 0 !important;
        }


</style>

<div class="nk-ibx-head">
    <div class="nk-ibx-head-actions">
        
    </div>
    <div>
        <ul class="nk-ibx-head-tools g-1">
            <!-- <li>
                <a href="#" class="btn btn-trigger btn-icon search-toggle toggle-search" data-target="search"><em class="icon ni ni-search"></em></a>
            </li> -->
            <li class="mr-n1 d-lg-none">
                <a href="#" class="btn btn-trigger btn-icon toggle" data-target="inbox-aside"><em
                        class="icon ni ni-menu-alt-r"></em></a>
            </li>
        </ul>
    </div>
</div>

<div class="nk-ibx-reply nk-reply" data-simplebar>
<div class="card card-preview">
    <div class="tab-content">
        <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
            <li class="nav-item">
                <a class="nav-link active" href="#attendance_summary_detail" data-toggle="tab"><em class="icon ni ni-sign-cc-alt"></em><span>Employee Time Tracking Report</span></a>
            </li>
        </ul><!-- .nav-tabs -->

            <div class="tab-pane active" id="attendance_summary_detail">
                <div class="card-inner">
                    <div class="col-6">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="custom-control-sm custom-radio">
                                    <input type="radio" id="reportTypeAttS" name="reportTypeTM"
                                        class="custom-control-input" value="summary" checked>
                                    <label class="custom-control-label" for="reportTypeAttS">
                                        Attendance Summary
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="custom-control-sm custom-radio">
                                    <input type="radio" id="reportTypeAttD" name="reportTypeTM"
                                        class="custom-control-input" value="detail">
                                    <label class="custom-control-label" for="reportTypeAttD">
                                        Attendance Detail
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    </div>
                    <br>
                    <!-- Filter -->
                   <div class="col-6">
                        <div class="form-control-wrap">
                            <div class="input-group flex-nowrap">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width:110px">Employee No.</span>
                                </div>

                                <select
                                    class="form-control select-search_employee_summary"
                                    name="nik"
                                    id="nik"
                                    style="width: 100%;"
                                >
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-6">
                    <div class="form-control-wrap">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend"> <span class="input-group-text" id="inputGroup-sizing-sm" style="width:70px">Month</span> </div>
                            <?php $currentMonth = date('n'); ?>
                            <select class="form-control select-search_month_summary" id="month" style="width: 100%;">
                                <option value="All">All Month</option>
                                <option value="1" <?= ($currentMonth == 1) ? 'selected' : '' ?>>January</option>
                                <option value="2" <?= ($currentMonth == 2) ? 'selected' : '' ?>>February</option>
                                <option value="3" <?= ($currentMonth == 3) ? 'selected' : '' ?>>March</option>
                                <option value="4" <?= ($currentMonth == 4) ? 'selected' : '' ?>>April</option>
                                <option value="5" <?= ($currentMonth == 5) ? 'selected' : '' ?>>May</option>
                                <option value="6" <?= ($currentMonth == 6) ? 'selected' : '' ?>>June</option>
                                <option value="7" <?= ($currentMonth == 7) ? 'selected' : '' ?>>July</option>
                                <option value="8" <?= ($currentMonth == 8) ? 'selected' : '' ?>>August</option>
                                <option value="9" <?= ($currentMonth == 9) ? 'selected' : '' ?>>September</option>
                                <option value="10" <?= ($currentMonth == 10) ? 'selected' : '' ?>>October</option>
                                <option value="11" <?= ($currentMonth == 11) ? 'selected' : '' ?>>November</option>
                                <option value="12" <?= ($currentMonth == 12) ? 'selected' : '' ?>>December</option>
                            </select>
                        </div>
                    </div>
                    </div>
                    <br>
                    <div class="col-6">
                    <div class="form-control-wrap">
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend"> <span class="input-group-text" id="inputGroup-sizing-sm" style="width:70px">Year</span> </div>
                            <input type="number" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="year" value="<?=date("Y")?>">
                        </div>
                    </div>
                    </div>
                    <br>
                    <div class="col-6">
                        <button  class="btn btn-dim btn-outline-primary" onclick="applyFilterTM()">Filter</button>
                    </div>
                    <br>
                    <!-- TABLE BALANCE -->
                    <div class="table-wrapper" style="position: relative;">
                    <div class="loading-table" style="display:none;">
                        <div class="loading-text">
                        <span>L</span>
                        <span>O</span>
                        <span>A</span>
                        <span>D</span>
                        <span>I</span>
                        <span>N</span>
                        <span>G</span>
                        </div>
                    </div>
                    <table id="summaryTMTable" class="summaryTMTable nowrap table table-striped display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Employee No.</th>
                                <th>Employee Name</th>
                                <th>Position</th>
                                <th>Department</th>
                                <th>Division</th>
                                <th>Schedule Working Hours</th>
                                <th>Actual Working Hours</th>
                                <th>Time Off</th>
                                <th>Attendance Percentage</th>
                                <th>Late In</th>
                                <th>Early Check Out</th>
                            </tr>
                        </thead>
                        <tbody id="summaryTMBody">
                            <!-- Data akan diisi oleh JavaScript -->
                        </tbody>
                    </table>
                    </div>

                    <!-- TABLE DETAIL -->
                    <div class="table-wrapper" style="position: relative;">
                    <div class="loading-table" style="display:none;">
                        <div class="loading-text">
                        <span>L</span>
                        <span>O</span>
                        <span>A</span>
                        <span>D</span>
                        <span>I</span>
                        <span>N</span>
                        <span>G</span>
                        </div>
                    </div>
                    <table id="detailTMTable" class="detailTMTable nowrap table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Employee No.</th>
                                <th>Employee Name</th>
                                <th>Personnel Area</th>
                                <th>Personnel Subarea</th>
                                <th>Date</th>
                                <th>Schedule</th>
                                <th>Schedule In</th>
                                <th>Schedule Out</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Attendance Code</th>
                                <th>Time Off Code</th>
                                <th>Schedule Working Hours</th>
                                <th>Actual Working Hours</th>
                                <th>Late In</th>
                                <th>Early Check Out</th>
                                <th>Office In</th>
                                <th>Check In Location</th>
                                <th>Coordinates In</th>
                                <th>DMS In</th>
                                <th>Office Out</th>
                                <th>Check Out Location</th>
                                <th>Coordinates Out</th>
                                <th>DMS Out</th>
                            </tr>
                        </thead>
                        <tbody id="detailTMBody"></tbody>
                    </table> 
                    </div>
                    <hr>
                    <div class="col-6" id="div-exp-summary-tm">
                        <button  class="btn btn-dim btn-outline-info export_report_tm_summary" id="export_report_tm_summary">Export Summary</button>
                    </div>

                    <div class="col-6" id="div-exp-detail-tm">
                        <button  class="btn btn-dim btn-outline-info export_report_tm_detail" id="export_report_tm_detail">Export Details</button>
                    </div>

                </div>
            </div>
    </div>
</div>
</div>

<iframe id="downloadFrame" style="display:none;"></iframe>