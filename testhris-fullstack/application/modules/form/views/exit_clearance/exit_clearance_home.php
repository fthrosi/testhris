<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css"
>
<div class="wrap-submit-rl">
        <input type="hidden" id="can_submit" value="<?= $can_submit ? '1' : '0' ?>">
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
                        <?php
                                $saved = (int)$step['status'] !== 0;
                                $status = (int)$step['status'];
                                
                        ?>
                    <div class="ec-step">
                        <div class="ec-step-number">
                                <h5 style="font-weight: bold;"><?= $step['title'] ?></h5>
                                <?php if ($step['can_access'] && $step['can_view']): ?>
                                        <a style="color: #b9b9b9; text-decoration: none;" href="<?= $step['url'] ?>">Click to view</a>
                                <?php elseif(!$step['can_view']): ?>
                                        <span id="cantView" style="color: #b9b9b9; cursor: pointer;">Click to view</span>
                                <?php else: ?>
                                        <span id="cantAccess" style="color: #b9b9b9; cursor: pointer;">Click to view</span>
                                <?php endif; ?>
                        </div>
                        <?php
                                $class_icon_pdf = $step['can_view'] ? 'show-file-ec' : 'cant-view-ec';
                        ?>
                        <div class="wrap-icon-status">
                                <em id="generated_ec_pdf" class="icon ni ni-file-pdf <?= $class_icon_pdf ?>" data-filename="<?= $step['filename'] ?>" data-id-employee="<?= $form_request['employee_id'] ?>" style="display: <?= $step['filename'] ? 'inline-block' : 'none' ?>; font-size: 2.5rem; color: #da1b1b;"></em>
                                <div id="flag-<?= $step['id']; ?>" class=" <?= $saved ? 'saved' : 'unsaved'; ?>" style="<?= $status === 1 ? 'background-color: #1ac236;' : ($status === 2 ? 'background-color: #ffcc00;' : ''); ?>">
                                        <?php if ($status === 1): ?>
                                                <i class="fa-solid fa-check"></i>
                                        <?php elseif ($status === 2): ?>
                                                <i class="fa-solid fa-exclamation"></i>
                                        <?php endif; ?>
                                </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <div style="width: 100%; border-bottom:none;" class="ec-step">
                        <div style="width: 100%;" class="">
                                <div class="nk-reply-header nk-ibx-reply-header">
                                        <div class="nk-reply-desc">
                                        <div style="margin:0;" class="nk-reply-info">
                                                <div class="nk-reply-author lead-text">
                                                <h5 style="font-weight: bold;">Notes</h5> 
                                                </div>
                                        </div>
                                        </div>
                                </div>
                                <div class="nk-reply-body nk-ibx-reply-body">
                                        <div class="nk-reply-entry entry">
                                        <div class="nk-block">
                                                <div class="nk-block-head nk-block-head-sm nk-block-between">
                                                <a style="padding-right:0; padding-left:0;" id="add_note" data-id="<?= $header['id_form_request'] ?>" data-type="Exit Clearance" class="btn btn-md text-primary">+ Add Note</a>
                                                </div>
                                                <?php if ($reason): ?>
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
                                                <?php endif; ?>
                                        </div>
                                        </div>
                                </div>
                        </div>
                </div>
                <div class="wrap-btn-submit">
                        <?php if((int)$header['status'] === 0): ?>
                                <button type="button" id="submit-all-ec" data-id="<?= $header['id'] ?>" class="btn btn-success">Submit</button>
                        <?php endif; ?>
                        <button type="button" id="<?= $can_approve ? 'approve_ec_back' : 'back_btn_user' ?>" class="btn btn-danger">Back</button> 
                        <?php if($can_approve && (int)$header['status'] === 1): ?>
                                <button type="button" id="approval_ec_btn" data-status="Revised" data-id="<?= $header['id_form_request'] ?>" class="btn btn-warning approval_ec_btn">Revise</button>
                                <button type="button" id="approval_ec_btn" data-status="Approved" data-id="<?= $header['id_form_request'] ?>" class="btn btn-success approval_ec_btn">Approve</button>
                        <?php endif; ?>
                </div>
            </div>
        </div>
</div>