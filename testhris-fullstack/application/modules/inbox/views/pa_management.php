<?php 

if ($division_status['is_status'] == 3 || $division_status['is_status'] == 1) {
    $show = 'none';
} else {
    $show = '';
} 

$nik = $this->session->userdata('nik');
$sql = "SELECT *
						FROM form_request as a left join form_approval as b on a.id = b.request_id
						WHERE a.employee_id LIKE '$nik' AND YEAR(a.created_at) = '$ev_year' AND b.approval_status = 'Approved' AND b.approval_priority = '1' AND b.approval_email LIKE 'MAKMUR.JAURY@IBSMULTI.COM' and (left(a.request_number,8) = 'EAPP_KPI' or left(a.request_number,9) = 'EAPP_PLAN')
						ORDER BY a.id ASC";
$query = $this->db->query($sql);
$res = $query->row();
if(!empty($res)){
    $disabled = '';
}else{
    $disabled = '';
}

// if($division_status['is_status'] == 0){
//     $show = "none";
// }
// echo $show." xxx"; die;
?>
<style>
.box-scroll {
flex-wrap: nowrap;
width: 100%;
height:600px;
overflow: auto;
cursor: pointer;
/* Hiddem scroll bar */
scrollbar-width: none;  /* Firefox */
-ms-overflow-style: none;  /* IE and Edge */
}

/* Hide scrollbar for Chrome, Safari and Opera */
.box-scroll::-webkit-scrollbar {
display: none;
}

.text1 {
      writing-mode:tb-rl;
    -webkit-transform:rotate(-90deg);
    -moz-transform:rotate(-90deg);
    -o-transform: rotate(-90deg);
    -ms-transform:rotate(-90deg);
    transform: rotate(180deg);
    white-space:nowrap;
    float:left;
    }
</style>
<div class="nk-ibx-head">
    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
           <li class="ml-n2" style="display: <?=$show?>">
                <a onclick="return responseDivision(this.id)" id="submit_to_hr" class="btn btn-icon btn-tooltip" title="Submit to HR">
                    <em class="icon ni ni-send"></em>
                        Submit to HR
                </a>
            </li>
            <li>
            
            </li>
        </ul>
    </div>
</div>


<div class="nk-ibx-reply nk-reply" data-simplebar>

    <div class="nk-ibx-reply-head">
        <div>
            <h4 class="title ff-base"><?=strtoupper(decrypt($this->session->userdata('division')));?> <span class="text-soft">DIVISION</span></h4>
            <?php 
            if(!empty($division_status['iom_file']) != ""){
                    $path = base_url().'upload/iom/'.$division_status['iom_file'];
                    echo "Revised with iom file: <a href = '{$path}' target = '_blank'>".$division_status['iom_file']."</a>";
                }
            ?>
        </div>
        <ul class="d-flex g-1">
            <li class="d-none d-sm-block" id="request_status"> 
                <?php 
                if (!empty($division_status)) {
                    echo status_division($division_status['is_status']);
                } else {
                    echo status_division(0);
                }
                ?>    
            </li>
        </ul>
    </div>

    <div class="card card-preview">
        <div class="card-inner">
            <div class="nk-block">
                <div class="row g-gs">
                    
                    <div class="col-lg-6 col-xxl-6">
                        <div class="card card-bordered h-100">
                            <div class="card-inner mb-n2">
                                <div class="card-title-group">
                                    <div class="card-title card-title-sm">
                                        <h6 class="title">PA & Plan Submision Progress </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-tb-list is-loose traffic-channel-table">
                                <div class="nk-tb-item nk-tb-head">
                                    <div class="nk-tb-col nk-tb-sessions"><span></span></div>
                                    <div class="nk-tb-col nk-tb-channel"><span>Total</span></div>
                                    <div class="nk-tb-col nk-tb-sessions"><span></span></div>
                                </div>
                                <div class="nk-tb-item">
                                     <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead text-primary">Waiting Approval</span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead"><?=$total_inprogress;?></span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">
                                            <a class="btn btn-sm btn-dim" onclick="return viewSummaryByDivision(this.id);" id="1">View</a>
                                        </span>
                                    </div>
                                </div>
                                <div class="nk-tb-item">
                                     <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead text-primary">Revise</span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead"><?=$total_revise;?></span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">
                                            <a class="btn btn-sm btn-dim" onclick="return viewSummaryByDivision(this.id);" id="2">View</a>
                                        </span>
                                    </div>
                                </div>
                                <div class="nk-tb-item">
                                     <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead text-success"><span class="badge badge-success">Full Approved</span></span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead"><?=$total_approved;?></span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="text-soft"><i>Check on the table below</i></span>
                                    </div>
                                </div>
                                <div class="nk-tb-item">
                                     <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">Total PA Submission</span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead"><span class="badge badge-pill badge-sm badge-soft"><?=($total_approved + $total_revise + $total_inprogress);?></span></span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead"></span>
                                    </div>
                                </div>
                                 <div class="nk-tb-item">
                                     <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">Total Team Member</span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead"><span class="badge badge-pill badge-sm badge-primary"><?=$total_team;?></span></span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">
                                            <a class="btn btn-sm btn-dim" onclick="return viewTeamMember(this.id);" id="<?= encrypt($this->session->userdata('division')) ?>">View</a>    
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php 
                        // $a = $this->db->query("select * from v_hris_employee_updated where email = '".encrypt($this->session->userdata('user_email'))."'")->result_array();
                        // foreach($a[0] as $key => $val){
                        //     if($key == "usrid_long3"){
                        //         echo $key." ==> ".decrypt($val)."<br>";
                        //     }else{
                        //         echo $key." ==> ".$val."<br>";
                        //     }
                            
                        // }
                    ?>

                    <div class="col-lg-6 col-xxl-6">
                        <div class="card card-bordered h-100">
                            <div class="card-inner mb-n2">
                                <div class="card-title-group">
                                    <div class="card-title card-title-sm">
                                        <h6 class="title">Summary Grade (Full approved)</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-tb-list is-loose traffic-channel-table">
                                <div class="nk-tb-item nk-tb-head">
                                    <div class="nk-tb-col nk-tb-sessions"><span>Score</span></div>
                                    <div class="nk-tb-col nk-tb-channel"><span>Grade</span></div>
                                    <div class="nk-tb-col nk-tb-sessions"><span>Total</span></div>
                                    <!-- <div class="nk-tb-col nk-tb-sessions"><span>HR Defined Percentage</span></div> -->
                                </div><!-- .nk-tb-head -->
                                <div class="nk-tb-item">
                                     <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">9.1 - 10.0</span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">A</span>
                                    </div>
                                     <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead"><span class="badge badge-pill badge-sm badge-soft"><?=$total_a;?></span></span>
                                    </div>
                                    <!-- <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">5%</span>
                                    </div> -->
                                </div>
                                <div class="nk-tb-item">
                                     <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">8.1 - 9.0</span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">B</span>
                                    </div>
                                     <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead"><span class="badge badge-pill badge-sm badge-soft"><?=$total_b;?></span></span>
                                    </div>
                                    <!-- <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">32%</span>
                                    </div> -->
                                </div>
                                <div class="nk-tb-item">
                                     <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">6.9 - 8.0</span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">C</span>
                                    </div>
                                     <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead"><span class="badge badge-pill badge-sm badge-soft"><?=$total_c;?></span></span>
                                    </div>
                                    <!-- <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">43%</span>
                                    </div> -->
                                </div>
                                <div class="nk-tb-item">
                                     <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">5.6 - 6.8</span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">D</span>
                                    </div>
                                     <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead"><span class="badge badge-pill badge-sm badge-soft"><?=$total_d;?></span></span>
                                    </div>
                                   <!--  <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">15%</span>
                                    </div> -->
                                </div>
                                <div class="nk-tb-item">
                                     <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">0.0 - 5.5</span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">E</span>
                                    </div>
                                     <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead"><span class="badge badge-pill badge-sm badge-soft"><?=$total_e;?></span></span>
                                    </div>
                                    <!-- <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead">5%</span>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-xxl-6">
                        <div class="card card-bordered h-100">
                            <div class="card-inner mb-n2">
                                <div class="card-title-group">
                                    <div class="card-title card-title-sm">
                                        <h6 class="title">Kurva Final</h6>
                                    </div>
                                </div>
                                <?php 
                                    $total_pa = 0;
                                    $total_line = 0;
                                    $valid = 0;
                                    $needrevise = 0;
                                    ($devisiasi_basic_line_a != "") ? $basic_line_a = $devisiasi_basic_line_a : $basic_line_a =round(($total_team_eligible*5)/100);
                                    ($ga_basic_line_a != "") ? $basic_line_a = $ga_basic_line_a : $basic_line_a =round(($total_team_eligible*5)/100);
                                    ($devisiasi_basic_line_b != "") ? $basic_line_b = $devisiasi_basic_line_b : $basic_line_b 
                                     = round(($total_team_eligible*32)/100);
                                    ($ga_basic_line_b != "") ? $basic_line_b = $ga_basic_line_b : $basic_line_b =round(($total_team_eligible*32)/100);
                                    ($devisiasi_basic_line_c != "") ? $basic_line_c = $devisiasi_basic_line_c : $basic_line_c 
                                     = round(($total_team_eligible*43)/100);
                                    ($ga_basic_line_c != "") ? $basic_line_c = $ga_basic_line_c : $basic_line_c =round(($total_team_eligible*43)/100);
                                    ($devisiasi_basic_line_d != "") ? $basic_line_d = $devisiasi_basic_line_d : $basic_line_d 
                                     = round(($total_team_eligible*15)/100);
                                    ($ga_basic_line_d != "") ? $basic_line_d = $ga_basic_line_d : $basic_line_d =round(($total_team_eligible*15)/100);
                                    ($devisiasi_basic_line_e != "") ? $basic_line_e = $devisiasi_basic_line_e : $basic_line_e 
                                     = round(($total_team_eligible*5)/100);
                                    ($ga_basic_line_e != "") ? $basic_line_e = $ga_basic_line_e : $basic_line_e =round(($total_team_eligible*5)/100);

                                    $total_line_all = $basic_line_a+$basic_line_b+$basic_line_c+$basic_line_d+$basic_line_e;
                                    if($total_line_all > $total_team_eligible){
                                        $basic_line_e = $basic_line_e-1;
                                    }elseif($total_line_all < $total_team_eligible){
                                        $total_tambah = $total_team_eligible - $total_line_all;
                                        $basic_line_c = $basic_line_c+$total_tambah;
                                    }
                                    $total_line = 0;
                                ?>
                                <div class="nk-tb-list is-loose traffic-channel-table">
                                    <div class="nk-tb-item nk-tb-head">
                                        <div class="nk-tb-col"><span class="tb-lead">Score</span></div>
                                        <div class="nk-tb-col"><span class="tb-lead">PA</span></div>
                                        <div class="nk-tb-col"><span class="tb-lead">Basic Line</span></div>
                                        <!-- <div class="nk-tb-col"><span class="tb-lead">Percentage</span></div> -->
                                        <div class="nk-tb-col"><span class="tb-lead">Note</span></div>
                                    </div>
                                    <div class="nk-tb-item nk-tb-head">
                                        <div class="nk-tb-col"><span class="tb-lead">A</span></div>
                                        <div class="nk-tb-col"><span class="tb-lead" id = "pa_a"><?=$total_a;?></span></div>
                                        <div class="nk-tb-col"><span class="tb-lead" id = "basic_line_a">
                                        <?php echo $basic_line_a; ?></span></div>
                                        <?php 
                                        if($devisiasi_basic_line_a != ""){
                                            $min_line_a = $devisiasi_basic_line_a;
                                            $max_line_a = $devisiasi_basic_line_a;
                                        }else{
                                            if($ga_basic_line_a != ""){
                                                $min_line_a = $ga_basic_line_a;
                                                $max_line_a = $ga_basic_line_a;
                                            }else{
                                                $min_line_a = (($basic_line_a-3) < 1) ? "0" : $basic_line_a-3;
                                                $max_line_a = $basic_line_a;
                                            }
                                            
                                        }
                                         
                                        ?>
                                        <!-- <div class="nk-tb-col"><span class="tb-lead" id = "percentage_a">5%</span></div> -->
                                        <div class="nk-tb-col"><span class="tb-lead" id = "note_a">
                                        <?php 
                                            if($devisiasi_basic_line_a != ""){
                                                if($total_a == $devisiasi_basic_line_a){
                                                    echo "<b class='badge badge-success'>Valid</b>";
                                                    $valid++;
                                                }else{
                                                    echo "<b class='badge badge-danger'>Not Valid</b>";
                                                    $needrevise++;
                                                }
                                            }else{
                                                if($total_a == $min_line_a or $total_a <= $max_line_a or $total_a == $basic_line_a){
                                                    echo "<b class='badge badge-success'>Valid</b>";
                                                    $valid++;
                                                }else{
                                                    echo "<b class='badge badge-danger'>Not Valid</b>";
                                                    $needrevise++;
                                                }
                                            }
                                            ?>

                                        </span></div>
                                    </div>
                                    <?php 
                                        $total_pa = $total_pa+$total_a;
                                        $total_line = $total_line+$basic_line_a;//(($total_team_eligible*5)/100);
                                    ?>
                                    <div class="nk-tb-item nk-tb-head">
                                        <div class="nk-tb-col"><span class="tb-lead">B</span></div>
                                        <div class="nk-tb-col"><span class="tb-lead" id = "pa_b"><?=$total_b;?></span></div>
                                        <div class="nk-tb-col"><span class="tb-lead" id = "basic_line_b">
                                                <?php echo $basic_line_b;  ?>
                                        </span></div>
                                        <?php 
                                        if($devisiasi_basic_line_b != ""){
                                            $min_line_b = $devisiasi_basic_line_b;
                                            $max_line_b = $devisiasi_basic_line_b;
                                        }else{
                                            if($ga_basic_line_b != ""){
                                                $min_line_b = $ga_basic_line_b;
                                                $max_line_b = $ga_basic_line_b;
                                            }else{
                                                $min_line_b = ($total_team_eligible < 1) ? "0" : round((($total_team_eligible*32)/100) - (((($total_team_eligible*32)/100)*(10/100))));
                                                $max_line_b = ($total_team_eligible < 1) ? "0" : round((($total_team_eligible*32)/100) + (((($total_team_eligible*32)/100)*(10/100))));
                                            }
                                        }
                                         
                                        ?>
                                        <!-- <div class="nk-tb-col"><span class="tb-lead" id = "percentage_b">32%</span></div> -->
                                        <div class="nk-tb-col"><span class="tb-lead" id = "note_b">
                                            <?php 
                                            if($devisiasi_basic_line_b != ""){
                                                if($total_b == $devisiasi_basic_line_b){
                                                    echo "<b class='badge badge-success'>Valid</b>";
                                                    $valid++;
                                                }else{
                                                    echo "<b class='badge badge-danger'>Not Valid</b>";
                                                    $needrevise++;
                                                }
                                            }else{
                                                if($total_b == $min_line_b or $total_b == $max_line_b or $total_b == $basic_line_b){
                                                    echo "<b class='badge badge-success'>Valid</b>";
                                                    $valid++;
                                                }else{
                                                    if($total_b <= $max_line_b and $total_b >= $min_line_b){
                                                        echo "<b class='badge badge-success'>Valid</b>";
                                                        $valid++;
                                                    }else{
                                                        echo "<b class='badge badge-danger'>Not Valid</b>";
                                                        $needrevise++;
                                                    }
                                                }
                                            }
                                                
                                            ?>
                                        </span></div>
                                    </div>
                                    <?php 
                                        $total_pa = $total_pa+$total_b;
                                        $total_line = $total_line+$basic_line_b;//(($total_team_eligible*32)/100);
                                    ?>
                                    <div class="nk-tb-item nk-tb-head">
                                        <div class="nk-tb-col"><span class="tb-lead">C</span></div>
                                        <div class="nk-tb-col"><span class="tb-lead" id = "pa_c"><?=$total_c;?></span></div>
                                        <div class="nk-tb-col"><span class="tb-lead" id = "basic_line_c">
                                        <?php echo $basic_line_c;  ?></span></div>
                                        <?php 
                                        if($devisiasi_basic_line_c != ""){
                                            $min_line_c = $devisiasi_basic_line_c;
                                            $max_line_c = $devisiasi_basic_line_c;
                                        }else{
                                            if($ga_basic_line_c != ""){
                                                $min_line_c = $ga_basic_line_c;
                                                $max_line_c = $ga_basic_line_c;
                                            }else{
                                                if($total_line_all < $total_team_eligible){
                                                    $min_line_c = ($basic_line_c < 1) ? "0" : round(($basic_line_c) - ((($basic_line_c)*(10/100))));
                                                    $max_line_c = ($basic_line_c < 1) ? "0" : round(($basic_line_c) + ((($basic_line_c)*(10/100))));
                                                }else{
                                                    $min_line_c = ($basic_line_c < 1) ? "0" : round((($total_team_eligible*43)/100) - (((($total_team_eligible*43)/100)*(10/100))));
                                                    $max_line_c = ($basic_line_c < 1) ? "0" : round((($total_team_eligible*43)/100) + (((($total_team_eligible*43)/100)*(10/100))));
                                                }
                                            }
                                        }
                                        //  echo "MIN LINE = ".$min_line_c." ==> MAX LINE = ".$max_line_c."<br>";
                                        ?>
                                        <!-- <div class="nk-tb-col"><span class="tb-lead" id = "percentage_c">43%</span></div> -->
                                        <div class="nk-tb-col"><span class="tb-lead" id = "note_c">
                                        <?php 
                                        if($devisiasi_basic_line_c != ""){
                                                if($total_c == $devisiasi_basic_line_c){
                                                    echo "<b class='badge badge-success'>Valid</b>";
                                                    $valid++;
                                                }else{
                                                    echo "<b class='badge badge-danger'>Not Valid</b>";
                                                    $needrevise++;
                                                }
                                            }else{
                                                    if($total_c == $min_line_c or $total_c == $max_line_c or $total_c == $basic_line_c){
                                                        // echo "TOTAL C = ".$total_c."<br>";
                                                        // echo "MIN LINE C = ".$min_line_c."<br>";
                                                        // echo "MAX LINE C = ".$max_line_c."<br>";
                                                        // echo "BASIC LINE C = ".$basic_line_c."<br>";

                                                        echo "<b class='badge badge-success'>Valid</b>";
                                                        $valid++;
                                                    }else{
                                                        if($total_c <= $max_line_c and $total_c >= $min_line_c){
                                                            echo "<b class='badge badge-success'>Valid</b>";
                                                            $valid++;
                                                        }else{
                                                            echo "<b class='badge badge-danger'>Not Valid</b>";
                                                            $needrevise++;
                                                        }
                                                    }
                                                }
                                            ?>
                                        </span></div>
                                    </div>
                                    <?php 
                                        $total_pa = $total_pa+$total_c;
                                        $total_line = $total_line+$basic_line_c;//(($total_team_eligible*43)/100);
                                    ?>
                                    <div class="nk-tb-item nk-tb-head">
                                        <div class="nk-tb-col"><span class="tb-lead">D</span></div>
                                        <div class="nk-tb-col"><span class="tb-lead" id = "pa_d"><?=$total_d;?></span></div>
                                        <div class="nk-tb-col"><span class="tb-lead" id = "basic_line_d">
                                        <?php echo $basic_line_d;  ?></span></div>
                                        <?php 
                                        if($devisiasi_basic_line_d != ""){
                                            $min_line_d = $devisiasi_basic_line_d;
                                            $max_line_d = $devisiasi_basic_line_d;
                                        }else{
                                            if($ga_basic_line_d != ""){
                                                $min_line_d = $ga_basic_line_d;
                                                $max_line_d = $ga_basic_line_d;
                                            }else{
                                                $min_line_d = ($total_team_eligible < 1) ? "0" : round((($total_team_eligible*15)/100) - (((($total_team_eligible*15)/100)*(15/100))));
                                                $max_line_d = ($total_team_eligible < 1) ? "0" : round((($total_team_eligible*15)/100) + (((($total_team_eligible*15)/100)*(15/100))));
                                            }
                                        }
                                         
                                        ?>
                                        
                                        <!-- <div class="nk-tb-col"><span class="tb-lead" id = "percentage_d">15%</span></div> -->
                                        <div class="nk-tb-col"><span class="tb-lead" id = "note_d">
                                        <?php 
                                        if($devisiasi_basic_line_d != ""){
                                            if($total_d == $devisiasi_basic_line_d){
                                                echo "<b class='badge badge-success'>Valid</b>";
                                                $valid++;
                                            }else{
                                                echo "<b class='badge badge-danger'>Not Valid</b>";
                                                $needrevise++;
                                            }
                                        }else{
                                                if($total_d == $min_line_d or $total_d == $max_line_d or $total_d == $basic_line_d){
                                                    echo "<b class='badge badge-success'>Valid</b>";
                                                    $valid++;
                                                }else{
                                                    if($total_d <= $max_line_d and $total_d >= $min_line_d){
                                                        echo "<b class='badge badge-success'>Valid</b>";
                                                        $valid++;
                                                    }else{
                                                        echo "<b class='badge badge-danger'>Not Valid</b>";
                                                        $needrevise++;
                                                    }
                                                }
                                            }
                                            ?>
                                        </span></div>
                                    </div>
                                    <?php 
                                        $total_pa = $total_pa+$total_d;
                                        $total_line = $total_line+$basic_line_d;//(($total_team_eligible*15)/100);
                                    ?>
                                    <div class="nk-tb-item nk-tb-head">
                                        <div class="nk-tb-col"><span class="tb-lead">E</span></div>
                                        <div class="nk-tb-col"><span class="tb-lead" id = "pa_e"><?=$total_e;?></span></div>
                                        <div class="nk-tb-col"><span class="tb-lead" id = "basic_line_e">
                                        <?php echo $basic_line_e;  ?></span></div>
                                        <?php 
                                        if($devisiasi_basic_line_e != ""){
                                            $min_line_e = $devisiasi_basic_line_e;
                                            $max_line_e = $devisiasi_basic_line_e;
                                        }else{
                                            if($ga_basic_line_e != ""){
                                                $min_line_e = $ga_basic_line_e;
                                                $max_line_e = $ga_basic_line_e;
                                            }else{
                                                $min_line_e = ($total_team_eligible < 1) ? "0" : round((($total_team_eligible*5)/100) - (((($total_team_eligible*5)/100)*(15/100))));
                                                $max_line_e = ($total_team_eligible < 1) ? "0" : round((($total_team_eligible*5)/100) + (((($total_team_eligible*5)/100)*(15/100))));
                                            }
                                        }
                                        ?>
                                        <!-- <div class="nk-tb-col"><span class="tb-lead" id = "percentage_e">5%</span></div> -->
                                        <div class="nk-tb-col"><span class="tb-lead" id = "note_e">
                                        <?php 
                                         if($devisiasi_basic_line_e != ""){
                                            if($total_e == $devisiasi_basic_line_e){
                                                echo "<b class='badge badge-success'>Valid</b>";
                                                $valid++;
                                            }else{
                                                echo "<b class='badge badge-danger'>Not Valid</b>";
                                                $needrevise++;
                                            }
                                        }else{
                                                if($total_e == $min_line_e or $total_e == $max_line_e or $total_e == $basic_line_e){
                                                    echo "<b class='badge badge-success'>Valid</b>";
                                                    $valid++;
                                                }else{
                                                    if($total_e <= $max_line_e and $total_e >= $min_line_e){
                                                        echo "<b class='badge badge-success'>Valid</b>";
                                                        $valid++;
                                                    }else{
                                                        echo "<b class='badge badge-danger'>Not Valid</b>";
                                                        $needrevise++;
                                                    }
                                                }
                                            }
                                            ?>
                                        </span></div>
                                    </div>
                                    <?php 
                                        $total_pa = $total_pa+$total_e;
                                        $total_line = $total_line+$basic_line_e;//(($total_team_eligible*5)/100);
                                    ?>
                                    <div class="nk-tb-item nk-tb-head">
                                        <div class="nk-tb-col"><span class="tb-lead">TOTAL</span></div>
                                        <div class="nk-tb-col"><span class="tb-lead"><?= $total_pa ?></span></div>
                                        <div class="nk-tb-col"><span class="tb-lead"><?= $total_line ?></span></div>
                                        <!-- <div class="nk-tb-col"><span class="tb-lead">100%</span></div> -->
                                        <div class="nk-tb-col"><span class="tb-lead"><?php
                                        //  echo $total_team."xxx<br>";
                                        // if($needrevise > 0 or $total_pa == 0 or $total_pa < $total_team_eligible or $total_talent_map < $total_team){
                                        if($needrevise > 0 or $total_pa == 0 or $total_pa < $total_team_eligible){
                                            echo "
                                            <script src = '/assets/v2/js/jquery.min.js'></script>
                                            <script>
                                            $(document).ready(function () {
                                                $('#submit_to_hr').css('display','none');
                                            });
                                            </script>
                                            <b style = 'color:red;' id = 'noteKurva'>Need To Revise</b>
                                            "; 
                                        }else{ 
                                            echo "
                                            <script src = '/assets/v2/js/jquery.min.js'></script>
                                            <script>
                                            $(document).ready(function () {
                                                $('#submit_to_hr').css('display','');
                                            });
                                            </script>
                                            <b id = 'noteKurva'>Ready To Submit</b>
                                            ";
                                        } ?></span></div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    <div class="col-lg-6 col-xxl-6">
                        <div class="card card-bordered h-100">
                            <div class="card-inner mb-n2">
                                <div class="card-title-group">
                                    <div class="card-title card-title-sm">
                                        <h6 class="title">Kurva Final (Line Chart)</h6>
                                    </div>
                                </div>
                                <div class="nk-tb-list is-loose traffic-channel-table">
                                <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="nk-ibx-reply-head">
        <div>
            <h4 class="title ff-base">TEAM MEMBER <span class="text-soft">SUMMARY</span></h4>
        </div>
    </div>

    <div class="card card-preview">
        <div class="card-inner">
            <table class="datatable-init-export nowrap table" data-export-title="Export Data" id="tableDivHead" data-ajaxsource="<?= site_url('inbox/readpa/'.$this->input->post('periodYear')); ?>">
                <thead>
                    <tr>
                        <th>NIK</th>
                        <th>Name</th>
                        <th>Division</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Direct Manager</th>
                        <th>Office Location</th>
                        <th>Join Date</th>
                        <th>Employment Type</th>
                        <th>Final Score</th>
                        <th>Grade</th>
                        <th>Status</th>
                        <th>Full Approved Date</th>
                        <th>Request Number</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <!-- <div class="nk-ibx-reply-head">
        <div>
            <h4 class="title ff-base">9 BOX GRID<span class="text-soft">Talent Map</span></h4> &nbsp; <h5><a href = "#" data-toggle="modal" data-target="#modalLegend">Click For Guidelines</a></h5>
        </div>
    </div>

    <div class="card card-preview">
        <div class="card-inner">
            
            <div class = "row">
                    
                    <div class = "col-md-12">
                        <div class = "table-responsive">
                            <table class="table table-striped score-pa" data-ajaxsource="<?= site_url('inbox/scorepa'); ?>">
                                <thead>
                                    <tr>
                                        <th>NIK</th>
                                        <th>Name</th>
                                        <th>Score</th>
                                        <th>Desc</th>
                                        <th>Performance</th>
                                        <th>Potential</th>
                                        <th>Note</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class = "col-md-12" id = "ninebox">
                        <div class = "table-responsive">
                        <table class = "table table-sm" style = "font-size:9px !important; color:black !important;" border = "1">
                            <tr>
                                <td rowspan = "6" width = "20px"><h5 class = "text1" style = "text-align: center; margin-top:170px;">POTENTIAL</h5></td>
                            </tr>
                            <tr>
                                <td><b class = "text1" style = "text-align: center;">More Learning Agility (3)</b></td>
                                <td style = "background-color:#CDCDCD; "><b>POTENTIAL PERFORMER</b>
                                <div id = "potential_performer">
                                <?php 
                                        if(!empty($potential_performer)){
                                            foreach($potential_performer as $key => $val){
                                                echo decrypt($val['employee_name'])."<br>";
                                            }
                                        }
                                    ?>
                                </div>
                                </td>
                                <td style = "background-color:#66cc91;"><b>HIGHT POTENTIAL</b>
                                <div id = "high_potential">
                                <?php 
                                        if(!empty($high_potential)){
                                            foreach($high_potential as $key => $val){
                                                echo decrypt($val['employee_name'])."<br>";
                                            }
                                        }
                                    ?>
                                </div>
                                </td>
                                <td style = "background-color:#66cc91;"><b>STAR</b>
                                <div id = "star">
                                    <?php 
                                        if(!empty($star)){
                                            foreach($star as $key => $val){
                                                echo decrypt($val['employee_name'])."<br>";
                                            }
                                        }
                                    ?>
                                </div>
                                </td>
                            </tr>
                            <tr>
                                <td><b class = "text1" style = "color:white;">xxxxxxxxxxxxxxxxxxxxxxxxx</b></td>
                                <td style = "background-color:#FFFF99;"><b>INCONSISTENT PLAYER</b>
                                <div id = "inconsistent_player">
                                <?php 
                                        if(!empty($inconsistent_player)){
                                            foreach($inconsistent_player as $key => $val){
                                                echo decrypt($val['employee_name'])."<br>";
                                            }
                                        }
                                    ?>
                                </div>
                                </td>
                                <td style = "background-color:#CDCDCD;"><b>CORE PLAYER</b>
                                <div id = "core_player">
                                <?php 
                                        if(!empty($core_player)){
                                            foreach($core_player as $key => $val){
                                                echo decrypt($val['employee_name'])."<br>";
                                            }
                                        }
                                    ?>
                                </div>
                                </td>
                                <td style = "background-color:#66cc91;"><b>HIGH PERFORMER</b>
                                <div id = "high_performer">
                                <?php 
                                        if(!empty($high_performer)){
                                            foreach($high_performer as $key => $val){
                                                echo decrypt($val['employee_name'])."<br>";
                                            }
                                        }
                                    ?>
                                </div>
                                </td>
                            </tr>
                            <tr>
                                <td><b class = "text1" style = "text-align: center;">Less Learning Agility (1)</b></td>
                                <td style = "background-color:#F08080;"><b>LOW CONTRIBUTOR</b>
                                <div id = "low_contributor">
                                <?php 
                                        if(!empty($low_contributor)){
                                            foreach($low_contributor as $key => $val){
                                                echo decrypt($val['employee_name'])."<br>";
                                            }
                                        }
                                    ?>
                                </div>
                                </td>
                                <td style = "background-color:#FFFF99;"><b>AVERAGE PERFORMER</b>
                                <div id = "average_performer">
                                <?php 
                                        if(!empty($average_performer)){
                                            foreach($average_performer as $key => $val){
                                                echo decrypt($val['employee_name'])."<br>";
                                            }
                                        }
                                    ?>
                                </div>
                                </td>
                                <td style = "background-color:#CDCDCD;"><b>SOLID PERFORMER</b>
                                <div id = "solid_performer">
                                <?php 
                                        if(!empty($solid_performer)){
                                            foreach($solid_performer as $key => $val){
                                                echo decrypt($val['employee_name'])."<br>";
                                            }
                                        }
                                    ?>
                                </div>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Less Then Effective (1)</td>
                                <td></td>
                                <td>High Effective (3)</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan = "4"><center><h4>PERFORMANCE</h4></center></td>
                                
                            </tr>
                        </table>
                        </div>
                    </div>
                </div>
        </div>
    </div> -->

</div>

<div class="modal fade" tabindex="-1" id="modalQuickView">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Final Score</h5>
                <form action="#" class="pt-2">
                    <div class="row gy-3 gx-gs">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label text-soft" for="edit-course-name">Name</label>
                                <div class="form-control-wrap">
                                    <b id="emp_name"></b> <i class="text-danger" id="final_score_title" style="display:none">*** New Employee</i>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label text-soft" for="edit-category">Position</label>
                                <div class="form-control-wrap">
                                    <b id="emp_position"></b>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label text-soft" for="edit-category">Join Date</label>
                                <div class="form-control-wrap">
                                    <b id="emp_join_date"></b>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label text-soft" for="edit-category">Employment Type</label>
                                <div class="form-control-wrap">
                                    <b id="emp_type"></b>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <br>
                            <label class="form-label" for="edit-category">Total Qualitative / KPIs</label>  
                            <table class="table table-striped" id="table_kpi_achievement">
                                <tr>
                                    <td class="w-60"><b>KPI Score</b></td>
                                    <td class="w-15"><b>85%</b></td>
                                    <td id="subtotal_kpi"></td>
                                    <td align="right" id="grandtotal_kpi"></td>
                                </tr>
                                <tr>
                                    <td><b>Qualitative Assesment Score</b></td>
                                    <td><b>15%</b></td>
                                    <td id="subtotal_qualitative"></td>
                                    <td align="right" id="grandtotal_qualitative"></td>
                                </tr>
                                <tr>
                                    <td><b>Pre Final Score</b></td>
                                    <td></td>
                                    <td></td>
                                    <td align="right" id="pre_final_score"></td>
                                </tr>
                                <tr id="tr_final_score">
                                    <td><b>Final Score</b></td>
                                    <td></td>
                                    <td></td>
                                    <td align="right">
                                        <input type="number" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" <?=$disabled?> maxlength="5" min="1" max="10" onchange="return calculate_final_score();" onClick="return calculate_final_score();" onKeyUp="return calculate_final_score();" placeholder="Score" name="final_score" id="final_score">
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Grade</b></td>
                                    <td></td>
                                    <td></td>
                                    <td align="right" id="grade"></td>
                                </tr>
                                <tr id="alert_fs" style="display: none;">
                                    <td colspan="3"><p class="text-danger">Please enter final score less than or equal to 10.</p></td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-12">
                            <div class="form-group">
                                <input type="hidden" name="req_id_modal" id="req_id_modal">
                                <input type="hidden" name="access_employee" id="access_employee" value = "<?= $this->session->userdata('access_employee') ?>">
                                <a onclick="return save_final_score();" class="btn btn-dim btn-block btn-primary"><span id="update-final">Update Final Score</span></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modalQuickViewReadonly">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Final Score</h5>
                <form action="#" class="pt-2">
                    <div class="row gy-3 gx-gs">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label text-soft" for="edit-course-name">Name</label>
                                <div class="form-control-wrap">
                                    <b id="emp_name_ro"></b> <i class="text-danger" id="final_score_title_ro" style="display:none">*** New Employee</i>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label text-soft" for="edit-category">Position</label>
                                <div class="form-control-wrap">
                                    <b id="emp_position_ro"></b>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label text-soft" for="edit-category">Join Date</label>
                                <div class="form-control-wrap">
                                    <b id="emp_join_date_ro"></b>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label text-soft" for="edit-category">Employment Type</label>
                                <div class="form-control-wrap">
                                    <b id="emp_type_ro"></b>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <br>
                            <label class="form-label" for="edit-category">Total Qualitative / KPIs</label>  
                            <table class="table table-striped" id="table_kpi_achievement_ro">
                                <tr>
                                    <td class="w-60"><b>KPI Score</b></td>
                                    <td class="w-15"><b>85%</b></td>
                                    <td id="subtotal_kpi_ro"></td>
                                    <td align="right" id="grandtotal_kpi_ro"></td>
                                </tr>
                                <tr>
                                    <td><b>Qualitative Assesment Score</b></td>
                                    <td><b>15%</b></td>
                                    <td id="subtotal_qualitative_ro"></td>
                                    <td align="right" id="grandtotal_qualitative_ro"></td>
                                </tr>
                                <tr>
                                    <td><b>Pre Final Score</b></td>
                                    <td></td>
                                    <td></td>
                                    <td align="right" id="pre_final_score_ro"></td>
                                </tr>
                                <tr id="tr_final_score_ro">
                                    <td><b>Final Score</b></td>
                                    <td></td>
                                    <td></td>
                                    <td align="right"  id="final_score_ro"></td>
                                </tr>
                                <tr id="alert_fs_ro" style="display: none;">
                                    <td colspan="3"><p class="text-danger">Please enter final score less than or equal to 10.</p></td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-12">
                            <div class="form-group">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modalViewSummary">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
               <table class="table table-striped">
                   <thead>
                       <tr>
                           <td>No.</td>
                           <td>NIK</td>
                           <td>Name</td>
                           <td>Last Updated at</td>
                       </tr>
                   </thead>
                   <tbody id="tableViewSummary">
                       
                   </tbody>
               </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalLegend" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Guidlines for Talent Map</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class = "table table-sm">
                    <tr>
                        <th>Performance Score</th>
                        <th>Description</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Under</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Effective</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Outstanding</td>
                    </tr>
                </table>
                <hr>
                <table class = "table table-sm">
                    <tr>
                        <th>Potential Score</th>
                        <th>Description</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Low</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Medium</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>High</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modalViewTeamMember"style="width:100%;">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Team Member</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            </div>
            <div class="modal-body" style="overflow-x:auto;">
               <table class="table table-striped" style="width:100%">
                   <thead style="width:100%">
                       <tr>
                           <td>No.</td>
                           <td>NIK</td>
                           <td>Name</td>
                           <td>Email</td>
                           <td>Position</td>
                       </tr>
                   </thead>
                   <tbody id = "tableViewTeamMember" style="width:100%;">
                       
                   </tbody>
               </table>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.0/dist/chart.umd.min.js"></script>
<script>
var xValues = ['A','B','C','D','E'];

new Chart("myChart", {
  type: "line",
  data: {
    labels: xValues,
    datasets: [{ 
      label: 'PA',
      data: [<?= $total_a ?>,<?= $total_b ?>,<?= $total_c ?>,<?= $total_d ?>,<?= $total_e ?>],
      borderColor: "blue",
      fill: false
    }, { 
      label: 'Basic Line',
      data: [<?= $basic_line_a ?>,<?= $basic_line_b ?>,<?= $basic_line_c ?>,<?= $basic_line_d ?>,<?= $basic_line_e ?>],
      borderColor: "orange",
      fill: false
    }]
  },
  options: {
    legend: {display: false}
  }
});
</script>


