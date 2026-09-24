
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
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        viewKurvaAdjustmentC('<?= str_replace(" ","_",str_replace("#","@",encode_url($division))) ?>');
    });
</script>
<?php
    if($total_approved >= 1){
        $display_sub = "'display:display'";
    }else{
        $display_sub = "'display:none'";
    }
    $divisionEncrypt = str_replace(" ","_",str_replace("#","@",$division));
?>
<div class="nk-ibx-head"  width="100%">
    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools">
            <?php 
                if($is_status_division >= 1){
                    ?><li>
                        <!-- <a href="<?= site_url('dashboard/listDivisionC'); ?>" class="btn btn-icon btn-tooltip" title="Back"> -->
                        <a href="javascript:window.history.go(-1);" class="btn btn-icon btn-tooltip" title="Back">
                            <em class="icon ni ni-arrow-left"></em>
                            Back to Summary
                        </a>
                    </li>
            <?php
                }else{
            ?>
                    <li>
                            <!-- <a href="<?= site_url('dashboard/listDivisionC'); ?>" class="btn btn-icon btn-tooltip" title="Back"> -->
                            <a href="javascript:window.history.go(-1);" class="btn btn-icon btn-tooltip" title="Back">
                                <em class="icon ni ni-arrow-left"></em>
                                Back to Summary
                            </a>
                    </li>
                    <li style = <?=$display_sub?>>
                        <div class="alert alert-danger" role="alert" id = "notifKurvaNotValid" style = "display:none;">
                            Scores cannot be updated, please make sure the scores of employees in this division are in accordance with the normal curve
                        </div>
                    </li>
                    <li style = <?=$display_sub?>>
                        <a onclick="return update_dummy_score_to_real('<?= $divisionEncrypt ?>')" id = "update_grade_pa_c" class="btn btn-icon btn-tooltip" title="Update Grade Pa Division">
                            <em class="icon ni ni-send"></em>
                            Update Grade Pa Division
                        </a>
                    </li>
            <?php 
                }
            ?>
        </ul>
    </div>
</div>

<input type = "hidden" id = "division_encrypt" value = "<?= str_replace(" ","_",str_replace("#","@",$division)) ?>">


<div class="nk-ibx-reply nk-reply" data-simplebar>

    <div class="nk-ibx-reply-head">
        <div>
            <h4 class="title ff-base"><?=strtoupper(decrypt($division));?> <span class="text-soft">DIVISION</span></h4>
           
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
                                    </div>
                                </div>
                                <div class="nk-tb-item">
                                     <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead text-success"><span class="badge badge-success">Full Approved</span></span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
                                        <span class="tb-lead"><?=$total_approved;?></span>
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
                                        <span class="tb-lead"><span class="badge badge-pill badge-sm badge-primary"><?=$total_team_eligible;?></span></span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-channel">
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
                    <div class="col-lg-12 col-xxl-12">
                        <div class="card card-bordered h-100">
                            <div class="card-inner mb-n2">
                                <div class="card-title-group">
                                    <div class="card-title card-title-sm">
                                        <h6 class="title">Kurva Final</h6>
                                    </div>
                                </div>
                                <table class = "table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Score</th>
                                            <th>PA</th>
                                            <th>Basic Line</th>
                                            <th>Percentage</th>
                                            <th>Note</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        ($devisiasi_basic_line_a != "") ? $basic_line_a = $devisiasi_basic_line_a : $basic_line_a = round(($total_team_eligible*5)/100);
                                        ($devisiasi_basic_line_b != "") ? $basic_line_b = $devisiasi_basic_line_b : $basic_line_b = round(($total_team_eligible*32)/100);
                                        ($devisiasi_basic_line_c != "") ? $basic_line_c = $devisiasi_basic_line_c : $basic_line_c = round(($total_team_eligible*43)/100);
                                        ($devisiasi_basic_line_d != "") ? $basic_line_d = $devisiasi_basic_line_d : $basic_line_d = round(($total_team_eligible*15)/100);
                                        ($devisiasi_basic_line_e != "") ? $basic_line_e = $devisiasi_basic_line_e : $basic_line_e = round(($total_team_eligible*5)/100);
                                        $total_line_all = $basic_line_a+$basic_line_b+$basic_line_c+$basic_line_d+$basic_line_e;
                                        ?>
                                        <tr>
                                            <?php 
                                                if($devisiasi_basic_line_a != ""){
                                                    $min_line_a = $devisiasi_basic_line_a;
                                                    $max_line_a = $devisiasi_basic_line_a;
                                                }else{
                                                    $min_line_a = (($basic_line_a-3) < 1) ? "0" : $basic_line_a-3;
                                                    $max_line_a = $basic_line_a;
                                                }
                                            ?>
                                            <td>A</td>
                                            <td><div id = "total_a"></div></td>
                                            <input type = "hidden" id = "total_score_a" readonly>
                                            <td><div id = "basic_a"></div></td>
                                            <input type = "hidden" id = "basic_line_a" readonly>
                                            <input type = "hidden" id = "min_line_a" value="<?=$min_line_a?>">
                                            <input type = "hidden" id = "max_line_a" value="<?=$max_line_a?>">
                                            <td>
                                                5%
                                                <input type = "hidden" id = "persentase_a" value = "5" readonly>
                                            </td>
                                            <td><div id = "note_a"></div></td>
                                        </tr>
                                        <tr>
                                            <?php 
                                               if($devisiasi_basic_line_b != ""){
                                                    $min_line_b = $devisiasi_basic_line_b;
                                                    $max_line_b = $devisiasi_basic_line_b;
                                                }else{
                                                    $min_line_b = ($basic_line_b < 1) ? "0" : round((($total_team_eligible*32)/100) - (((($total_team_eligible*32)/100)*(10/100))));
                                                    $max_line_b = ($basic_line_b < 1) ? "0" : round((($total_team_eligible*32)/100) + (((($total_team_eligible*32)/100)*(10/100))));
                                                }
                                            ?>    
                                            <td>B</td>
                                            <td><div id = "total_b"></div></td>
                                            <input type = "hidden" id = "total_score_b" readonly>
                                            <td><div id = "basic_b"></div></td>
                                            <input type = "hidden" id = "basic_line_b" readonly>
                                            <input type = "hidden" id = "min_line_b" value="<?=$min_line_b?>">
                                            <input type = "hidden" id = "max_line_b" value="<?=$max_line_b?>">
                                            <td>
                                                32%
                                                <input type = "hidden" id = "persentase_b" value = "32" readonly>
                                            </td>
                                            <td><div id = "note_b"></div></td>
                                        </tr>
                                        <tr>
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
                                            <td>C</td>
                                            <td><div id = "total_c"></div></td>
                                            <input type = "hidden" id = "total_score_c" readonly>
                                            <td><div id = "basic_c"></div></td>
                                            <input type = "hidden" id = "basic_line_c" readonly>
                                            <input type = "hidden" id = "min_line_c" value="<?=$min_line_c?>">
                                            <input type = "hidden" id = "max_line_c" value="<?=$max_line_c?>">
                                            <td>
                                                43%
                                                <input type = "hidden" id = "persentase_c" value = "43" readonly>
                                            </td>
                                            <td><div id = "note_c"></div></td>
                                        </tr>
                                        <tr>
                                            <?php 
                                                if($devisiasi_basic_line_d != ""){
                                                    $min_line_d = $devisiasi_basic_line_d;
                                                    $max_line_d = $devisiasi_basic_line_d;
                                                }else{
                                                    $min_line_d = ($basic_line_d < 1) ? "0" : round((($total_team_eligible*15)/100) - (((($total_team_eligible*15)/100)*(15/100))));
                                                    $max_line_d = ($basic_line_d < 1) ? "0" : round((($total_team_eligible*15)/100) + (((($total_team_eligible*15)/100)*(15/100))));
                                                }
                                            ?>
                                            <td>D</td>
                                            <td><div id = "total_d"></div></td>
                                            <input type = "hidden" id = "total_score_d" readonly>
                                            <td><div id = "basic_d"></div></td>
                                            <input type = "hidden" id = "basic_line_d" readonly>
                                            <input type = "hidden" id = "min_line_d" value="<?=$min_line_d?>">
                                            <input type = "hidden" id = "max_line_d" value="<?=$max_line_d?>">
                                            <td>
                                                15%
                                                <input type = "hidden" id = "persentase_d" value = "15" readonly>
                                            </td>
                                            <td><div id = "note_d"></div></td>
                                        </tr>
                                        <tr>
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
                                            <td>E</td>
                                            <td><div id = "total_e"></div></td>
                                            <input type = "hidden" id = "total_score_e" readonly>
                                            <td><div id = "basic_e"></div></td>
                                            <input type = "hidden" id = "basic_line_e" readonly>
                                            <input type = "hidden" id = "min_line_e" value="<?=$min_line_e?>">
                                            <input type = "hidden" id = "max_line_e" value="<?=$max_line_e?>">
                                            <td>
                                                5%
                                                <input type = "hidden" id = "persentase_e" value = "5" readonly>
                                            </td>
                                            <td><div id = "note_e"></div></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan = "3"><div id = "totalall"></div></th>
                                            <th></th>
                                            <th><div id = "notekurva"></div></th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <input type = "hidden" id = "is_valid" readonly>
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
            <table class="table" id = "default_table">
                <thead>
                    <tr>
                        <th>NIK</th>
                        <th>Name</th>
                        <th>Final Score</th>
                        <th>Adjustment Final Score</th>
                        <th>Grade</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if(!empty($listForm)){
                    foreach ($listForm as $key) {

                            $dec = grade_pa(decrypt($key->final_score));
                            ?>
                            <tr>
                                <td><?= $key->employee_nik ?></td>
                                <td><?= decrypt($key->employee_name) ?></td>
                                <td><input type = "text" name= "final_score" value = "<?= decrypt($key->final_score) ?>" style = "text-align:;" disabled></td>
                                <td><input type = "number" value = "<?= decrypt($key->final_score) ?>" style = "text-align:;" <?= ($is_status_division == 3) ? "disabled" : "" ?> onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="5" min="1" max="10" onchange="return calculate_final_score_dashboard(<?= $key->id ?>);" onClick="return calculate_final_score_dashboard(<?= $key->id ?>);" onKeyUp="return calculate_final_score_dashboard(<?= $key->id ?>);" placeholder="Score" id="final_score<?= $key->id ?>" <?= ($division_status == 1 or $division_status == 3) ? "disabled" : "" ?>></td>
                                <td align="right" id="grade<?= $key->id ?>"><?= $dec ?></td>
                            </tr>
                            <?php
                        }
                    }
                    
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- 
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
</script> -->




