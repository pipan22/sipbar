<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SIPBAR</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-sipbar.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0a1628;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        .bg-aurora {
            position: fixed;
            inset: 0;
            z-index: -3;
            background: radial-gradient(ellipse at top right, #1e3a8a 0%, #0a1628 60%),
                        radial-gradient(ellipse at bottom left, #4c1d95 0%, transparent 50%),
                        #0a1628;
        }
        .bg-grid {
            position: fixed;
            inset: 0;
            z-index: -2;
            background-image: 
                linear-gradient(rgba(34, 211, 238, 0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(34, 211, 238, 0.06) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse at center, black 20%, transparent 70%);
            -webkit-mask-image: radial-gradient(ellipse at center, black 20%, transparent 70%);
        }
        .glow {
            position: fixed;
            border-radius: 50%;
            filter: blur(120px);
            z-index: -1;
            pointer-events: none;
        }
        .glow-1 {
            width: 500px; height: 500px;
            background: #06b6d4;
            top: -200px; right: -100px;
            opacity: 0.3;
            animation: glowFloat 15s ease-in-out infinite;
        }
        .glow-2 {
            width: 400px; height: 400px;
            background: #8b5cf6;
            bottom: -150px; left: -100px;
            opacity: 0.25;
            animation: glowFloat 20s ease-in-out infinite reverse;
        }
        @keyframes glowFloat {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(50px, -50px); }
        }

        /* LOGIN CARD */
        .login-card {
            width: 100%;
            max-width: 420px;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(30px);
            border: 1px solid rgba(34, 211, 238, 0.3);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.5), 0 0 60px rgba(34, 211, 238, 0.15);
            position: relative;
            z-index: 10;
            display: block;
        }

        /* LOGO SECTION - VERTICAL */
        .login-logo {
            text-align: center;
            margin-bottom: 32px;
            display: block;
        }
        .login-logo img {
            height: 80px;
            width: auto;
            display: inline-block;
            margin-bottom: 12px;
        }
        .login-logo h1 {
            font-size: 26px;
            font-weight: 800;
            color: #22d3ee;
            letter-spacing: -0.5px;
            margin-bottom: 4px;
        }
        .login-logo p {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.6);
        }

        /* FORM */
        .form-group {
            margin-bottom: 18px;
            display: block;
        }
        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.85);
        }
        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            font-family: inherit;
            font-size: 14px;
            background: rgba(255, 255, 255, 0.05);
            color: white;
            transition: all 0.2s;
            display: block;
        }
        .form-group input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }
        .form-group input:focus {
            outline: none;
            border-color: #22d3ee;
            background: rgba(34, 211, 238, 0.05);
            box-shadow: 0 0 0 4px rgba(34, 211, 238, 0.15);
        }

        /* BUTTON */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #22d3ee 0%, #06b6d4 100%);
            border: none;
            border-radius: 12px;
            color: #0a1628;
            font-family: inherit;
            font-size: 15px;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 8px 24px rgba(34, 211, 238, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 8px;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(34, 211, 238, 0.6);
        }

        /* ERROR */
        .error-msg {
            background: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 16px;
            border-left: 3px solid #ef4444;
            display: block;
        }

        /* FOOTER */
        .login-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.5);
            display: block;
        }
        .login-footer a {
            color: #22d3ee;
            font-weight: 700;
            text-decoration: none;
        }
        .login-footer a:hover { text-decoration: underline; }

        /* BACK HOME */
        .back-home {
            position: absolute;
            top: 30px;
            left: 30px;
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s;
            z-index: 10;
        }
        .back-home:hover { color: #22d3ee; }
    </style>
</head>
<body>
    <div class="bg-aurora"></div>
    <div class="bg-grid"></div>
    <div class="glow glow-1"></div>
    <div class="glow glow-2"></div>

    <a href="/" class="back-home">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>

    <div class="login-card">
        {{-- LOGO SECTION --}}
        <div class="login-logo">
            <img src="{{ asset('images/logo-sipbar.png') }}" alt="SIPBAR">
            <h1>SIPBAR</h1>
            <p>Sistem Peminjaman Barang</p>
        </div>

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="error-msg">
                <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
            </div>
        @endif

        {{-- FORM --}}
        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="{{ old('username') }}" placeholder="Masukkan username" required autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password" required>
            </div>
            <button type="submit" class="btn-submit">
                <i class="fas fa-sign-in-alt"></i> Masuk
            </button>
        </form>

        {{-- FOOTER --}}
        <div class="login-footer">
            Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
        </div>
    </div>
</body>
</html>