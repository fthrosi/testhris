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
          <h4 class="title ff-base"><?=strtoupper(decrypt($this->session->userdata('division')));?> & <?=strtoupper(decrypt($this->session->userdata('second_division')));?><span class="text-soft"> DIVISION</span></h4>
        </ul>
    </div>
</div>

<div class="nk-ibx-reply nk-reply" data-simplebar>

    <ul class="nav nav-tabs nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#tabItem5">
                <?=status_division_icon($division_status['is_status']);?>
                <span><?=decrypt($this->session->userdata('division'))?></span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#tabItem6">
                <?php if(!empty($second_division_status['is_status'])){ echo status_division_icon($second_division_status['is_status']); } ?>
                <span><?=decrypt($this->session->userdata('second_division'))?></span>
            </a>
        </li>
    </ul>

    <div class="tab-content mt-0">

        <div class="tab-pane active" id="tabItem5">

            <?php 
            if ($division_status['is_status'] == 3 || $division_status['is_status'] == 1) {
                $show = 'none';
            } else {
                $show = '';
            } 
            ?>
            
            <div class="card card-preview">
                <div class="card-inner">
                    <div class="nk-block">
                        <div class="row g-gs">
                            <div class="col-lg-6 col-xxl-6">
                                 <div class="nk-ibx-head-actions">
                                    <ul class="nk-ibx-head-tools g-1">
                                       <li class="ml-n2" style="display: <?=$show?>" id = "submit_to_hr_ceo">
                                            <a onclick="return responseDivision(this.id)" id="submit_to_hr_mgmt" class="btn btn-icon btn-tooltip" title="Submit to HR">
                                                <em class="icon ni ni-send"></em>
                                                Submit <?=decrypt($this->session->userdata('division'))?> to HR
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                             </div>
                            <div class="col-lg-6 col-xxl-6 text-right">
                                 <?php if (!empty($division_status)) {
                                    echo status_division($division_status['is_status']);
                                } else {
                                    echo status_division(0);
                                }?>   
                             </div>
                        </div>
                    </div>
                </div>
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
                                                    <a class="btn btn-sm btn-dim" onclick="return dashboardSummaryByDivision(this.id);" id="1">View</a>
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
                                                    <a class="btn btn-sm btn-dim" onclick="return dashboardSummaryByDivision(this.id);" id="2">View</a>
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
                                                    <a class="btn btn-sm btn-dim" onclick="return viewTeamMemberCEO(this.id);" id="<?= encrypt($this->session->userdata('user_email')) ?>">View</a>
                                                </span>
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
                                            ($devisiasi_basic_line_b != "") ? $basic_line_b = $devisiasi_basic_line_b : $basic_line_b = round(($total_team_eligible*32)/100);
                                            ($devisiasi_basic_line_c != "") ? $basic_line_c = $devisiasi_basic_line_c : $basic_line_c = round(($total_team_eligible*43)/100);
                                            ($devisiasi_basic_line_d != "") ? $basic_line_d = $devisiasi_basic_line_d : $basic_line_d = round(($total_team_eligible*15)/100);
                                            ($devisiasi_basic_line_e != "") ? $basic_line_e = $devisiasi_basic_line_e : $basic_line_e = round(($total_team_eligible*5)/100);

                                            $total_line = $basic_line_a+$basic_line_b+$basic_line_c+$basic_line_d+$basic_line_e;
                                            // dumper($total_team_eligible);
                                            if($total_line > $total_team_eligible){
                                                $basic_line_e = $basic_line_e-1;
                                            }elseif($total_line < $total_team_eligible){
                                                $basic_line_c = $basic_line_c+1;
                                            }
                                            //dumper($total_line." - ".$total_team_eligible);
                                            if(decrypt($this->session->userdata('division')) == "FIBER OPTIC"){
                                                $basic_line_a = $basic_line_a-$basic_line_a;
                                                $basic_line_c = $basic_line_c+2;
                                            }
                                            $total_line = 0;
                                            //dumper($devisiasi_basic_line_b." - ".$basic_line_b);
                                        ?>
                                        <div class="nk-tb-list is-loose traffic-channel-table">
                                            <div class="nk-tb-item nk-tb-head">
                                                <div class="nk-tb-col"><span class="tb-lead">Score</span></div>
                                                <div class="nk-tb-col"><span class="tb-lead">PA</span></div>
                                                <div class="nk-tb-col"><span class="tb-lead">Basic Line</span></div>
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
                                                        $min_line_a = ($total_team_eligible < 1) ? "0" : round(round(($total_team_eligible*5)/100)-3);
                                                        $max_line_a = $basic_line_a;//round(($total_team_eligible*5)/100);
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
                                            <!-- <div class="nk-tb-item nk-tb-head">
                                                <div class="nk-tb-col"><span class="tb-lead">A</span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "pa_a"><?=$total_a;?></span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "basic_line_a"><?php $basic_line_a = round(($total_team*5)/100); echo $basic_line_a; ?></span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "note_a">
                                                <?php 
                                                        // if($total_a == $min_line_a or $total_a <= $max_line_a or $total_a == $basic_line_a){
                                                        //     echo "<b class='badge badge-success'>Valid</b>";
                                                        //     $valid++;
                                                        // }else{
                                                        //     echo "<b class='badge badge-danger'>Not Valid</b>";
                                                        //     $needrevise++;
                                                        // }
                                                    ?>

                                                </span></div>
                                            </div> -->
                                            <?php 
                                                $total_pa = $total_pa+$total_a;
                                                $total_line = $total_line+$basic_line_a;
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
                                                        $min_line_b = ($total_team_eligible < 1) ? "0" : round($basic_line_b-1);
                                                        $max_line_b = ($total_team_eligible < 1) ? "0" : round($basic_line_b+1);
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
                                            <!-- <div class="nk-tb-item nk-tb-head">
                                                <div class="nk-tb-col"><span class="tb-lead">B</span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "pa_b"><?=$total_b;?></span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "basic_line_b"><?php $basic_line_b = round(($total_team*32)/100); echo $basic_line_b; ?></span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "note_b">
                                                    <?php 
                                                        // if($total_b == $min_line_b or $total_b <= $max_line_b or $total_b == $basic_line_b){
                                                        //     echo "<b class='badge badge-success'>Valid</b>";
                                                        //     $valid++;
                                                        // }else{
                                                        //     if($total_b <= $max_line_b and $total_b >= $min_line_b){
                                                        //         echo "<b class='badge badge-success'>Valid</b>";
                                                        //         $valid++;
                                                        //     }else{
                                                        //         echo "<b class='badge badge-danger'>Not Valid</b>";
                                                        //         $needrevise++;
                                                        //     }
                                                        // }
                                                    ?>
                                                </span></div>
                                            </div> -->
                                            <?php 
                                                $total_pa = $total_pa+$total_b;
                                                $total_line = $total_line+$basic_line_b;
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
                                                        $min_line_c = ($total_team_eligible < 1) ? "0" : round($basic_line_c-1);
                                                        $max_line_c = ($total_team_eligible < 1) ? "0" : round($basic_line_c+1);
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
                                            <!-- <div class="nk-tb-item nk-tb-head">
                                                <div class="nk-tb-col"><span class="tb-lead">C</span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "pa_c"><?=$total_c;?></span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "basic_line_c"><?php $basic_line_c = round(($total_team*43)/100);  if($total_line < $total_team){ $basic_line_c = $basic_line_c+1;} echo $basic_line_c;  ?></span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "note_c">
                                                <?php 
                                                        // if($total_c == $min_line_c or $total_c <= $max_line_c or $total_c == $basic_line_c){
                                                        //     echo "<b class='badge badge-success'>Valid</b>";
                                                        //     $valid++;
                                                        // }else{
                                                        //     if($total_c <= $max_line_c and $total_c >= $min_line_c){
                                                        //         echo "<b class='badge badge-success'>Valid</b>";
                                                        //         $valid++;
                                                        //     }else{
                                                        //         echo "<b class='badge badge-danger'>Not Valid</b>";
                                                        //         $needrevise++;
                                                        //     }
                                                        // }
                                                    ?>
                                                </span></div>
                                            </div> -->
                                            <?php 
                                                $total_pa = $total_pa+$total_c;
                                                $total_line = $total_line+$basic_line_c;
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
                                                        $min_line_d = ($total_team_eligible < 1) ? "0" : round($basic_line_d-2);
                                                        $max_line_d = ($total_team_eligible < 1) ? "0" : round($basic_line_d+2);
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
                                            <!-- <div class="nk-tb-item nk-tb-head">
                                                <div class="nk-tb-col"><span class="tb-lead">D</span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "pa_d"><?=$total_d;?></span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "basic_line_d"><?php $basic_line_d = round(($total_team*15)/100); echo $basic_line_d;  ?></span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "note_d">
                                                <?php 
                                                        // if($total_d == $min_line_d or $total_d <= $max_line_d or $total_d == $basic_line_d){
                                                        //     echo "<b class='badge badge-success'>Valid</b>";
                                                        //     $valid++;
                                                        // }else{
                                                        //     if($total_d <= $max_line_d and $total_d >= $min_line_d){
                                                        //         echo "<b class='badge badge-success'>Valid</b>";
                                                        //         $valid++;
                                                        //     }else{
                                                        //         echo "<b class='badge badge-danger'>Not Valid</b>";
                                                        //         $needrevise++;
                                                        //     }
                                                        // }
                                                    ?>
                                                </span></div>
                                            </div> -->
                                            <?php 
                                                $total_pa = $total_pa+$total_d;
                                                $total_line = $total_line+$basic_line_d;
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
                                                        $min_line_e = ($total_team_eligible < 1) ? "0" : round($basic_line_e-2);
                                                        $max_line_e = ($total_team_eligible < 1) ? "0" : round($basic_line_e+2);
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
                                            <!-- <div class="nk-tb-item nk-tb-head">
                                                <div class="nk-tb-col"><span class="tb-lead">E</span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "pa_e"><?=$total_e;?></span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "basic_line_e"><?php $basic_line_e = round(($total_team*5)/100); if($total_line > $total_team){ $basic_line_e = $basic_line_e-1;} echo $basic_line_e;  ?></span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "note_e">
                                                <?php 
                                                        // if($total_e == $min_line_e or $total_e <= $max_line_e or $total_e == $basic_line_e){
                                                        //     echo "<b class='badge badge-success'>Valid</b>";
                                                        //     $valid++;
                                                        // }else{
                                                        //     if($total_e <= $max_line_e and $total_e >= $min_line_e){
                                                        //         echo "<b class='badge badge-success'>Valid</b>";
                                                        //         $valid++;
                                                        //     }else{
                                                        //         echo "<b class='badge badge-danger'>Not Valid</b>";
                                                        //         $needrevise++;
                                                        //     }
                                                        // }
                                                    ?>
                                                </span></div>
                                            </div> -->
                                            <?php 
                                                $total_pa = $total_pa+$total_e;
                                                $total_line = $total_line+$basic_line_e;
                                            ?>
                                            <div class="nk-tb-item nk-tb-head">
                                                <div class="nk-tb-col"><span class="tb-lead">TOTAL</span></div>
                                                <div class="nk-tb-col"><span class="tb-lead"><?= $total_pa ?></span></div>
                                                <div class="nk-tb-col"><span class="tb-lead"><?= $total_line ?></span></div>
                                                <div class="nk-tb-col"><span class="tb-lead"><?php
                                                //  echo $total_team."xxx<br>".$total_pa." - ".$total_team_eligible." - ".$total_talent_map;
                                                // if($needrevise > 0 or $total_pa == 0 or $total_pa < $total_team_eligible or $total_talent_map < $total_team){
                                                if($needrevise > 0 or $total_pa == 0 or $total_pa < $total_team_eligible){
                                                    echo "
                                                    <script src = 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js'></script>
                                                    <script>
                                                    $(document).ready(function () {
                                                        $('#submit_to_hr_ceo').css('display','none');
                                                    });
                                                    </script>
                                                    <b style = 'color:red;' id = 'noteKurva'>Need To Revise</b>
                                                    "; 
                                                }else{ 
                                                    echo "
                                                    <script src = 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js'></script>
                                                    <b id = 'noteKurva'>Ready To Submit</b>
                                                    ";
                                                } 
                                                ?></span></div>
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
                                        <canvas id="myChartCEO" style="width:100%;max-width:600px"></canvas>
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
                    <table class="datatable-init-export nowrap table" data-export-title="Export Data" data-ajaxsource="<?= site_url('inbox/readceo/'); ?>">
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
            </div> -->

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
                            <!-- <div class = "col-md-12" id = "ninebox">
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
                                        <td style = "background-color:#CDCDCD;"><b>SOLID PERFORMERR</b>
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
                            </div> -->
                        </div>
                </div>
            </div>


        </div>



        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.0/dist/chart.umd.min.js"></script>
        <script>
        var xValues = ['A','B','C','D','E'];

        new Chart("myChartCEO", {
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


        <!--=======================================================================================================================--->
       
        <div class="tab-pane" id="tabItem6">
            <?php if (isset($second_division_status['is_status']) == 3 || isset($second_division_status['is_status']) == 1) {
                $tampil = 'none';
            } else {
                $tampil = '';
            } ?>

            <div class="card card-preview">
                <div class="card-inner">
                    <div class="nk-block">
                        <div class="row g-gs">
                             <div class="col-lg-6 col-xxl-6">
                                 <div class="nk-ibx-head-actions">
                                    <ul class="nk-ibx-head-tools g-1">
                                       <li class="ml-n2" style="display: <?=$tampil?>" id = "submit_to_hr_second">
                                            <a onclick="return responseDivision(this.id)" id="submit_to_hr_second_division_mgmt" class="btn btn-icon btn-tooltip" title="Submit to HR">
                                                <em class="icon ni ni-send"></em>
                                                Submit <?=decrypt($this->session->userdata('second_division'))?> to HR
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                             </div>
                             <div class="col-lg-6 col-xxl-6 text-right">
                                 <?php if (!empty($second_division_status)) {
                                    echo status_division($second_division_status['is_status']);
                                } else {
                                    echo status_division(0);
                                }
                                ?>   
                             </div>
                        </div>
                    </div>
                </div>
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
                                                <h6 class="title">PMO PA & Plan Submision Progress </h6>
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
                                                <span class="tb-lead"><?=$second_total_inprogress;?></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-channel">
                                                <span class="tb-lead">
                                                    <a class="btn btn-sm btn-dim" onclick="return viewSummaryBySecondDivision(this.id);" id="1">View</a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="nk-tb-item">
                                             <div class="nk-tb-col nk-tb-channel">
                                                <span class="tb-lead text-primary">Revise</span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-channel">
                                                <span class="tb-lead"><?=$second_total_revise;?></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-channel">
                                                <span class="tb-lead">
                                                    <a class="btn btn-sm btn-dim" onclick="return viewSummaryBySecondDivision(this.id);" id="2">View</a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="nk-tb-item">
                                             <div class="nk-tb-col nk-tb-channel">
                                                <span class="tb-lead text-success"><span class="badge badge-success">Full Approved</span></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-channel">
                                                <span class="tb-lead"><?=$second_total_approved;?></span>
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
                                                <span class="tb-lead"><span class="badge badge-pill badge-sm badge-soft"><?=($second_total_approved + $second_total_revise + $second_total_inprogress);?></span></span>
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
                                                <span class="tb-lead"><span class="badge badge-pill badge-sm badge-primary"><?=$second_total_team;?></span></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-channel">
                                                <span class="tb-lead">
                                                    <a class="btn btn-sm btn-dim" onclick="return viewTeamMemberPMO(this.id);" id="<?= encrypt($this->session->userdata('user_email')) ?>">View</a>
                                                </span>
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
                                                <h6 class="title">Summary Grade (Full approved)</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-tb-list is-loose traffic-channel-table">
                                        <div class="nk-tb-item nk-tb-head">
                                            <div class="nk-tb-col nk-tb-sessions"><span>Score</span></div>
                                            <div class="nk-tb-col nk-tb-channel"><span>Grade</span></div>
                                            <div class="nk-tb-col nk-tb-sessions"><span>Total</span></div>
                                        </div><!-- .nk-tb-head -->
                                        <div class="nk-tb-item">
                                             <div class="nk-tb-col nk-tb-channel">
                                                <span class="tb-lead">9.1 - 10.0</span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-channel">
                                                <span class="tb-lead">A</span>
                                            </div>
                                             <div class="nk-tb-col nk-tb-channel">
                                                <span class="tb-lead"><span class="badge badge-pill badge-sm badge-soft"><?=$second_total_a;?></span></span>
                                            </div>
                                        </div>
                                        <div class="nk-tb-item">
                                             <div class="nk-tb-col nk-tb-channel">
                                                <span class="tb-lead">8.1 - 9.0</span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-channel">
                                                <span class="tb-lead">B</span>
                                            </div>
                                             <div class="nk-tb-col nk-tb-channel">
                                                <span class="tb-lead"><span class="badge badge-pill badge-sm badge-soft"><?=$second_total_b;?></span></span>
                                            </div>
                                        </div>
                                        <div class="nk-tb-item">
                                             <div class="nk-tb-col nk-tb-channel">
                                                <span class="tb-lead">6.9 - 8.0</span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-channel">
                                                <span class="tb-lead">C</span>
                                            </div>
                                             <div class="nk-tb-col nk-tb-channel">
                                                <span class="tb-lead"><span class="badge badge-pill badge-sm badge-soft"><?=$second_total_c;?></span></span>
                                            </div>
                                        </div>
                                        <div class="nk-tb-item">
                                             <div class="nk-tb-col nk-tb-channel">
                                                <span class="tb-lead">5.6 - 6.8</span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-channel">
                                                <span class="tb-lead">D</span>
                                            </div>
                                             <div class="nk-tb-col nk-tb-channel">
                                                <span class="tb-lead"><span class="badge badge-pill badge-sm badge-soft"><?=$second_total_d;?></span></span>
                                            </div>
                                        </div>
                                        <div class="nk-tb-item">
                                             <div class="nk-tb-col nk-tb-channel">
                                                <span class="tb-lead">0.0 - 5.5</span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-channel">
                                                <span class="tb-lead">E</span>
                                            </div>
                                             <div class="nk-tb-col nk-tb-channel">
                                                <span class="tb-lead"><span class="badge badge-pill badge-sm badge-soft"><?=$second_total_e;?></span></span>
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
                                                <h6 class="title">Kurva Final</h6>
                                            </div>
                                        </div>
                                        <?php 
                                            $total_pa_pmo = 0;
                                            $total_line = 0;
                                            $valid = 0;
                                            $needrevise = 0;
                                            ($devisiasi_basic_line_a_second != "") ? $basic_line_a = $devisiasi_basic_line_a_second : $basic_line_a =round(($second_total_team*5)/100);
                                            ($devisiasi_basic_line_b_second != "") ? $basic_line_b = $devisiasi_basic_line_b_second : $basic_line_b = round(($second_total_team*32)/100);
                                            ($devisiasi_basic_line_c_second != "") ? $basic_line_c = $devisiasi_basic_line_c_second : $basic_line_c = round(($second_total_team*43)/100);
                                            ($devisiasi_basic_line_d_second != "") ? $basic_line_d = $devisiasi_basic_line_d_second : $basic_line_d = round(($second_total_team*15)/100);
                                            ($devisiasi_basic_line_e_second != "") ? $basic_line_e = $devisiasi_basic_line_e_second : $basic_line_e = round(($second_total_team*5)/100);

                                            // dumper($devisiasi_basic_line_b_second);

                                            if(decrypt($this->session->userdata('second_division')) == "TRANSMISSION DEVELOPMENT"){
                                                $basic_line_b = $basic_line_b-1;
                                            }

                                            $total_line = $basic_line_a+$basic_line_b+$basic_line_c+$basic_line_d+$basic_line_e;
                                            // dumper($total_line);
                                            if($total_line > $second_total_team){
                                                $basic_line_e = $basic_line_e-1;
                                            }elseif($total_line < $second_total_team){
                                                $basic_line_c = $basic_line_c+1;
                                            }

                                            if(decrypt($this->session->userdata('second_division')) == "FIBER OPTIC"){
                                                $basic_line_a = $basic_line_a-$basic_line_a;
                                                $basic_line_c = $basic_line_c+2;
                                            }
                                            $total_line = 0;
                                        ?>
                                        <div class="nk-tb-list is-loose traffic-channel-table">
                                            <div class="nk-tb-item nk-tb-head">
                                                <div class="nk-tb-col"><span class="tb-lead">Score</span></div>
                                                <div class="nk-tb-col"><span class="tb-lead">PA</span></div>
                                                <div class="nk-tb-col"><span class="tb-lead">Basic Line</span></div>
                                                <div class="nk-tb-col"><span class="tb-lead">Note</span></div>
                                            </div>
                                            <div class="nk-tb-item nk-tb-head">
                                                <div class="nk-tb-col"><span class="tb-lead">A</span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "pa_a"><?=$second_total_a;?></span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "basic_line_a">
                                                <?php echo $basic_line_a; ?></span></div>
                                                <?php 
                                                if($devisiasi_basic_line_a_second != ""){
                                                    $min_line_a = $devisiasi_basic_line_a_second;
                                                    $max_line_a = $devisiasi_basic_line_a_second;
                                                }else{
                                                    $min_line_a = ($second_total_team < 1) ? "0" : round(round(($second_total_team*5)/100)-3);
                                                    $max_line_a = $basic_line_a;//round(($second_total_team*5)/100);
                                                    
                                                }
                                                
                                                ?>
                                                <!-- <div class="nk-tb-col"><span class="tb-lead" id = "percentage_a">5%</span></div> -->
                                                <div class="nk-tb-col"><span class="tb-lead" id = "note_a">
                                                <?php 
                                                    if($devisiasi_basic_line_a_second != ""){
                                                        if($second_total_a == $devisiasi_basic_line_a_second){
                                                            echo "<b class='badge badge-success'>Valid</b>";
                                                            $valid++;
                                                        }else{
                                                            echo "<b class='badge badge-danger'>Not Valid</b>";
                                                            $needrevise++;
                                                        }
                                                    }else{
                                                        if($second_total_a == $min_line_a or $second_total_a <= $max_line_a or $second_total_a == $basic_line_a){
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
                                            <!-- <div class="nk-tb-item nk-tb-head">
                                                <div class="nk-tb-col"><span class="tb-lead">A</span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "pa_a"><?=$second_total_a;?></span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "basic_line_a"><?php $basic_line_a = round(($second_total_team*5)/100); echo $basic_line_a; ?></span></div>
                                                <?php $min_line_a = ($second_total_team < 1) ? "0" : round(round(($second_total_team*5)/100)-3); ;  ?>
                                                <?php $max_line_a = round(($second_total_team*5)/100);;  ?>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "note_a">
                                                <?php 
                                                        // if($second_total_a == $min_line_a or $second_total_a <= $max_line_a or $second_total_a == $basic_line_a){
                                                        //     echo "<b class='badge badge-success'>Valid</b>";
                                                        //     $valid++;
                                                        // }else{
                                                        //     echo "<b class='badge badge-danger'>Not Valid</b>";
                                                        //     $needrevise++;
                                                        // }
                                                    ?>

                                                </span></div>
                                            </div> -->
                                            <?php 
                                                $total_pa_pmo = $total_pa_pmo+$second_total_a;
                                                $total_line = $total_line+$basic_line_a;
                                            ?>
                                            <div class="nk-tb-item nk-tb-head">
                                                <div class="nk-tb-col"><span class="tb-lead">B</span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "pa_b"><?=$second_total_b;?></span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "basic_line_b">
                                                <?php echo $basic_line_b; ?></span></div>
                                                <?php 
                                                if($devisiasi_basic_line_b_second != ""){
                                                    $min_line_b = $devisiasi_basic_line_b_second;
                                                    $max_line_b = $devisiasi_basic_line_b_second;
                                                }else{
                                                    // $min_line_b = ($second_total_team < 1) ? "0" : round(round(($second_total_team*5)/100)-3);
                                                    // $max_line_b = $basic_line_a;//round(($second_total_team*5)/100);
                                                    $min_line_b = ($total_team_eligible < 1) ? "0" : round($basic_line_b-1);
                                                    $max_line_b = ($total_team_eligible < 1) ? "0" : round($basic_line_b+1);
                                                }
                                                
                                                ?>
                                                <!-- <div class="nk-tb-col"><span class="tb-lead" id = "percentage_a">5%</span></div> -->
                                                <div class="nk-tb-col"><span class="tb-lead" id = "note_b">
                                                <?php 
                                                    if($devisiasi_basic_line_b_second != ""){
                                                        if($second_total_b == $devisiasi_basic_line_b_second){
                                                            echo "<b class='badge badge-success'>Valid</b>";
                                                            $valid++;
                                                        }else{
                                                            echo "<b class='badge badge-danger'>Not Valid</b>";
                                                            $needrevise++;
                                                        }
                                                    }else{
                                                        // dumper($second_total_b." - ".$max_line_b." - ".$basic_line_b);
                                                        if($second_total_b == $min_line_b or $second_total_b == $max_line_b or $second_total_b == $basic_line_b){
                                                            echo "<b class='badge badge-success'>Valid</b>";
                                                            $valid++;
                                                        }else{
                                                            if($second_total_b <= $max_line_b and $second_total_b >= $min_line_b){
                                                                echo "<b class='badge badge-success'>Valid</b>";
                                                                $valid++;
                                                            }else{
                                                                echo "<b class='badge badge-danger'>Not Valid</b>";
                                                                $needrevise++;
                                                            }
                                                        }

                                                        // if($second_total_b == $min_line_b or $second_total_b <= $max_line_b or $second_total_b == $basic_line_b){
                                                        //     echo "<b class='badge badge-success'>Valid</b>";
                                                        //     $valid++;
                                                        // }else{
                                                        //     echo "<b class='badge badge-danger'>Not Valid</b>";
                                                        //     $needrevise++;
                                                        // }
                                                    }
                                                    ?>

                                                </span></div>
                                            </div>
                                            <!-- <div class="nk-tb-item nk-tb-head">
                                                <div class="nk-tb-col"><span class="tb-lead">B</span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "pa_b"><?=$second_total_b;?></span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "basic_line_b"><?php $basic_line_b = round(($second_total_team*32)/100); echo $basic_line_b; ?></span></div>
                                                <?php $min_line_b = ($second_total_team < 1) ? "0" : round(round(($second_total_team*32)/100)-1);;  ?>
                                                <?php $max_line_b = ($second_total_team < 1) ? "0" : round(round(($second_total_team*32)/100)+1);; ?>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "note_b">
                                                    <?php 
                                                        // if($second_total_b == $min_line_b or $second_total_b <= $max_line_b or $second_total_b == $basic_line_b){
                                                        //     echo "<b class='badge badge-success'>Valid</b>";
                                                        //     $valid++;
                                                        // }else{
                                                        //     if($second_total_b <= $max_line_b and $second_total_b >= $min_line_b){
                                                        //         echo "<b class='badge badge-success'>Valid</b>";
                                                        //         $valid++;
                                                        //     }else{
                                                        //         echo "<b class='badge badge-danger'>Not Valid</b>";
                                                        //         $needrevise++;
                                                        //     }
                                                        // }
                                                    ?>
                                                </span></div>
                                            </div> -->
                                            <?php 
                                                $total_pa_pmo = $total_pa_pmo+$second_total_b;
                                                $total_line = $total_line+$basic_line_b;
                                            ?>
                                            <div class="nk-tb-item nk-tb-head">
                                                <div class="nk-tb-col"><span class="tb-lead">C</span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "pa_c"><?=$second_total_c;?></span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "basic_line_c">
                                                <?php echo $basic_line_c;  ?></span></div>
                                                <?php 
                                                if($devisiasi_basic_line_c_second != ""){
                                                    $min_line_c = $devisiasi_basic_line_c_second;
                                                    $max_line_c = $devisiasi_basic_line_c_second;
                                                }else{
                                                    if($ga_basic_line_c != ""){
                                                        $min_line_c = $ga_basic_line_c;
                                                        $max_line_c = $ga_basic_line_c;
                                                    }else{
                                                        $min_line_c = ($total_team_eligible < 1) ? "0" : round($basic_line_c-1);
                                                        $max_line_c = ($total_team_eligible < 1) ? "0" : round($basic_line_c+1);
                                                    }
                                                }
                                                //  echo "MIN LINE = ".$min_line_c." ==> MAX LINE = ".$max_line_c."<br>";
                                                ?>
                                                <!-- <div class="nk-tb-col"><span class="tb-lead" id = "percentage_c">43%</span></div> -->
                                                <div class="nk-tb-col"><span class="tb-lead" id = "note_c">
                                                <?php 
                                                if($devisiasi_basic_line_c_second != ""){
                                                        if($second_total_c == $devisiasi_basic_line_c_second){
                                                            echo "<b class='badge badge-success'>Valid</b>";
                                                            $valid++;
                                                        }else{
                                                            echo "<b class='badge badge-danger'>Not Valid</b>";
                                                            $needrevise++;
                                                        }
                                                    }else{
                                                            if($second_total_c == $min_line_c or $second_total_c == $max_line_c or $second_total_c == $basic_line_c){
                                                                echo "<b class='badge badge-success'>Valid</b>";
                                                                $valid++;
                                                            }else{
                                                                if($second_total_c <= $max_line_c and $second_total_c >= $min_line_c){
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
                                            <!-- <div class="nk-tb-item nk-tb-head">
                                                <div class="nk-tb-col"><span class="tb-lead">C</span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "pa_c"><?=$second_total_c;?></span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "basic_line_c"><?php $basic_line_c = round(($second_total_team*43)/100); echo $basic_line_c;  ?></span></div>
                                                <?php $min_line_c = ($second_total_team < 1) ? "0" : round(round(($second_total_team*43)/100)-1); ;  ?>
                                                <?php $max_line_c = ($second_total_team < 1) ? "0" : round(round(($second_total_team*43)/100)+1); ;  ?>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "note_c">
                                                <?php 
                                                        // if($second_total_c == $min_line_c or $second_total_c <= $max_line_c or $second_total_c == $basic_line_c){
                                                        //     echo "<b class='badge badge-success'>Valid</b>";
                                                        //     $valid++;
                                                        // }else{
                                                        //     if($second_total_c <= $max_line_c and $second_total_c >= $min_line_c){
                                                        //         echo "<b class='badge badge-success'>Valid</b>";
                                                        //         $valid++;
                                                        //     }else{
                                                        //         echo "<b class='badge badge-danger'>Not Valid</b>";
                                                        //         $needrevise++;
                                                        //     }
                                                        // }
                                                    ?>
                                                </span></div>
                                            </div> -->
                                            <?php 
                                                $total_pa_pmo = $total_pa_pmo+$second_total_c;
                                                $total_line = $total_line+$basic_line_c;
                                            ?>
                                            <div class="nk-tb-item nk-tb-head">
                                                <div class="nk-tb-col"><span class="tb-lead">D</span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "pa_d"><?=$second_total_d;?></span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "basic_line_d">
                                                <?php echo $basic_line_d;  ?></span></div>
                                                <?php 
                                                if($devisiasi_basic_line_d_second != ""){
                                                    $min_line_d = $devisiasi_basic_line_d_second;
                                                    $max_line_d = $devisiasi_basic_line_d_second;
                                                }else{
                                                    if($ga_basic_line_d != ""){
                                                        $min_line_d = $ga_basic_line_d;
                                                        $max_line_d = $ga_basic_line_d;
                                                    }else{
                                                        $min_line_d = ($total_team_eligible < 1) ? "0" : round($basic_line_d-2);
                                                        $max_line_d = ($total_team_eligible < 1) ? "0" : round($basic_line_d+2);
                                                    }
                                                }
                                                
                                                ?>
                                                
                                                <!-- <div class="nk-tb-col"><span class="tb-lead" id = "percentage_d">15%</span></div> -->
                                                <div class="nk-tb-col"><span class="tb-lead" id = "note_d">
                                                <?php 
                                                if($devisiasi_basic_line_d_second != ""){
                                                    if($second_total_d == $devisiasi_basic_line_d_second){
                                                        echo "<b class='badge badge-success'>Valid</b>";
                                                        $valid++;
                                                    }else{
                                                        echo "<b class='badge badge-danger'>Not Valid</b>";
                                                        $needrevise++;
                                                    }
                                                }else{
                                                        if($second_total_d == $min_line_d or $second_total_d == $max_line_d or $second_total_d == $basic_line_d){
                                                            echo "<b class='badge badge-success'>Valid</b>";
                                                            $valid++;
                                                        }else{
                                                            if($second_total_d <= $max_line_d and $second_total_d >= $min_line_d){
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
                                            <!-- <div class="nk-tb-item nk-tb-head">
                                                <div class="nk-tb-col"><span class="tb-lead">D</span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "pa_d"><?=$second_total_d;?></span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "basic_line_d"><?php $basic_line_d = round(($second_total_team*15)/100); echo $basic_line_d;  ?></span></div>
                                                <?php $min_line_d = ($second_total_team < 1) ? "0" : round(round(($second_total_team*15)/100)-2);; ?>
                                                <?php $max_line_d = ($second_total_team < 1) ? "0" : round(round(($second_total_team*15)/100)+2);; ?>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "note_d">
                                                <?php 
                                                        // if($second_total_d == $min_line_d or $second_total_d <= $max_line_d or $second_total_d == $basic_line_d){
                                                        //     echo "<b class='badge badge-success'>Valid</b>";
                                                        //     $valid++;
                                                        // }else{
                                                        //     if($second_total_d <= $max_line_d and $second_total_d >= $min_line_d){
                                                        //         echo "<b class='badge badge-success'>Valid</b>";
                                                        //         $valid++;
                                                        //     }else{
                                                        //         echo "<b class='badge badge-danger'>Not Valid</b>";
                                                        //         $needrevise++;
                                                        //     }
                                                        // }
                                                    ?>
                                                </span></div>
                                            </div> -->
                                            <?php 
                                                $total_pa_pmo = $total_pa_pmo+$second_total_d;
                                                $total_line = $total_line+$basic_line_d;
                                            ?>
                                            <div class="nk-tb-item nk-tb-head">
                                                <div class="nk-tb-col"><span class="tb-lead">E</span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "pa_e"><?=$second_total_e;?></span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "basic_line_e">
                                                <?php echo $basic_line_e;  ?></span></div>
                                                <?php 
                                                if($devisiasi_basic_line_e_second != ""){
                                                    $min_line_e = $devisiasi_basic_line_e_second;
                                                    $max_line_e = $devisiasi_basic_line_e_second;
                                                }else{
                                                    if($ga_basic_line_e != ""){
                                                        $min_line_e = $ga_basic_line_e;
                                                        $max_line_e = $ga_basic_line_e;
                                                    }else{
                                                        $min_line_e = ($total_team_eligible < 1) ? "0" : round($basic_line_e-2);
                                                        $max_line_e = ($total_team_eligible < 1) ? "0" : round($basic_line_e+2);
                                                    }
                                                }
                                                ?>
                                                <!-- <div class="nk-tb-col"><span class="tb-lead" id = "percentage_e">5%</span></div> -->
                                                <div class="nk-tb-col"><span class="tb-lead" id = "note_e">
                                                <?php 
                                                if($devisiasi_basic_line_e_second != ""){
                                                    if($second_total_e == $devisiasi_basic_line_e_second){
                                                        echo "<b class='badge badge-success'>Valid</b>";
                                                        $valid++;
                                                    }else{
                                                        echo "<b class='badge badge-danger'>Not Valid</b>";
                                                        $needrevise++;
                                                    }
                                                }else{
                                                        if($second_total_e == $min_line_e or $second_total_e == $max_line_e or $second_total_e == $basic_line_e){
                                                            echo "<b class='badge badge-success'>Valid</b>";
                                                            $valid++;
                                                        }else{
                                                            if($second_total_e <= $max_line_e and $second_total_e >= $min_line_e){
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
                                            <!-- <div class="nk-tb-item nk-tb-head">
                                                <div class="nk-tb-col"><span class="tb-lead">E</span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "pa_e"><?=$second_total_e;?></span></div>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "basic_line_e"><?php $basic_line_e = round(($second_total_team*5)/100); echo $basic_line_e;  ?></span></div>
                                                <?php $min_line_e = ($second_total_team < 1) ? "0" : round(round(($second_total_team*5)/100)-2);;  ?>
                                                <?php $max_line_e = ($second_total_team < 1) ? "0" : round(round(($second_total_team*5)/100)+2);;  ?>
                                                <div class="nk-tb-col"><span class="tb-lead" id = "note_e">
                                                <?php 
                                                        // if($second_total_e == $min_line_e or $second_total_e <= $max_line_e or $second_total_e == $basic_line_e){
                                                        //     echo "<b class='badge badge-success'>Valid</b>";
                                                        //     $valid++;
                                                        // }else{
                                                        //     if($second_total_e <= $max_line_e and $second_total_e >= $min_line_e){
                                                        //         echo "<b class='badge badge-success'>Valid</b>";
                                                        //         $valid++;
                                                        //     }else{
                                                        //         echo "<b class='badge badge-danger'>Not Valid</b>";
                                                        //         $needrevise++;
                                                        //     }
                                                        // }
                                                    ?>
                                                </span></div>
                                            </div> -->
                                            <?php 
                                                $total_pa_pmo = $total_pa_pmo+$second_total_e;
                                                $total_line = $total_line+$basic_line_e;
                                            ?>
                                            <div class="nk-tb-item nk-tb-head">
                                                <div class="nk-tb-col"><span class="tb-lead">TOTAL</span></div>
                                                <div class="nk-tb-col"><span class="tb-lead"><?= $total_pa_pmo ?></span></div>
                                                <div class="nk-tb-col"><span class="tb-lead"><?= $total_line ?></span></div>
                                                <div class="nk-tb-col"><span class="tb-lead"><?php
                                                //  echo $total_talent_map_pmo."xxx<br>".$total_team_eligible_pmo;
                                                // if($needrevise > 0 or $total_pa_pmo == 0 or $total_pa_pmo < $total_team_eligible_pmo or $total_talent_map_pmo < $second_total_team){
                                                if($needrevise > 0 or $total_pa_pmo == 0 or $total_pa_pmo < $total_team_eligible_pmo){
                                                    echo "
                                                    <script src = 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js'></script>
                                                    <script>
                                                    $(document).ready(function () {
                                                        $('#submit_to_hr_second').css('display','none');
                                                    });
                                                    </script>
                                                    <b style = 'color:red;' id = 'noteKurvaSecond'>Need To Revise</b>
                                                    "; 
                                                }else{ 
                                                    echo "
                                                    <script src = 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js'></script>
                                                    <b id = 'noteKurvaSecond'>Ready To Submit</b>
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
                                        <canvas id="myChartSecond" style="width:100%;max-width:600px"></canvas>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <script>
            var xValues = ['A','B','C','D','E'];

            new Chart("myChartSecond", {
            type: "line",
            data: {
                labels: xValues,
                datasets: [{ 
                label: 'PA',
                data: [<?= $second_total_a ?>,<?= $second_total_b ?>,<?= $second_total_c ?>,<?= $second_total_d ?>,<?= $second_total_e ?>],
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

            <div class="nk-ibx-reply-head">
                <div>
                    <h4 class="title ff-base">TEAM MEMBER <span class="text-soft">SUMMARY</span></h4>
                </div>
            </div>

            <div class="card card-preview">
                <div class="card-inner">
                    <table class="datatable-init-export nowrap table" data-export-title="Export Data" data-ajaxsource="<?= site_url('dashboard/read_by_second_division/'.decrypt($this->session->userdata('second_division'))); ?>">
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
            </div> -->

            <div class="card card-preview">
                <div class="card-inner">
                    
                    <div class = "row">
                            
                            <div class = "col-md-12">
                                <div class = "table-responsive">
                                    <table class="table table-striped score-pa" data-ajaxsource="<?= site_url('inbox/scorepaPMO'); ?>">
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
                            <!-- <div class = "col-md-12" id = "ninebox_pmo">
                                <div class = "table-responsive">
                                <table class = "table table-sm" style = "font-size:9px !important; color:black !important;" border = "1">
                                    <tr>
                                        <td rowspan = "6" width = "20px"><h5 class = "text1" style = "text-align: center; margin-top:170px;">POTENTIAL</h5></td>
                                    </tr>
                                    <tr>
                                        <td><b class = "text1" style = "text-align: center;">More Learning Agility (3)</b></td>
                                        <td style = "background-color:#CDCDCD; "><b>POTENTIAL PERFORMER</b>
                                        <div id = "potential_performer_pmo">
                                        <?php 
                                                if(!empty($potential_performer_pmo)){
                                                    foreach($potential_performer_pmo as $key => $val){
                                                        echo decrypt($val['employee_name'])."<br>";
                                                    }
                                                }
                                            ?>
                                        </div>
                                        </td>
                                        <td style = "background-color:#66cc91;"><b>HIGHT POTENTIAL</b>
                                        <div id = "high_potential_pmo">
                                        <?php 
                                                if(!empty($high_potential_pmo)){
                                                    foreach($high_potential_pmo as $key => $val){
                                                        echo decrypt($val['employee_name'])."<br>";
                                                    }
                                                }
                                            ?>
                                        </div>
                                        </td>
                                        <td style = "background-color:#66cc91;"><b>STAR</b>
                                        <div id = "star_pmo">
                                            <?php 
                                                if(!empty($star_pmo)){
                                                    foreach($star_pmo as $key => $val){
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
                                        <div id = "inconsistent_player_pmo">
                                        <?php 
                                                if(!empty($inconsistent_player_pmo)){
                                                    foreach($inconsistent_player_pmo as $key => $val){
                                                        echo decrypt($val['employee_name'])."<br>";
                                                    }
                                                }
                                            ?>
                                        </div>
                                        </td>
                                        <td style = "background-color:#CDCDCD;"><b>CORE PLAYER</b>
                                        <div id = "core_player_pmo">
                                        <?php 
                                                if(!empty($core_player_pmo)){
                                                    foreach($core_player_pmo as $key => $val){
                                                        echo decrypt($val['employee_name'])."<br>";
                                                    }
                                                }
                                            ?>
                                        </div>
                                        </td>
                                        <td style = "background-color:#66cc91;"><b>HIGH PERFORMER</b>
                                        <div id = "high_performer_pmo">
                                        <?php 
                                                if(!empty($high_performer_pmo)){
                                                    foreach($high_performer_pmo as $key => $val){
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
                                        <div id = "low_contributor_pmo">
                                        <?php 
                                                if(!empty($low_contributor_pmo)){
                                                    foreach($low_contributor_pmo as $key => $val){
                                                        echo decrypt($val['employee_name'])."<br>";
                                                    }
                                                }
                                            ?>
                                        </div>
                                        </td>
                                        <td style = "background-color:#FFFF99;"><b>AVERAGE PERFORMER</b>
                                        <div id = "average_performer_pmo">
                                        <?php 
                                                if(!empty($average_performer_pmo)){
                                                    foreach($average_performer_pmo as $key => $val){
                                                        echo decrypt($val['employee_name'])."<br>";
                                                    }
                                                }
                                            ?>
                                        </div>
                                        </td>
                                        <td style = "background-color:#CDCDCD;"><b>SOLID PERFORMER</b>
                                        <div id = "solid_performer_pmo">
                                        <?php 
                                                if(!empty($solid_performer_pmo)){
                                                    foreach($solid_performer_pmo as $key => $val){
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
                            </div> -->
                        </div>
                </div>
            </div>


        </div>
      
    </div>

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
                                        <input type="number" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="5" min="1" max="10" onchange="return calculate_final_score();" onClick="return calculate_final_score();" onKeyUp="return calculate_final_score();" placeholder="Score" name="final_score" id="final_score">
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
                                <input type = "hidden" name = "access_employee" id = "access_employee" value = "<?= $this->session->userdata('access_employee'); ?>">
                                <a onclick="return save_final_score();" class="btn btn-dim btn-block btn-primary"><span id="update-final">Update Final Score</span></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" id="modalViewSummary">
    <div class="modal-dialog modal-md" role="document">
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
<!-- <div class="modal fade" id="modalLegend" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
</div> -->

<div class="modal fade" tabindex="-1" id="modalViewTeamMember">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
               <table class="table table-striped"">
                   <thead>
                       <tr>
                           <td>No.</td>
                           <td>NIK</td>
                           <td>Name</td>
                           <td>Email</td>
                       </tr>
                   </thead>
                   <tbody id = "tableViewTeamMember">
                       
                   </tbody>
               </table>
            </div>
        </div>
    </div>
</div>