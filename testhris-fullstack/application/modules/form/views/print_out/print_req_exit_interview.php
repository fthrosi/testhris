<style>
    body { font-family: helvetica, sans-serif; font-size: 8.5px; }
    table {
        margin-left: 0 !important;
    }
</style>

<!-- INSTRUKSI -->
<table border="0" cellpadding="2" cellspacing="0" style="width: 100%; font-size: 8.5px;">
    <tr>
        <td width="17%" style="font-weight: semibold; font-size: 9px;">Instruksi <i style="font-weight: normal;">(Instruction):</i></td>
    </tr>
    <tr>
        <td width="2%" align="left" vertical-align="middle">•</td>
        <td width="98%"><b><u>Silahkan isi jawaban anda di dalam kotak jawaban yang tersedia</u></b><br><i style="font-size:7.5px;">Please fill in the box below of the question.</i></td>
    </tr>
</table>

<!-- DATA PROFIL KARYAWAN -->
<table border="0" cellpadding="2" cellspacing="0" style="width: 100%; font-size: 8.5px;">
    <tr>
        <td width="16%"><b><u>Nama Karyawan</u></b><br><i style="font-size:7.5px;">Employee Name</i></td>
        <td width="2%" align="center">:</td>
        <td width="32%" valign="middle" style="border-bottom: 1px solid #000; vertical-align: middle;"><?= htmlspecialchars($employee['name'] ?? '') ?></td>

        <td width="16%" align="right"><b><u>Tanggal Bergabung</u></b><br><i style="font-size:7.5px;">Date of Hired</i></td>
        <td width="2%" align="center">:</td>
        <td width="32%" style="border-bottom: 1px solid #000; vertical-align: middle;"><?= !empty($employee['join_date']) ? date('d-m-Y', strtotime($employee['join_date'])) : '' ?></td>
    </tr>
    <tr>
        <td><b><u>Posisi</u></b><br><i style="font-size:7.5px;">Position</i></td>
        <td align="center">:</td>
        <td style="border-bottom: 1px solid #000; vertical-align: middle;"><?= htmlspecialchars($employee['position'] ?? '') ?></td>

        <td align="right"><b><u>Tanggal Keluar</u></b><br><i style="font-size:7.5px;">Date of Resign</i></td>
        <td align="center">:</td>
        <td style="border-bottom: 1px solid #000; vertical-align: middle;"><?= !empty($employee['last_date']) ? date('d-m-Y', strtotime($employee['last_date'])) : '' ?></td>
    </tr>
    <tr>
        <td><b><u>Departemen</u></b><br><i style="font-size:7.5px;">Division</i></td>
        <td align="center">:</td>
        <td style="border-bottom: 1px solid #000; vertical-align: middle;"><?= htmlspecialchars($employee['division'] ?? '') ?></td>

        <td align="right"><b><u>Masa Kerja</u></b><br><i style="font-size:7.5px;">Period of Work</i></td>
        <td align="center">:</td>
        <td style="border-bottom: 1px solid #000; vertical-align: middle;"><?= htmlspecialchars($employee['period_of_work'] ?? '') ?></td>
    </tr>
</table>

<br><br>

<!-- LOOPING DINAMIS PERTANYAAN DB -->
<?php 
$num = 1;
foreach ($form as $q_id => $q): 
    $user_answer = $q['answer'] ?? '';
?>
    <table border="0" cellpadding="4" cellspacing="0" style="width: 100%;">
        <tr>
            <td width="4%"><b><?= $num++ ?>.</b></td>
            <td width="96%"><b><u><?= htmlspecialchars($q['title'] ?? $q['question'] ?? '') ?></u></b><br><i><?= htmlspecialchars($q['translation']) ?></i></td>
        </tr>
        <?php if ($q['question_type'] !== 'checkbox' && $q['question_type'] !== 'radio'): ?>
            <tr>
                <td width="4%"><b></b></td>
                <td width="96%" style="border-bottom: 1px solid #000;"><?= nl2br(htmlspecialchars($user_answer)) ?></td>
            </tr>
        <?php endif; ?>
    </table>
    <br>
    <br>
    <?php if (!empty($q['options'])): ?>
        <table border="0" cellpadding="2" cellspacing="0" style="width: 100%; margin-top: 3px;">
            <tr>
                <?php foreach ($q['options'] as $opt): 
                    $is_selected = ($user_answer == $opt['value']);
                ?>
                    <td width="4%"></td>
                    <td>[ <?= $is_selected ? 'V' : '&nbsp;&nbsp;' ?> ] 
                        <?= htmlspecialchars($opt['title']) ?> 
                        <?php if(!empty($opt['translation'])): ?>
                            (<i><?= htmlspecialchars($opt['translation']) ?></i>)
                        <?php endif; ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        </table>
        <br>
    <?php endif; ?>
    <?php if (!empty($q['children'])): ?>
        <br>
        <table border="0" cellpadding="2" cellspacing="0" style="width: 100%; margin-bottom: 6px;">
            <?php 
                $sub_num = 1;
                foreach ($q['children'] as $child): 
                $child_val = (int)($child['answer'] ?? 0);
                if (!empty($child['id_parrent_question']) && ((int)$child['id_parrent_question'] === 32) && ($child['question_type'] !== 'label')):
            ?>
                <tr>
                    <td width="7%" valign="top"></td>
                    <td width="4%" align="center"><?= $sub_num++ ?></td>
                    <td width="60%"><?= htmlspecialchars($child['title'] ?? $child['question'] ?? '') ?> / <i><?= htmlspecialchars($child['translation']) ?></i></td>
                    <?php if (!empty($child['options'])):
                        foreach ($child['options'] as $opt):
                        $is_selected = ($child_val == $opt['value']);
                    ?>
                        <td width="7%">[ <?= $is_selected ? '<span  style="font-weight: bold;">V</span>' : '&nbsp;&nbsp;' ?> ] <?= htmlspecialchars($opt['label']) ?></td>
                    <?php endforeach; endif; ?>
                </tr>
                <?php elseif($child['question_type'] === 'label'): ?>
                    <tr>
                        <td width="4%" valign="top"></td>
                        <td width="3%" valign="top">*)</td>
                        <td width="93%"><b><?= htmlspecialchars($child['title'] ?? $child['question'] ?? '') ?></b><br><i><?= htmlspecialchars($child['translation']) ?></i></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td width="7%" valign="top"></td>
                        <td width="35%"><b><?= htmlspecialchars($child['title'] ?? $child['question'] ?? '') ?></b> (<i><?= htmlspecialchars($child['translation']) ?></i>)</td>
                        <td width="2%" align="center">:</td>
                        <td width="56%" style="border-bottom: 1px solid #000;"><?= htmlspecialchars($child['answer'] ?? '') ?></td>
                    </tr>
            <?php 
                endif;
                endforeach; 
            ?>
        </table>
    <?php endif; ?>
<?php endforeach; ?>

<br><br>

<!-- TANDA TANGAN KARYAWAN -->
<table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
    <tr>
        <td width="4%"></td>
        <td width="36%" align="start">
            Jakarta, <?= !empty($employee['tanggal_submit']) ? date('d-m-Y', strtotime($employee['tanggal_submit'])) : date('d-m-Y') ?><br>
            Hormat saya / <i>Employee's Signature</i>,
        </td>
        <td width="60%"></td>
    </tr>
    <br>
    <tr>
        <td width="4%"></td>
        <td height="70" align="start" vertical-align="middle">
            <?php 
                $sign_pemohon = $employee['sign_img'] ?? '';
                if (!empty($employee['sign_img']) && file_exists($employee['sign_img'])): 
            ?>
                <div align="center" style="line-height: 0.8;">
                    <img src="<?= $sign_pemohon ?>" height="68"><br>
                    <span style="font-size: 6px; color: #555555; font-style: italic;">Signature is generated by system</span>
                </div>
            <?php endif; ?>
        </td>
        <td width="60%"></td>
    </tr>
    <br>
    <tr>
        <td width="4%"></td>
        <td width="36%" align="start">
            <table border="0" cellpadding="1" cellspacing="0" style="width: 100%; font-size: 8px;" align="left">
                <tr>
                    <td width="25%" align="left">Name</td>
                    <td width="5%" align="center">:</td>
                    <td width="70%" align="left" style="border-bottom: 1px solid #000;"><?= htmlspecialchars($employee['name'] ?? '') ?></td>
                </tr>
                <tr>
                    <td align="left">Date</td>
                    <td align="center">:</td>
                    <td align="left" style="border-bottom: 1px solid #000;"><?= !empty($employee['tanggal_submit']) ? date('d-m-Y', strtotime($employee['tanggal_submit'])) : '' ?></td>
                </tr>
            </table>
        </td>
        <td width="60%"></td>
    </tr>
</table>