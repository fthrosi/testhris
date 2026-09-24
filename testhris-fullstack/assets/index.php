<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>404 - Halaman Tidak Ditemukan</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    background:linear-gradient(135deg,#f3f4f6,#e8eefc);
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    color:#334155;
    padding:20px;
}

.card{
    width:100%;
    max-width:620px;
    background:#fff;
    border-radius:18px;
    box-shadow:0 20px 50px rgba(0,0,0,.12);
    overflow:hidden;
}

.header{
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    color:#fff;
    padding:35px;
    text-align:center;
}

.header .code{
    font-size:90px;
    font-weight:700;
    line-height:1;
    opacity:.9;
}

.header h1{
    margin-top:10px;
    font-size:30px;
    font-weight:600;
}

.content{
    padding:35px;
    text-align:center;
}

.icon{
    width:90px;
    height:90px;
    margin:-80px auto 20px;
    background:#fff;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    box-shadow:0 10px 25px rgba(0,0,0,.15);
    font-size:42px;
}

.content p{
    font-size:16px;
    color:#64748b;
    line-height:1.8;
    margin-bottom:30px;
}

.actions{
    display:flex;
    justify-content:center;
    gap:15px;
    flex-wrap:wrap;
}

.btn{
    display:inline-block;
    padding:12px 24px;
    border-radius:8px;
    text-decoration:none;
    transition:.25s;
    font-weight:600;
}

.btn-primary{
    background:#2563eb;
    color:#fff;
}

.btn-primary:hover{
    background:#1d4ed8;
}

.btn-secondary{
    border:1px solid #d1d5db;
    color:#374151;
    background:#fff;
}

.btn-secondary:hover{
    background:#f8fafc;
}

.footer{
    border-top:1px solid #edf2f7;
    padding:15px 25px;
    text-align:center;
    font-size:13px;
    color:#94a3b8;
}

@media(max-width:600px){

    .header .code{
        font-size:70px;
    }

    .header h1{
        font-size:24px;
    }

    .content{
        padding:30px 20px;
    }

    .icon{
        margin-top:-70px;
    }
}
</style>

</head>
<body>

<div class="card">

    <div class="header">
        <h1>404 Page Not Found</h1>
    </div>
	<br>
    <div class="content">

        <div class="icon">🔍</div>

        <p>
            The page you requested was not found.
        </p>

    </div>

    <div class="footer">
        Jika Anda merasa ini adalah kesalahan sistem, silakan hubungi Administrator.
    </div>

</div>

</body>
</html>