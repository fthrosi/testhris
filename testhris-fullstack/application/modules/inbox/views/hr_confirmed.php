<?php
if($this->input->post('periodpasearch')){
    $periodpa = $this->input->post('periodpasearch');
}else{
    $periodpa = date("Y",strtotime("now - 1 year"));
}
?>
<div class="nk-ibx-head">
    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <li>
                 <h3 class="title">HR Confirmed PA & Plan</h3>
                 <strong>EVALUATION PERIOD: <span class="text-primary"> Januari <?= $periodpa ?> - Desember <?= $periodpa ?></span></strong>
            </li>
        </ul>
    </div>
</div>
<div class="card-inner">
    <div class = "row">
    <div class = "col-md-3">
    <form action = "" method = "post">
        <strong>Select Period</strong>
        <select name = "periodpasearch" class = "form-control" onchange = "this.form.submit()">
            <?php for($i = date("Y",strtotime("now - 1 year")); $i >= 2023; $i--){ ?>
                <option value = "<?= $i; ?>" <?= ($periodpa == $i) ? "selected" : "" ?>><?= $i; ?></option>
            <?php } ?>
        </select>
    </form>
    </div>
    </div>
</div>
<div class="nk-ibx-reply nk-reply" data-simplebar>
    <div class="card card-preview">
        <div class="card-inner">
            <table class="nowrap table hrd-table" data-export-title="Export Data" id="tableDivHead" data-ajaxsource="<?= site_url('inbox/read_hr_confirmed/'.$periodpa); ?>">
                <thead>
                    <tr>
                        <th>NIK</th>
                        <th>Name</th>
                        <th>Division</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Direct Manager</th>
                        <th>Office Location</th>
                        <th>Join Date</th>
                        <th>Employment Type</th>
                        <th>Final Score</th>
                        <th>Grade</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Full Approved Date</th>
                        <th>Request Number</th>
                        <th>Area Improvement</th>
                        <th>Development Plan</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

