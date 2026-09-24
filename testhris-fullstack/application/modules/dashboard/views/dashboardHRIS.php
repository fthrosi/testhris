<style>

td:first-of-type a {
	background: url(<?= base_url(); ?>/assets/images_file/file.png) no-repeat 10px 50%;
	padding-left: 35px;
}
th:first-of-type {
	padding-left: 35px;
}
.tr_type :hover td a {
	color: #000;
}
a {
	text-decoration: none;
}

.td_type a {
	color: #663300;
	display: block;
	padding: 5px 10px;
}
.th_type a {
	padding-left: 0
}

.th_type th {
	background-color: #b1b5b2;
}

/* Lebih lega di mobile */
@media (max-width: 767px) {
  .dataTables_filter {
    text-align: center !important;
    margin-top: 10px;
  }

  .dataTables_filter input {
    width: 90% !important;
    margin: 0 auto;
  }

  .dataTables_length {
    text-align: center !important;
    margin-bottom: 5px;
  }

  .dataTables_info,
  .dataTables_paginate {
    text-align: center !important;
  }

  table.dataTable thead th {
    font-size: 13px;
    white-space: nowrap;
  }

  table.dataTable tbody td {
    font-size: 13px;
    white-space: nowrap;
  }
}

/* Umum */
.dataTables_wrapper .dataTables_paginate .paginate_button {
  padding: 3px 8px;
}



/* .tr_type:nth-of-type(odd) {
	background-color: white;
} */


/* icons for file types (icons by famfamfam) */

/* images */
table tr td:first-of-type a[href$=".jpg"], 
table tr td:first-of-type a[href$=".png"], 
table tr td:first-of-type a[href$=".gif"], 
table tr td:first-of-type a[href$=".svg"], 
table tr td:first-of-type a[href$=".jpeg"]
{background-image: url(<?= base_url(); ?>/assets/images_file/image.png);}

/* zips */
table tr td:first-of-type a[href$=".zip"] 
{background-image: url(<?= base_url(); ?>/assets/images_file/zip.png);}

/* zips */
table tr td:first-of-type a[href$=".ZIP"] 
{background-image: url(<?= base_url(); ?>/assets/images_file/zip.png);}

/* css */
table tr td:first-of-type a[href$=".css"] 
{background-image: url(<?= base_url(); ?>/assets/images_file/css.png);}

/* docs */
table tr td:first-of-type a[href$=".doc"],
table tr td:first-of-type a[href$=".docx"],
table tr td:first-of-type a[href$=".ppt"],
table tr td:first-of-type a[href$=".pptx"],
table tr td:first-of-type a[href$=".pps"],
table tr td:first-of-type a[href$=".ppsx"],
table tr td:first-of-type a[href$=".xls"],
table tr td:first-of-type a[href$=".xlsx"]
{background-image: url(<?= base_url(); ?>/assets/images_file/office.png)}

/* videos */
table tr td:first-of-type a[href$=".avi"], 
table tr td:first-of-type a[href$=".wmv"], 
table tr td:first-of-type a[href$=".mp4"], 
table tr td:first-of-type a[href$=".mov"], 
table tr td:first-of-type a[href$=".m4a"]
{background-image: url(<?= base_url(); ?>/assets/images_file/video.png);}

/* audio */
table tr td:first-of-type a[href$=".mp3"], 
table tr td:first-of-type a[href$=".ogg"], 
table tr td:first-of-type a[href$=".aac"], 
table tr td:first-of-type a[href$=".wma"] 
{background-image: url(<?= base_url(); ?>/assets/images_file/audio.png);}

/* web pages */
table tr td:first-of-type a[href$=".html"],
table tr td:first-of-type a[href$=".htm"],
table tr td:first-of-type a[href$=".xml"]
{background-image: url(<?= base_url(); ?>/assets/images_file/xml.png);}

table tr td:first-of-type a[href$=".php"] 
{background-image: url(<?= base_url(); ?>/assets/images_file/php.png);}

table tr td:first-of-type a[href$=".js"] 
{background-image: url(<?= base_url(); ?>/assets/images_file/script.png);}

/* directories */
table tr.dir td:first-of-type a
{background-image: url(<?= base_url(); ?>/assets/images_file/folder.png);}
</style>

<div class="nk-ibx-head">
    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <li>
                <?php
                    $nik = $InfoEmployee[0]->nik;
                    $time = date("H");
                    $timezone = date("e");
                    if ($time < "12") {
                        $say = "Good Morning";
                    } else if ($time >= "12" && $time < "17") {
                        $say = "Good Afternoon";
                    } else if ($time >= "17" && $time < "19") {
                        $say = "Good Evening";
                    } else if ($time >= "19") {
                        $say = "Good Night";
                    }
                ?>
                <h5>
		                <b>	
				<?php 
									?>
												
								 <?= $say.", ".decrypt($InfoEmployee[0]->complete_name) ?>
</b>
				                <br>
			
                </h5>
					                <?= "It's ".$today = date("l, M j Y"); ?>
														
											                <!-- <a href="<?= site_url('dashboard/dashboardHRIS'); ?>" class="btn btn-icon btn-trigger"><em class="icon ni ni-undo"></em></a> -->
            </li>
        </ul>
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
    <div class="card card-preview responsive-table">
        <div class="tab-content">

            <?php 
            $info_s = $info[0]['status'];
            $text = $info[0]['info'];

            if($info_s == 1){
                echo "<div class='alert alert-pro alert-warning'>    
                        <div class='alert-text'>        
                            <h6>INFORMATION</h6>        
                            <p>{$text}</p>    
                        </div>
                    </div>";

            }elseif($info_s == 2){
                echo "<div class='alert alert-pro alert-danger'>    
                        <div class='alert-text'>        
                            <h6>ATTENTION</h6>        
                            <p>{$text}</p>    
                        </div>
                    </div>";
            }
            ?>
            
            <table border='0' cellspacing="2" cellpadding="2" width="100%">
                <tr style="height: 200px;">
                    <td align="center">
                        <div class="user-avatar xxl" style="width:150px;">      
                        <?php 
                            $gen = ucwords(strtolower(decrypt($InfoEmployee[0]->gender))); 
                            if($gen =='Male'){
                        ?>  
                            <img src="<?php echo base_url(); ?>/assets/images/avatar_man.png" width="200">
                        <?php
                            }else{
                        ?>
                            <img src="<?php echo base_url(); ?>/assets/images/avatar_female.png">
                        <?php
                            }
                        ?>
                        </div>
                    </td>
                </tr>
                <tr style="height: 130px;">
                    <td align="center">
                    <font size="4">
                    <span class="tb-odr-id lead-primary fw-bold">
                        <?= (decrypt($InfoEmployee[0]->complete_name)); ?><br>
                        <?= $InfoEmployee[0]->nik; ?><br>
                        <?= (decrypt($InfoEmployee[0]->position)); ?>
                    </span>
                    </font>
                    </td>
                </tr>

                
                <!-- <tr>
                    <td align="center">
                    <font size="4">
                    <span class="tb-odr-id lead-primary fw-bold">
                        <?= $InfoEmployee[0]->nik; ?>
                    </span>
                    </font>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                    <font size="4">
                    <span class="tb-odr-id lead-primary fw-bold">
                        <?= (decrypt($InfoEmployee[0]->position)); ?>
                    </span>
                    </font>
                    </td>
                </tr> -->
            </table>

            <div>
                <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                    <li class="nav-item">
                        <a class="nav-link active" href="#personal" role="tab" data-toggle="tab">
                            <em class="icon ni ni-user-circle-fill"></em><span>Personal Info</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#employment" role="tab" data-toggle="tab">
                            <em class="icon ni ni-archived-fill"></em><span>Employment Data</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#eduexp" role="tab" data-toggle="tab">
                            <em class="icon ni ni-article"></em><span>Education & Experience</span></a>    
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#employeeslip" role="tab" data-toggle="tab">
                            <em class="icon ni ni-report-profit"></em><span>Employee Slip</span></a>       
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="personal">
                    <div class="card-inner">
                        <!-- <div class="btn-group">
                        <h4 class="title"><span class="text-soft"><b>UNDER MAINTENANCE PERSONAL</b></span>
                    </div>
                    <hr> -->
                        <div>
                            <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#basicinfo" role="tab"
                                        data-toggle="tab"><span>Basic Info</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#family" role="tab"
                                        data-toggle="tab"><span>Family</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#emergency_contact" role="tab"
                                        data-toggle="tab"><span>Emergency Contact</span></a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane active" id="basicinfo">
                                <div class="card-inner">
                                    <!-- Personal Data -->
                                    <div class="nk-reply-header nk-ibx-reply-header is-collapsed">
                                        <div class="nk-reply-desc">
                                            <div class="nk-reply-info">
                                                <div class="nk-reply-author lead-text">
                                                    <h5 class="text-soft">Personal Data</h5>
                                                </div>
                                                <div class="nk-reply-msg-excerpt">Click to view</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-reply-body nk-ibx-reply-body is-shown">
                                        <div class="nk-reply-entry entry">
                                            <div class="nk-block nk-block-lg">
                                                <div class="card card-bordered card-stretch">
                                                    <div class="card-inner-group">
                                                        <div class="card-inner">
                                                            <table class="table table-orders">
                                                                <tbody class="tb-odr-body">
                                                                    <tr class="tb-odr-item">
                                                                        <td class="tb-odr-info">
                                                                            <span
                                                                                class="tb-odr-id text-soft">Employee Number</span>
                                                                            <span
                                                                                class="tb-odr-id lead-primary fw-bold">
                                                                                <?= $InfoEmployee[0]->nik; ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="tb-odr-item">
                                                                        <td class="tb-odr-info">
                                                                            <span
                                                                                class="tb-odr-id text-soft">Complete Name</span>
                                                                            <span
                                                                                class="tb-odr-id lead-primary fw-bold">
                                                                                <?= ucwords(strtolower(decrypt($InfoEmployee[0]->complete_name))); ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="tb-odr-item">
                                                                        <td class="tb-odr-info">
                                                                            <span
                                                                                class="tb-odr-id text-soft">Phone</span>
                                                                            <span
                                                                                class="tb-odr-id lead-primary fw-bold">
                                                                                <?= (decrypt($InfoEmployee[0]->phone_number)); ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="tb-odr-item">
                                                                        <td class="tb-odr-info">
                                                                            <span
                                                                                class="tb-odr-id text-soft">Smartfren Number</span>
                                                                            <span
                                                                                class="tb-odr-id lead-primary fw-bold">
                                                                                <?= (decrypt($InfoEmployee[0]->sf_phone_number)); ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="tb-odr-item">
                                                                        <td class="tb-odr-info">
                                                                            <span
                                                                                class="tb-odr-id text-soft">Personal Email</span>
                                                                            <span
                                                                                class="tb-odr-id lead-primary fw-bold">
                                                                                <?= (decrypt($InfoEmployee[0]->personal_email)); ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="tb-odr-item">
                                                                        <td class="tb-odr-info">
                                                                            <span
                                                                                class="tb-odr-id text-soft">Company Email</span>
                                                                            <span
                                                                                class="tb-odr-id lead-primary fw-bold">
                                                                                <?= (decrypt($InfoEmployee[0]->email)); ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="tb-odr-item">
                                                                        <td class="tb-odr-info">
                                                                            <span
                                                                                class="tb-odr-id text-soft">Birthplace</span>
                                                                            <span
                                                                                class="tb-odr-id lead-primary fw-bold">
                                                                                <?= (decrypt($InfoEmployee[0]->birthplace)); ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="tb-odr-item">
                                                                        <td class="tb-odr-info">
                                                                            <span class="tb-odr-id text-soft">Birthdate</span>
                                                                            <span
                                                                                class="tb-odr-id lead-primary fw-bold">
                                                                                <?php
                                                                                $date_of_birth = decrypt($InfoEmployee[0]->date_of_birth);
                                                                                $date_of_birth = DateTime::createFromFormat('Ymd', $date_of_birth);
                                                                                $date_of_birth = $date_of_birth->format('d.m.Y');


                                                                                $birthDate = new DateTime($date_of_birth);
                                                                                $today     = date("Y-m-d");
                                                                                $today     = new DateTime($today);
                                                                                if ($birthDate > $today) {
                                                                                    exit("0");
                                                                                }
                                                                                $y = $today->diff($birthDate)->y;
                                                                                echo $date_of_birth . ' | ' . $y . ' Year';
                                                                                ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="tb-odr-item">
                                                                        <td class="tb-odr-info">
                                                                            <span class="tb-odr-id text-soft">Gender</span>
                                                                            <span
                                                                                class="tb-odr-id lead-primary fw-bold">
                                                                                <?= ucwords(strtolower(decrypt($InfoEmployee[0]->gender))); ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="tb-odr-item">
                                                                        <td class="tb-odr-info">
                                                                            <span
                                                                                class="tb-odr-id text-soft">Marital Status</span>
                                                                            <span
                                                                                class="tb-odr-id lead-primary fw-bold">
                                                                                <?php
                                                                                if((decrypt($InfoEmployee[0]->marital_status)) == 'Marr.'){
                                                                                    $marital_status = 'Married';
                                                                                }else if(((decrypt($InfoEmployee[0]->marital_status)) == 'Div.') || ((decrypt($InfoEmployee[0]->marital_status)) == 'Wid.')){
                                                                                    $marital_status = 'Divorce';
                                                                                }else{
                                                                                    $marital_status = 'Single';
                                                                                }
                                                                                ?>
                                                                                <?= $marital_status; ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="tb-odr-item">
                                                                        <td class="tb-odr-info">
                                                                            <span
                                                                                class="tb-odr-id text-soft">Religion</span>
                                                                            <span
                                                                                class="tb-odr-id lead-primary fw-bold">
                                                                                <?= (decrypt($InfoEmployee[0]->religion)); ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <hr>
                                    <br>
                                    <div class="nk-reply-header nk-ibx-reply-header is-collapsed">
                                        <div class="nk-reply-desc">
                                            <div class="nk-reply-info">
                                                <div class="nk-reply-author lead-text">
                                                    <h5 class="text-soft">Identity Card</h5>
                                                </div>
                                                <div class="nk-reply-msg-excerpt">Click to view</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-reply-body nk-ibx-reply-body is-shown">
                                        <div class="nk-reply-entry entry">
                                            <div class="nk-block nk-block-lg">
                                                <div class="card card-bordered card-stretch">
                                                    <div class="card-inner-group">
                                                        <div class="card-inner">
                                                            <table class="table table-orders table-responsive">
                                                                <tbody class="tb-odr-body">
                                                                    <tr class="tb-odr-item">
                                                                        <td class="tb-odr-info">
                                                                            <span
                                                                                class="tb-odr-id text-soft">ID Type</span>
                                                                            <span
                                                                                class="tb-odr-id lead-primary fw-bold">
                                                                                KTP
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="tb-odr-item">
                                                                        <td class="tb-odr-info">
                                                                            <span
                                                                                class="tb-odr-id text-soft">ID Number</span>
                                                                            <span
                                                                                class="tb-odr-id lead-primary fw-bold">
                                                                                <?= ucwords(strtolower(decrypt($InfoEmployee[0]->no_ktp))); ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="tb-odr-item">
                                                                        <td class="tb-odr-info">
                                                                            <span
                                                                                class="tb-odr-id text-soft">Permanent Address</span>
                                                                            <span
                                                                                class="tb-odr-id lead-primary fw-bold">
                                                                                <?= (decrypt($InfoEmployee[0]->permanent_address)); ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="tb-odr-item">
                                                                        <td class="tb-odr-info">
                                                                            <span
                                                                                class="tb-odr-id text-soft">Temporary Address</span>
                                                                            <span
                                                                                class="tb-odr-id lead-primary fw-bold">
                                                                                <?= (decrypt($InfoEmployee[0]->temporary_address)); ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane" id="family">
                                <div class="card-inner"  style="overflow-x:auto;">
                                    <div class="btn-group">
                                        <table class="table dashboard_employee-table table-striped"
                                            data-export-title="Export Data" id="table_dashboard_family"
                                            data-ajaxsource="<?= site_url('dashboard/read_data_employee/family_employee/'); ?>">
                                            <thead>
                                                <tr>
                                                    <th>Family Members</th>
                                                    <th>SeqNo</th>
                                                    <th>Member Names</th>
                                                    <th>Gender</th>
                                                    <th>Member Birthplace</th>
                                                    <th>Member Birthdate</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                            <div class="tab-pane" id="emergency_contact">
                                <div class="card-inner"  style="overflow-x:auto;">
                                    <div class="btn-group">
                                        Under Maintenance
                                    </div>
                                    <hr>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="employment">
                    <div class="card-inner">
                        <!-- Personal Data -->
                        <div class="nk-reply-header nk-ibx-reply-header">
                                        <div class="nk-reply-desc">
                                            <div class="nk-reply-info">
                                                <div class="nk-reply-author lead-text">
                                                    <h5 class="text-soft">Employment Data</h5>
                                                </div>
                                                <div class="nk-reply-msg-excerpt">Click to view</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-reply-body nk-ibx-reply-body is-shown">
                                        <div class="nk-reply-entry entry">
                                            <div class="nk-block nk-block-lg">
                                                <div class="card card-bordered card-stretch">
                                                    <div class="card-inner-group">
                                                        <div class="card-inner">
                                                            <table class="table table-orders">
                                                                <tbody class="tb-odr-body">
                                                                    <tr class="tb-odr-item">
                                                                        <td class="tb-odr-info">
                                                                            <span
                                                                                class="tb-odr-id text-soft">Employee Number</span>
                                                                            <span
                                                                                class="tb-odr-id lead-primary fw-bold">
                                                                                <?= $InfoEmployee[0]->nik; ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="tb-odr-item">
                                                                        <td class="tb-odr-info">
                                                                            <span class="tb-odr-id text-soft">Company</span>
                                                                            <span
                                                                                class="tb-odr-id lead-primary fw-bold">
                                                                                <?= (decrypt($InfoEmployee[0]->company_name)); ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="tb-odr-item">
                                                                        <td class="tb-odr-info">
                                                                            <span
                                                                                class="tb-odr-id text-soft">Directorat</span>
                                                                            <span
                                                                                class="tb-odr-id lead-primary fw-bold">
                                                                                <?= ucwords(decrypt($InfoEmployee[0]->directorate)); ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="tb-odr-item">
                                                                        <td class="tb-odr-info">
                                                                            <span
                                                                                class="tb-odr-id text-soft">Departement</span>
                                                                            <span
                                                                                class="tb-odr-id lead-primary fw-bold">
                                                                                <?= (decrypt($InfoEmployee[0]->department)); ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="tb-odr-item">
                                                                        <td class="tb-odr-info">
                                                                            <span
                                                                                class="tb-odr-id text-soft">Position</span>
                                                                            <span
                                                                                class="tb-odr-id lead-primary fw-bold">
                                                                                <?= (decrypt($InfoEmployee[0]->position)); ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="tb-odr-item">
                                                                        <td class="tb-odr-info">
                                                                            <span
                                                                                class="tb-odr-id text-soft">Grade</span>
                                                                            <span
                                                                                class="tb-odr-id lead-primary fw-bold">
                                                                                <?= ucwords(strtolower(decrypt($InfoEmployee[0]->employee_group))); ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="tb-odr-item">
                                                                        <td class="tb-odr-info">
                                                                            <span
                                                                                class="tb-odr-id text-soft">Employement Status</span>
                                                                            <span
                                                                                class="tb-odr-id lead-primary fw-bold">
                                                                                <?= ucwords(strtolower(decrypt($InfoEmployee[0]->employee_subgroup))); ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="tb-odr-item">
                                                                        <td class="tb-odr-info">
                                                                            <span
                                                                                class="tb-odr-id text-soft">Personnel Area</span>
                                                                            <span
                                                                                class="tb-odr-id lead-primary fw-bold">
                                                                                <?= (decrypt($InfoEmployee[0]->personnel_area)); ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="tb-odr-item">
                                                                        <td class="tb-odr-info">
                                                                            <span
                                                                                class="tb-odr-id text-soft">Personnel Subarea</span>
                                                                            <span
                                                                                class="tb-odr-id lead-primary fw-bold">
                                                                                <?= (decrypt($InfoEmployee[0]->personnel_subarea)); ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="tb-odr-item">
                                                                        <td class="tb-odr-info">
                                                                            <span class="tb-odr-id text-soft">Join Date</span>
                                                                            <span
                                                                                class="tb-odr-id lead-primary fw-bold">
                                                                                <?php
                                                                                $join_date = decrypt($InfoEmployee[0]->join_date);
                                                                                $join_date = DateTime::createFromFormat('Ymd', $join_date);
                                                                                $join_date_f = $join_date->format('d.m.Y');

                                                                                $join_date_g           = strtotime(decrypt($this->session->userdata('join_date')));
                                                                                $join_date_g           = date('Y-m-d', $join_date_g);
                                                                                $today                 = date("Y-m-d");

                                                                                $diff                = abs(strtotime($today) - strtotime($join_date_g));
                                                                                $join_years          = floor($diff / (365*60*60*24));
                                                                                $join_months         = floor(($diff - $join_years * 365*60*60*24) / (30*60*60*24));
                                                                                $join_days           = floor(($diff - $join_years * 365*60*60*24 - $join_months*30*60*60*24)/ (60*60*24));                                                                                
                                                                                
                                                                                echo $join_date_f . ' | ' . $join_years . ' Year '. $join_months .' Month '. $join_days .' Day ';
                                                                                ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="tb-odr-item">
                                                                        <td class="tb-odr-info">
                                                                            <span
                                                                                class="tb-odr-id text-soft">Status PTKP</span>
                                                                            <span
                                                                                class="tb-odr-id lead-primary fw-bold">
                                                                                <?= (decrypt($InfoEmployee[0]->status_ptkp)); ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="tb-odr-item">
                                                                        <td class="tb-odr-info">
                                                                            <span
                                                                                class="tb-odr-id text-soft">NPWP ID</span>
                                                                            <span
                                                                                class="tb-odr-id lead-primary fw-bold">
                                                                                <?= (decrypt($InfoEmployee[0]->npwp_id)); ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="tb-odr-item">
                                                                        <td class="tb-odr-info">
                                                                            <span
                                                                                class="tb-odr-id text-soft">BPJS Ketenagakerjaan</span>
                                                                            <span
                                                                                class="tb-odr-id lead-primary fw-bold">
                                                                                <?= (decrypt($InfoEmployee[0]->bpjs_ketenagakerjaan)); ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="tb-odr-item">
                                                                        <td class="tb-odr-info">
                                                                            <span
                                                                                class="tb-odr-id text-soft">BPJS Kesehatan</span>
                                                                            <span
                                                                                class="tb-odr-id lead-primary fw-bold">
                                                                                <?= (decrypt($InfoEmployee[0]->bpjs_kesehatan)); ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="tb-odr-item">
                                                                        <td class="tb-odr-info">
                                                                            <span
                                                                                class="tb-odr-id text-soft">Sinarmas Account</span>
                                                                            <span
                                                                                class="tb-odr-id lead-primary fw-bold">
                                                                                <?= (decrypt($InfoEmployee[0]->bankn)); ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="tb-odr-item">
                                                                        <td class="tb-odr-info">
                                                                            <span
                                                                                class="tb-odr-id text-soft">Mandiri Account</span>
                                                                            <span
                                                                                class="tb-odr-id lead-primary fw-bold">
                                                                                <?= (decrypt($InfoEmployee[0]->bankn1)); ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        <hr>
                    </div>
                </div>
                <div class="tab-pane" id="eduexp">
                    <div class="card-inner">
                        <!-- Personal Data -->
                        <div>
                            <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#formaleducation" role="tab"
                                        data-toggle="tab"><span>Formal Education</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#workingexperience" role="tab"
                                        data-toggle="tab"><span>Working Experience</span></a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                        <div class="tab-pane active" id="formaleducation">
                                <div class="card-inner"  style="overflow-x:auto;">
                                    <div class="btn-group">
                                        Formal Education
                                    </div>
                                    <hr>
                                </div>
                            </div>
                            <div class="tab-pane" id="workingexperience">
                                <div class="card-inner"  style="overflow-x:auto;">
                                    <div class="btn-group">
                                        Working Experience
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        <hr>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="employeeslip">
                    <div class="card-inner" style="overflow-x:auto;">
                        <table id="MySlip" class="MySlip table-hover nowrap tr_type th_type td_type" width="100%">
                            <thead>
                                <tr>
                                    <th>File Name</th>
                                    <th>Period</th>
                                    <th>Slip Type</th>
                                    <th>Date Modified</th>
                                    <th>Size</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // === Fungsi untuk menampilkan ukuran file dalam format cantik ===
                                function pretty_filesize($files, $nik) {
                                    $fpath = 'reports/payslip/' . encrypt_pay($nik.'InfrastrukturBisnisSejahtera'.$nik.'HRIS') . '/' . $files;
                                    if (file_exists($fpath)) {
                                        $size = filesize($fpath);
                                        if ($size < 1024) $size = $size . " Bytes";
                                        elseif ($size < 1048576) $size = round($size / 1024, 1) . " KB";
                                        elseif ($size < 1073741824) $size = round($size / 1048576, 1) . " MB";
                                        else $size = round($size / 1073741824, 1) . " GB";
                                        return $size;
                                    }
                                    return "-";
                                }

                                // === Path folder payslip ===
                                $dpath = "reports/payslip/" . encrypt_pay($nik.'InfrastrukturBisnisSejahtera'.$nik.'HRIS') . "/";

                                // === Cek folder tersedia ===
                                if (is_dir($dpath)) {
                                    $dirArray = [];
                                    if ($handle = opendir($dpath)) {
                                        while (false !== ($entryName = readdir($handle))) {
                                            if ($entryName != '.' && $entryName != '..' && $entryName != 'index.php' && $entryName != 'index.html') {
                                                $dirArray[] = $entryName;
                                            }
                                        }
                                        closedir($handle);
                                    }

                                    if (!empty($dirArray)) {
                                        // === Urutkan berdasarkan tanggal modified DESC ===
                                        $fileTimes = [];
                                        foreach ($dirArray as $file) {
                                            $fpath = $dpath . $file;
                                            if (is_file($fpath)) {
                                                $fileTimes[$file] = filemtime($fpath);
                                            }
                                        }
                                        array_multisort($fileTimes, SORT_DESC, $dirArray);

                                        // === Tampilkan daftar file ===
                                        foreach ($dirArray as $name) {
                                            $pieces = explode("_", $name);
                                            $nik    = $pieces[0];
                                            $var    = $pieces[1] ?? 'Monthly';
                                            $month  = $pieces[2] ?? $var;
                                            $mnt    = explode(".", $month);
                                            $month  = $mnt[0];
                                            $fpath  = $dpath . $name;

                                            if (file_exists($fpath)) {
                                                $modtime = date("Y-m-d H:i:s", filemtime($fpath));
                                                $size = pretty_filesize($name, $nik);
                                            } else {
                                                $modtime = "-";
                                                $size = "-";
                                            }

                                            echo "
                                            <tr>
                                                <td><a target='_blank' rel='noopener noreferrer' href='$fpath'>$name</a></td>
                                                <td>$month</td>
                                                <td>$var</td>
                                                <td>$modtime</td>
                                                <td>$size</td>
                                            </tr>";
                                        }
                                    } else {
                                        echo "<tr>
                                            <td></td>
                                            <td></td>
                                            <td><center><b>SLIP NOT FOUND</b></center></td>
                                            <td></td>
                                            <td></td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr>
                                        <td></td>
                                        <td></td>
                                        <td><center><b>SLIP NOT FOUND</b></center></td>
                                        <td></td>
                                        <td></td>
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
</div>                                