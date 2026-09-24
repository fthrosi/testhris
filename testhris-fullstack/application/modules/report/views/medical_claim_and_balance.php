<style>
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
                <a class="nav-link active" href="#medical_claim_balance" data-toggle="tab"><em class="icon ni ni-sign-cc-alt"></em><span>Medical Claim and Balance</span></a>
            </li>
        </ul><!-- .nav-tabs -->

            <div class="tab-pane active" id="medical_claim_balance">
                <div class="card-inner">
                    <div class="col-6">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="custom-control-sm custom-radio">
                                    <input type="radio" id="reportTypeMCBS" name="reportType"
                                        class="custom-control-input" value="balance" checked>
                                    <label class="custom-control-label" for="reportTypeMCBS">
                                        Medical Claim Balance Summary
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="custom-control-sm custom-radio">
                                    <input type="radio" id="reportTypeMCD" name="reportType"
                                        class="custom-control-input" value="detail">
                                    <label class="custom-control-label" for="reportTypeMCD">
                                        Medical Claim Detail
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
                                    class="form-control select-search_employee_balance"
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
                            <select class="form-control select-search_month_balance" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="month" style="width: 100%;">
                                <option value="All">All Month</option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>

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
                        <button  class="btn btn-dim btn-outline-primary" onclick="applyFilter()">Filter</button>
                    </div>
                    <br>
                    <!-- TABLE BALANCE -->
                    <table id="balanceMDCRTable" class="balanceMDCRTable nowrap table table-striped display" style="width:100%">
                        <thead>
                            <tr>
                                <th rowspan="2">Employee No.</th>
                                <th rowspan="2">Employee Name</th>
                                <th rowspan="2">Cost Center</th>

                                <th colspan="3" style="text-align: center; vertical-align: middle; border-bottom: 1px solid #b3b1b1 !important;">Outpatient</th>
                                <th colspan="3" style="text-align: center; vertical-align: middle; border-bottom: 1px solid #b3b1b1 !important;">Inpatient</th>
                                <th colspan="3" style="text-align: center; vertical-align: middle; border-bottom: 1px solid #b3b1b1 !important;">Optic</th>

                                <th rowspan="2">Action</th>
                                <th rowspan="2">Month</th>
                                <th rowspan="2">Year</th>
                            </tr>
                            <tr>
                                <!-- Outpatient -->
                                <th>Plafon Amount</th>
                                <th>Claimed Amount</th>
                                <th>Remaining Balance</th>

                                <!-- Inpatient -->
                                <th>Plafon Amount</th>
                                <th>Claimed Amount</th>
                                <th>Remaining Balance</th>

                                <!-- Optic -->
                                <th>Plafon Amount</th>
                                <th>Claimed Amount</th>
                                <th>Remaining Balance</th>
                            </tr>
                        </thead>
                        <tbody id="balanceMDCRBody">
                            <!-- Data akan diisi oleh JavaScript -->
                        </tbody>
                    </table>


                    <!-- TABLE DETAIL -->
                    <!-- <table id="detailMDCRTable" class="hidden"> -->
                    <table id="detailMDCRTable" class="detailMDCRTable nowrap table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Nama Karyawan</th>
                                <th><i>Cost Center</i></th>
                                <th>Jenis Penggantian</th>
                                <th>Sub Penggantian</th>
                                <th>Detil Penggantian</th>
                                <th>Diagnosa</th>
                                <th>Status Peserta</th>
                                <th>Keterangan</th>
                                <th>Nominal Kuitansi</th>
                                <th>Nominal Penggantian</th>
                                <th>Tanggal Kuitansi</th>
                                <th><i>Submit Date</i></th>
                                <th><i>Checked by HR Date</i></th>
                                <th><i>Bundling FI Date</i></th>
                                <th><i>Approved by HRGA Divhead Date</i></th>
                                <th><i>HR sent to AP Date</i></th>
                                <th><i>Fully Paid Date</i></th>
                            </tr>
                        </thead>
                        <tbody id="detailMDCRBody"></tbody>
                    </table> 
                    <hr>
                    <div class="col-6" id="div-exp-balance">
                        <button  class="btn btn-dim btn-outline-info export_report_mdcr_balance" id="export_report_mdcr_balance">Export Balance</button>
                    </div>

                    <div class="col-6" id="div-exp-detail">
                        <button  class="btn btn-dim btn-outline-info export_report_mdcr_detail" id="export_report_mdcr_detail">Export Details</button>
                    </div>

                </div>
            </div>
    </div>
</div>
</div>

<iframe id="downloadFrame" style="display:none;"></iframe>