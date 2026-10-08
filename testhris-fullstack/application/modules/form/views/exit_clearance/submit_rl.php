<?php 
        $resignation_letter = isset($resignation_letter) ? $resignation_letter : array();
        $is_submitted = isset($resignation_letter['status']) && (int) $resignation_letter['status'] === 1;
        $can_edit = isset($resignation_letter['status']) && (int) $resignation_letter['status'] === 1;
        $just_view = isset($resignation_letter['status']) && ((int) $resignation_letter['status'] === 3 || (int) $resignation_letter['status'] === 4 );
        $resignation_date = !empty($resignation_letter['resignation_date']) ? date('d F Y', strtotime($resignation_letter['resignation_date'])) : '';
        $last_working_date = !empty($resignation_letter['last_date']) ? date('d F Y', strtotime($resignation_letter['last_date'])) : '';
        $notes = isset($resignation_letter['notes']) ? $resignation_letter['notes'] : '';
        $filename = isset($resignation_letter['file_path']) ? $resignation_letter['file_path'] : '';
        $is_generated = !empty($filename);
        $is_user = isset($form_request['employee_id']) && $form_request['employee_id'] === $nik;
        $id_ecode = encode_url($header['id_form_request']);
        $is_revised = isset($resignation_letter['status']) && (int) $resignation_letter['status'] === 2;

?>
<div class="wrap-submit-rl">
        <input type="hidden" class="hidden" id="request_id" value="<?= $header['id_form_request'] ?>">
        <input type="hidden" class="hidden" id="notice_period" value="<?= $employee['notice_period'] ?>">
        <input type="hidden" class="hidden" id="is_submitted" value="<?= $is_submitted ? '1' : '0' ?>">
        <input type="hidden" class="hidden" id="just_view" value="<?= $just_view ? '1' : '0' ?>">
        <input type="hidden" class="hidden" id="edit_mode" value="0">
        <input type="hidden" class="hidden" id="filename" value="<?= htmlspecialchars($filename, ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" class="hidden" id="is_generated" value="<?= $is_generated ? '1' : '0' ?>">
        <input type="hidden" class="hidden" id="is_user" value="<?= $is_user ? '1' : '0' ?>">
        <input type="hidden" class="hidden" id="id_encode" value="<?= $id_ecode ?>">
        <input type="hidden" class="hidden" id="employee_id" value="<?= $form_request['employee_id'] ?>">
        <div class="title-section-resign">
                <div class="number-step-resign">
                        1
                </div>
                <div class="title-step-resign">
                        Submit Resignation Letter
                </div>
        </div>
        <div class="content-submit-rl">
                <form class="form-submit-rl" id="form-submit-rl" method="POST" action="<?= base_url('form/update_resignation_letter') ?>">
                        <div class="form-group-resign">
                                <div class="date-field">
                                        <div class="date-field-label">
                                                Resignation Submission Date
                                        </div>

                                        <input
                                                type="text"
                                                autocomplete="off"
                                                placeholder="Input Submission Date"
                                                id="resignation_date"
                                                class="form-control date-field-input"
                                                value="<?= htmlspecialchars($resignation_date, ENT_QUOTES, 'UTF-8') ?>"
                                                <?= $is_submitted || $just_view || !$is_user ? 'readonly' : '' ?>
                                        >
                                </div>
                                <div class="date-field">
                                        <div class="date-field-label">
                                                Last Working Date
                                        </div>

                                        <input
                                                type="text"
                                                id="last_working_date"
                                                class="form-control date-field-input last-date"
                                                value="<?= htmlspecialchars($last_working_date, ENT_QUOTES, 'UTF-8') ?>"
                                                readonly
                                        >
                                </div>
                        </div>
                        <div class="notes-field">
                                <div class="notes-field-label">
                                        Additional Notes
                                </div>

                                <textarea
                                        id="notes"
                                        class="form-control notes-field-input"
                                        placeholder="Enter your notes here(max 255 characters)"
                                        maxlength="255"
                                        <?= $is_submitted || $just_view || !$is_user ? 'readonly' : '' ?>
                                ><?= htmlspecialchars($notes, ENT_QUOTES, 'UTF-8') ?></textarea>
                        </div>
                        <div id="button-submit-rl" class="button-submit-rl">
                                <button id="cancel_btn_edit" type="reset" class="btn btn-warning">Back</button>
                                <?php if (($is_submitted || $is_revised) && $is_user): ?>
                                        <button id="cancel_btn" type="reset" class="btn btn-danger">Cancel</button>
                                <?php endif; ?>
                                <?php if (!$just_view && $is_user): ?>
                                        <button id="submit_btn" type="submit" class="btn btn-success" <?= $is_submitted ? 'style="display: none;"' : '' ?>>Submit</button>
                                        <?php if ($can_edit): ?>
                                                <button id="btn_edit" type="button" class="btn btn-success">Edit</button>
                                        <?php endif; ?>
                                <?php endif; ?>
                        </div>
                </form>
                <div class="generated-rl">
                        <button id="generate_rl" type="button" class="btn btn-warning" <?= $filename ? 'disabled' : '' ?>>Generate</button>
                        
                        <em id="generated_rl_pdf" class="icon ni ni-file-pdf show-file" style="display: <?= $filename ? 'inline-block' : 'none' ?>; font-size: 3.5rem; color: #da1b1b;"></em>
                        
                </div>
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