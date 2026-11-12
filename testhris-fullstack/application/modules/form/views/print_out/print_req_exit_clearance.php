<style>
    .bg-header { 
        background-color: #f2f2f2; 
        font-weight: bold; 
        text-align: center; 
    }
</style>


<!-- Data Header Karyawan (Tanpa Border) -->
<table border="0" cellpadding="0" cellspacing="0" style="width: 100%; font-size: 8.5px;">
    <tr>
        <!-- BLOK KIRI (50% Lebar Kertas) -->
        <td width="50%" align="left" vertical-align="top">
            <table border="0" cellpadding="2" cellspacing="0" style="width: 100%;">
                <tr>
                    <td width="20%">Nama</td>
                    <td width="4%" align="center">:</td>
                    <td width="76%"><?= htmlspecialchars($employee['name'] ?? '') ?></td>
                </tr>
                <tr>
                    <td>Posisi</td>
                    <td align="center">:</td>
                    <td><?= htmlspecialchars($employee['position'] ?? '') ?></td>
                </tr>
                <tr>
                    <td>Divisi</td>
                    <td align="center">:</td>
                    <td><?= htmlspecialchars($employee['division'] ?? '') ?></td>
                </tr>
                <tr>
                    <td>No. Hp</td>
                    <td align="center">:</td>
                    <td><?= htmlspecialchars($employee['phone'] ?? '') ?></td>
                </tr>
            </table>
        </td>

        <!-- BLOK KANAN (50% Lebar Kertas - MENTOK KANAN) -->
        <td width="50%" align="right" vertical-align="top">
            <table border="0" cellpadding="2" cellspacing="0" style="width: 100%;" align="right">
                <tr>
                    <td width="50%"></td>
                    <td width="27%" align="left">Tgl. Bergabung</td>
                    <td width="3%" align="center">:</td>
                    <td width="20%" align="left">
                        <?= !empty($employee['join_date']) ? date('d-m-Y', strtotime($employee['join_date'])) : '' ?>
                    </td>
                </tr>
                <tr>
                    <td width="50%"></td>
                    <td align="left">Tgl. Akhir Kerja</td>
                    <td align="center">:</td>
                    <td align="left">
                        <?= !empty($employee['last_date']) ? date('d-m-Y', strtotime($employee['last_date'])) : '' ?>
                    </td>
                </tr>
                <tr>
                    <td width="50%"></td>
                    <td align="left">NIK</td>
                    <td align="center">:</td>
                    <td align="left">
                        <?= htmlspecialchars($employee['nik'] ?? '') ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<br><br>

<!-- Tabel Utama Item Exit Clearance (Dengan Border 1px) -->
<table border="1" cellpadding="3" cellspacing="0" style="width: 100%; font-size: 8.5px;">
    <thead>
        <tr class="bg-header">
            <th width="4%" rowspan="2" align="center"><br><br>No.</th>
            <th width="16%" rowspan="2" align="center"><br><br>Departemen</th>
            <th width="28%" rowspan="2" align="center"><br><br>Item</th>
            <th width="6%" rowspan="2" align="center"><br><br>V/X</th>
            <th width="8%" rowspan="2" align="center"><br><br>Jumlah</th>
            <th width="14%" rowspan="2" align="center">Tanggal Clearance</th>
            <th width="24%" colspan="3" align="center">Penerima Clearance</th>
        </tr>
        <tr class="bg-header">
            <th width="16%" align="center">Nama</th>
            <th width="8%" align="center">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no = 1;
        foreach ($form as $sec_id => $sec): 
            if (empty($sec['questions'])) continue;

            $rowspan = count($sec['questions']);
            $first_row = true;

            $first_q = $sec['questions'][0] ?? [];
            $sec_tanggal = !empty($first_q['tanggal_clearance']) ? date('d-m-Y', strtotime($first_q['tanggal_clearance'])) : '';
            $sec_receiver = $first_q['receiver_name'] ?? '';
            $sec_status = $first_q['receiver_status'] ?? $first_q['status'] ?? '';
            $pad_top = 0;
            if ($rowspan > 1) {
                $pad_top = ($rowspan - 1) * 9; // 9px per sisa baris
            }
            
            // Buat helper style margin/padding
            $style_push = ($pad_top > 0) ? 'style="margin-top: ' . $pad_top . 'px; line-height: 1.2;"' : '';

            foreach ($sec['questions'] as $q):
        ?>
                <tr>
                    <!-- 1. Kolom No & Departemen -->
                    <?php if ($first_row): ?>
                        <td width="4%" rowspan="<?= $rowspan ?>" align="center">
                            <div <?= $style_push ?>><?= $no++ ?></div>
                        </td>
                        <td width="16%" rowspan="<?= $rowspan ?>">
                            <div <?= $style_push ?>><?= htmlspecialchars($sec['name']) ?></div>
                        </td>
                    <?php endif; ?>

                    <!-- 2. Kolom Item, V/X, Jumlah -->
                    <td width="28%"><?= htmlspecialchars($q['question'] ?? '') ?></td>
                    <td width="6%" align="center"><?= htmlspecialchars((int)$q['answer'] === 1 ? 'V' : 'X') ?></td>
                    <td width="8%" align="center"><?= htmlspecialchars($q['jumlah'] ?? '') ?></td>

                    <!-- 3. Kolom Penerima Clearance -->
                    <?php if ((int)$sec_id === 1): ?>
                        <!-- KHUSUS SECTION 1 -->
                        <td width="14%" align="center"><?= !empty($q['tanggal_clearance']) ? date('d-m-Y', strtotime($q['tanggal_clearance'])) : '' ?></td>
                        <td width="16%"><?= htmlspecialchars($q['receiver_name'] ?? '') ?></td>
                        <td width="8%" align="center"><?= htmlspecialchars($q['receiver_status'] ?? $q['status'] ?? '') ?></td>
                    <?php else: ?>
                        <!-- SECTION 2 - 6 -->
                        <?php if ($first_row): ?>
                            <td width="14%" rowspan="<?= $rowspan ?>" align="center">
                                <div <?= $style_push ?>><?= $sec_tanggal ?></div>
                            </td>
                            <td width="16%" rowspan="<?= $rowspan ?>">
                                <div <?= $style_push ?>><?= htmlspecialchars($sec_receiver) ?></div>
                            </td>
                            <td width="8%" rowspan="<?= $rowspan ?>" align="center">
                                <div <?= $style_push ?>><?= htmlspecialchars($sec_status) ?></div>
                            </td>
                        <?php endif; ?>
                    <?php endif; ?>
                </tr>
        <?php 
                $first_row = false;
            endforeach; 
        endforeach; 
        ?>
    </tbody>
</table>

<br><br>

<!-- Tabel Approval Box 3 Kolom (Bawah) -->
<table border="1" cellpadding="3" cellspacing="0" style="width: 100%; font-size: 8.5px;">
    <tr class="bg-header">
        <td width="33.33%" align="center">DIAJUKAN OLEH PEMOHON</td>
        <td width="33.33%" align="center">DISETUJUI OLEH KA.DIV.</td>
        <td width="33.34%" align="center">DISAHKAN OLEH HR HEAD</td>
    </tr>
    <tr>
        <!-- Area Tanda Tangan / Space Kosong -->
        <td height="80" align="center" vertical-align="middle">
            <?php 
                $sign_pemohon = $approval['pemohon']['sign_img'] ?? '';
                if (!empty($sign_pemohon) && file_exists($sign_pemohon)): 
            ?>
                <div align="center" style="line-height: 0.8;">
                    <img src="<?= $sign_pemohon ?>" height="78"><br>
                    <span style="font-size: 6px; color: #555555; font-style: italic;">Signature is generated by system</span>
                </div>
            <?php endif; ?>
        </td>

        <!-- 2. TTD KALDIV -->
        <td height="80" align="center" vertical-align="middle">
            <?php 
                $sign_kaldiv = $approval['kaldiv']['sign_img'] ?? '';
                if (!empty($sign_kaldiv) && file_exists($sign_kaldiv)): 
            ?>
                <div align="center" style="line-height: 0.8;">
                    <img src="<?= $sign_kaldiv ?>" height="78">
                    <span style="font-size: 6.5px; color: #555555; font-style: italic;">Signature is generated by system</span>
                </div>
            <?php endif; ?>
        </td>

        <!-- 3. TTD HR HEAD -->
        <td height="80" align="center" vertical-align="middle">
            <?php 
                $sign_hr = $approval['hr_head']['sign_img'] ?? '';
                if (!empty($sign_hr) && file_exists($sign_hr)): 
            ?>
                <div align="center" style="line-height: 0.8;">
                    <img src="<?= $sign_hr ?>" height="78">
                    <span style="font-size: 6.5px; color: #555555; font-style: italic;">Signature is generated by system</span>
                </div>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td style="line-height: 1.4;">
            Nama: <?= htmlspecialchars($approval['pemohon']['name'] ?? $header['nama'] ?? '') ?><br>
            Posisi: <?= htmlspecialchars($approval['pemohon']['position'] ?? $header['posisi'] ?? '') ?><br>
            Tanggal: <?= !empty($approval['pemohon']['tanggal_clearance']) ? date('d-m-Y', strtotime($approval['pemohon']['tanggal_clearance'])) : '' ?>
        </td>
        <td style="line-height: 1.4;">
            Nama: <?= htmlspecialchars($approval['kaldiv']['name'] ?? '') ?><br>
            Posisi: <?= htmlspecialchars($approval['kaldiv']['position'] ?? '') ?><br>
            Tanggal: <?= !empty($approval['kaldiv']['tanggal_clearance']) ? date('d-m-Y', strtotime($approval['kaldiv']['tanggal_clearance'])) : '' ?>
        </td>
        <td style="line-height: 1.4;">
            Nama: <?= htmlspecialchars($approval['hr_head']['name'] ?? 'Gladys Christine') ?><br>
            Posisi: <?= htmlspecialchars($approval['hr_head']['position'] ?? 'HRGA Division Head') ?><br>
            Tanggal: <?= !empty($approval['hr_head']['tanggal_clearance']) ? date('d-m-Y', strtotime($approval['hr_head']['tanggal_clearance'])) : '' ?>
        </td>
    </tr>
</table>