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
            <th width="23%" rowspan="2" align="center"><br><br>Keterangan</th>
            <th width="28%" colspan="3" align="center">Alat</th>
            <th width="13%" rowspan="2" align="center"><br>Status<br>Selesai/Tertunda</th>
            <th width="13%" rowspan="2" align="center"><br>Pic yang Menerima Pekerjaan</th>
            <th width="19%" rowspan="2" align="center"><br><br>Email</th>
        </tr>
        <tr class="bg-header">
            <th width="20%" align="center">Nama</th>
            <th width="8%" align="center">Jumlah</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $no = 1;
            $pic = is_array($pic) ? $pic : [];
            $total_rows = max(15, count($pic));
            for ($i = 0; $i < $total_rows; $i++):
                $p = $pic[$i] ?? [];
        ?>
                <tr>
                    <td width="4%" align="center"><?= $no++ ?></td>
                    <td width="23%"><?= htmlspecialchars($p['notes'] ?? '') ?></td>
                    <td width="20%"><?= htmlspecialchars($p['nama_alat'] ?? '') ?></td>
                    <td width="8%" align="center"><?= htmlspecialchars($p['jumlah_alat'] ?? '') ?></td>
                    <td width="13%" align="center"><?= htmlspecialchars($p['status'] ?? '') ?></td>
                    <td width="13%" align="center"><?= htmlspecialchars($p['name'] ?? '') ?></td>
                    <td width="19%"><?= htmlspecialchars($p['email'] ?? '') ?></td>
                </tr>
        <?php 
            endfor; 
        ?>
    </tbody>
</table>

<br><br><br><br><br><br>

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