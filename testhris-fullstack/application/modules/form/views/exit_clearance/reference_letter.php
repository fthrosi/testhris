
<div class="wrap-submit-rl">
    <div class="title-section-resign">
        <div class="number-step-resign">
                5
        </div>
        <div class="title-step-resign">
                Reference Letter
        </div>
    </div>
    <?php if (!empty($form_request['result_document'])): ?>
        <iframe src="<?= base_url('form/view_reference_letter/'.$form_request['employee_id'] . '/' . $form_request['result_document'] .'#sidebar=0&zoom=100') ?>" width="100%" height="600px" style="border: none;"></iframe>
    <?php else: ?>
        <div class="reference-letter-waiting">
            <svg class="reference-letter-waiting-icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M7 2h10a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1h-.5v2.2c0 1.55-.71 3.01-1.93 3.97L13.5 12l1.07.83A4.88 4.88 0 0 1 16.5 16.8V19H17a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1h.5v-2.2c0-1.55.71-3.01 1.93-3.97L10.5 12l-1.07-.83A4.88 4.88 0 0 1 7.5 7.2V5H7a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1zm2 3v2.2c0 1.02.47 1.98 1.27 2.61l.89.69a1.34 1.34 0 0 1 0 2.1l-.89.69A3.5 3.5 0 0 0 9 16.8V19h6v-2.2c0-1.02-.47-1.98-1.27-2.61l-.89-.69a1.34 1.34 0 0 1 0-2.1l.89-.69A3.5 3.5 0 0 0 15 7.2V5H9zm1 14h4v-.5c0-.28-.22-.5-.5-.5h-3a.5.5 0 0 0-.5.5V19zm.5-11.5h3A2.5 2.5 0 0 1 12 9.8a2.5 2.5 0 0 1-1.5-2.3z" />
            </svg>
            <div class="reference-letter-waiting-text">Waiting for Reference Letter</div>
        </div>
    <?php endif; ?>
    
</div>