<link rel="stylesheet" href="<?= base_url(); ?>/assets/v2/css/dashlite.css?ver=2.6.0">
<link id="skin-default" rel="stylesheet" href="<?= base_url(); ?>/assets/v2/css/theme.css?ver=2.6.0">

<title>HRIS - Approval Time Off</title>

<input type="hidden" id="request_id" name="request_id" value="<?=decode_url($this->uri->segment(4));?>">

<div class="container mt-5 d-flex flex-column">
    <div class="card card-preview w-50 justify-content-center align-items-center align-self-center">
        <div class="align-center pt-3">
            <div class="sq-md">
                <a href="<?= site_url('dashboard'); ?>"><img class="" src="<?= base_url(); ?>/assets/v2/images/logo_IBS.jpg" alt="logo"></a>
            </div>
            <div class="pl-2">
                <span class="lead-text">HRIS</span>
                <span class="sub-text">Human Resources Department</span>
            </div>
        </div>
        <hr class="col-11">
        
        <div class="nk-ibx-reply nk-reply pb-2">
            <div class="nk-ibx-reply-head">    
                <h5 class="title"><span class="text-soft">TIME MANAGEMENT: </span>TIME-OFF</h5>
            </div>

            <?php
            if($header['status'] == 1){
                echo "<div class='bg-teal-dim text-success rounded-pill'><center><b>Full Approved</b></center></div>";
            }
            ?>
        </div>

        <div class="nk-block nk-block-lg">
            <div class="card card-bordered card-preview">
                <table class="table table-orders">
                    <tbody class="tb-odr-body">
                        <tr class="tb-odr-item">
                            <td class="tb-odr-info">
                                <span class="tb-odr-id text-soft">Nama</span>
                                <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                    <?= decrypt($personal_detail['complete_name']); ?>
                                </span>
                            </td>
                            <td class="tb-odr-info">
                                <span class="tb-odr-id text-soft">No. Karyawan</span>
                                <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                    <?= $header['nik'];?>
                                </span>
                            </td>
                        </tr>
                        <tr class="tb-odr-item">
                            <td class="tb-odr-info">
                                <span class="tb-odr-id text-soft">Tipe Time-Off</span>
                                <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                    <?= $header['jenis']; ?>
                                </span>
                            </td>
                            <td class="tb-odr-info">
                                <span class="tb-odr-id text-soft">Notes</span>
                                <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                    <?= $header['note']; ?>
                                </span>
                            </td>
                        </tr>
                        <tr class="tb-odr-item">
                            <td class="tb-odr-info">
                                <span class="tb-odr-id text-soft">Start Date</span>
                                <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                    <?= $header['start_date']; ?>
                                </span>
                            </td>
                            <td class="tb-odr-info">
                                <span class="tb-odr-id text-soft">End Date</span>
                                <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                    <?= $header['end_date']; ?>
                                </span>
                            </td>
                        </tr>
                        <tr class="tb-odr-item">
                        <?php if (!empty($header['waktu_masuk'])) { ?>
                            <td class="tb-odr-info">
                                <span class="tb-odr-id text-soft">Waktu Masuk</span>
                                <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                    <?= $header['waktu_masuk']; ?>
                                </span>
                            </td>
                        <?php } if (!empty($header['waktu_keluar'])) { ?>
                            <td class="tb-odr-info">
                                <span class="tb-odr-id text-soft">Waktu Keluar</span>
                                <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                    <?= $header['waktu_keluar']; ?>
                                </span>
                            </td>
                        <?php } if (!empty($header['files'])){ ?>
                            <td class="tb-odr-info">
                                <span class="tb-odr-id text-soft">Files</span>
                                <span class="tb-odr-id lead-primary fw-bold text-uppercase">
                                    <a href="<?php echo base_url();?>assets/documents/documents_tm/<?= $header['files']; ?>" target="_blank"><?= $header['files']; ?></a>
                                </span>
                                </td>
                        <?php } ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <?php
            if($header['status'] == 0){
                $color = 'btn-primary';
                $disabled = '';
            } else {
                $color = 'btn-secondary';
                $disabled = 'disabled';
            }
        ?>
        <div class="sp-package-action pt-4">
            <button onclick="return respond_approval();" class="btn btn-md <?=$color?>" <?=$disabled?>>Approve</button>
            <a href="<?= site_url('form/detail_approval/TM/' . encode_url($header['request_id'])); ?>" class="btn btn-dim btn-info">More Details</a>
        </div>
        <div class="p-2">
            <a href="<?= site_url('form/overview/TM'); ?>" class=""><em class="icon ni ni-back-alt"></em> Back to Home</a>
        </div>

    </div>
</div>

<script>
    function respond_approval(){
        var id = $('#request_id').val();
        var url = "../../response";

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-light'
            },
            buttonsStyling: false
        })
    
        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            //text: "Revise this request",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, sure.',
            cancelButtonText: 'Cancel.',
            reverseButtons: true,
            allowOutsideClick: false
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: 'post',
                    data: 'id=' + id + '&resp=Approved',
                    dataType: 'json',
                    beforeSend: function () {
                    Swal.fire({
                        position: "center",
                        title: "Please Wait...",
                        onBeforeOpen: () => {
                        Swal.showLoading();
                        },
                    });
                    },
                    success: function (response) {
    
                        if (response.status == 1) {
    
                            swalWithBootstrapButtons.fire('Thank You!','Response has been saved.','success');
                            window.location.href = '../../../inbox/approval';
    
                        } else {
                            swalWithBootstrapButtons.fire('Oops!', 'Something went wrong. Please try again.', 'error')
                        }
                        
                    },
                    error: function (response) {
                        alert('Oops! There\'s something wrong, it might be slow network or expired user session. Please refresh this page and try again.');
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire('Cancelled','Action has been cancelled.','success')
            }
        })
    }
</script>

<?php $version= date('Y-m-d H:i:s');?>
<script src="<?= base_url(); ?>/assets/v2/js/bundle.js?ver=2.6.0"></script>
<!-- <script src="<?= base_url(); ?>/assets/v2/js/scripts.js?ver=<?= $version;?>"></script> -->
<script src="<?= base_url(); ?>/assets/v2/js/toastr.js?ver=2.6.0"></script>
<script src="<?= base_url(); ?>/assets/v2/js/apps/inbox.js?ver=2.6.0"></script>
<script src="<?= base_url(); ?>/assets/v2/js/libs/tagify.js?ver=2.6.0"></script>
<!-- <script src="<?= base_url(); ?>/assets/v2/js/charts/gd-analytics.js?ver=2.6.0"></script> -->
<!-- <script src="<?= base_url(); ?>/assets/v2/js/charts/chart-analytics.js?ver=2.6.0"></script> -->
<script src="<?= base_url(); ?>/assets/v2/js/libs/jqvmap.js?ver=2.6.0"></script>
<!-- Dropzone -->
<!-- <script src="<?= base_url() ?>/assets/v2/js/dropzone.js"></script> -->

<script src="<?= base_url(); ?>/assets/v2/js/eapp/request.js"></script>
<script src="<?= base_url(); ?>/assets/v2/js/eapp/register.js"></script>
<script src="<?= base_url(); ?>/assets/v2/js/eapp/e-approval.js?ver=<?= $version;?>"></script>
<script src="<?= base_url(); ?>/assets/v2/js/eapp/dashboard.js"></script>
<script src="<?= base_url(); ?>/assets/v2/js/eapp/e-approval_pa.js?ver=<?= $version;?>"></script>
<script src="<?= base_url(); ?>/assets/v2/js/eapp/dashboard_pa.js?ver=<?= $version;?>"></script>
<!-- <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script> -->

<link rel="stylesheet" href="<?= base_url(); ?>/assets/v2/css/editors/quill.css?ver=2.6.0">
<!-- <script src="<?= base_url() ?>assets/js/switch/node_modules/bootstrap4-toggle/js/bootstrap4-toggle.min.js"></script> -->