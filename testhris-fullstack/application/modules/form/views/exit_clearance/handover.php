<link rel="stylesheet" href="<?= base_url(); ?>assets/v2/css/exit_clearance/ec_handover.css?ver=<?= $version ?? date('Y-m-d H:i:s'); ?>">
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css"
>
<?php
    $id = encode_url($form_request['id'] ?? '');
    $canEdit = isset($form_handover['status']) && (int)$form_handover['status'] === 0;
    $save = isset($form_handover['status']) && (int)$form_handover['status'] === 1;
    $select_length = count($select_pic);
    $is_select_empty = $select_length === null || $select_length === 0;
?>
<input type="hidden" id="is_select_empty" value="<?= $is_select_empty ?>">
<input type="hidden" id="id_form_request" value="<?= $id ?? ''; ?>">
<input type="hidden" id="id_handover" value="<?= $handover['id'] ?? ''; ?>">

<div class="wrap-submit-rl">
    <div class="title-section-resign">
        <div class="number-step-resign">
                3
        </div>
        <div class="title-step-resign">
            Handover
        </div>
    </div>
    <div class="content-handover">
        <div class="d-flex justify-content-end align-items-center">
            <button type="button" class="btn btn-primary add-handover" id="btn-add" <?= $canEdit ? '' : 'disabled' ?>>
                <i class="fas fa-plus"></i>
                Add Handover
            </button>
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

                        <th rowspan="2" class="text-center align-middle col-action">
                            Action
                        </th>
                    </tr>

                    <tr>
                        <th class="text-center col-alat-nama">Nama</th>
                        <th class="text-center col-alat-jumlah">Jumlah</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($pic)): ?>
                        <?php $no = 1; ?>

                        <?php foreach ($pic as $row): ?>
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

                                <td class="text-center">
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-primary btn-edit-handover"
                                        data-id="<?= $row['id'] ?>"
                                        data-notes ="<?= htmlspecialchars($row['notes']) ?>"
                                        data-tool-name ="<?= htmlspecialchars($row['nama_alat']) ?>"
                                        data-quantity ="<?= $row['jumlah_alat'] ?>"
                                        data-status ="<?= $row['status'] ?>"
                                        data-name ="<?= htmlspecialchars($row['name']) ?>"
                                        data-email ="<?= htmlspecialchars($row['email']) ?>"
                                        style="display:inline-flex; align-items:center; justify-content:center; gap:0.25rem;"
                                        <?= $canEdit ? '' : 'disabled' ?>
                                        >
                                        <i class="fas fa-edit"></i>
                                        Edit
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-danger btn-delete-handover"
                                        data-id="<?= $row['id'] ?>"
                                        style="display:inline-flex; align-items:center; justify-content:center; gap:0.25rem;"
                                        <?= $canEdit ? '' : 'disabled' ?>
                                        >
                                        <i class="fas fa-trash"></i>
                                        Delete
                                    </button>
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
        <div class="wrap-btn-submit">
            <button type="<?= $save ? 'button' : 'submit' ?>" id="<?= $save ? 'update-handover' : 'submit-btn-handover' ?>" data-id="<?= $form_handover['id'] ?>" class="btn btn-success"><?= $save ? 'Edit' : 'Submit' ?></button>
           <button type="button" id="back-btn" class="btn btn-danger">Back</button> 
        </div>
    </div>
</div>
<div
    class="modal fade"
    id="handover-modal"
    data-backdrop="static"
    data-keyboard="false"
    tabindex="-1"
    aria-labelledby="handoverModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="handoverModalLabel">
                    Add Handover
                </h5>

                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <form id="handover-form" class="form-handover">

                    <!-- Tools -->
                    <div class="form-group">

                        <div class="input-group">
                            <label for="toolName">
                                Tools Name
                            </label>

                            <input
                                id="toolName"
                                type="text"
                                placeholder="Enter Tools Name"
                                name="tool_name"
                                required
                            >
                        </div>

                        <div class="input-group">
                            <label for="quantity">
                                Tools Quantity
                            </label>

                            <input
                                id="quantity"
                                type="number"
                                onwheel="this.blur()"
                                placeholder="Enter Quantity"
                                name="quantity"
                                min="1"
                                required
                            >
                        </div>

                    </div>


                    <!-- PIC Type -->
                    <div id="pic-type-section" class="form-group">

                        <label style="margin:0;">
                            PIC Type
                        </label>

                        <div class="radio-group">
                            <div class="form-check form-check-inline">

                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="pic_type"
                                    id="pic-type-employee"
                                    value="employee"
                                    checked
                                >

                                <label
                                    class="form-check-label"
                                    for="pic-type-employee"
                                >
                                    Karyawan
                                </label>

                            </div>

                            <div class="form-check form-check-inline">

                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="pic_type"
                                    id="pic-type-non-employee"
                                    value="non_employee"
                                >

                                <label
                                    class="form-check-label"
                                    for="pic-type-non-employee"
                                >
                                    Non Karyawan
                                </label>

                            </div>
                        </div>

                    </div>


                    <!-- Employee PIC -->
                    <div id="employee-pic-section" class="employee-pic-section">

                        <div class="form-group">
                            <div class="input-group">
                                <label for="pic">
                                    PIC
                                </label>

                                <div class="select-wrapper">
                                    <select
                                    required
                                        name="employee_id"
                                        id="pic"
                                        style="width: 100%; font-size: 0.75rem; line-height: 1.5;"
                                        >
                                        <option value="">
                                            Select PIC
                                        </option>

                                        <?php foreach ($select_pic as $p): ?>

                                            <option
                                                value="<?= $p['id'] ?>"
                                                data-name="<?= htmlspecialchars($p['name']) ?>"
                                                data-email="<?= htmlspecialchars($p['email']) ?>"
                                            >
                                                <?= htmlspecialchars($p['name']) ?> (<?= htmlspecialchars($p['id_employee']) ?>)
                                            </option>

                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="input-group">
                                <label for="toolName">
                                    Status
                                </label>
                                <div class="select-wrapper">
                                    <select
                                    name="status"
                                    id="employee-status"
                                    required
                                    style="width: 100%; font-size: 0.75rem; line-height: 1.5;"
                                    >
                                        <option value="">
                                            Select Status
                                        </option>
                                        <option
                                            value="1"
                                        >
                                            Pending
                                        </option>
                                        <option
                                            value="2"
                                        >
                                            Finished
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">

                                <label for="employee-name">
                                    Name
                                </label>

                                <input
                                    name="name"
                                    id="employee-name"
                                    type="text"
                                    readonly
                                    required
                                >

                            </div>
                            <div class="input-group">
                                <label for="employee-email">
                                    Email
                                </label>

                                <input
                                    name="email"
                                    id="employee-email"
                                    type="email"
                                    readonly
                                    required
                                >
                            </div>
                            

                        </div>

                    </div>


                    <!-- Non Employee PIC -->
                    <div
                        id="non-employee-pic-section"
                        style="display: none;"
                        class="non-employee-pic-section"
                    >

                        <div class="form-group">
                            <div class="input-group">
                                <label for="non-employee-name">
                                    Name
                                </label>

                                <input
                                    name="name"
                                    id="non-employee-name"
                                    type="text"
                                    placeholder="Enter PIC Name"
                                    required
                                >
                            </div>

                            <div class="input-group">

                                <label for="non-employee-email">
                                    Email
                                </label>

                                <input
                                    name="email"
                                    id="non-employee-email"
                                    type="email"
                                    placeholder="Enter Email"
                                    required
                                >

                            </div>

                        </div>

                        <div class="input-group">
                            <label for="toolName">
                                Status
                            </label>
                            <div class="select-wrapper">
                                <select
                                    name="status"
                                    id="non-employee-status"
                                    required
                                    style="width: 100%; font-size: 0.75rem; line-height: 1.5;"
                                    >
                                        <option value="">
                                            Select Status
                                        </option>
                                        <option
                                            value="1"
                                        >
                                            Pending
                                        </option>
                                        <option
                                            value="2"
                                        >
                                            Finished
                                        </option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="input-group">
                        <label for="description">
                            Description
                        </label>

                        <textarea
                            id="description"
                            placeholder="Enter Description"
                            name="description"
                            maxlength="255"
                            style="width: 100%; font-size: 0.75rem; line-height: 1.5; padding: 0.375rem 0.75rem; border: 1px solid #ced4da; border-radius: 0.25rem;"
                        ></textarea>

                    </div>
                </form>

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-danger"
                    data-dismiss="modal"
                >
                    Close
                </button>

                <button
                    type="button"
                    class="btn btn-primary"
                    id="btn-save"
                >
                    Save
                </button>

            </div>

        </div>
    </div>
</div>