<?php 
if ($division_status['is_status'] == 3) {
    $show = 'none';

} else {
    $show = '';
} 


    $total_pa = 0;
    $total_line = 0;
    $valid = 0;
    $needrevise = 0;

    ($devisiasi_basic_line_a != "") ? $basic_line_a = $devisiasi_basic_line_a : $basic_line_a =round(($total_team_eligible*5)/100);
    ($devisiasi_basic_line_b != "") ? $basic_line_b = $devisiasi_basic_line_b : $basic_line_b =round(($total_team_eligible*32)/100);
    ($devisiasi_basic_line_c != "") ? $basic_line_c = $devisiasi_basic_line_c : $basic_line_c =round(($total_team_eligible*43)/100);
    ($devisiasi_basic_line_d != "") ? $basic_line_d = $devisiasi_basic_line_d : $basic_line_d =round(($total_team_eligible*15)/100);
    ($devisiasi_basic_line_e != "") ? $basic_line_e = $devisiasi_basic_line_e : $basic_line_e =round(($total_team_eligible*5)/100);

    $total_line_all = $basic_line_a+$basic_line_b+$basic_line_c+$basic_line_d+$basic_line_e;
    $total_line = $basic_line_a+$basic_line_b+$basic_line_c+$basic_line_d+$basic_line_e;

    if($total_line_all > $total_team_eligible){
        $basic_line_e = $basic_line_e-1;
    }elseif($total_line_all < $total_team_eligible){
        $total_tambah = $total_team_eligible - $total_line_all;
        $basic_line_c = $basic_line_c+$total_tambah;
    }

    $total_line = 0;

?>

<div class="nk-ibx-head">
    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <li class="ml-n2">
                <a href="<?= site_url('inbox/hr_division'); ?>" class="btn btn-icon btn-tooltip" title="Back">
                    <em class="icon ni ni-arrow-left"></em>
                    Back
                </a>
            </li>
            <?php 
                if($division_status['is_status'] == 1){
            ?>
            <li class="ml-n2" style="display: <?=$show?>">
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">
                        <em class="icon ni ni-more-v"></em> Response
                    </a>
                    <div class="dropdown-menu">
                        <ul class="link-list-opt no-bdr">
                            <input type="hidden" name="performance_division_id" id="performance_division_id" value="<?=$division_status['id']?>">
                            <li><a class="dropdown-item" onclick="return responseDivision(this.id);" id="Confirm"><span>Confirm</span></a></li>
                            <!--//////////////////////////////////////////Revise Off 2025//////////////////////////////////////////////////////-->
                            <li><a class="dropdown-item" id="Revised" data-toggle="modal" data-target="#staticBackdrop"><span>Revise</span></a></li>
                             <!--//////////////////////////////////////////Revise Off 2025//////////////////////////////////////////////////////-->
                        </ul>
                    </div>
                </div>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>

<!-- Modal -->
<!--//////////////////////////////////////////Start Revise Off 2025//////////////////////////////////////////////////////-->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">HR Revise</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <table>
        <tr>
            <td>Division</td>
            <td>:</td>
            <td><?= str_replace(array('%20'), array(' '), decrypt($division_status['division_name'])); ?></td>
        </tr>
        <tr>
            <td>Total Team</b></td>
            <td>:</td>
            <td><input type = "number" id = "hr_total_team" value = "<?=$total_team;?>" disabled></td>
        </tr>
        <tr>
            <td>Total Team Eligible</b></td>
            <td>:</td>
            <td><input type = "number" id = "hr_total_team_eligible" name= "hr_total_team_eligible" value = "<?=$total_team_eligible;?>" disabled></td>
        </tr>
      </table>
      <div class="nk-tb-list is-loose traffic-channel-table">
      <form action = "<?= base_url('/inbox/kurva_devisiasi'); ?>" method = "post" enctype="multipart/form-data">
            <input type = "hidden" name = "id" value = "<?= $division_status['id'] ?>">
            <input type = "hidden" name = "division_name" value = "<?= decrypt($division_status['division_name']) ?>">
            <input type = "hidden" id="hr_te" name="hr_te" value = "<?=$total_team_eligible;?>">
            <div class="nk-tb-item nk-tb-head">
                
                <div class="nk-tb-col"><span class="tb-lead">Score</span></div> 
                <div class="nk-tb-col"><span class="tb-lead">Basic Line</span></div>
                <!-- <div class="nk-tb-col"><span class="tb-lead">Min Basic Line</span></div>
                <div class="nk-tb-col"><span class="tb-lead">Max Basic Line</span></div>
                <div class="nk-tb-col"><span class="tb-lead">Percentage</span></div> -->
            </div>
            <div class="nk-tb-item nk-tb-head">
                <div class="nk-tb-col"><span class="tb-lead">A</span></div>
                <div class="nk-tb-col"><span class="tb-lead" id = "hr_basic_line_a">
                    <input type = "number" id = "hr_basic_line_a_field" name = "basic_line[a]" onkeypress="return isNumeric(event)" onkeyup = "hrBasicLine('a',this.value)" value="<?=$basic_line_a?>"></span>
                </div>
                <!-- <div class="nk-tb-col"><span class="tb-lead" id = "hr_min_line_a"></span></div>
                <div class="nk-tb-col"><span class="tb-lead" id = "hr_max_line_a"></span></div>
                <div class="nk-tb-col"><span class="tb-lead" id = "hr_percentage_a">5%</span></div> -->
            </div>
            <div class="nk-tb-item nk-tb-head">
                <div class="nk-tb-col"><span class="tb-lead">B</span></div>
                <div class="nk-tb-col"><span class="tb-lead" id = "hr_basic_line_b">
                    <input type = "number" id = "hr_basic_line_b_field" name = "basic_line[b]" onkeypress="return isNumeric(event)" onkeyup = "hrBasicLine('b',this.value)" value="<?=$basic_line_b?>"></span>
                </div>
                <!-- <div class="nk-tb-col"><span class="tb-lead" id = "hr_min_line_b"></span></div>
                <div class="nk-tb-col"><span class="tb-lead" id = "hr_max_line_b"></span></div>
                <div class="nk-tb-col"><span class="tb-lead" id = "hr_percentage_b">32%</span></div> -->
            </div>
            <div class="nk-tb-item nk-tb-head">
                <div class="nk-tb-col"><span class="tb-lead">C</span></div>
                <div class="nk-tb-col"><span class="tb-lead" id = "hr_basic_line_c">
                    <input type = "number" id = "hr_basic_line_c_field" name = "basic_line[c]" onkeypress="return isNumeric(event)" onkeyup = "hrBasicLine('c',this.value)" value="<?=$basic_line_c?>"></span>
                </div>
                <!-- <div class="nk-tb-col"><span class="tb-lead" id = "hr_min_line_c"></span></div>
                <div class="nk-tb-col"><span class="tb-lead" id = "hr_max_line_c"></span></div>
                <div class="nk-tb-col"><span class="tb-lead" id = "hr_percentage_c">43%</span></div> -->
            </div>
            <div class="nk-tb-item nk-tb-head">
                <div class="nk-tb-col"><span class="tb-lead">D</span></div>
                <div class="nk-tb-col"><span class="tb-lead" id = "hr_basic_line_d">
                    <input type = "number" id = "hr_basic_line_d_field" name = "basic_line[d]" onkeypress="return isNumeric(event)" onkeyup = "hrBasicLine('d',this.value)" value="<?=$basic_line_d?>"></span>
                </div>
                <!-- <div class="nk-tb-col"><span class="tb-lead" id = "hr_min_line_d"></span></div>
                <div class="nk-tb-col"><span class="tb-lead" id = "hr_max_line_d"></span></div>
                <div class="nk-tb-col"><span class="tb-lead" id = "hr_percentage_d">15%</span></div> -->
            </div>
            <div class="nk-tb-item nk-tb-head">
                <div class="nk-tb-col"><span class="tb-lead">E</span></div>
                <div class="nk-tb-col"><span class="tb-lead" id = "hr_basic_line_e">
                    <input type = "number" id = "hr_basic_line_e_field" name = "basic_line[e]" onkeypress="return isNumeric(event)" onkeyup = "hrBasicLine('e',this.value)" value="<?=$basic_line_e?>"></span>
            </div>
                <!-- <div class="nk-tb-col"><span class="tb-lead" id = "hr_min_line_e"></span></div>
                <div class="nk-tb-col"><span class="tb-lead" id = "hr_max_line_e"></span></div>
                <div class="nk-tb-col"><span class="tb-lead" id = "hr_percentage_e">5%</span></div> -->
            </div>
        </div>
        <!-- <div class="form-group">
            <br>
            <label for="exampleFormControlFile1">Please attach IOM</label>
            <input type="file" name = "iom_file" class="form-control-file" id="iom_file" accept = ".img,.jpg,.jpeg,.pdf" required>
        </div> -->
        * If there is a change in the basic line above, there will be a deviation.
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id = "btn-revise" style = "">Revise</button>
      </div>
      <input type = "hidden" name = "division" id = "division" value = "<?= $division_status['division_name'] ?>">
      </form>
    </div>
  </div>
</div>
<!--//////////////////////////////////////////End Revise Off 2025//////////////////////////////////////////////////////-->

<div class="nk-ibx-reply nk-reply" data-simplebar>
    <?= $this->session->flashdata('notif') ?>
    
    <div class="nk-ibx-reply-head">
        
        <div>
            <h4 class="title ff-base"><?=strtoupper(decrypt($division_status['division_name']));?> <span class="text-soft">DIVISION</span></h4>
            <?php 
            // if($division_status['iom_file'] != ""){
            //         $path = base_url().'upload/iom/'.$division_status['iom_file'];
            //         echo "Revised with iom file: <a href = '{$path}' target = '_blank'>".$division_status['iom_file']."</a>";
            //     }
            ?>
        </div>
        <ul class="d-flex g-1">
            <li class="d-none d-sm-block" id="request_status"> 
                <?php if (!empty($division_status)) {
                    echo status_division($division_status['is_status']);
                } else {
                    echo status_division(0);
                }?>    
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
                                        <span class="tb-lead"></span>
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
                                        <span class="tb-lead"></span>
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
                                        <span class="tb-lead"></span>
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
                                        <h6 class="title">Summary Grade</h6>
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
                                        <span class="tb-lead"><span class="badge badge-pill badge-sm badge-soft"><?=$total_a;?></span></span>
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
                                        <span class="tb-lead"><span class="badge badge-pill badge-sm badge-soft"><?=$total_b;?></span></span>
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
                                        <span class="tb-lead"><span class="badge badge-pill badge-sm badge-soft"><?=$total_c;?></span></span>
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
                                        <span class="tb-lead"><span class="badge badge-pill badge-sm badge-soft"><?=$total_d;?></span></span>
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
                                        <span class="tb-lead"><span class="badge badge-pill badge-sm badge-soft"><?=$total_e;?></span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-xxl-6">
                        <div class="card card-bordered h-100">
                            <div class="card-inner mb-n2">
                                <?php if($devisiasi_basic_line_a != ""){ ?>
                                    <div class="card-title card-title-sm alert alert-fill alert-icon alert-primary" role="alert">    
                                        <em class="icon ni ni-alert-circle"></em>     
                                        Basic line before deviation, click <a data-toggle="modal" data-target="#modalIOM"><strong><em class="icon ni ni-file-text"></em></strong></a> to see.
                                    </div>
                                <?php } ?>
                                <div class="card-title-group">
                                    <div class="card-title card-title-sm">
                                        <h6 class="title">Kurva Final</h6>
                                    </div>
                                </div>
                                
                                <div class="nk-tb-list is-loose traffic-channel-table">
                                    <div class="nk-tb-item nk-tb-head">
                                        <div class="nk-tb-col"><span class="tb-lead">Score</span></div>
                                        <div class="nk-tb-col"><span class="tb-lead">PA</span></div>
                                        <div class="nk-tb-col"><span class="tb-lead">Basic Line</span></div>
                                        <div class="nk-tb-col"><span class="tb-lead">Min Basic Line</span></div>
                                        <div class="nk-tb-col"><span class="tb-lead">Max Basic Line</span></div>
                                        <div class="nk-tb-col"><span class="tb-lead">Percentage</span></div>
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
                                            $min_line_a = (($basic_line_a-3) < 1) ? "0" : $basic_line_a-3;
                                            $max_line_a = $basic_line_a;
                                        }
                                         
                                        ?>
                                        <div class="nk-tb-col"><span class="tb-lead" id = "min_line_a"><?php echo $min_line_a;  ?></span></div>
                                        <div class="nk-tb-col"><span class="tb-lead" id = "max_line_a"><?php echo $max_line_a;  ?></span></div>
                                        <div class="nk-tb-col"><span class="tb-lead" id = "percentage_a">5%</span></div>
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
                                                if(($total_a >= $min_line_a and $total_a <= $max_line_a) or $total_a == $basic_line_a){
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
                                        $total_line = $total_line+$basic_line_a;
                                    ?>
                                    <div class="nk-tb-item nk-tb-head">
                                        <div class="nk-tb-col"><span class="tb-lead">B</span></div>
                                        <div class="nk-tb-col"><span class="tb-lead" id = "pa_b"><?=$total_b;?></span></div>
                                        <div class="nk-tb-col"><span class="tb-lead" id = "basic_line_b">
                                                <?php echo $basic_line_b;  ?></span></div>
                                        <?php 
                                        if($devisiasi_basic_line_b != ""){
                                            $min_line_b = $devisiasi_basic_line_b;
                                            $max_line_b = $devisiasi_basic_line_b;
                                        }else{
                                            $min_line_b = ($total_team_eligible < 1) ? "0" : round((($total_team_eligible*32)/100) - (((($total_team_eligible*32)/100)*(10/100))));
                                            $max_line_b = ($total_team_eligible < 1) ? "0" : round((($total_team_eligible*32)/100) + (((($total_team_eligible*32)/100)*(10/100))));
                                        }
                                         
                                        ?>
                                        <div class="nk-tb-col"><span class="tb-lead" id = "min_line_b"><?php echo $min_line_b;  ?></span></div>
                                        <div class="nk-tb-col"><span class="tb-lead" id = "max_line_b"><?php echo $max_line_b; ?></span></div>
                                        <div class="nk-tb-col"><span class="tb-lead" id = "percentage_b">32%</span></div>
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
                                                if($total_b == $basic_line_b){
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
                                            if($total_line_all < $total_team_eligible){
                                                $min_line_c = ($basic_line_c < 1) ? "0" : round(($basic_line_c) - ((($basic_line_c)*(10/100))));
                                                $max_line_c = ($basic_line_c < 1) ? "0" : round(($basic_line_c) + ((($basic_line_c)*(10/100))));
                                            }else{
                                                $min_line_c = ($basic_line_c < 1) ? "0" : round((($total_team_eligible*43)/100) - (((($total_team_eligible*43)/100)*(10/100))));
                                                $max_line_c = ($basic_line_c < 1) ? "0" : round((($total_team_eligible*43)/100) + (((($total_team_eligible*43)/100)*(10/100))));
                                            } 
                                        }
                                         
                                        ?>
                                        <div class="nk-tb-col"><span class="tb-lead" id = "min_line_c"><?php echo $min_line_c;  ?></span></div>
                                        <div class="nk-tb-col"><span class="tb-lead" id = "max_line_c"><?php echo $max_line_c;  ?></span></div>
                                        <div class="nk-tb-col"><span class="tb-lead" id = "percentage_c">43%</span></div>
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
                                                    if($total_c == $basic_line_c){
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
                                            $min_line_d = ($total_team_eligible < 1) ? "0" : round((($total_team_eligible*15)/100) - (((($total_team_eligible*15)/100)*(15/100))));
                                            $max_line_d = ($total_team_eligible < 1) ? "0" : round((($total_team_eligible*15)/100) + (((($total_team_eligible*15)/100)*(15/100))));
                                        }
                                         
                                        ?>
                                        <div class="nk-tb-col"><span class="tb-lead" id = "min_line_d"><?php echo $min_line_d; ?></span></div>
                                        <div class="nk-tb-col"><span class="tb-lead" id = "max_line_d"><?php echo $max_line_d; ?></span></div>
                                        <div class="nk-tb-col"><span class="tb-lead" id = "percentage_d">15%</span></div>
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
                                            // dumper($total_d." - ".$min_line_d." - ".$max_line_d." - ".$basic_line_d);
                                                if($total_d == $basic_line_d){
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
                                            if($total_line_all < $total_team_eligible){
                                                $min_line_e = ($basic_line_e < 1) ? "0" : round((($total_team_eligible*5)/100) - (((($total_team_eligible*5)/100)*(15/100))));
                                                $max_line_e = ($basic_line_e < 1) ? "0" : round((($total_team_eligible*5)/100) + (((($total_team_eligible*5)/100)*(15/100))));
                                            }else{
                                                $min_line_e = ($basic_line_e < 1) ? "0" : round(($basic_line_e) - ((($basic_line_e)*(15/100))));
                                                $max_line_e = ($basic_line_e < 1) ? "0" : round(($basic_line_e) + ((($basic_line_e)*(15/100))));
                                            }
                                        }
                                        ?>
                                        <div class="nk-tb-col"><span class="tb-lead" id = "min_line_e"><?php echo $min_line_e;  ?></span></div>
                                        <div class="nk-tb-col"><span class="tb-lead" id = "max_line_e"><?php echo $max_line_e;  ?></span></div>
                                        <div class="nk-tb-col"><span class="tb-lead" id = "percentage_e">5%</span></div>
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
                                                if($total_e == $basic_line_e){
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
                                        $total_line = $total_line+$basic_line_e;
                                    ?>
                                    <div class="nk-tb-item nk-tb-head">
                                        <div class="nk-tb-col"><span class="tb-lead">TOTAL</span></div>
                                        <div class="nk-tb-col"><span class="tb-lead"><?= $total_pa ?></span></div>
                                        <div class="nk-tb-col"><span class="tb-lead"><?= $total_line ?></span></div>
                                        <div class="nk-tb-col"><span class="tb-lead"></span></div>
                                        <div class="nk-tb-col"><span class="tb-lead"></span></div>
                                        <div class="nk-tb-col"><span class="tb-lead">100%</span></div>
                                        <div class="nk-tb-col"><span class="tb-lead"><?= ($needrevise > 0 or $total_pa == 0) ? "
                                        <b style = 'color:red;'>Not Valid</b>
                                        " : "
                                        <b>Valid</b>
                                        " ?></span></div>
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

    <div class="card card-preview">
        <div class="card-inner">
            <h5><?= str_replace(array('%20'), array(' '), decrypt($division_status['division_name'])); ?></h5>
            <table class="datatable-init-export nowrap table" data-export-title="Export Data" id="tableDivHead" data-ajaxsource="<?= site_url('inbox/read_hr_review/'.encode_url(str_replace(array('%20'), array(' '), decrypt($division_status['division_name']))).'/'.$year); ?>">
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
                            <table class="table table-striped score-pa" data-ajaxsource="<?= site_url('inbox/scorepa_hrview/'.$division); ?>">
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


<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="modalIOM">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card-inner">
                    <!-- <div class="card-head">
                        <h5 class="card-title">DEVIATION</h5>
                    </div> -->
                    <div class="card-content">
                            <!-- File IOM Deviation, please click <a href="<?=base_url()?>/upload/iom/<?=$check_devisiasi[0]->iom_file?>" target="_blank"><em class="icon ni ni-file-text"></em></a> to see.
                            <hr> -->
                            <h5>Basic Line Before Deviation</h5>
                            <?php 
                                        $total_pa = 0;
                                        $total_line = 0;
                                        $valid = 0;
                                        $needrevise = 0;

                                        $basic_line_a =round(($total_team_eligible*5)/100);
                                        $basic_line_b =round(($total_team_eligible*32)/100);
                                        $basic_line_c =round(($total_team_eligible*43)/100);
                                        $basic_line_d =round(($total_team_eligible*15)/100);
                                        $basic_line_e =round(($total_team_eligible*5)/100);

                                        $total_line = $basic_line_a+$basic_line_b+$basic_line_c+$basic_line_d+$basic_line_e;
                                        if($total_line > $total_team_eligible){
                                            $basic_line_e = $basic_line_e-1;
                                        }elseif($total_line < $total_team_eligible){
                                            $basic_line_c = $basic_line_c+1;
                                        }

                                        $total_line = 0;
                                    ?>
                                    <div class="nk-tb-list is-loose traffic-channel-table">
                                        <div class="nk-tb-item nk-tb-head">
                                            <div class="nk-tb-col"><span class="tb-lead">Score</span></div>
                                            <div class="nk-tb-col"><span class="tb-lead">PA</span></div>
                                            <div class="nk-tb-col"><span class="tb-lead">Basic Line</span></div>
                                            <div class="nk-tb-col"><span class="tb-lead">Min Basic Line</span></div>
                                            <div class="nk-tb-col"><span class="tb-lead">Max Basic Line</span></div>
                                            <div class="nk-tb-col"><span class="tb-lead">Percentage</span></div>
                                            <div class="nk-tb-col"><span class="tb-lead">Note</span></div>
                                        </div>
                                        <div class="nk-tb-item nk-tb-head">
                                            <div class="nk-tb-col"><span class="tb-lead">A</span></div>
                                            <div class="nk-tb-col"><span class="tb-lead" id = "pa_a"><?=$total_a;?></span></div>
                                            <div class="nk-tb-col"><span class="tb-lead" id = "basic_line_a">
                                            <?php echo $basic_line_a; ?></span></div>
                                            <?php 
                                                $min_line_a = (($basic_line_a-3) < 1) ? "0" : $basic_line_a-3;
                                                $max_line_a = $basic_line_a;
                                            ?>
                                            <div class="nk-tb-col"><span class="tb-lead" id = "min_line_a"><?php echo $min_line_a;  ?></span></div>
                                            <div class="nk-tb-col"><span class="tb-lead" id = "max_line_a"><?php echo $max_line_a;  ?></span></div>
                                            <div class="nk-tb-col"><span class="tb-lead" id = "percentage_a">5%</span></div>
                                            <div class="nk-tb-col"><span class="tb-lead" id = "note_a">
                                            <?php 
                                                    if(($total_a >= $min_line_a and $total_a <= $max_line_a) or $total_a == $basic_line_a){
                                                        echo "<b class='badge badge-success'>Valid</b>";
                                                        $valid++;
                                                    }else{
                                                        echo "<b class='badge badge-danger'>Not Valid</b>";
                                                        $needrevise++;
                                                    }
                                            ?>

                                            </span></div>
                                        </div>
                                        <?php 
                                            $total_pa = $total_pa+$total_a;
                                            $total_line = $total_line+$basic_line_a;
                                        ?>
                                        <div class="nk-tb-item nk-tb-head">
                                            <div class="nk-tb-col"><span class="tb-lead">B</span></div>
                                            <div class="nk-tb-col"><span class="tb-lead" id = "pa_b"><?=$total_b;?></span></div>
                                            <div class="nk-tb-col"><span class="tb-lead" id = "basic_line_b">
                                                    <?php echo $basic_line_b;  ?></span></div>
                                            <?php 
                                            
                                                $min_line_b = ($total_team_eligible < 1) ? "0" : round((($total_team_eligible*32)/100) - (((($total_team_eligible*32)/100)*(10/100))));
                                                $max_line_b = ($total_team_eligible < 1) ? "0" : round((($total_team_eligible*32)/100) + (((($total_team_eligible*32)/100)*(10/100))));
                                                
                                            ?>
                                            <div class="nk-tb-col"><span class="tb-lead" id = "min_line_b"><?php echo $min_line_b;  ?></span></div>
                                            <div class="nk-tb-col"><span class="tb-lead" id = "max_line_b"><?php echo $max_line_b; ?></span></div>
                                            <div class="nk-tb-col"><span class="tb-lead" id = "percentage_b">32%</span></div>
                                            <div class="nk-tb-col"><span class="tb-lead" id = "note_b">
                                                <?php 
                                                
                                                    if($total_b == $basic_line_b){
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
                                                    
                                                ?>
                                            </span></div>
                                        </div>
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

                                                $min_line_c = ($total_team_eligible < 1) ? "0" : round((($total_team_eligible*43)/100) - (((($total_team_eligible*43)/100)*(10/100))));
                                                $max_line_c = ($total_team_eligible < 1) ? "0" : round((($total_team_eligible*43)/100) + (((($total_team_eligible*43)/100)*(10/100))));

                                            ?>
                                            <div class="nk-tb-col"><span class="tb-lead" id = "min_line_c"><?php echo $min_line_c;  ?></span></div>
                                            <div class="nk-tb-col"><span class="tb-lead" id = "max_line_c"><?php echo $max_line_c;  ?></span></div>
                                            <div class="nk-tb-col"><span class="tb-lead" id = "percentage_c">43%</span></div>
                                            <div class="nk-tb-col"><span class="tb-lead" id = "note_c">
                                            <?php 
                                            
                                                if($total_c == $basic_line_c){
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
                                            ?>
                                            </span></div>
                                        </div>
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
                                            
                                                $min_line_d = ($total_team_eligible < 1) ? "0" : round((($total_team_eligible*15)/100) - (((($total_team_eligible*15)/100)*(15/100))));
                                                $max_line_d = ($total_team_eligible < 1) ? "0" : round((($total_team_eligible*15)/100) + (((($total_team_eligible*15)/100)*(15/100))));
                                            
                                            ?>
                                            <div class="nk-tb-col"><span class="tb-lead" id = "min_line_d"><?php echo $min_line_d; ?></span></div>
                                            <div class="nk-tb-col"><span class="tb-lead" id = "max_line_d"><?php echo $max_line_d; ?></span></div>
                                            <div class="nk-tb-col"><span class="tb-lead" id = "percentage_d">15%</span></div>
                                            <div class="nk-tb-col"><span class="tb-lead" id = "note_d">
                                            <?php 
                                                
                                                if($total_d == $basic_line_d){
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
                                            ?>
                                            </span></div>
                                        </div>
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

                                                $min_line_e = ($total_team_eligible < 1) ? "0" : round((($total_team_eligible*5)/100) - (((($total_team_eligible*5)/100)*(15/100))));
                                                $max_line_e = ($total_team_eligible < 1) ? "0" : round((($total_team_eligible*5)/100) + (((($total_team_eligible*5)/100)*(15/100))));
                                            
                                            ?>
                                            <div class="nk-tb-col"><span class="tb-lead" id = "min_line_e"><?php echo $min_line_e;  ?></span></div>
                                            <div class="nk-tb-col"><span class="tb-lead" id = "max_line_e"><?php echo $max_line_e;  ?></span></div>
                                            <div class="nk-tb-col"><span class="tb-lead" id = "percentage_e">5%</span></div>
                                            <div class="nk-tb-col"><span class="tb-lead" id = "note_e">
                                            <?php 
                                                    if($total_e == $basic_line_e){
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
                                            ?>
                                            </span></div>
                                        </div>
                                        <?php 
                                            $total_pa = $total_pa+$total_e;
                                            $total_line = $total_line+$basic_line_e;
                                        ?>
                                        <div class="nk-tb-item nk-tb-head">
                                            <div class="nk-tb-col"><span class="tb-lead">TOTAL</span></div>
                                            <div class="nk-tb-col"><span class="tb-lead"><?= $total_pa ?></span></div>
                                            <div class="nk-tb-col"><span class="tb-lead"><?= $total_line ?></span></div>
                                            <div class="nk-tb-col"><span class="tb-lead"></span></div>
                                            <div class="nk-tb-col"><span class="tb-lead"></span></div>
                                            <div class="nk-tb-col"><span class="tb-lead">100%</span></div>
                                            <div class="nk-tb-col"><span class="tb-lead"><?= ($needrevise > 0 or $total_pa == 0) ? "
                                            <b style = 'color:red;'>Not Valid</b>
                                            " : "
                                            <b>Valid</b>
                                            " ?></span></div>
                                        </div>
                    </div>
                </div>
                <hr>
                <div class="sp-package-action">
                    <button type = "button" class="btn btn-dim btn-primary" data-dismiss="modal" data-toggle="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>