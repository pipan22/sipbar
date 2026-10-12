<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPBAR - Sistem Peminjaman Barang</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-sipbar.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #0a1628;
            color: white;
            overflow-x: hidden;
            position: relative;
        }

        /* ============ BACKGROUND ============ */
        .bg-base {
            position: fixed;
            inset: 0;
            z-index: -5;
            background: radial-gradient(ellipse at top right, #1e3a8a 0%, #0a1628 60%),
                        radial-gradient(ellipse at bottom left, #4c1d95 0%, transparent 50%),
                        #0a1628;
        }

        /* Grid pattern */
        .bg-grid {
            position: fixed;
            inset: 0;
            z-index: -4;
            background-image: 
                linear-gradient(rgba(34, 211, 238, 0.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(34, 211, 238, 0.08) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse at center, black 20%, transparent 70%);
            -webkit-mask-image: radial-gradient(ellipse at center, black 20%, transparent 70%);
        }

        /* Glow orbs */
        .glow {
            position: fixed;
            border-radius: 50%;
            filter: blur(120px);
            z-index: -3;
            pointer-events: none;
        }
        .glow-1 {
            width: 700px; height: 700px;
            background: #06b6d4;
            top: -250px; right: -150px;
            opacity: 0.3;
            animation: glowFloat 15s ease-in-out infinite;
        }
        .glow-2 {
            width: 600px; height: 600px;
            background: #8b5cf6;
            bottom: -250px; left: -150px;
            opacity: 0.25;
            animation: glowFloat 20s ease-in-out infinite reverse;
        }
        .glow-3 {
            width: 400px; height: 400px;
            background: #ec4899;
            top: 50%; right: -100px;
            opacity: 0.15;
            animation: glowFloat 25s ease-in-out infinite;
        }
        @keyframes glowFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(60px, -60px) scale(1.15); }
        }

        /* ============ PARTICLE SYSTEM ============ */
        .particles {
            position: fixed;
            inset: 0;
            z-index: -2;
            pointer-events: none;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            width: 3px; height: 3px;
            background: #22d3ee;
            border-radius: 50%;
            box-shadow: 0 0 10px #22d3ee, 0 0 20px #22d3ee;
            animation: particleRise 12s linear infinite;
        }
        .particle:nth-child(1) { left: 5%; animation-delay: 0s; }
        .particle:nth-child(2) { left: 15%; animation-delay: 2s; background: #a78bfa; box-shadow: 0 0 10px #a78bfa; }
        .particle:nth-child(3) { left: 25%; animation-delay: 4s; }
        .particle:nth-child(4) { left: 40%; animation-delay: 1s; background: #ec4899; box-shadow: 0 0 10px #ec4899; }
        .particle:nth-child(5) { left: 55%; animation-delay: 3s; }
        .particle:nth-child(6) { left: 70%; animation-delay: 5s; background: #a78bfa; box-shadow: 0 0 10px #a78bfa; }
        .particle:nth-child(7) { left: 80%; animation-delay: 2.5s; }
        .particle:nth-child(8) { left: 90%; animation-delay: 4.5s; background: #ec4899; box-shadow: 0 0 10px #ec4899; }
        .particle:nth-child(9) { left: 35%; animation-delay: 6s; }
        .particle:nth-child(10) { left: 60%; animation-delay: 7s; }
        .particle:nth-child(11) { left: 10%; animation-delay: 8s; background: #a78bfa; box-shadow: 0 0 10px #a78bfa; }
        .particle:nth-child(12) { left: 48%; animation-delay: 9s; }

        @keyframes particleRise {
            0% {
                transform: translateY(100vh) scale(0);
                opacity: 0;
            }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% {
                transform: translateY(-100px) scale(1.5);
                opacity: 0;
            }
        }

        /* Sparkles (bling bling ✨) */
        .sparkle {
            position: fixed;
            z-index: -1;
            pointer-events: none;
            color: #22d3ee;
            font-size: 14px;
            animation: sparkleBlink 3s ease-in-out infinite;
            filter: drop-shadow(0 0 6px #22d3ee);
        }
                .sparkle:nth-child(1) { top: 20%; left: 15%; animation-delay: 0s; }
        .sparkle:nth-child(2) { top: 30%; right: 20%; animation-delay: 0.5s; color: #a78bfa; filter: drop-shadow(0 0 6px #a78bfa); }
        .sparkle:nth-child(3) { top: 60%; left: 12%; animation-delay: 1s; }
        .sparkle:nth-child(4) { top: 75%; right: 15%; animation-delay: 1.5s; color: #ec4899; filter: drop-shadow(0 0 6px #ec4899); }
        .sparkle:nth-child(5) { top: 45%; left: 55%; animation-delay: 2s; }
        .sparkle:nth-child(6) { top: 85%; left: 35%; animation-delay: 2.5s; color: #a78bfa; filter: drop-shadow(0 0 6px #a78bfa); }

        @keyframes sparkleBlink {
            0%, 100% { opacity: 0; transform: scale(0.5) rotate(0deg); }
            50% { opacity: 1; transform: scale(1.2) rotate(180deg); }
        }

        /* Side glow lines (bingkai kiri kanan) */
        .side-glow {
            position: fixed;
            top: 0;
            width: 2px;
            height: 100vh;
            z-index: -1;
            background: linear-gradient(180deg, transparent 0%, #22d3ee 30%, #8b5cf6 70%, transparent 100%);
            opacity: 0.4;
            filter: blur(1px);
        }
        .side-glow-left { left: 20px; }
        .side-glow-right { right: 20px; }

        /* ============ NAVBAR ============ */
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 60px;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
            position: relative;
            z-index: 50;
        }
        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: white;
            font-weight: 800;
            font-size: 18px;
        }
        .nav-logo-icon {
            width: 36px; height: 32px;
            background: linear-gradient(135deg, #22d3ee 0%, #06b6d4 100%);
            border-radius: 9px 9px 9px 3px;
            display: flex; align-items: center; justify-content: center;
            color: #0a1628; font-size: 16px;
            box-shadow: 0 4px 20px rgba(34, 211, 238, 0.5);
        }
        .nav-menu { display: flex; gap: 36px; }
        .nav-menu a {
            color: rgba(255, 255, 255, 0.7); font-weight: 500; font-size: 14px;
            text-decoration: none; transition: color 0.2s;
        }
        .nav-menu a:hover { color: #22d3ee; }
        .nav-auth .btn-signup {
            background: linear-gradient(135deg, #22d3ee 0%, #06b6d4 100%);
            color: #0a1628; font-weight: 700; font-size: 13px;
            padding: 10px 22px; border-radius: 50px;
            text-decoration: none; transition: all 0.2s;
            box-shadow: 0 4px 20px rgba(34, 211, 238, 0.4);
        }
        .nav-auth .btn-signup:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(34, 211, 238, 0.6);
        }

        /* ============ HERO ============ */
        .hero {
            padding: 60px 60px 40px;
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 60px;
            position: relative;
            z-index: 10;
        }
        .hero h1 {
            font-size: 54px;
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -2px;
            margin-bottom: 20px;
        }
        .hero h1 .c1 { color: #22d3ee; }
        .hero h1 .c2 { color: #a78bfa; }
        .hero p {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.65);
            line-height: 1.7;
            margin-bottom: 32px;
            max-width: 520px;
        }
        .hero-buttons {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }
        .btn-primary {
            padding: 13px 30px;
            background: linear-gradient(135deg, #22d3ee 0%, #06b6d4 100%);
            color: #0a1628;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            box-shadow: 0 8px 24px rgba(34, 211, 238, 0.4);
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(34, 211, 238, 0.6);
        }
        .btn-secondary {
            padding: 13px 28px;
            background: rgba(255, 255, 255, 0.05);
            border: 1.5px solid rgba(255, 255, 255, 0.2);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }
        .btn-secondary:hover {
            border-color: #22d3ee;
            color: #22d3ee;
            transform: translateY(-3px);
        }

        /* ============ HERO VISUAL ============ */
        .hero-visual {
            position: relative;
            height: 480px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Ring glow di belakang robot */
        .ring-glow {
            position: absolute;
            width: 380px;
            height: 380px;
            border-radius: 50%;
            border: 1px solid rgba(34, 211, 238, 0.3);
            box-shadow: 0 0 60px rgba(34, 211, 238, 0.2), inset 0 0 60px rgba(34, 211, 238, 0.1);
            animation: ringRotate 20s linear infinite;
        }
        .ring-glow::before {
            content: '';
            position: absolute;
            top: -5px; left: 50%;
            width: 10px; height: 10px;
            background: #22d3ee;
            border-radius: 50%;
            box-shadow: 0 0 15px #22d3ee, 0 0 30px #22d3ee;
            transform: translateX(-50%);
        }
        @keyframes ringRotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .dashboard-mock {
            position: absolute;
            width: 100%;
            max-width: 460px;
            background: rgba(30, 58, 138, 0.3);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(34, 211, 238, 0.2);
            border-radius: 20px;
            padding: 20px;
            z-index: 1;
            transform: translate(-30px, -20px) rotate(-2deg);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
        }
        .mock-header {
            display: flex;
            gap: 6px;
            margin-bottom: 16px;
        }
        .mock-header span {
            width: 10px; height: 10px;
            border-radius: 50%;
        }
        .mock-dots-1 { background: #ef4444; }
        .mock-dots-2 { background: #f59e0b; }
        .mock-dots-3 { background: #10b981; }
        .mock-chart {
            display: flex;
            align-items: flex-end;
            gap: 8px;
            height: 100px;
            background: rgba(34, 211, 238, 0.05);
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 12px;
        }
        .mock-bar {
            flex: 1;
            background: linear-gradient(180deg, #22d3ee, #06b6d4);
            border-radius: 4px 4px 0 0;
            opacity: 0.6;
        }
        .mock-rows {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .mock-row {
            height: 8px;
            background: rgba(34, 211, 238, 0.15);
            border-radius: 4px;
        }

        .cat-wrapper {
            position: relative;
            z-index: 10;
            animation: catFloat 5s ease-in-out infinite;
            transform: translateX(30px);
        }
        @keyframes catFloat {
            0%, 100% { transform: translateX(30px) translateY(0); }
            50% { transform: translateX(30px) translateY(-20px); }
        }
        .cat-img {
            max-width: 320px;
            width: 100%;
            height: auto;
            filter: drop-shadow(0 20px 40px rgba(34, 211, 238, 0.4));
            animation: catGlow 4s ease-in-out infinite;
        }
        @keyframes catGlow {
            0%, 100% { filter: drop-shadow(0 20px 40px rgba(34, 211, 238, 0.4)); }
            50% { filter: drop-shadow(0 25px 50px rgba(139, 92, 246, 0.6)); }
        }

        /* Badges */
        .badge {
            position: absolute;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(34, 211, 238, 0.3);
            border-radius: 12px;
            padding: 8px 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 700;
            color: white;
            z-index: 20;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3), 0 0 15px rgba(34, 211, 238, 0.2);
            animation: badgeFloat 4s ease-in-out infinite;
        }
        @keyframes badgeFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        .badge i { color: #22d3ee; font-size: 13px; }
        .badge-1 { top: 8%; left: -5%; animation-delay: 0s; }
        .badge-2 { top: 5%; right: 0%; animation-delay: 1s; }
        .badge-3 { bottom: 20%; left: -10%; animation-delay: 2s; }
        .badge-4 { bottom: 8%; right: -5%; animation-delay: 0.5s; }

        /* ============ SECTION FITUR ============ */
        .section-box {
            max-width: 1300px;
            margin: 20px auto 60px;
            padding: 40px 40px 44px;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(34, 211, 238, 0.15);
            border-radius: 24px;
            position: relative;
            z-index: 10;
            box-shadow: 0 0 60px rgba(34, 211, 238, 0.05);
        }
        .section-box h2 {
            text-align: center;
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 32px;
            color: white;
            letter-spacing: -0.5px;
        }

        .fitur-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 16px;
        }
        .fitur-card {
            padding: 20px 18px;
            background: rgba(34, 211, 238, 0.05);
            border: 1px solid rgba(34, 211, 238, 0.15);
            border-radius: 16px;
            transition: all 0.3s;
        }
        .fitur-card:hover {
            background: rgba(34, 211, 238, 0.1);
            border-color: rgba(34, 211, 238, 0.4);
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(34, 211, 238, 0.2);
        }
        .fitur-icon {
            width: 40px; height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #22d3ee 0%, #06b6d4 100%);
            display: flex; align-items: center; justify-content: center;
            color: #0a1628; font-size: 16px;
            margin-bottom: 14px;
            box-shadow: 0 4px 12px rgba(34, 211, 238, 0.4);
        }
        .fitur-card h3 {
            font-size: 13px;
            font-weight: 700;
            color: white;
            margin-bottom: 6px;
        }
        .fitur-card p {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.55);
            line-height: 1.6;
        }

        /* ============ FAQ + CTA ============ */
        .bottom-row {
            max-width: 1300px;
            margin: 0 auto 60px;
            padding: 0 40px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            position: relative;
            z-index: 10;
        }

        .faq-box {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(34, 211, 238, 0.15);
            border-radius: 24px;
            padding: 32px;
        }
        .faq-box h3 {
            font-size: 18px;
            font-weight: 800;
            color: white;
            margin-bottom: 20px;
        }
        .faq-item {
            background: rgba(34, 211, 238, 0.05);
            border: 1px solid rgba(34, 211, 238, 0.15);
            border-radius: 12px;
            margin-bottom: 10px;
            overflow: hidden;
            transition: all 0.3s;
        }
        .faq-item:hover { border-color: rgba(34, 211, 238, 0.3); }
        .faq-q {
            padding: 14px 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
            color: white;
        }
        .faq-q i {
            color: #22d3ee;
            font-size: 11px;
            transition: transform 0.3s;
        }
        .faq-item.open .faq-q i { transform: rotate(180deg); }
        .faq-a {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s, padding 0.3s;
            padding: 0 18px;
            color: rgba(255, 255, 255, 0.6);
            font-size: 12px;
            line-height: 1.6;
        }
        .faq-item.open .faq-a {
            max-height: 200px;
            padding: 0 18px 14px;
        }

        .cta-box {
            background: linear-gradient(135deg, rgba(34, 211, 238, 0.15) 0%, rgba(139, 92, 246, 0.15) 100%);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(34, 211, 238, 0.3);
            border-radius: 24px;
            padding: 32px;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 0 60px rgba(34, 211, 238, 0.15);
        }
        .cta-box::before {
            content: '';
            position: absolute;
            top: -50%; right: -10%;
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(34, 211, 238, 0.4), transparent 70%);
            border-radius: 50%;
        }
        .cta-content {
            flex: 1;
            position: relative;
            z-index: 2;
        }
        .cta-box h3 {
            font-size: 20px;
            font-weight: 800;
            color: white;
            margin-bottom: 8px;
            letter-spacing: -0.3px;
        }
        .cta-box p {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 18px;
        }
        .cta-btn {
            padding: 11px 24px;
            background: linear-gradient(135deg, #22d3ee 0%, #06b6d4 100%);
            color: #0a1628;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            box-shadow: 0 6px 20px rgba(34, 211, 238, 0.4);
        }
        .cta-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(34, 211, 238, 0.6);
        }
        .cta-cat {
            width: 80px;
            height: auto;
            position: relative;
            z-index: 2;
            filter: drop-shadow(0 10px 20px rgba(34, 211, 238, 0.4));
            animation: catFloat 4s ease-in-out infinite;
            margin-right: 20px;
            flex-shrink: 0;
        }

        /* ============ FOOTER ============ */
        .footer {
            padding: 40px 60px 30px;
            border-top: 1px solid rgba(34, 211, 238, 0.1);
            background: rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 10;
        }
        .footer-inner {
            max-width: 1300px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
        }
        .footer-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            font-size: 16px;
            color: #22d3ee;
            margin-bottom: 12px;
        }
        .footer-brand-icon {
            width: 32px; height: 28px;
            border-radius: 8px;
            background: linear-gradient(135deg, #06b6d4 0%, #22d3ee 100%);
            display: flex; align-items: center; justify-content: center;
            color: #0a1628;
            font-size: 14px;
        }
        .footer-desc {
            font-size: 12.5px;
            color: rgba(255, 255, 255, 0.5);
            line-height: 1.7;
        }
        .footer-col h4 {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #22d3ee;
            margin-bottom: 14px;
        }
        .footer-col a {
            display: block;
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            font-size: 12.5px;
            margin-bottom: 8px;
            transition: color 0.2s;
        }
        .footer-col a:hover { color: #22d3ee; }
        .footer-bottom {
            max-width: 1300px;
            margin: 24px auto 0;
            padding-top: 20px;
            border-top: 1px solid rgba(34, 211, 238, 0.1);
            text-align: center;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.4);
        }

        /* ============ RESPONSIVE ============ */
        @media (max-width: 1100px) {
            .fitur-grid { grid-template-columns: repeat(3, 1fr); }
            .bottom-row { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .navbar { padding: 16px 20px; }
            .nav-menu { display: none; }
            .hero { grid-template-columns: 1fr; padding: 40px 20px; }
            .hero h1 { font-size: 34px; letter-spacing: -1px; }
            .hero-visual { height: 400px; }
            .cat-img { max-width: 240px; }
            .dashboard-mock { max-width: 320px; }
            .badge { font-size: 11px; padding: 6px 10px; }
            .ring-glow { width: 280px; height: 280px; }
            .section-box { padding: 24px 20px; margin: 20px; }
            .fitur-grid { grid-template-columns: 1fr 1fr; }
            .bottom-row { padding: 0 20px; }
            .footer-inner { grid-template-columns: 1fr; gap: 24px; }
            .footer { padding: 32px 20px 20px; }
        }
                /* ============ ALUR ============ */
        .alur-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 16px;
        }
        .alur-step {
            padding: 24px 20px;
            background: rgba(34, 211, 238, 0.05);
            border: 1px solid rgba(34, 211, 238, 0.15);
            border-radius: 16px;
            text-align: center;
            transition: all 0.3s;
            position: relative;
        }
        .alur-step:hover {
            background: rgba(34, 211, 238, 0.1);
            border-color: rgba(34, 211, 238, 0.4);
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(34, 211, 238, 0.2);
        }
        .alur-num {
            position: absolute;
            top: 12px;
            right: 14px;
            font-size: 11px;
            font-weight: 800;
            color: #22d3ee;
            background: rgba(34, 211, 238, 0.15);
            padding: 3px 8px;
            border-radius: 50px;
            letter-spacing: 1px;
        }
        .alur-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: linear-gradient(135deg, #22d3ee 0%, #06b6d4 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0a1628;
            font-size: 20px;
            margin: 0 auto 14px;
            box-shadow: 0 4px 12px rgba(34, 211, 238, 0.4);
        }
        .alur-step h3 {
            font-size: 14px;
            font-weight: 700;
            color: white;
            margin-bottom: 6px;
        }
        .alur-step p {
            font-size: 11.5px;
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.6;
        }

        /* Responsive alur */
        @media (max-width: 1100px) {
            .alur-grid { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 768px) {
            .alur-grid { grid-template-columns: 1fr 1fr; }
        }
    </style>
</head>
<body>
    <!-- Backgrounds -->
    <div class="bg-base"></div>
    <div class="bg-grid"></div>
    <div class="glow glow-1"></div>
    <div class="glow glow-2"></div>
    <div class="glow glow-3"></div>

    <!-- Side glow lines -->
    <div class="side-glow side-glow-left"></div>
    <div class="side-glow side-glow-right"></div>

    <!-- Particles -->
    <div class="particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <!-- Sparkles -->
    <i class="fas fa-star sparkle"></i>
    <i class="fas fa-star sparkle"></i>
    <i class="fas fa-star sparkle"></i>
    <i class="fas fa-star sparkle"></i>
    <i class="fas fa-star sparkle"></i>
    <i class="fas fa-star sparkle"></i>

    <!-- NAVBAR -->
    <nav class="navbar">
        <a href="/" class="nav-logo">
            <img src="{{ asset('images/logo-sipbar.png') }}" alt="SIPBAR" style="height: 42px; width: auto;">
            <span>SIPBAR</span>
        </a>
        <div class="nav-menu">
            <a href="#alur">Alur</a>
            <a href="#fitur">Fitur</a>
            <a href="#faq">FAQ</a>
            <a href="#kontak">Kontak</a>
        </div>
        <div class="nav-auth">
            @auth
                <a href="{{ Auth::user()->role === 'mahasiswa' ? route('mahasiswa.dashboard') : route('dashboard') }}" class="btn-signup">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-signup">Masuk Dashboard</a>
            @endauth
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-content">
            <h1>
                Kelola Peminjaman<br>
                <span class="c1">Barang Kampus</span><br>
                dengan Mudah
            </h1>
            <p>
                Sistem pintar, aman, dan terintegrasi untuk mengelola, meminjam, serta memantau aset & ruangan kampus dalam satu dashboard.
            </p>
            <div class="hero-buttons">
                <a href="{{ route('login') }}" class="btn-primary">
                    <i class="fas fa-rocket"></i> Mulai Sekarang
                </a>
                <a href="#fitur" class="btn-secondary">
                    <i class="fas fa-book-open"></i> Pelajari Selengkapnya
                </a>
            </div>
        </div>

        <div class="hero-visual">
            <div class="ring-glow"></div>

            <div class="dashboard-mock">
                <div class="mock-header">
                    <span class="mock-dots-1"></span>
                    <span class="mock-dots-2"></span>
                    <span class="mock-dots-3"></span>
                </div>
                <div class="mock-chart">
                    <div class="mock-bar" style="height: 40%;"></div>
                    <div class="mock-bar" style="height: 65%;"></div>
                    <div class="mock-bar" style="height: 85%;"></div>
                    <div class="mock-bar" style="height: 55%;"></div>
                    <div class="mock-bar" style="height: 75%;"></div>
                    <div class="mock-bar" style="height: 95%;"></div>
                    <div class="mock-bar" style="height: 60%;"></div>
                </div>
                <div class="mock-rows">
                    <div class="mock-row" style="width: 70%;"></div>
                    <div class="mock-row" style="width: 50%;"></div>
                    <div class="mock-row" style="width: 85%;"></div>
                </div>
            </div>

            <div class="badge badge-1"><i class="fas fa-shield-halved"></i> Aman</div>
            <div class="badge badge-2"><i class="fas fa-bolt"></i> Cepat</div>
            <div class="badge badge-3"><i class="fas fa-eye"></i> Terpantau</div>
            <div class="badge badge-4"><i class="fas fa-bullseye"></i> Tepat</div>

            <div class="cat-wrapper">
                <img src="{{ asset('images/hero-cat.png') }}" alt="SIPBAR" class="cat-img"
                     onerror="this.style.display='none'; this.parentElement.innerHTML='<div style=\'width:240px;height:240px;border-radius:50%;background:linear-gradient(135deg,#22d3ee,#8b5cf6);display:flex;align-items:center;justify-content:center;font-size:100px;color:white;box-shadow:0 20px 60px rgba(34,211,238,0.5)\'><i class=\'fas fa-robot\'></i></div>';">
            </div>
        </div>
    </section>

        <!-- ALUR -->
    <section class="section-box" id="alur" style="margin-top: 80px;">
        <h2>Cara Kerja SIPBAR</h2>
        <div class="alur-grid">
            <div class="alur-step">
                <div class="alur-num">01</div>
                <div class="alur-icon"><i class="fas fa-search"></i></div>
                <h3>Pilih Barang</h3>
                <p>Cari barang yang ingin dipinjam dari katalog.</p>
            </div>
            <div class="alur-step">
                <div class="alur-num">02</div>
                <div class="alur-icon"><i class="fas fa-paper-plane"></i></div>
                <h3>Ajukan Peminjaman</h3>
                <p>Isi form peminjaman, pilih durasi, dan kirim.</p>
            </div>
            <div class="alur-step">
                <div class="alur-num">03</div>
                <div class="alur-icon"><i class="fas fa-check-circle"></i></div>
                <h3>Verifikasi Admin</h3>
                <p>Admin akan menyetujui atau menolak pengajuan.</p>
            </div>
            <div class="alur-step">
                <div class="alur-num">04</div>
                <div class="alur-icon"><i class="fas fa-hand-holding"></i></div>
                <h3>Serah Terima</h3>
                <p>Petugas menyerahkan barang ke mahasiswa.</p>
            </div>
            <div class="alur-step">
                <div class="alur-num">05</div>
                <div class="alur-icon"><i class="fas fa-undo"></i></div>
                <h3>Pengembalian</h3>
                <p>Kembalikan barang, cek kondisi, dan selesai.</p>
            </div>
        </div>
    </section>

    <!-- FITUR -->
    <section class="section-box" id="fitur">
        <h2>Semua yang Anda Butuhkan</h2>
        <div class="fitur-grid">
            <div class="fitur-card">
                <div class="fitur-icon"><i class="fas fa-box"></i></div>
                <h3>Manajemen Barang</h3>
                <p>Kelola data barang dengan mudah, termasuk stok dan kategori.</p>
            </div>
            <div class="fitur-card">
                <div class="fitur-icon"><i class="fas fa-clipboard-list"></i></div>
                <h3>Peminjaman Ruangan</h3>
                <p>Peminjaman barang atau ruangan, semua tercatat dalam satu dashboard.</p>
            </div>
            <div class="fitur-card">
                <div class="fitur-icon"><i class="fas fa-users"></i></div>
                <h3>Manajemen Pengguna</h3>
                <p>Kelola data pengguna, admin, pegawai, dan mahasiswa di dashboard.</p>
            </div>
            <div class="fitur-card">
                <div class="fitur-icon"><i class="fas fa-bell"></i></div>
                <h3>Riwayat & Notifikasi</h3>
                <p>Catat riwayat peminjaman, aktivitas, notifikasi dari pengguna lain.</p>
            </div>
            <div class="fitur-card">
                <div class="fitur-icon"><i class="fas fa-chart-line"></i></div>
                <h3>Laporan Statistik</h3>
                <p>Laporan detail dan statistik dan visualisasi data peminjaman.</p>
            </div>
        </div>
    </section>

    <!-- FAQ + CTA -->
    <section class="bottom-row">
        <div class="faq-box" id="faq">
            <h3>Pertanyaan Umum</h3>
            <div class="faq-item">
                <div class="faq-q" onclick="toggleFaq(this)">
                    <span>Apa itu Sistem Peminjaman Barang?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-a">
                    Sistem Peminjaman Barang adalah aplikasi berbasis web untuk mengelola peminjaman dan pengembalian barang di lingkungan universitas.
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-q" onclick="toggleFaq(this)">
                    <span>Siapa saja yang bisa menggunakan sistem ini?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-a">
                    Sistem ini digunakan oleh admin/pegawai sebagai pengelola, serta mahasiswa/dosen yang akan meminjam barang.
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-q" onclick="toggleFaq(this)">
                    <span>Bagaimana cara meminjam barang?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-a">
                    Mahasiswa mengajukan peminjaman melalui dashboard, admin memverifikasi, lalu petugas menyerahkan barang.
                </div>
            </div>
        </div>

        <div class="cta-box" id="kontak">
            <div class="cta-content">
                <h3>Siap Memulai?</h3>
                <p>Masuk ke dashboard dan mulai kelola peminjaman barang sekarang.</p>
                <a href="{{ route('login') }}" class="cta-btn">
                    <i class="fas fa-arrow-right"></i> Mulai Sekarang
                </a>
            </div>
            <img src="{{ asset('images/hero-cat.png') }}" alt="SIPBAR" class="cta-cat"
                 onerror="this.style.display='none';">
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-inner">
            <div>
                    <div class="footer-brand" style="display: flex; align-items: center; gap: 10px;">
                        <img src="{{ asset('images/logo-sipbar.png') }}" alt="SIPBAR" style="height: 40px; width: auto;">
                        <span style="font-weight: 800; font-size: 18px; color: #22d3ee;">SIPBAR</span>
                    </div>
                    <p class="footer-desc" style="margin-top: 12px;">
                        Sistem Peminjaman Barang Universitas 
                        mengelola peminjaman barang kampus dengan efisien dan terorganisir.
                    </p>
                </div>
            <div class="footer-col">
                <h4>Navigasi</h4>
                <a href="#fitur">Fitur</a>
                <a href="#faq">FAQ</a>
                <a href="{{ route('login') }}">Login</a>
            </div>
            <div class="footer-col">
                <h4>Fitur</h4>
                <a href="{{ route('login') }}">Barang</a>
                <a href="{{ route('login') }}">Ruangan</a>
                <a href="{{ route('login') }}">Peminjaman</a>
            </div>
            <div class="footer-col">
                <h4>Kontak</h4>
                <a href="#"><i class="fas fa-envelope" style="margin-right: 6px;"></i> admin@univ.ac.id</a>
                <a href="#"><i class="fas fa-phone" style="margin-right: 6px;"></i> (0721) 123-456</a>
                <a href="#"><i class="fas fa-map-marker-alt" style="margin-right: 6px;"></i> Lampung, Indonesia</a>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; 2026 SIPBAR — Sistem Peminjaman Barang. Dibuat oleh Vivian <i class="fas fa-heart" style="color: #22d3ee;"></i>
        </div>
    </footer>

    <script>
        function toggleFaq(el) {
            el.parentElement.classList.toggle('open');
        }
    </script>
</body>
</html>