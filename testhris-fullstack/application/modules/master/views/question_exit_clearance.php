<ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
    <li class="nav-item">
        <a class="nav-link active" href="#question" role="tab" data-toggle="tab"><em class="icon ni ni-user-circle-fill"></em><span>Question Exit Clearance</span></a>
    </li>
</ul>

<div class="nk-ibx-reply nk-reply" data-simplebar>
<div class="card card-preview responsive-table">
    <div class="tab-content">
        
            <div class="tab-pane table-responsive active" id="question">
                <div class="card-inner">
                    <div class="btn-group">
                        <h4>DATA QUESTION EXIT CLEARANCE</h4>
                    </div>
                    <hr>
                    <span>
                        <a class="text-primary btn btn-icon btn-add-question" data-toggle="modal" data-target="#modalQuestionExitClearance" data-offset="-4,0"><em class="icon ni ni-plus-circle"></em> Add Question Exit Clearance
                        </a>
                    </span>
                    <br>
                    <table class="nowrap table qec-table table-striped display" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Form Section</th>
                                <th>Parent Question</th>
                                <th>Question</th>
                                <th>Type</th>
                                <th>Mandatory</th>
                                <th>Sequence</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <div class="btn-group">
                        <h4>DATA QUESTION OPTION EXIT CLEARANCE</h4>
                    </div>
                    <hr>
                    <span>
                        <a class="text-primary btn btn-icon btn-add-option" data-toggle="modal" data-target="#modalOptionQuestion" data-offset="-4,0"><em class="icon ni ni-plus-circle"></em> Add Option Question
                        </a>
                    </span>
                    <br>
                    <table class="nowrap table opt-qec-table table-striped display" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Question</th>
                                <th>Label Option</th>
                                <th>Value Option</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
</div>
</div>



<!-- /////////////////////////////////////////////Modal Tambah Couple////////////////////////////////////// -->

<div class="modal fade" tabindex="-1" id="modalQuestionExitClearance">
    <input type="hidden" id="edit_question_id" name="edit_question_id">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Add Question Exit Clearance</h5>
                <form action="#" id="form_question_exit_clearance" data-mode="add" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="section_id">Section Form</label>   
                                <div class="form-control-wrap">        
                                    <select required class="form-select select-search_question_section" name="section_id" id="section_id">
                                        <option value="">Select Section</option>
                                        <?php foreach($section as $s){ ?>
                                            <option value="<?= $s['id'] ?>"><?= $s['name'] ?></option>
                                        <?php } ?>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="parent_id">Parent Question</label>   
                                <div class="form-control-wrap">        
                                    <select class="form-select select-search_question_section" name="parent_id" id="parent_question_id">
                                        <option value="">Select Question</option>
                                        <?php foreach($question as $q){ ?>
                                            <option value="<?= $q['id'] ?>"><?= $q['question'] ?></option>
                                        <?php } ?>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Question</label>
                                <input required type="text" class="form-control" placeholder="Question" name="question" id="question_text">
                            </div>
                        </div>
                        <?php
                            $option_type = [
                                ['value' => 'text', 'label' => 'Text'],
                                ['value' => 'number', 'label' => 'Number'],
                                ['value' => 'radio', 'label' => 'Radio'],
                                ['value' => 'checkbox', 'label' => 'Checkbox'],
                                ['value' => 'select', 'label' => 'Select'],
                                ['value' => 'special', 'label' => 'Special'],
                            ];
                            $mandatory_option = [
                                ['value' => 1, 'label' => 'Required'],
                                ['value' => 0, 'label' => 'Optional'],
                            ];
                        ?>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="question_type">Question Type</label>   
                                <div class="form-control-wrap">        
                                    <select required class="form-select select-search_question_section" name="question_type" id="question_type">
                                        <option value="">Select Question Type</option>
                                        <?php foreach($option_type as $type){ ?>
                                            <option value="<?= $type['value'] ?>"><?= $type['label'] ?></option>
                                        <?php } ?>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        
                        <!-- Question Options -->
                        <div class="col-12 d-none" id="question_options_container">
                            <div class="form-group">
                                <label class="form-label">Question Options</label>

                                <div id="question_options_list">
                                    <!-- Input option akan ditambahkan melalui JavaScript -->
                                </div>

                                <button type="button"
                                        class="btn btn-outline-primary btn-sm mt-2"
                                        id="add_question_option">
                                    <em class="icon ni ni-plus"></em>
                                    Add Option
                                </button>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="mandatory">Mandatory</label>   
                                <div class="form-control-wrap">        
                                    <select required class="form-select select-search_question_section" name="mandatory" id="mandatory">
                                        <option value="">Select Mandatory</option>
                                        <?php foreach($mandatory_option as $type){ ?>
                                            <option value="<?= $type['value'] ?>"><?= $type['label'] ?></option>
                                        <?php } ?>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Sequence</label>
                                <input required type="number" onwheel="this.blur()" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="form-control" placeholder="Sequence" name="sequence" id="sequence">
                            </div>
                        </div>
                        <!-- Start Menambahkan Start date dan End date Luffi 2025-->
                        <div class="col-6">
                            <div class="form-group">
                                    <label class="form-label">Start Date</label>    
                                    <div class="form-control-wrap">        
                                        <input required type="text" class="form-control date-picker" name="start_date_question" id="start_date_question">    
                                    </div>    
                                    <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                    </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                    <label class="form-label">End Date</label>    
                                    <div class="form-control-wrap">        
                                        <input type="text" class="form-control date-picker" name="end_date_question" id="end_date_question">    
                                    </div>    
                                    <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                    </div>
                            </div>
                        </div>
                        <!-- End Menambahkan Start date dan End date Luffi 2025-->
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button type="button" class="btn btn-primary" id="save_question">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modalOptionQuestion">
    <input type="hidden" id="edit_option_id" name="edit_option_id">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Edit Option</h5>
                <form action="#" id="form_edit_option" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="Employee-objective">Parent Question</label>   
                                <div class="form-control-wrap">        
                                    <select required class="form-select select-search_question_option" name="parent_id_option" id="parent_id_question_option">
                                        <option value="">Select Question</option>
                                        <?php foreach($question_have_option as $q){ ?>
                                            <option value="<?= $q['id'] ?>"><?= $q['question'] ?></option>
                                        <?php } ?>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Label</label>
                                <input required type="text" class="form-control" placeholder="Label" name="label" id="label_option">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Value</label>
                                <input required type="text" class="form-control" placeholder="value" name="value" id="value_option">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                    <label class="form-label">Start Date</label>    
                                    <div class="form-control-wrap">        
                                        <input required type="text" class="form-control date-picker" name="start_date_option" id="start_date_option">    
                                    </div>    
                                    <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                    </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                    <label class="form-label">End Date</label>    
                                    <div class="form-control-wrap">        
                                        <input type="text" class="form-control date-picker" name="end_date_option" id="end_date_option">    
                                    </div>    
                                    <div class="form-note">Date format <code>mm/dd/yyyy</code>
                                    </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button type="button" class="btn btn-primary" id="edit_option">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>