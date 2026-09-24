<?php 
        // $resignation_letter = isset($resignation_letter) ? $resignation_letter : array();
        // $is_submitted = isset($resignation_letter['status']) && (int) $resignation_letter['status'] === 1;
        // $can_edit = isset($resignation_letter['status']) && (int) $resignation_letter['status'] === 1;
        // $just_view = isset($resignation_letter['status']) && ((int) $resignation_letter['status'] === 3 || (int) $resignation_letter['status'] === 4 );
        // $resignation_date = !empty($resignation_letter['resignation_date']) ? date('d F Y', strtotime($resignation_letter['resignation_date'])) : '';
        // $last_working_date = !empty($resignation_letter['last_date']) ? date('d F Y', strtotime($resignation_letter['last_date'])) : '';
        // $notes = isset($resignation_letter['notes']) ? $resignation_letter['notes'] : '';
        // $filename = isset($resignation_letter['file_path']) ? $resignation_letter['file_path'] : '';
        // $is_generated = !empty($filename);
        // $is_user = isset($form_request['employee_id']) && $form_request['employee_id'] === $nik;
        // $id_ecode = encode_url($header['id_form_request']);
        // $is_revised = isset($resignation_letter['status']) && (int) $resignation_letter['status'] === 2;
        $form_steps =[
            [
                'title' => 'Exit Clearance',
                'url'   => base_url("form/getQuestion/EC")
            ],
            [
                'title' => 'Exit Interview',
                'url'   => base_url("form/home_exit_clearance/{$id_ecode}")
            ],
            [
                'title' => 'Handover',
                'url'   => base_url("form/home_exit_clearance/{$id_ecode}")
            ]
        ]

?>
<div class="wrap-submit-rl">
        <!-- <input type="hidden" class="hidden" id="request_id" value="<?= $header['id_form_request'] ?>">
        <input type="hidden" class="hidden" id="notice_period" value="<?= $employee['notice_period'] ?>">
        <input type="hidden" class="hidden" id="is_submitted" value="<?= $is_submitted ? '1' : '0' ?>">
        <input type="hidden" class="hidden" id="just_view" value="<?= $just_view ? '1' : '0' ?>">
        <input type="hidden" class="hidden" id="edit_mode" value="0">
        <input type="hidden" class="hidden" id="filename" value="<?= htmlspecialchars($filename, ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" class="hidden" id="is_generated" value="<?= $is_generated ? '1' : '0' ?>">
        <input type="hidden" class="hidden" id="is_user" value="<?= $is_user ? '1' : '0' ?>">
        <input type="hidden" class="hidden" id="id_encode" value="<?= $id_ecode ?>">
        <input type="hidden" class="hidden" id="employee_id" value="<?= $form_request['employee_id'] ?>"> -->
        <div class="title-section-resign">
                <div class="number-step-resign">
                        3
                </div>
                <div class="title-step-resign">
                        Submit Exit Clearance
                </div>
        </div>
        <div class="content-home-ec">
            <div class="home-ec">
                <?php foreach ($form_steps as $step_number => $step): ?>
                    <div class="ec-step">
                        <h5 style="font-weight: bold;"><?= $step['title'] ?></h5>
                        <a style="color: #b9b9b9; text-decoration: none;" href="<?= $step['url'] ?>">Click to view</a>
                    </div>
                <?php endforeach; ?>
                <div class="ec-step-note">
                    <h5 style="font-weight: bold;">Note</h5>
                    <a style="color: #b9b9b9; text-decoration: none;" href="<?= $step['url'] ?>">+ Add Note</a>
                </div>
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