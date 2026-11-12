<div class="wrap-submit-rl">
    <div class="title-section-resign">
        <div class="number-step-resign">
                4
        </div>
        <div class="title-step-resign">
                Approval Exit Clearance
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-tranx is-compact fs-13px" id="table_matrix_prev">
            <thead>
                <tr>
                    <th class="w-5">Nik</th>
                    <th class="w-20">Approval Name</th>
                    <th class="w-20">Division</th>
                    <th class="w-10">Status</th>
                    <th class="w-10 text-left">Action Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($approval_list as $key => $value) {  ?>
                <tr>
                    <td><?=$value['nik'];?></td>
                    <td width="25%"><?=$value['approver_name'];?></td>
                    <td width="25%"><?=$value['division_name'];?></td>
                    <td><?=status_text($value['status']);?></td>
                    <td class="text-left">
                        <?php if((int)$value['status'] !== 1): ?>
                            <?= str_replace('.000','', $value['acted_at']);?>
                        <?php endif; ?>
                    </td>
                    
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php if ($reason): ?>
        <div class="">
                <div class="nk-reply-header nk-ibx-reply-header">
                        <div class="nk-reply-desc">
                        <div class="nk-reply-info">
                                <div class="nk-reply-author lead-text">
                                <h5 class="text-soft">Notes</h5> 
                                </div>
                        </div>
                        </div>
                </div>
                <div class="nk-reply-body nk-ibx-reply-body">
                        <div class="nk-reply-entry entry">
                        <div class="nk-block">
                                <div class="nk-block-head nk-block-head-sm nk-block-between">
                                <a id="add_note" data-id="<?= $header['id_form_request'] ?>" data-type="Resignation Letter" class="btn btn-md text-primary">+ Add Note</a>
                                </div>
                                <?php foreach ($reason as $key => $value) { ?>
                                <div class="bq-note">
                                        <div class="bq-note-item">
                                        <div class="bq-note-text">
                                                <p><?= $value['note'] ?></p>
                                        </div>
                                        <div class="bq-note-meta">
                                                <span class="bq-note-added">Added on <span class="date"><?= $value['created_at'] ?></span></span>
                                                <span class="bq-note-sep sep">|</span>
                                                <span class="bq-note-by text-dark">By <strong><?= $value['created_by'] ?></strong></span>
                                                <!-- <a id="<?= $value['id'] ?>" style="cursor: pointer;"  onclick="return delete_notes(this.id)" class="link link-sm link-danger">Delete Note</a> -->
                                        </div>
                                        </div>
                                </div>
                                <hr>
                                <?php } ?>
                        </div>
                        </div>
                </div>
        </div>
    <?php endif; ?>
</div>