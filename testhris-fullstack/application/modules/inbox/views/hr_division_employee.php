<?php
if(empty($_REQUEST['division_name'])){
    $_REQUEST['division_name'] = "";
}
if($checkDeviasi > 0){
    $st = 'show';
}else{
    $st = 'hidden';
}

if($division_status == 3){
    $st_btn = 'hidden';
}elseif($division_status == 1){
    $st_btn = 'show';
}else{
    $st_btn = 'show';
}
?>
<div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-ibx">
                                    <div class="nk-ibx-aside" data-content="inbox-aside" data-toggle-overlay="true" data-toggle-screen="lg">
                                        <div class="nk-ibx-head">
                                            <h5 class="mb-0">Division List</h5>
                                            
                                        </div>
                                        <div class="nk-ibx-nav" data-simplebar>
                                            <ul class="nk-ibx-menu">
                                                <?php 
                                                    foreach($division_list as $key => $val){
                                                        ?>
                                                        <li class="">
                                                            <a class="nk-ibx-menu-item" href="<?= base_url() ?>inbox/hr_division_employee?division_name=<?= $val ?>">
                                                                <span class="nk-ibx-menu-text"><?= strtoupper($val); ?></span>
                                                            </a>
                                                        </li>
                                                        <?php
                                                    }
                                                ?>
                                                        <li class="nk-ibx-menu-item">
                                                        </li>
                                                        <li class="nk-ibx-menu-item">
                                                        </li>
                                                        <li class="nk-ibx-menu-item">
                                                        </li>
                                            </ul>
                                            
                                        </div>
                                    </div><!-- .nk-ibx-aside -->
                                    <div class="nk-ibx-body bg-white">
                                        <div class="nk-ibx-head">
                                            <div class="nk-ibx-head-actions">
                                                <h5 class="mb-0"><?= (!empty(str_replace("&","And",$_REQUEST['division_name']))) ? strtoupper($_REQUEST['division_name']) : "" ?>
                                                    <?php 
                                                        $totemp = 0;
                                                        if(!empty($list_employee)){
                                                            foreach($list_employee as $key){
                                                                $personnel_area		= decrypt($key->personnel_area);
                                                                $pers 				= substr($personnel_area,0,3);
                                                                // if($pers != "TIS"){
                                                                    $totemp++;
                                                                // }
                                                            }
                                                            echo ", Total Employee ".$totemp;
                                                        }
                                                    ?>
                                                </h5>
                                            </div>
                                            <div>
                                                
                                            </div>
                                            <div class="search-wrap" data-search="search">
                                                
                                            </div><!-- .search-wrap -->
                                        </div><!-- .nk-ibx-head -->

                                        <!--content employee-->
                                        <div class="nk-ibx-list" data-simplebar>
                                            <table class = "table table-sm" id = "default_table">
                                                <thead>
                                                    <tr>
                                                        <th>NIK</th>
                                                        <th>Employee</th>
                                                        <th>Join Date</th>
                                                        <th>Dept</th>
                                                        <th>Division</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $no =1;
                                                    
                                                    if(!empty($list_employee)){
                                                        foreach($list_employee as $key){
                                                            $personnel_area		= decrypt($key->personnel_area);
		                                                    $pers 				= substr($personnel_area,0,3);
                                                            if($pers != "TIS"){
                                                            ?>
                                                            <tr>
                                                                <td><?= $key->nik;//." == ".decrypt($key->personnel_area); ?></td>
                                                                <td><?= decrypt($key->complete_name) ?></td>
                                                                <td><?= date("d/m/Y",strtotime(decrypt($key->join_date))) ?></td>
                                                                <td><?= decrypt($key->department) ?></td>
                                                                <td><?= decrypt($key->division) ?></td>
                                                            </tr>
                                                            <?php
                                                            $no++;
                                                            }
                                                        }
                                                    }else{
                                                        // echo "hihih";die;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                            <br><br>
                                            <table>
                                                <tr>
                                                    <td>Total Team</b></td>
                                                    <td>:</td>
                                                    <td>&nbsp&nbsp<b><?= $count_employee; ?></b></td>
                                                </tr>
                                                <tr>
                                                    <td>Total Team Eligible</b></td>
                                                    <td>:</td>
                                                    <td>&nbsp&nbsp<b><?= $total_team_eligible; ?></b></td>
                                                </tr>
                                            </table>

                                            <?php 
                                                //==================rumus=================//
                                                $basic_line_a =round(($total_team_eligible*5)/100);
                                                $basic_line_b =round(($total_team_eligible*32)/100);
                                                $basic_line_c =round(($total_team_eligible*43)/100);
                                                $basic_line_d =round(($total_team_eligible*15)/100);
                                                $basic_line_e =round(($total_team_eligible*5)/100);

                                               
                                                $total_line = $basic_line_a+$basic_line_b+$basic_line_c+$basic_line_d+$basic_line_e;
                                                
                                                if($total_line > $total_team_eligible){
                                                    $basic_line_e = $basic_line_e-1;
                                                }elseif($total_line < $total_team_eligible){
                                                    $total_tambah = $total_team_eligible - $total_line;
                                                    $basic_line_c = $basic_line_c+$total_tambah;
                                                }


                                                $min_line_a = (($basic_line_a-3) < 1) ? "0" : $basic_line_a-3;//round(round(($total_team_eligible*5)/100)-3);
                                                $max_line_a = $basic_line_a;
                                                $min_line_b = ($basic_line_b < 1) ? "0" : round((($total_team_eligible*32)/100) - (((($total_team_eligible*32)/100)*(10/100))));
                                                $max_line_b = ($basic_line_b < 1) ? "0" : round((($total_team_eligible*32)/100) + (((($total_team_eligible*32)/100)*(10/100))));
                                                $min_line_d = ($basic_line_d < 1) ? "0" : round((($total_team_eligible*15)/100) - (((($total_team_eligible*15)/100)*(15/100))));
                                                $max_line_d = ($basic_line_d < 1) ? "0" : round((($total_team_eligible*15)/100) + (((($total_team_eligible*15)/100)*(15/100))));

                                                if($total_line < $total_team_eligible){
                                                    $min_line_c = ($basic_line_c < 1) ? "0" : round(($basic_line_c) - ((($basic_line_c)*(10/100))));
                                                    $max_line_c = ($basic_line_c < 1) ? "0" : round(($basic_line_c) + ((($basic_line_c)*(10/100))));
                                                    $min_line_e = ($basic_line_e < 1) ? "0" : round((($total_team_eligible*5)/100) - (((($total_team_eligible*5)/100)*(15/100))));
                                                    $max_line_e = ($basic_line_e < 1) ? "0" : round((($total_team_eligible*5)/100) + (((($total_team_eligible*5)/100)*(15/100))));
                                                }else{
                                                    $min_line_c = ($basic_line_c < 1) ? "0" : round((($total_team_eligible*43)/100) - (((($total_team_eligible*43)/100)*(10/100))));
                                                    $max_line_c = ($basic_line_c < 1) ? "0" : round((($total_team_eligible*43)/100) + (((($total_team_eligible*43)/100)*(10/100))));
                                                    $min_line_e = ($basic_line_e < 1) ? "0" : round(($basic_line_e) - ((($basic_line_e)*(15/100))));
                                                    $max_line_e = ($basic_line_e < 1) ? "0" : round(($basic_line_e) + ((($basic_line_e)*(15/100))));
                                                }
                                                
                                            ?>

                                            <div class="nk-tb-list is-loose traffic-channel-table">
                                                <form action = "#" id = "formKurvaGA" method = "post" enctype="multipart/form-data">
                                                        <!-- <input type = "hidden" name = "year" id = "year" value = "<?= $year; ?>"> -->
                                                        <div class="nk-tb-item nk-tb-head">
                                                            <div class="nk-tb-col"><span class="tb-lead">Score</span></div> 
                                                            <div class="nk-tb-col"><span class="tb-lead">Basic Line</span></div>
                                                            <div class="nk-tb-col"><span class="tb-lead">Min Basic Line</span></div>
                                                            <div class="nk-tb-col"><span class="tb-lead">Max Basic Line</span></div>
                                                            <div class="nk-tb-col"><span class="tb-lead" <?=$st?>>Deviasi Basic Line</span></div>
                                                            <?php
                                                                if(!empty($_REQUEST['division_name'])){
                                                            ?>
                                                                    <div class="nk-tb-col" <?=$st_btn;?> ><a href="#" class="btn btn-dim btn-danger" data-toggle="modal" data-target="#updatekur">Update</a></div>
                                                            <?php
                                                                }
                                                            ?>
                                                            <!-- <div class="nk-tb-col"><span class="tb-lead">Percentage</span></div> -->
                                                        </div>
                                                        <div class="nk-tb-item nk-tb-head">
                                                            <div class="nk-tb-col"><span class="tb-lead">A</span></div>
                                                            <div class="nk-tb-col"><span class="tb-lead" id = "hr_basic_line_a"><?= $basic_line_a ?></span></div>
                                                            <div class="nk-tb-col"><span class="tb-lead" id = "hr_min_line_a"><?= $min_line_a; ?></span></div>
                                                            <div class="nk-tb-col"><span class="tb-lead" id = "hr_max_line_a"><?= $max_line_a; ?></span></div>
                                                            <div class="nk-tb-col" <?=$st?>><span class="tb-lead" id = "hr_dev_line_a"><?= $devisiasi_basic_line_a ?></span></div>
                                                            <!-- <div class="nk-tb-col"><span class="tb-lead" id = "hr_percentage_a">5%</span></div> -->
                                                        </div>
                                                        <div class="nk-tb-item nk-tb-head">
                                                            <div class="nk-tb-col"><span class="tb-lead">B</span></div>
                                                            <div class="nk-tb-col"><span class="tb-lead" id = "hr_basic_line_b"><?= $basic_line_b ?></span></div>
                                                            <div class="nk-tb-col"><span class="tb-lead" id = "hr_min_line_b"><?= $min_line_b; ?></span></div>
                                                            <div class="nk-tb-col"><span class="tb-lead" id = "hr_max_line_b"><?= $max_line_b; ?></span></div>
                                                            <div class="nk-tb-col" <?=$st?>><span class="tb-lead" id = "hr_dev_line_b"><?= $devisiasi_basic_line_b ?></span></div>
                                                            <!-- <div class="nk-tb-col"><span class="tb-lead" id = "hr_percentage_b">32%</span></div> -->
                                                        </div>
                                                        <div class="nk-tb-item nk-tb-head">
                                                            <div class="nk-tb-col"><span class="tb-lead">C</span></div>
                                                            <div class="nk-tb-col"><span class="tb-lead" id = "hr_basic_line_c"><?= $basic_line_c ?></span></div>
                                                            <div class="nk-tb-col"><span class="tb-lead" id = "hr_min_line_c"><?= $min_line_c; ?></span></div>
                                                            <div class="nk-tb-col"><span class="tb-lead" id = "hr_max_line_c"><?= $max_line_c; ?></span></div>
                                                            <div class="nk-tb-col" <?=$st?>><span class="tb-lead" id = "hr_dev_line_c"><?= $devisiasi_basic_line_c ?></span></div>
                                                            <!-- <div class="nk-tb-col"><span class="tb-lead" id = "hr_percentage_c">43%</span></div> -->
                                                        </div>
                                                        <div class="nk-tb-item nk-tb-head">
                                                            <div class="nk-tb-col"><span class="tb-lead">D</span></div>
                                                            <div class="nk-tb-col"><span class="tb-lead" id = "hr_basic_line_d"><?= $basic_line_d ?></span></div>
                                                            <div class="nk-tb-col"><span class="tb-lead" id = "hr_min_line_d"><?= $min_line_d; ?></span></div>
                                                            <div class="nk-tb-col"><span class="tb-lead" id = "hr_max_line_d"><?= $max_line_d; ?></span></div>
                                                            <div class="nk-tb-col" <?=$st?>><span class="tb-lead" id = "hr_dev_line_d"><?= $devisiasi_basic_line_d ?></span></div>
                                                            <!-- <div class="nk-tb-col"><span class="tb-lead" id = "hr_percentage_d">15%</span></div> -->
                                                        </div>
                                                        <div class="nk-tb-item nk-tb-head">
                                                            <div class="nk-tb-col"><span class="tb-lead">E</span></div>
                                                            <div class="nk-tb-col"><span class="tb-lead" id = "hr_basic_line_e"><?= $basic_line_e ?></span></div>
                                                            <div class="nk-tb-col"><span class="tb-lead" id = "hr_min_line_e"><?= $min_line_e; ?></span></div>
                                                            <div class="nk-tb-col"><span class="tb-lead" id = "hr_max_line_e"><?= $max_line_e; ?></span></div>
                                                            <div class="nk-tb-col" <?=$st?>><span class="tb-lead" id = "hr_dev_line_e"><?= $devisiasi_basic_line_e ?></span></div>
                                                        </div>
                                                        <div class="nk-tb-item nk-tb-head">
                                                            <div class="nk-tb-col"><span class="tb-lead">TOTAL</span></div>
                                                            <div class="nk-tb-col">
                                                                <span class="tb-lead">
                                                                    <?php 
                                                                        echo $total_line = $basic_line_a+$basic_line_b+$basic_line_c+$basic_line_d+$basic_line_e;
                                                                    ?>
                                                                </span>
                                                            </div>
                                                            <div class="nk-tb-col"><span class="tb-lead"></div>
                                                            <div class="nk-tb-col"><span class="tb-lead"></div>
                                                            <div class="nk-tb-col" <?=$st?>>
                                                                <span class="tb-lead">
                                                                    <?php 
                                                                        echo $total_dev_line = $devisiasi_basic_line_a+$devisiasi_basic_line_b+$devisiasi_basic_line_c+$devisiasi_basic_line_d+$devisiasi_basic_line_e;
                                                                    ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        
                                                </form>
                                            </div>
                                        </div>
                                        <br>
                                        <br>
                                        <br>
                                        <!-- content employee -->
                                        
                                    </div><!-- .nk-ibx-body -->
                                </div><!-- .nk-ibx -->
                            </div>
                        </div>
                    </div>
                </div>


<!--//////////////////////////////////////////Start Update Kurva Normal 2025//////////////////////////////////////////////////////-->
<div class="modal fade" id="updatekur" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="updatekurLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updatekurLabel">Deviasi Basic Line</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <table>
        <tr>
            <td>Division</td>
            <td>:</td>
            <td><?= (!empty(str_replace("&","And",$_REQUEST['division_name']))) ? strtoupper($_REQUEST['division_name']) : "" ?></td>
        </tr>
        <tr>
            <td>Total Team</b></td>
            <td>:</td>
            <td><strong><?=$count_employee;?></strong></td>
        </tr>
        <tr>
            <td>Total Team Eligible</b></td>
            <td>:</td>
            <td><strong><?=$total_team_eligible;?></strong></td>
        </tr>
      </table>
      <div class="nk-tb-list is-loose traffic-channel-table">
      <!-- <form action = "<?= base_url('/inbox/kurva_devisiasi'); ?>" method = "post" enctype="multipart/form-data"> -->
      <form>
            <input type = "hidden" id="hr_te" name="hr_te" value = "<?=$total_team_eligible;?>">
            <input type = "hidden" id = "hr_tot" value = "<?=$count_employee;?>">
            <input type = "hidden" id = "division_name" value = "<?= (!empty(str_replace("&","And",$_REQUEST['division_name']))) ? strtoupper($_REQUEST['division_name']) : "" ?>">
            <div class="nk-tb-item nk-tb-head">
                
                <div class="nk-tb-col"><span class="tb-lead">Score</span></div> 
                <div class="nk-tb-col"><span class="tb-lead">Basic Line</span></div>
            </div>
            <div class="nk-tb-item nk-tb-head">
                <div class="nk-tb-col"><span class="tb-lead">A</span></div>
                <div class="nk-tb-col"><span class="tb-lead" id = "hr_basic_line_a">
                    <input type = "number" id = "hr_basic_line_a_field" name = "basic_line[a]" min="0" max="<?=$total_team_eligible;?>" value="0" onkeypress="return isNumeric(event)"></span>
                </div>
            </div>
            <div class="nk-tb-item nk-tb-head">
                <div class="nk-tb-col"><span class="tb-lead">B</span></div>
                <div class="nk-tb-col"><span class="tb-lead" id = "hr_basic_line_b">
                    <input type = "number" id = "hr_basic_line_b_field" name = "basic_line[b]" min="0" max="<?=$total_team_eligible;?>" value="0" onkeypress="return isNumeric(event)"></span>
                </div>
            </div>
            <div class="nk-tb-item nk-tb-head">
                <div class="nk-tb-col"><span class="tb-lead">C</span></div>
                <div class="nk-tb-col"><span class="tb-lead" id = "hr_basic_line_c">
                    <input type = "number" id = "hr_basic_line_c_field" name = "basic_line[c]" min="0" max="<?=$total_team_eligible;?>" value="0" onkeypress="return isNumeric(event)"></span>
                </div>
            </div>
            <div class="nk-tb-item nk-tb-head">
                <div class="nk-tb-col"><span class="tb-lead">D</span></div>
                <div class="nk-tb-col"><span class="tb-lead" id = "hr_basic_line_d">
                    <input type = "number" id = "hr_basic_line_d_field" name = "basic_line[d]" min="0" max="<?=$total_team_eligible;?>" value="0" onkeypress="return isNumeric(event)"></span>
                </div>
            </div>
            <div class="nk-tb-item nk-tb-head">
                <div class="nk-tb-col"><span class="tb-lead">E</span></div>
                <div class="nk-tb-col"><span class="tb-lead" id = "hr_basic_line_e">
                    <input type = "number" id = "hr_basic_line_e_field" name = "basic_line[e]" min="0" max="<?=$total_team_eligible;?>" value="0" onkeypress="return isNumeric(event)"></span>
            </div>
                
            </div>
        </div>      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger mr-auto btn-update-deviasi" id = "btn-update-deviasi">Update</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--//////////////////////////////////////////End Update Kurva Normal 2025//////////////////////////////////////////////////////-->