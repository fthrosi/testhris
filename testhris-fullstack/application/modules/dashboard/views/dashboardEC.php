<div class="card" style="padding: 20px;">
    <div class="card-inner" style="padding-left: 0px;">
        <div class="card-title-group">
            <div class="card-title">
                <h5 class="title">Monitoring Exit Clearance</h5>
            </div>
        </div>
    </div>

    <div class="card-inner p-0">
        <div class="table-responsive">
            <table id="table-monitoring" class="table table-hover" style="width: max-content !important; min-width: 100%; table-layout: fixed;">
                <colgroup>
                    <col style="width: 60px;">
                    <col style="width: 150px;">
                    <col style="width: 180px;">
                    <col style="width: 120px;">
                    <col style="width: 180px;">
                    <col style="width: 180px;">
                    <col style="width: 180px;">
                    <col style="width: 160px;">
                    <col style="width: 150px;">
                    <col style="width: 160px;">
                    <col style="width: 160px;">
                    <col style="width: 120px;">
                    <col style="width: 100px;">
                </colgroup>
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Request Number</th>
                        <th>Employee Name</th>
                        <th>NIK</th>
                        <th>Position</th>
                        <th>Department</th>
                        <th>Division</th>
                        <th>Resignation Letter</th>
                        <th>Submission Date</th>
                        <th>Last Working Date</th>
                        <th>Overall Progress</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($listEC)) : ?>
                        <?php foreach ($listEC as $row):
                            $id = encode_url($row['id']);
                            $url = $row['status_ec'] === '' ||  $row['status_ec'] === null ? base_url("inbox/detail_req_resignation_letter/{$id}") : base_url("form/home_exit_clearance/{$id}"); ?>
                            <tr>
                                <td></td>

                                <td style="width: 100px;"><?= html_escape($row['request_number']) ?></td>
                                <td style="width: 100px;"><?= html_escape($row['complete_name']) ?></td>
                                <td style="width: 100px;"><?= html_escape($row['nik']) ?></td>
                                <td style="width: 100px;"><?= html_escape($row['position']) ?></td>
                                <td style="width: 100px;"><?= html_escape($row['department']) ?></td>
                                <td style="width: 100px;"><?= html_escape($row['division']) ?></td>

                                <td style="width: 100px;">
                                    <?= html_escape($row['status_rl']) ?>
                                </td>

                                <td style="width: 100px;"><?= html_escape($row['submitted_at']) ?></td>
                                <td style="width: 100px;"><?= html_escape($row['last_date']) ?></td>
                                <?php
                                    $progress = (int) $row['overall_progress'];
                                    $progress_color = $progress >= 100
                                        ? '#1ee0ac'
                                        : ($progress >= 50 ? '#f4bd0e' : '#e85347');
                                ?>
                                <td style="width: 100px;">
                                    <div class="progress" style="height: 8px; min-width: 80px;">
                                        <div
                                            class="progress-bar"
                                            role="progressbar"
                                            style="width: <?= $progress ?>%; background-color: <?= $progress_color ?>;"
                                            aria-valuenow="<?= $progress ?>"
                                            aria-valuemin="0"
                                            aria-valuemax="100">
                                        </div>
                                    </div>

                                    <small>
                                        <?= $progress ?>%
                                    </small>
                                </td>
                                <td style="width: 100px;">
                                    <?= html_escape($row['status_ec']) ?>
                                </td>
                                <td style="width: 100px;">
                                    <a href="<?= $url ?>" class="btn btn-sm btn-primary">
                                        View
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>