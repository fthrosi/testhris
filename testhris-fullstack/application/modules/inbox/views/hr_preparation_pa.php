
<div class="nk-ibx-head">
    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <?php 
                $year = date("Y",strtotime("now - 1 year"));
                if($is_ready == 0){
            ?>
            <li>
                <a onclick = "readyForPA(<?= $year ?>)">
                    <em class="icon ni ni-send"></em>
                    Submit Ready For PA <?php echo date("Y",strtotime("now - 1 year")); ?>
                </a>
            </li>
            <?php }else{
                ?>
                <div class="alert alert-success" role="alert">
                  PA <?= $year ?> has opened on <?= date("Y-m-d H:i:s",strtotime($is_ready)) ?>!
                  &nbsp;&nbsp; <button class = "btn btn-sm btn-danger"  onclick = "cancelReadyForPA(<?= $year ?>)">Cancel</button>
                </div>
                <?php
                
            } ?>
        </ul>
    </div>
</div>
<div class="nk-ibx-reply nk-reply" data-simplebar>
    <div class="card card-preview">
        <div class="card-inner">
        <h3 class="title">Preparation Division PA</h3>
            <?php 
                if($is_ready == 0){
            ?>
            <button type = "button" class = "btn btn-sm btn-primary" data-toggle="modal" data-target="#modalDivisionChange">Add Employee Change Division</button>
            <?php } ?>
            <br><br>
            <div class = "table-responsive">
            <table class="table table-sm" id = "default_table">
                <thead>
                    <tr>
                        <th rowspan = "2">#</th>
                        <th rowspan = "2">NIK</th>
                        <th rowspan = "2">Name</th>
                        <th colspan = "4"><center>Before</center></th>
                        <th colspan = "4"><center>After</center></th>
                        <th rowspan = "2">Action</th>
                    </tr>
                    <tr>
                        <th>Division</th>
                        <th>Dept Head</th>
                        <th>Div Head</th>
                        <th>Directorate</th>
                        <th>Division</th>
                        <th>Dept Head</th>
                        <th>Div Head</th>
                        <th>Directorate</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        if(!empty($data_change)){
                            $no = 1;
                            foreach($data_change as $key => $val){

                                ?>
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td><?= $val['nik'] ?></td>
                                    <td><?= decrypt($val['complete_name']) ?></td>
                                    <td><?= decrypt($val['division_old']) ?></td>
                                    <td><?= ($val['depthead_old'] != "") ? decrypt($val['depthead_old']) : $val['depthead_old'] ?></td>
                                    <td><?= decrypt($val['divhead_old']) ?></td>
                                    <td><?= decrypt($val['director_old']) ?></td>
                                    <td><?= decrypt($val['division_new']) ?></td>
                                    <td><?= ($val['depthead_new'] != "") ? decrypt($val['depthead_new']) : $val['depthead_new'] ?></td>
                                    <td><?= decrypt($val['divhead_new']) ?></td>
                                    <td><?= decrypt($val['director_new']) ?></td>
                                    <td>
                                    <?php 
                                        if($is_ready == 0){
                                    ?>    
                                    <button type = "button" class = "btn btn-sm btn-danger" onclick = "deleteChangeDivision(<?= $val['id'] ?>)">Delete</button>
                                    <?php } ?>
                                </td>
                                </tr>
                                <?php
                                $no++;

                            }
                        }
                    ?>
                </tbody>
            </table>
            </div>
            
        </div>
    </div>
</div>

<script>
    
</script>
<?php 
// foreach($employee as $key => $val){
//     // print_r();
//     echo $key."xxx<br>";
//     echo $val['nik']." aaa<br>";
// }

$arremployee = array();

foreach($employee as $key => $val){
    $arremployee[] = decrypt($val['complete_name'])."|".$val['nik']."|".decrypt($val['action']);
}

sort($arremployee);
?>
<div class="modal fade" tabindex="-1" data-keyboard="false" id="modalDivisionChange">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="card-title">Add Change</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="container">
                <div class="modal-body">
                            <form action = "<?= base_url()."inbox/hr_preparation_pa_update"; ?>" id = "" method = "POST">
                                <div class="col-12" id="">
                                    <div class="form-group">
                                        <div class="form-control-wrap focused">
                                            <span class="lead-primary">
                                                <select class="form-control" id="mySelect2" name="nik"  onchange = "addChangeDivision(this.value)">
                                                    <option value = ""></option>
                                                    <?php 
                                                        foreach($arremployee as $key => $val){
                                                            $exp = explode("|",$val);
                                                            ?>
                                                                <option value = "<?= $exp[1]?>"><?php echo $exp[1]." | ".$exp[0]; ?></option>
                                                            <?php
                                                        }
                                                    ?>
                                                </select>
                                                <label class="form-label-outlined text-primary" for="select_hard_skill">Employee Name</label>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <br><br>
                                <div class="table-responsive" id = "form-change" style = "display:none;">
                                    <table class="table" width="100%">
                                        <tr>
                                            <th></th>
                                            <th>Division</th>
                                            <th>Dept Head</th>
                                            <th>Div Head</th>
                                            <th>Directorate</th>
                                        </tr>
                                        <tr>
                                            <td><b>Existing</b></td>
                                            <td id = "existing_division"></td>
                                            <td id = "existing_depthead"></td>
                                            <td id = "existing_divhead"></td>
                                            <td id = "existing_director"></td>
                                        </tr>
                                        <tr>
                                            <td><b>Change To</b></td>
                                            <td>
                                                <select name = "change_division" class="form-control" id = "change_division" required>
                                                    <option value = ""></option>
                                                    <?php 
                                                        foreach($alldivision as $key => $val){
                                                            ?>
                                                                <option value = "<?= $val['division'] ?>" data-div = "<?= encode_url(str_replace("&","_",$val['division'])) ?>"><?= $val['division'] ?></option>
                                                            <?php
                                                        }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select name = "change_depthead" id = "change_depthead" class="form-control">
                                                    <option value = ""></option>
                                                </select>
                                            </td>
                                            <td>
                                                <p id = "change_divhead"></p>
                                                <input type = "hidden" name = "divhead" id = "divhead">
                                            </td>
                                            <td>
                                                <p id = "change_director"></p>
                                                <input type = "hidden" name = "director" id = "director">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            <div class="sp-package-action">
                                <button type = "button" class="btn btn-dim btn-danger" onClick="window.location.reload();">Cancel</button>
                                <button type="submit"class="btn btn-md btn-primary" id = "submitUOM"><span class="text-notes-response"> Save</span></button>
                            </div>
                            </form>
                </div>
            </div>
        </div>
    </div>
</div>