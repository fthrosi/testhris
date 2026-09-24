<?php 
    $resignation_letter = isset($resignation_letter) ? $resignation_letter : array();
    $is_submitted = isset($resignation_letter['status']) && (int) $resignation_letter['status'] === 1;
    $can_edit = isset($resignation_letter['status']) && (int) $resignation_letter['status'] === 1;
    $just_view = isset($resignation_letter['status']) && ((int) $resignation_letter['status'] === 2 || (int) $resignation_letter['status'] === 4 || (int) $resignation_letter['status'] === 3);
    $resignation_date = !empty($resignation_letter['resignation_date']) ? date('d F Y', strtotime($resignation_letter['resignation_date'])) : '';
    $last_working_date = !empty($resignation_letter['last_date']) ? date('d F Y', strtotime($resignation_letter['last_date'])) : '';
    $notes = isset($resignation_letter['notes']) ? $resignation_letter['notes'] : '';
    $filename = isset($resignation_letter['file_path']) ? $resignation_letter['file_path'] : '';
    $is_generated = !empty($filename);
    $is_user = isset($form_request['employee_id']) && $form_request['employee_id'] === $this->emp_id;
    if($roles){
        if (in_array("DVH", $roles)) {
            $can_approve = true;
        } else {
            $can_approve = false;
        }
    }
    $aprroved = $approval['status'] === "Approved" ? true : false;
    
?>
<div class="wrap-submit-rl">
    <div class="title-section-resign">
        <div class="number-step-resign">
                2
        </div>
        <div class="title-step-resign">
                Approval Resignation Letter
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-tranx is-compact fs-13px" id="table_matrix_prev">
            <thead>
                <tr>
                    <th class="w-5">Layer</th>
                    <th class="w-20">Approval Name</th>
                    <th class="w-20">Approval Email</th>
                    <th class="w-10">Status</th>
                    <th class="w-10 text-left">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($approval as $key => $value) {  ?>
                <tr>
                    <td><?=$value['layer'];?>.</td>
                    <td width="25%"><?=$value['complete_name'];?></td>
                    <td width="25%"><?=$value['email'];?></td>
                    <td><?=approval_status($value['status']);?></td>
                    <td class="text-left">
                        <?= str_replace('.000','', $value['acted_at']);?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <iframe src="<?= base_url('form/view_resignation_letter/'.$form_request['employee_id'] . '/' . $resignation_letter['file_path'] .'#sidebar=0&zoom=100') ?>" width="100%" height="600px" style="border: none;"></iframe>
    <div id="button-approve-rl" class="button-approve-rl">
        <input type="hidden" id="id_form_request" value="<?= $resignation_letter['id_form_request'] ?>">
        <input type="hidden" id="can_approve" value="<?= $can_approve ?>">
        <button id="approve_back" type="reset" class="btn btn-warning">Back</button>
        <?php if ($can_approve): ?>
            <button id="revise_btn" type="button" class="btn btn-danger">Revise</button>
            <?php if (!$just_view): ?>
                <button id="approve_btn" type="button" class="btn btn-success">Approve</button> 
            <?php endif; ?>
        <?php endif; ?>
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
                                <a id="add_note" class="btn btn-md text-primary">+ Add Note</a>
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