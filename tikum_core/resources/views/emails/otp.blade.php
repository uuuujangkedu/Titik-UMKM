<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Verifikasi - Titik UMKM</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #F8F7F2;
            color: #1B1B18;
            margin: 0;
            padding: 24px;
        }
        .container {
            max-width: 520px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #E8E6DF;
            box-shadow: 0 4px 16px rgba(7, 91, 80, 0.08);
        }
        .header {
            background-color: #075B50;
            padding: 28px 24px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            letter-spacing: 1px;
            font-weight: 700;
        }
        .header p {
            margin: 4px 0 0;
            font-size: 13px;
            opacity: 0.9;
        }
        .body-content {
            padding: 32px 28px;
        }
        .greeting {
            font-size: 16px;
            font-weight: 600;
            color: #075B50;
            margin-bottom: 12px;
        }
        .otp-box {
            background: #F8F7F2;
            border: 2px dashed #075B50;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            margin: 24px 0;
        }
        .otp-code {
            font-size: 36px;
            font-weight: 800;
            letter-spacing: 10px;
            color: #075B50;
            font-family: 'Courier New', Courier, monospace;
        }
        .warning {
            background-color: #FFF9E6;
            border-left: 4px solid #F5B800;
            padding: 12px 16px;
            font-size: 13px;
            color: #6A5300;
            border-radius: 4px;
            margin-top: 20px;
        }
        .footer {
            background: #F8F7F2;
            padding: 18px 24px;
            text-align: center;
            font-size: 12px;
            color: #706F6C;
            border-top: 1px solid #E8E6DF;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div style="background: rgba(255,255,255,0.95); display: inline-block; padding: 6px 14px; border-radius: 10px; margin-bottom: 10px;">
                <img src="{{ asset('images/TIKUM-Logo.png') }}" alt="TIKUM" style="height: 36px; vertical-align: middle;">
            </div>
            <p>Platform Investasi UMKM & Sewa Ruko</p>
        </div>
        <div class="body-content">
            <div class="greeting">Halo, {{ $userName }}!</div>
            <p>Gunakan kode OTP berikut untuk <strong>{{ $action }}</strong> di Titik UMKM:</p>
            
            <div class="otp-box">
                <div class="otp-code">{{ $otp }}</div>
                <div style="font-size: 12px; color: #706F6C; margin-top: 8px;">Berlaku selama 5 menit</div>
            </div>

            <div class="warning">
                <strong>Perhatian:</strong> Jangan berikan kode OTP ini kepada siapa pun termasuk pihak yang mengatasnamakan Titik UMKM.
            </div>
            
            <p style="font-size: 13px; color: #706F6C; margin-top: 24px;">
                Jika Anda tidak merasa melakukan permintaan ini, silakan abaikan email ini.
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Titik UMKM. Hak cipta dilindungi.
        </div>
    </div>
</body>
</html>
