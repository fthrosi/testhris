<link rel="stylesheet" href="<?= base_url(); ?>assets/v2/css/exit_clearance/exit_form.css?ver=<?= $version ?? date('Y-m-d H:i:s'); ?>">
<link rel="stylesheet" href="<?= base_url(); ?>assets/v2/css/exit_clearance/ec_approver.css?ver=<?= $version ?? date('Y-m-d H:i:s'); ?>">
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css"
>
<?php
    $notes = $form['note'] ?? [];
    $saved = (int)$form['status'] === 1;
    $class = $saved ? 'disabled' : '';
?>
<div style="padding: 1rem; display: flex; flex-direction: column; gap: 1rem; overflow-y: auto; height: 100%;">
    <div style="display:flex; flex-direction:column; gap: 1rem;">
        <div class="title-section-resign" style="border-bottom: 2px solid #f9ca24 !important;">
                <div class="title-step-resign">
                    Exit Clearance
                </div>
        </div>
        <div class="wrap-section" id="section-form" data-section-id="<?= $form['id']; ?>" data-section-name="<?= $form['name']; ?>" >
            <div class="section-header" id="heading-<?= $form['id']; ?>">
                <h7 style="font-weight: 600;"><?= html_escape($form['name']); ?></h7>  
                <!-- <div class="wrap-icon-status">
                    <div id="flag-<?= $form['id']; ?>" class=" <?= $saved ? 'save' : 'unsave'; ?>">
                        <i class="fa-solid fa-check"></i>
                        <span id="flag-text-<?= $section['id']; ?>"><?= $saved ? 'Saved' : 'Unsaved'; ?></span>
                    </div>
                    <i class="fa-solid fa-angle-right icon-acc"></i>
                </div> -->
            
            </div>
            <div
                id="section-<?= $form['id']; ?>"
            >
                <div class="card-body">
                    <?php foreach ($form['questions'] as $question): ?>
                        <?php
                            $answer = $question['answer'] ?? '';
                            $jumlah = $question['jumlah'] ?? '';
                        ?>
                        <?php if($question['question_type'] === 'checkbox'): ?>
                            <div class="input-checkbox-label">
                                <div class="input-checkbox">
                                    <input disabled type="hidden" name="answer[<?= $question['id']; ?>]" value="<?= $answer; ?>">
                                    <input disabled <?= $answer ? 'checked' : '' ?> class="question-checkbox" type="checkbox" id="question-<?= $question['id']; ?>" name="answer[<?= $question['id']; ?>]" value="1">
                                    <label style="margin: 0;" for="question-<?= $question['id']; ?>"><?= html_escape($question['question']); ?></label> 
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if($question['question_type'] === 'text'): ?>
                            <div class="input-with-label">
                                <label style="margin: 0;" for="question-<?= $question['id']; ?>"><?= html_escape($question['question']); ?></label>
                                <input value="<?= html_escape($answer); ?>" <?= $saved ? 'readonly' : '' ?> disabled="disabled" type="text" id="question-<?= $question['id']; ?>" data-parent-id="<?= $question['id_parrent_question'] ?? ''; ?>" data-question-type="<?= $question['question_type']; ?>" name="answer[<?= $question['id']; ?>]">
                            </div>
                        <?php endif; ?>
                        <?php if($question['question_type'] === 'select'): ?>
                            <div class="input-with-label">
                                <label style="margin: 0;" for="question-<?= $question['id']; ?>"><?= html_escape($question['question']); ?></label>
                                <div class="wraper-select">
                                        <select <?= $saved ? 'disabled' : '' ?> id="question-<?= $question['id']; ?>" data-parent-id="<?= $question['id_parrent_question'] ?? ''; ?>" data-question-type="<?= $question['question_type']; ?>" name="answer[<?= $question['id']; ?>]">
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
                                <input value="<?= html_escape($jumlah); ?>" <?= $saved ? '' : 'readonly' ?> <?= ($question['question_type'] === 'checkbox' && !$answer) ? 'disabled' : '' ?> onwheel="this.blur()" oninput="this.value = this.value.replace(/[^0-9]/g, '')" type="number" min="0" data-parent-id="<?= $question['id'] ?? ''; ?>" id="jumlah-<?= $question['id']; ?>" name="jumlah[<?= $question['id']; ?>]" class="<?= $class; ?>">
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
                                    data-initial-pics='<?= html_escape(json_encode($form['pic'] ?? [])); ?>'
                                    >
                                    <div class="label-special">
                                        <label style="margin: 0;">
                                            <?= html_escape($child['question']); ?>
                                        </label>
                                    </div>

                                    <div class="pic-list">
                                        <?php foreach (($form['pic'] ?? []) as $pic): ?>
                                            <div class="pic-item" data-type="internal" data-value="<?= html_escape($pic[0]); ?>">
                                                <span><?= html_escape($pic[1]. ' - '.$pic[0]); ?></span>
                                                
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
                                        <input <?= $saved ? 'disabled' : '' ?> <?= $answer ? 'checked' : '' ?> class="question-checkbox" type="checkbox" id="question-<?= $child['id']; ?>" data-parent-id="<?= $child['id_parrent_question'] ?? ''; ?>" data-question-type="<?= $child['question_type']; ?>" name="answer[<?= $child['id']; ?>]" value="1">
                                        <label style="margin: 0;" for="question-<?= $child['id']; ?>"><?= html_escape($child['question']); ?></label> 
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if($child['question_type'] === 'text'): ?>
                                <div class="input-with-label">
                                    <label style="margin: 0;" for="question-<?= $child['id']; ?>"><?= html_escape($child['question']); ?></label>
                                    <input value="<?= html_escape($answer); ?>" <?= $saved ? 'readonly' : '' ?> disabled="disabled" type="text" id="question-<?= $child['id']; ?>" data-parent-id="<?= $child['id_parrent_question'] ?? ''; ?>" data-question-type="<?= $child['question_type']; ?>" name="answer[<?= $child['id']; ?>]">
                                </div>
                            <?php endif; ?>
                            <?php if($child['question_type'] === 'select'): ?>
                                <div class="input-with-label">
                                    <label style="margin: 0;" for="question-<?= $child['id']; ?>"><?= html_escape($child['question']); ?></label>
                                    <div class="wraper-select">
                                            <select <?= $saved ? 'disabled' : '' ?> id="question-<?= $child['id']; ?>" data-parent-id="<?= $child['id_parrent_question'] ?? ''; ?>" data-question-type="<?= $child['question_type']; ?>" name="answer[<?= $child['id']; ?>]">
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
                            <div class="input-with-label" style="margin-top: 10px;">
                                <label style="margin: 0;" for="note-<?= $form['id']; ?>"><?= $is_requestor_note ? 'Note Requestor' : 'Note Approve - ' . $name ?></label>
                                <textarea class="<?= $class_note; ?>" style="width: 100%; height:70px; padding: 0.5rem;" maxlength="255" readonly type="text" id="note-<?= $note['id']; ?>" name="note-<?= $note['id']; ?>"><?= html_escape($note['note']); ?></textarea>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if(!$notes || (int)$form['my_note_length'] === 0): ?>
                        <div class="input-with-label" style="margin-top: 10px;">
                            <label style="margin: 0;" id="label-note-approve" for="note-approve">Notes</label>
                            <textarea style="padding: 0.5rem; width: 100%; height:70px;" maxlength="255" value="" type="text" id="note-approve" name="note-approve"></textarea>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <?php if($form['is_internal']): ?>
        <div style="min-height:1rem; flex: 0 0 auto; display:flex; flex-direction:column; gap:1rem;">
            <div class="title-section-resign" style="border-bottom: 2px solid #f9ca24 !important;">
                <div class="title-step-resign">
                    Handover
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-data">
                    <thead>
                        <tr>
                            <th rowspan="2" class="text-center align-middle col-no">
                                NO
                            </th>

                            <th rowspan="2" class="text-center align-middle col-keterangan">
                                Keterangan
                            </th>

                            <th colspan="2" class="text-center">
                                Alat
                            </th>

                            <th rowspan="2" class="text-center align-middle col-status">
                                Status
                            </th>

                            <th rowspan="2" class="text-center align-middle col-pic">
                                PIC yang Menerima Pekerjaan
                            </th>

                            <th rowspan="2" class="text-center align-middle col-email">
                                Email
                            </th>
                        </tr>

                        <tr>
                            <th class="text-center col-alat-nama">Nama</th>
                            <th class="text-center col-alat-jumlah">Jumlah</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($select_pic)): ?>
                            <?php $no = 1; ?>

                            <?php foreach ($select_pic as $row): ?>
                                <tr>
                                    <td class="text-center">
                                        <?= $no++ ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['notes']) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['nama_alat']) ?>
                                    </td>

                                    <td class="text-center">
                                        <?= $row['jumlah_alat'] ?>
                                    </td>

                                    <td class="text-center">
                                        <?= htmlspecialchars($row['word_status']) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(strtoupper($row['name'])) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(strtoupper($row['email'])) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">
                                    No Data
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
    <?php
        $data = [
            'section_id' => $form['id_section'],
            'section_saved_id' => $form['id_section_saved'] ?? '',
            'id_form' => $form_exit['id'],
            'id_ec' => $header['id'],
            'id_request' => $form_request['id'],
        ];
        $data_encode = base64_encode(json_encode($data));
    ?>
    <div class="wraper-btn-save">
        <a
            href="<?= base_url('inbox/approval_resignation_letter'); ?>"
            type="button"
            class="btn btn-danger"
        >
            Back
        </a>
        <?php if((int)$form['status'] === 1 && (int)$my_app_status === 0): ?>
            <button
                type="button"
                class="btn btn-warning"
                id="btn-verificator"
                data-submit-data="<?= $data_encode; ?>"
                data-value= "revised"
            >
                Revise
            </button>
            <button
                type="button"
                class="btn btn-success"
                id="btn-verificator"
                data-submit-data="<?= $data_encode; ?>"
                data-value= "approved"
            >
                Approve
            </button>
        <?php endif; ?>
    </div>
</div>


    
