<?php 

if($this->input->post('yearpasearch')){
    $yearpa = $this->input->post('yearpasearch');
}else{
    $yearpa = date("Y",strtotime("now - 1 year"));
}

?>
<div class="nk-ibx-head">
    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <li>
                 <h3 class="title">Summary </h3>
				 <strong>HISTORY PERFORMANCE APPRAISAL EVALUATION PERIOD: <span class="text-primary"> Januari <?=$eval_year = $yearpa;?> - Desember <?=$eval_year = $yearpa ;?></span></strong>
            </li>
        </ul>
    </div>
</div>
    <div class="nk-ibx-reply-group">
        <div class="card card-preview">
            <div class="card-inner">
               <div class = "row">
                <div class = "col-md-3">
                <form action = "" method = "post">
                    <strong>Select Period</strong>
                    <select name = "yearpasearch" class = "form-control" onchange = "this.form.submit()">
                        <?php for($i = date("Y",strtotime("now - 1 year")); $i >= 2022; $i--){ ?>
                            <option value = "<?= $i; ?>" <?= ($yearpa == $i) ? "selected" : "" ?>><?= $i; ?></option>
                        <?php } ?>
                    </select>
                </form>
                </div>
               </div>
            </div>
            <div class="card-inner">
                <table class="nowrap table tableDashboard" data-export-title="Export Data" id="tableHROnlyPA" data-ajaxsource="<?= site_url('dashboard/read_hr/history_pa/'.$yearpa); ?>">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Name</th>
                            <th>Division</th>
                            <th>Department</th>
                            <th>Position</th>
                            <th>Status</th>
                            <th>Direct Manager</th>
                            <th>Office Location</th>
                            <th>Join Date</th>
                            <th>Employment Type</th>
                            <th>Final Score</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



