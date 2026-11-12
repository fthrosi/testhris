<link rel="stylesheet" href="<?= base_url(); ?>assets/v2/css/exit_clearance/exit_form.css?ver=<?= $version ?? date('Y-m-d H:i:s'); ?>">
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css"
>
<?php
    $id = encode_url($form_request['id'] ?? '');
?>
<input type="hidden" id="id_form_request" value="<?= $id ?? ''; ?>">
<input type="hidden" id="id_form_exit" value="<?= $form_exit['id'] ?? ''; ?>">

<div class="wrap-submit-rl">
        <div class="title-section-resign">
                <div class="number-step-resign">
                        3
                </div>
                <div class="title-step-resign">
                    Exit Clearance
                </div>
        </div>
        <div class="">
            <form id="formAccordion" class="accordion">
                    <?php foreach ($form as $section): ?>
                        <?php
                            $saved = $section['saved'] ?? false;
                            $notes = $section['note'] ?? [];
                            $class = $saved ? 'btn-edit-section' : 'btn-save-section';
                            $section_status = (int)$section['status'] === 2 ? 'Revised' : ((int)$section['status'] === 1 ? 'Submitted' : '');
                            $class_status = $saved ? 'save' : 'unsave';
                            $status = (int)$section['status'];
                            if((int)$section['status'] !== 1){
                                $open_save = true;
                            }
                            $can_save = (int)$section['status'] === 1 ? true : false; 
                        ?>
                        <input type="hidden" id="saved-<?= $section['id']; ?>" value="<?= $can_save ? '1' : '0'; ?>">
                        <div class="wrap-section" data-section-id="<?= $section['id']; ?>" data-section-name="<?= $section['name']; ?>" >
                            <div class="section-header" id="heading-<?= $section['id']; ?>" data-toggle="collapse"
                                    data-target="#section-<?= $section['id']; ?>"
                                    aria-expanded="false"
                                    aria-controls="section-<?= $section['id']; ?>">
                                <h7 style="font-weight: 600;"><?= html_escape($section['name']); ?></h7>  
                                <div class="wrap-icon-status">
                                    <div id="flag-<?= $section['id']; ?>" class=" <?= $class_status; ?>" style="<?= $status === 1 ? 'background-color: #1ac236;' : ($status === 2 ? 'background-color: #ffcc00;' : ''); ?>">
                                        <!-- <?php if($saved): ?>
                                            <i class="fa-solid fa-check"></i>
                                        <?php endif; ?> -->
                                        <?php if ($status === 1): ?>
                                                <i class="fa-solid fa-check"></i>
                                        <?php elseif ($status === 2): ?>
                                                <i class="fa-solid fa-exclamation"></i>
                                        <?php endif; ?>
                                        <span id="flag-text-<?= $section['id']; ?>"><?= $section_status; ?></span>
                                    </div>
                                    <i class="fa-solid fa-angle-right icon-acc"></i>
                                </div>
                            </div>
                            <div
                                id="section-<?= $section['id']; ?>"
                                class="collapse"
                                aria-labelledby="heading-<?= $section['id']; ?>"
                                data-parent="#formAccordion"
                            >
                                <div class="card-body">
                                    <?php foreach ($section['questions'] as $question): ?>
                                        <?php
                                            $answer = $question['answer'] ?? '';
                                            $jumlah = $question['jumlah'] ?? '';
                                        ?>
                                        <?php if($question['question_type'] === 'checkbox'): ?>
                                            <div class="input-checkbox-label">
                                                <div class="input-checkbox">
                                                    <input <?= ($saved && !$open_save) ? 'disabled' : '' ?> <?= $answer ? 'checked' : '' ?> class="question-checkbox" type="checkbox" id="question-<?= $question['id']; ?>" name="answer[<?= $question['id']; ?>]" value="1">
                                                    <label style="margin: 0;" for="question-<?= $question['id']; ?>"><?= html_escape($question['question']); ?></label> 
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if($question['question_type'] === 'text'): ?>
                                            <div class="input-with-label">
                                                <label style="margin: 0;" for="question-<?= $question['id']; ?>"><?= html_escape($question['question']); ?></label>
                                                <input value="<?= html_escape($answer); ?>" <?= ($saved && !$open_save) ? 'readonly' : '' ?> disabled="disabled" type="text" id="question-<?= $question['id']; ?>" data-parent-id="<?= $question['id_parrent_question'] ?? ''; ?>" data-question-type="<?= $question['question_type']; ?>" name="answer[<?= $question['id']; ?>]">
                                            </div>
                                        <?php endif; ?>
                                        <?php if($question['question_type'] === 'select'): ?>
                                            <div class="input-with-label">
                                                <label style="margin: 0;" for="question-<?= $question['id']; ?>"><?= html_escape($question['question']); ?></label>
                                                <div class="wraper-select">
                                                        <select <?= ($saved && !$open_save) ? 'disabled' : '' ?> id="question-<?= $question['id']; ?>" data-parent-id="<?= $question['id_parrent_question'] ?? ''; ?>" data-question-type="<?= $question['question_type']; ?>" name="answer[<?= $question['id']; ?>]">
                                                        <option value="" selected disabled>
                                                            -- Pilih <?= html_escape($question['question']); ?> --
                                                        </option>
                                                        <?php foreach ($question['options'] as $option): ?>
                                                            <option <?= $question['answer'] === $option['value'] ? 'selected' : '' ?> value="<?= html_escape($option['value']); ?>"><?= html_escape($option['label']); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            
                                            </div>
                                        <?php endif; ?>
                                        <?php if((int)$question['id'] !== 15): ?>
                                            <div class="input-with-label">
                                                <label style="margin: 0;" for="jumlah-<?= $question['id']; ?>">Quantity</label>
                                                <input value="<?= html_escape($jumlah); ?>" <?= ($saved && !$open_save) ? 'readonly' : '' ?> <?= ($question['question_type'] === 'checkbox' && !$answer) ? 'disabled' : '' ?> onwheel="this.blur()" oninput="this.value = this.value.replace(/[^0-9]/g, '')" type="number" min="0" data-parent-id="<?= $question['id'] ?? ''; ?>" id="jumlah-<?= $question['id']; ?>" name="jumlah[<?= $question['id']; ?>]">
                                            </div>
                                        <?php endif; ?>
                                        <?php foreach ($question['children'] ?? [] as $child): ?>
                                            <?php
                                                $specialType = ($child['question_type'] ?? '') === 'special' ? true : false;
                                                $answer = $child['answer'] ?? '';
                                            ?>
                                            <input type="hidden" id="special" value="<?= $specialType ? '1' : '0'; ?>">
                                            <?php if($specialType): ?>
                                                <div class="input-with-label pic-assignment"
                                                    data-question-id="<?= $child['id']; ?>"
                                                    data-parent-id="<?= $child['id_parrent_question'] ?? ''; ?>"
                                                    data-question-type="<?= $child['question_type']; ?>"
                                                    data-initial-pics='<?= html_escape(json_encode($section['pic'] ?? [])); ?>'
                                                    >
                                                    <div class="label-special">
                                                        <label style="margin: 0;">
                                                            <?= html_escape($child['question']); ?>
                                                        </label>

                                                        <i class="fa-solid fa-plus icon-add btn-add-pic disabled"></i>
                                                    </div>

                                                    <div class="pic-list">
                                                        <?php foreach (($section['pic'] ?? []) as $pic): ?>
                                                            <div class="pic-item" data-type="internal" data-value="<?= html_escape($pic[0]); ?>">
                                                                <span><?= html_escape($pic[1]. ' - '.$pic[0]); ?></span>
                                                                    <i class="fa-solid fa-xmark pic-remove <?= ($saved && !$open_save) ? 'disabled' : ''; ?>"></i>
                                                                <input
                                                                    type="hidden"
                                                                    name="pic[<?= $child['id']; ?>][]"
                                                                    value="<?= html_escape($pic[0]); ?>"
                                                                    data-value-compose="<?= html_escape($pic[1].'-'.$pic[0].'-'.$pic[2]); ?>"
                                                                >
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>

                                                </div>
                                            <?php endif; ?>
                                            <?php if($child['question_type'] === 'checkbox'): ?>
                                                <div class="input-checkbox-label">
                                                    <div class="input-checkbox">
                                                        <input <?= ($saved && !$open_save) ? 'disabled' : '' ?> <?= $answer ? 'checked' : '' ?> class="question-checkbox" type="checkbox" id="question-<?= $child['id']; ?>" data-parent-id="<?= $child['id_parrent_question'] ?? ''; ?>" data-question-type="<?= $child['question_type']; ?>" name="answer[<?= $child['id']; ?>]" value="1">
                                                        <label style="margin: 0;" for="question-<?= $child['id']; ?>"><?= html_escape($child['question']); ?></label> 
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <?php if($child['question_type'] === 'text'): ?>
                                                <div class="input-with-label">
                                                    <label style="margin: 0;" for="question-<?= $child['id']; ?>"><?= html_escape($child['question']); ?></label>
                                                    <input value="<?= html_escape($answer); ?>" <?= ($saved && !$open_save) ? 'readonly' : '' ?> disabled="disabled" type="text" id="question-<?= $child['id']; ?>" data-parent-id="<?= $child['id_parrent_question'] ?? ''; ?>" data-question-type="<?= $child['question_type']; ?>" name="answer[<?= $child['id']; ?>]">
                                                </div>
                                            <?php endif; ?>
                                            <?php if($child['question_type'] === 'select'): ?>
                                                <div class="input-with-label">
                                                    <label style="margin: 0;" for="question-<?= $child['id']; ?>"><?= html_escape($child['question']); ?></label>
                                                    <div class="wraper-select">
                                                            <select <?= ($saved && !$open_save) ? 'disabled' : '' ?> id="question-<?= $child['id']; ?>" data-parent-id="<?= $child['id_parrent_question'] ?? ''; ?>" data-question-type="<?= $child['question_type']; ?>" name="answer[<?= $child['id']; ?>]">
                                                            <option value="" selected disabled>
                                                                -- Pilih <?= html_escape($child['question']); ?> --
                                                            </option>
                                                            <?php foreach ($child['options'] as $option): ?>
                                                                <option <?= $child['answer'] === $option['value'] ? 'selected' : '' ?> value="<?= html_escape($option['value']); ?>"><?= html_escape($option['label']); ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                    <?php if($notes): ?>
                                        <?php foreach ($notes as $note): ?>
                                            <?php 
                                                $fr_employee_id = (string)$form_request['employee_id'];
                                                $note_employee_id = (string)$note['id_employee'];
                                                $is_requestor_note = $note_employee_id === $fr_employee_id;
                                                $name = decrypt($note['complete_name']);
                                                $class_note = $note['is_my_note'] ? 'my-note' : 'disabled';
                                            ?>
                                            <input type="hidden" id="name-notes" value="<?= $name; ?>">
                                            <div class="input-with-label" style="margin-top: 10px;">
                                                <label style="margin: 0;" for="note-<?= $form['id']; ?>"><?= $is_requestor_note ? 'Note Requestor' : 'Note Approver - ' . $name ?></label>
                                                <textarea class="<?= $class_note; ?>" style="width: 100%; height:70px; padding: 0.5rem; color: #000000;" maxlength="255" <?= (($note['is_my_note'] && (int)$section['status'] !== 1) || (!$saved && $open_save)) ? '' : 'disabled' ?> type="text" id="note-<?= $note['id']; ?>" name="note-<?= $note['id']; ?>"><?= html_escape($note['note']); ?></textarea>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <?php if(!$notes || (int)$section['my_note_length'] === 0): ?>
                                        <div class="input-with-label" style="margin-top: 10px;">
                                            <label style="margin: 0;" id="label-note-<?= $section['id']; ?>" for="note-<?= $section['id']; ?>">Notes</label>
                                            <textarea style="width: 100%; height:70px; padding: 0.8rem;" maxlength="255" value="" <?= ($saved && !$open_save) ? 'readonly' : '' ?> type="text" id="note-<?= $section['id']; ?>" name="note-<?= $section['id']; ?>"></textarea>
                                        </div>
                                    <?php endif; ?>
                                    <?php if((int)$header['status'] === 0): ?>
                                        <div class="wraper-btn-save">
                                            <button
                                                type="button"
                                                class="btn btn-success <?= $class; ?>"
                                                data-section-id="<?= $section['id']; ?>"
                                                data-mynik="<?= $my_nik; ?>"
                                                data-form-nik="<?= $form_request['employee_id']; ?>"
                                            >
                                                <?= $saved ? 'Edit' : 'Save'; ?>
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                    <?php 
                                        $class_btn = (int)$section['id'] !== 1 ? 'btn-save-section' : 'btn-save-pic-section';
                                        if((int)$header['status'] !== 0 && (int)$section['status'] !== 1): 
                                    ?>
                                        <div class="wraper-btn-save">
                                            <button
                                                type="button"
                                                class="btn btn-success <?= $class_btn; ?>"
                                                data-section-id="<?= $section['id']; ?>"
                                                data-mynik="<?= $my_nik; ?>"
                                                data-form-nik="<?= $form_request['employee_id']; ?>"
                                                data-id-exit = <?= $header['id_form_request']; ?>
                                                data-status="<?= htmlspecialchars(json_encode($pic_handover_status), ENT_QUOTES, 'UTF-8'); ?>"
                                            >
                                                Save
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="wrap-btn-submit">
                        <?php if((int)$header['status'] === 0): ?>
                            <button style="<?= ((int)$form_exit['status'] === 0 || (int)$form_exit['status'] === 2) ? '' : 'display:none;' ?>" type="submit" id="submit-btn" class="btn btn-success">Submit</button>
                        <?php endif; ?>
                        <?php if(((int)$form_exit['status'] === 2)): ?>
                            <button style="<?= ((int)$form_exit['status'] === 2) ? '' : 'display:none;' ?>" type="button" id="submit-revise-ec-btn" class="btn btn-success">Submit</button>
                        <?php endif; ?>
                        <button type="button" id="back-btn" class="btn btn-danger">Back</button>
                    </div>
            </form>
        </div>
</div>
