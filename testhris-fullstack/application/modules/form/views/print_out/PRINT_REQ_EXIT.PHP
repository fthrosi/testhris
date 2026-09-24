<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Surat Pengunduran Diri</title>
<style>
    @page {
        size: A4;
        margin: 2.2cm 2.5cm 2.0cm 2.5cm;
    }

    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        font-family: "Times New Roman", Times, serif;
        font-size: 12pt;
        line-height: 1.15;
        color: #000;
    }

    p {
        margin: 0 0 15px 0;
    }

    .date {
        margin-top: 20px;
        margin-bottom: 17px;
    }

    .recipient {
        margin-bottom: 18px;
    }

    .recipient div {
        line-height: 1.15;
    }

    .identity {
        margin: 0 0 17px 0;
    }

    .body-text {
        text-align: justify;
        margin-bottom: 16px;
    }

    .closing {
        margin-top: 3px;
    }

    .signature {
        margin-top: 50px;
        font-style: italic;
    }

    .cc {
        margin-top: 0px;
    }

    .cc-title {
        text-decoration: underline;
        font-style: italic;
        margin-bottom: 0;
    }

    .placeholder {
        background: #ffff00;
        padding: 0 2px;
    }

    .bold {
        font-weight: bold;
    }
</style>
</head>

<body>

    <table border="0" cellspacing="0" cellpadding="0" width="100%" bgcolor="#245487">
        <tr height="92">
            <td width="23%" align="center" valign="middle" bgcolor="#245487">
                <img height="64" src="/assets/images/IBS.png" alt="IBS">
            </td>
            <td width="57%" align="center" valign="middle" bgcolor="#245487">
                <font face="helvetica" color="white" size="14"><b>SURAT PENGUNDURAN DIRI</b></font><br>
            </td>
            <td width="20%" align="center" valign="middle" bgcolor="#245487">
                <table border="1" cellspacing="0" cellpadding="5" width="90%" bgcolor="white">
                    <tr>
                        <td align="center" valign="middle">
                            <font face="times" color="black" size="11"><b>CONFIDENTIAL</b></font>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="date">
        Jakarta, <span class="placeholder"><?=$date?></span>
    </div>

    <div class="recipient">
        <div>Yth.</div>
        <div>Bapak/Ibu <span class="placeholder"><?=$division_head?></span></div>
        <div>PT Infrastruktur Bisnis Sejahtera (IBS)</div>
        <div>di Jakarta</div>
    </div>

    <p>Yang bertanda tangan di bawah ini:</p>

    <table border="0" cellspacing="0" cellpadding="0" width="100%" class="identity">
        <tr>
            <td width="95">Nama</td>
            <td width="16">:</td>
            <td width="*"><span class="placeholder"><?=$complete_name?></span></td>
        </tr>
        <tr>
            <td>Posisi</td>
            <td>:</td>
            <td><span class="placeholder"><?=$position?></span></td>
        </tr>
        <tr>
            <td>Divisi</td>
            <td>:</td>
            <td><span class="placeholder"><?=$division?></span></td>
        </tr>
        <tr>
            <td>NIK Karyawan</td>
            <td>:</td>
            <td><span class="placeholder"><?=$nik?></span></td>
        </tr>
    </table>

    <p class="body-text">
        Melalui surat ini, saya bermaksud mengajukan permohonan pengunduran diri dari perusahaan
        terhitung <span class="placeholder"><?=$notice_period?></span> bulan dari tanggal
        <span class="placeholder"><?=$resignation_date?></span>.
    </p>

    <p class="body-text">
        Sebelumnya saya menyampaikan terima kasih atas kesempatan yang diberikan kepada saya
        selama bekerja dan berkarya di PT Infrastruktur Bisnis Sejahtera. Terima kasih atas
        bimbingan yang selama ini diberikan. Permohonan maaf saya sampaikan atas kekurangan
        saya selama <span class="placeholder"><?=$working_year?></span> tahun
        <span class="placeholder"><?=$working_month?></span> bulan
    </p>

    <p class="body-text">
        Dalam masa pemberitahuan pengunduran diri saya, saya bersedia menyelesaikan semua tanggung
        jawab saya terhadap perusahaan, serta mengikuti ketentuan, tata tertib, dan etika kerja
        yang berlaku sesuai dengan Peraturan Perusahaan.
    </p>

    <p class="body-text">
        Demikian surat pengunduran diri kerja ini saya buat dengan penuh kesadaran serta atas
        keinginan sendiri dan tanpa ada paksaan dari siapa pun.
    </p>

    <div class="closing">
        Hormat saya,
    </div>

    <div class="signature">
        <span class="placeholder"><?=$complete_name?></span>
    </div>

    <div class="cc">
        <div class="cc-title">Tembusan:</div>
        <div>HR Department</div>
    </div>

</body>
</html>