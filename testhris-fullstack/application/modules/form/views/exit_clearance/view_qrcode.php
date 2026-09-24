<!-- <link rel="stylesheet" href="<?= base_url('assets/css/exit_clearance.css') ?>"> -->
<link rel="stylesheet" href="<?= base_url(); ?>assets/v2/css/exit_clearance/qrcode.css?ver=<?= $version ?? date('Y-m-d H:i:s'); ?>">
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
>

<div class="qr-result-page">

    <div class="qr-result-container">

        <!-- SUCCESS -->
        <div class="qr-result-success">

            <div class="qr-result-success-icon">
                <i class="fas fa-check"></i>
            </div>

            <h1 class="qr-result-success-title">
                Scan Berhasil
            </h1>

            <p class="qr-result-success-description">
                Resignation Letter berhasil ditemukan.
            </p>

        </div>


        <!-- REQUEST INFORMATION -->
        <div class="qr-result-card">

            <!-- Header -->
            <div class="qr-result-header">

                <div class="qr-result-document-icon">
                    <i class="far fa-file-alt"></i>
                </div>

                <div class="qr-result-header-content">

                    <h2 class="qr-result-title">
                        Resignation Letter
                    </h2>

                    <p class="qr-result-subtitle">
                        Request Information
                    </p>

                </div>

            </div>


            <!-- Information -->
            <div class="qr-result-info-list">

                <!-- Request ID -->
                <div class="qr-result-info-item">

                    <div class="qr-result-info-icon">
                        <i class="fas fa-hashtag"></i>
                    </div>

                    <div class="qr-result-info-content">

                        <span class="qr-result-info-label">
                            Request ID
                        </span>

                        <span class="qr-result-info-value">
                            <?= $request_id ?>
                        </span>

                    </div>

                </div>


                <!-- Nama -->
                <div class="qr-result-info-item">

                    <div class="qr-result-info-icon">
                        <i class="far fa-user"></i>
                    </div>

                    <div class="qr-result-info-content">

                        <span class="qr-result-info-label">
                            Nama
                        </span>

                        <span class="qr-result-info-value">
                            <?= $nama ?>
                        </span>

                    </div>

                </div>


                <!-- NIK -->
                <div class="qr-result-info-item">

                    <div class="qr-result-info-icon">
                        <i class="far fa-id-card"></i>
                    </div>

                    <div class="qr-result-info-content">

                        <span class="qr-result-info-label">
                            NIK
                        </span>

                        <span class="qr-result-info-value">
                            <?= $nik ?>
                        </span>

                    </div>

                </div>


                <!-- Tanggal Submit -->
                <div class="qr-result-info-item">

                    <div class="qr-result-info-icon">
                        <i class="far fa-calendar-alt"></i>
                    </div>

                    <div class="qr-result-info-content">

                        <span class="qr-result-info-label">
                            Tanggal Submit
                        </span>

                        <span class="qr-result-info-value">
                            <?= $tanggal_submit ?>
                        </span>

                    </div>

                </div>

            </div>

        </div>


        <!-- Footer -->
        <div class="qr-result-footer">
            © 2026 PT. Infrastruktur Bisnis Sejahtera
        </div>

    </div>

</div>
