<link rel="stylesheet" href="<?= base_url(); ?>assets/v2/css/exit_clearance/exit_interview.css?ver=<?= $version ?? date('Y-m-d H:i:s'); ?>">
<?php
    $id = encode_url($form_request['id'] ?? '');
    $save = isset($form_exit['status']) && (int)$form_exit['status'] === 1;
?>
<input type="hidden" id="id_form_request" value="<?= $id ?? ''; ?>">
<input type="hidden" id="id_form_interview" value="<?= $form_exit['id'] ?? ''; ?>">
<div class="wrap-submit-rl">
        <div class="title-section-resign">
                <div class="number-step-resign">
                        3
                </div>
                <div class="title-step-resign">
                    Exit Interview
                </div>
        </div>
        <div class="">
            <form id="exitInterviewForm" class="exit-interview-form">
                <?php $no = 1; ?>
                <?php foreach ($form as $f): ?>
                    <?php if($f['question_type'] === 'text'): ?>
                        <div class="input-interview form-grid">
                            <label class="label-marker" style="color: #000000; font-weight: 600; flex-shrink: 0; margin: 0;"> <?= $no++; ?>.</label>
                            <div class="input-interview-text">
                                <div class="input-interview-label">
                                    <label class="question-text">
                                        <?= $f['question'] ?? ''; ?>
                                    </label>
                                    <label class="question-translation">
                                        <?= $f['translation'] ?? ''; ?>
                                    </label>
                                </div>
                                <textarea <?= $save ? 'disabled' : ''; ?> <?= (int)$f['is_required'] === 1 ? 'required' : ''; ?> maxlength="255" style="width: 100%;" name="<?= $f['id'] ?? ''; ?>" id=""><?= html_escape($f['answer'] ?? ''); ?></textarea>
                            </div>
                        </div>
                    <?php elseif($f['question_type'] === 'radio'): ?>
                        <div class="input-interview form-grid">
                            <label class="label-marker" style="color: #000000; font-weight: 600; flex-shrink: 0; margin: 0;"> <?= $no++; ?>.</label>
                            <div class="input-interview-text">
                                <div class="input-interview-label">
                                    <label class="question-text">
                                        <?= $f['question'] ?? ''; ?>
                                    </label>
                                    <?php if(!empty($f['translation'])): ?>
                                        <label class="question-translation">
                                            <?= $f['translation'] ?? ''; ?>
                                        </label>
                                    <?php endif; ?>
                                </div>
                                <div class="input-interview-radio">
                                    <?php foreach ($f['options'] as $o): ?>
                                        <div class="input-interview-radio-item">
                                            <input <?= $save ? 'disabled' : ''; ?> <?= $f['answer'] === $o['value'] ? 'checked' : ''; ?> <?= (int)$f['is_required'] === 1 ? 'required' : ''; ?> type="radio" name="<?= $f['id'] ?? ''; ?>" value="<?= $o['value'] ?? ''; ?>" id="<?= $o['id'] ?? ''; ?>">
                                            <div class="input-interview-radio-label">
                                                <label style="color: #000000; margin: 0;" for="<?= $o['id'] ?? ''; ?>"><?= $o['label'] ?? ''; ?></label>
                                                <?php if(!empty($o['translation'])): ?>
                                                    <label style="color: #6c757d; margin: 0;" for="<?= $o['id'] ?? ''; ?>"><?= $o['translation'] ?? ''; ?></label>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php foreach ($f['children'] as $c): ?>
                        <?php if($c['question_type'] === 'text'): ?>
                            <div class="input-interview form-grid-child">
                                <div class="input-interview-text">
                                    <div class="input-interview-label">
                                        <label class="question-text">
                                            <?= $c['question'] ?? ''; ?>
                                        </label>
                                        <label class="question-translation">
                                            <?= $c['translation'] ?? ''; ?>
                                        </label>
                                    </div>
                                    <textarea <?= $save ? 'disabled' : ''; ?> <?= (int)$c['is_required'] === 1 ? 'required' : ''; ?> maxlength="255" style="width: 100%;" name="<?= $c['id'] ?? ''; ?>" id=""><?= html_escape($c['answer'] ?? ''); ?></textarea>
                                </div>
                            </div>
                        <?php elseif($c['question_type'] === 'radio'): ?>
                            <div class="input-interview form-grid-child">
                                <div class="input-interview-text">
                                    <div class="input-interview-label">
                                        <label class="question-text">
                                            <?= $c['question'] ?? ''; ?>
                                        </label>
                                        <?php if(!empty($c['translation'])): ?>
                                            <label class="question-translation">
                                                <?= $c['translation'] ?? ''; ?>
                                            </label>
                                        <?php endif; ?>
                                    </div>
                                    <div class="input-interview-radio">
                                        <?php foreach ($c['options'] as $co): ?>
                                            <div class="input-interview-radio-item">
                                                <input <?= $save ? 'disabled' : ''; ?> <?= $c['answer'] === $co['value'] ? 'checked' : ''; ?> <?= (int)$c['is_required'] === 1 ? 'required' : ''; ?> type="radio" name="<?= $c['id'] ?? ''; ?>" value="<?= $co['value'] ?? ''; ?>" id="<?= $co['id'] ?? ''; ?>">
                                                <div class="input-interview-radio-label">
                                                    <label style="color: #000000; margin: 0;" for="<?= $co['id'] ?? ''; ?>"><?= $co['label'] ?? ''; ?></label>
                                                    <?php if(!empty($co['translation'])): ?>
                                                        <label style="color: #6c757d; margin: 0;" for="<?= $co['id'] ?? ''; ?>"><?= $co['translation'] ?? ''; ?></label>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php elseif($c['question_type'] === 'label'): ?>
                            <div class="input-interview input-interview-label-type form-grid-child">
                                <label class="label-marker" style="color: #000000; font-weight: 600; flex-shrink: 0; margin: 0;">*)</label>
                                <div class="input-interview-text">
                                    <div class="input-interview-label">
                                        <label class="question-text">
                                            <?= $c['question'] ?? ''; ?>
                                        </label>
                                        <?php if(!empty($c['translation'])): ?>
                                            <label class="question-translation">
                                                <?= $c['translation'] ?? ''; ?>
                                            </label>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?> 
                    
                <?php endforeach; ?>
                <div class="wrap-btn-submit">
                    <button type="<?= $save ? 'button' : 'submit' ?>" id="<?= $save ? 'update-interview' : 'submit-btn-interview' ?>" data-id="<?= $form_exit['id'] ?>" class="btn btn-success"><?= $save ? 'Edit' : 'Submit' ?></button>
                    <button type="button" id="back-btn" class="btn btn-danger">Back</button> 
                </div>
            </form>
        </div>
</div>