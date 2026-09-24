<div class="nk-ibx-head">
    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <li>
                 <h3 class="title">Give Access To Division For Leaving Employee PA</h3>
            </li>
        </ul>
    </div>
</div>

<div class="nk-ibx-reply nk-reply" data-simplebar>
    <div class="card card-preview">
        <div class="card-inner">
            <button type = "button" class = "btn btn-sm btn-primary" data-toggle="modal" data-target="#modalUOM">Add Division</button>
            <br><br>
            <table class="nowrap table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Division Name</th>
                        <th>Evaluation Year</th>
                        <th>Created At</th>
                        <th>Created By</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        if(!empty($list)){
                            $no = 1;
                            foreach($list as $item){
                                ?>
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td><?= decrypt($item->division) ?></td>
                                    <td><?= $item->evaluation_year ?></td>
                                    <td><?= $item->created_at ?></td>
                                    <td><?= $item->created_by ?></td>
                                    <td>
                                    <div class="btn-group btn-group-sm">
                                            <button type = "button" class = "btn btn-primary btn-sm" onclick = "openModalDIVHEAD(<?= $item->id ?>)"><em class="icon ni ni-eye"></em></button>
                                    </div>
                                    <!-- <div class="btn-group btn-group-sm">
                                        <button type = "button" class = "btn btn-danger btn-sm" onclick = "deleteDIVHEADPA(<?= $item->id ?>)"><em class="icon ni ni-trash"></em></button>
                                    </div> -->
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

<script>
    
</script>
<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="modalUOM">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card-inner">
                    <div class="card-head">
                        <h5 class="card-title">Give Access To Division</h5>
                    </div>
                    <div class="card-content">
                    <form action = "#" id = "formDIVHEADPA">
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">Division</label>
                            <div class="col-sm-10">
                            <select name = "division" id = "division" class = "form-control">
                                <option value = ""></option>
                                <?php 
                                    foreach($list_division as $item){
                                        ?>
                                        <option value = "<?= encrypt($item); ?>"><?= $item; ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                            </div>
                        </div>

                        <div class="form-group row" id = "active_field" style = "display:none;">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-10">
                            <select name = "is_active" id = "is_active" class = "form-control" disabled>
                                <option value = "1">Active</option>
                                <option value = "0">Not Active</option>
                            </select>
                            </div>
                        </div>
                    </form>
                    <input type = "hidden" name = "id" id = "id_access_divhead">
                    </div>
                </div>
                <div class="sp-package-action">
                    <button type = "button" class="btn btn-dim btn-danger" data-dismiss="modal" data-toggle="modal">Cancel</button>
                    <button type="button"class="btn btn-md btn-primary" id = "submitDIVHEADPA"><span class="text-notes-response"> Save</span></button>
                </div>

            </div>
        </div>
    </div>
</div>