<link rel="stylesheet" href="<?= base_url(); ?>/assets/v2/css/dashlite.css?ver=2.6.0">
<link id="skin-default" rel="stylesheet" href="<?= base_url(); ?>/assets/v2/css/theme.css?ver=2.6.0">
    
<ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
    <li class="nav-item">
        <a class="nav-link active" href="#" onClick="change_type('DEC')" role="tab" data-toggle="tab"><em class="icon ni ni-user-circle-fill"></em><span>DECRYPT</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#" onClick="change_type('ENC')" role="tab" data-toggle="tab"><em class="icon ni ni-user-circle-fill"></em><span>ENCRYPT</span></a>
    </li>
</ul>

<input type="hidden" id="conversion_type" name="conversion_type" value="DEC">
<div class="p-3">
    <div class="form-group">
        <label class="form-label">INPUT</label>
        <input type="text" class="form-control" name="input_check_enc" id="input_check_enc">
    </div>
    <div class="form-group">
        <label class="form-label">OUTPUT</label>
        <input type="text" class="form-control" name="output_check_enc" id="output_check_enc">
    </div>
    <div class="form-group">
        <button data-dismiss="modal" type="button" class="btn btn-primary decrypt_encryption" id="decrypt_encryption">CHECK</button>
    </div>
</div>

<?php $version= date('Y-m-d H:i:s');?>
<script src="<?= base_url(); ?>/assets/v2/js/bundle.js?ver=2.6.0"></script>
<script src="<?= base_url(); ?>/assets/v2/js/scripts.js?ver=<?= $version;?>"></script>
<script src="<?= base_url(); ?>/assets/v2/js/toastr.js?ver=2.6.0"></script>