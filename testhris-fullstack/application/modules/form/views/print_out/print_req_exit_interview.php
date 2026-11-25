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
        <td width="98%"><b>Silahkan isi jawaban anda di dalam kotak jawaban yang tersedia</b><br><i style="font-size:7.5px;">Please fill in the box below of the question.</i></td>
    </tr>
</table>

<!-- DATA PROFIL KARYAWAN -->
<table border="0" cellpadding="2" cellspacing="0" style="width: 100%; font-size: 8.5px; margin-bottom: 10px;">
    <tr>
        <td width="65%" align="left">
            <table border="0" cellpadding="2" cellspacing="0" style="width: 100%;">
                <tr>
                    <td width="30%"><b>Nama Karyawan</b><br><i style="font-size:7.5px;">Employee Name</i></td>
                    <td width="5%" align="center">:</td>
                    <td width="65%" valign="middle" ><?= htmlspecialchars($employee['name'] ?? '') ?></td>
                </tr>
            </table>
        </td>
        <td width="35%" align="left">
            <table border="0" cellpadding="2" cellspacing="0" style="width: 100%;">
                <tr>
                    <td width="50%" align="left"><b>Tanggal Bergabung</b><br><i style="font-size:7.5px;">Date of Hired</i></td>
                    <td width="5%" align="center">:</td>
                    <td width="45%" ><?= !empty($employee['join_date']) ? indo_date($employee['join_date']) : '' ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td width="65%" align="left">
            <table border="0" cellpadding="2" cellspacing="0" style="width: 100%;">
                <tr>
                    <td width="30%"><b>Posisi</b><br><i style="font-size:7.5px;">Position</i></td>
                    <td width="5%" align="center">:</td>
                    <td width="65%" ><?= htmlspecialchars($employee['position'] ?? '') ?></td>
                </tr>
            </table>
        </td>
        <td width="35%" align="left">
            <table border="0" cellpadding="2" cellspacing="0" style="width: 100%;">
                <tr>
                    <td width="50%" align="left"><b>Tanggal Keluar</b><br><i style="font-size:7.5px;">Date of Resign</i></td>
                    <td width="5%" align="center">:</td>
                    <td width="45%" ><?= !empty($employee['last_date']) ? indo_date($employee['last_date']) : '' ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td width="65%" align="left">
            <table border="0" cellpadding="2" cellspacing="0" style="width: 100%;">
                <tr>
                    <td width="30%"><b>Divisi</b><br><i style="font-size:7.5px;">Division</i></td>
                    <td width="5%" align="center">:</td>
                    <td width="65%" ><?= htmlspecialchars($employee['division'] ?? '') ?></td>
                </tr>
            </table>
        </td>
        <td width="35%" align="left">
            <table border="0" cellpadding="2" cellspacing="0" style="width: 100%;">
                <tr>
                    <td width="50%" align="left"><b>Masa Kerja</b><br><i style="font-size:7.5px;">Period of Work</i></td>
                    <td width="5%" align="center">:</td>
                    <td width="45%" ><?= !empty($employee['last_date']) ? indo_date($employee['period_of_work']) : '' ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td width="100%" align="left">
            <table border="0" cellpadding="2" cellspacing="0" style="width: 100%;">
                <tr>
                    <td width="100%" style="border-bottom: 1px solid #000;"></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<!-- LOOPING DINAMIS PERTANYAAN DB -->
<?php 
$num = 1;
foreach ($form as $q_id => $q): 
    $user_answer = $q['answer'] ?? '';
?>
    <table border="0" cellpadding="4" cellspacing="0" style="width: 100%;">
        <tr>
            <td width="5%"><b><?= $num++ ?>.</b></td>
            <td width="95%"><b><?= htmlspecialchars($q['title'] ?? $q['question'] ?? '') ?></b><br><i><?= htmlspecialchars($q['translation']) ?></i></td>
        </tr>
        <?php if ($q['question_type'] !== 'checkbox' && $q['question_type'] !== 'radio'): ?>
            <tr>
                <td width="5%"><b></b></td>
                <td width="95%"><?= nl2br(htmlspecialchars($user_answer)) ?></td>
            </tr>
        <?php endif; ?>
    </table>
    <br>
    <?php if (!empty($q['options'])): ?>
        <table border="0" cellpadding="2" cellspacing="0" style="width: 100%; margin-top: 3px;">
            <tr>
                <?php foreach ($q['options'] as $opt): 
                    $is_selected = ($user_answer == $opt['value']);
                ?>
                    <td width="5%"></td>
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
        <table border="0" cellpadding="2" cellspacing="0" style="width: 100%; margin-bottom: 6px;">
            <?php 
                $sub_num = 1;
                foreach ($q['children'] as $child): 
                $child_val = (int)($child['answer'] ?? 0);
                if (!empty($child['id_parrent_question']) && ((int)$child['id_parrent_question'] === 32) && ($child['question_type'] !== 'label')):
            ?>
                <tr>
                    <td width="8%" valign="top"></td>
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
                        <td width="8%" valign="top"></td>
                        <td width="35%"><b><?= htmlspecialchars($child['title'] ?? $child['question'] ?? '') ?></b> (<i><?= htmlspecialchars($child['translation']) ?></i>)</td>
                        <td width="2%" align="center">:</td>
                        <td width="56%"><?= htmlspecialchars($child['answer'] ?? '') ?></td>
                    </tr>
            <?php 
                endif;
                endforeach; 
            ?>
            
        <br>
        </table>
    <?php endif; ?>
<?php endforeach; ?>

<br><br>

<!-- TANDA TANGAN KARYAWAN -->
<table nobr="true" border="0" cellpadding="0" cellspacing="0" style="width: 100%; page-break-inside: avoid;">
    <tr>
        <td width="5%"></td>
        <td width="35%" align="start">
            Jakarta, <?= !empty($employee['tanggal_submit']) ? date('d-m-Y', strtotime($employee['tanggal_submit'])) : date('d-m-Y') ?><br>
            Hormat saya / <i>Employee's Signature</i>,
        </td>
        <td width="60%"></td>
    </tr>
    <br>
    <tr>
        <td width="5%"></td>
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
        <td width="5%"></td>
        <td width="35%" align="start">
            <table border="0" cellpadding="1" cellspacing="0" style="width: 100%; font-size: 8px;" align="left">
                <tr>
                    <td width="25%" align="left">Name</td>
                    <td width="5%" align="center">:</td>
                    <td width="70%" align="left"><?= htmlspecialchars($employee['name'] ?? '') ?></td>
                </tr>
                <tr>
                    <td align="left">Date</td>
                    <td align="center">:</td>
                    <td align="left" ><?= !empty($employee['tanggal_submit']) ? date('d-m-Y', strtotime($employee['tanggal_submit'])) : '' ?></td>
                </tr>
            </table>
        </td>
        <td width="60%"></td>
    </tr>
</table>