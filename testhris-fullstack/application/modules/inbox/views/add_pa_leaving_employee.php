<div class="nk-ibx-head">
    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <li>
                 <h3 class="title">PA Leaving Employee Division : <?= decrypt($this->session->userdata('division')  ) ?></h3>
            </li>
        </ul>
    </div>
</div>

<?= $this->session->flashdata('notif');  ?>

<div class="nk-ibx-reply nk-reply" data-simplebar>
    <div class="card card-preview">
        <div class="card-inner">
            <button type = "button" class = "btn btn-sm btn-primary" data-toggle="modal" data-target="#modalUOM">Add PA Employee</button>
            <br><br>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Final Score</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $no = 1;
                        foreach($list_pa as $key => $val){
                            ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= decrypt($val['employee_name']) ?></td>
                                <td><?= decrypt($val['final_score'])  ?></td>
                            </tr>
                            <?php
                            $no++;
                        }
                    ?>
                </tbody>
            </table>
            
        </div>
    </div>
</div>

<script>
    
</script>
<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="modalUOM">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Add PA Employee</h5>
                    </div>
                    <div class="card-content">
                    <form action = "inbox/proses_pa_leaving_employee" id = "" method = "post">
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">Choose Employee</label>
                            <div class="col-sm-10">
                            <select name = "email" id = "email" class = "form-control" required>
                                <option value = ""></option>
                                <?php 
                                if(!empty($list_employee)){
                                    $no = 1;
                                    foreach($list_employee as $key => $val){
                                        ?>
                                        <option value = "<?= decrypt($val['email']); ?>"><?= decrypt($val['complete_name']); ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Final Score</label>
                            <div class="col-sm-10">
                            <input type="text" class = "form-control" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="5" min="1" max="10" onchange="return calculate_final_score();" placeholder="Score" name="final_score" id="final_score" required>
                            </div>
                        </div>

                        <div class="form-group row" id = "active_field">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">Grade</label>
                            <div class="col-sm-10">
                            <b id="grade"></b>
                            </div>
                        </div>
                        <div id="alert_fs" style="display: none;">
                            <b colspan="3"><p class="text-danger">Please enter final score less than or equal to 10.</p></b>
                        </div>
                    
                    <input type = "hidden" name = "id" id = "id_uom">
                    </div>
                </div>
                <div class="sp-package-action">
                    <button type = "button" class="btn btn-dim btn-danger" data-dismiss="modal" data-toggle="modal">Cancel</button>
                    <button type="submit"class="btn btn-md btn-primary" id="save_pa_leaving"><span class="text-notes-response"> Save</span></button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>