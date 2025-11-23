<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil!</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('image/bps.png') }}" type="image/x-icon">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            overflow-x: hidden;
            position: relative;
            padding: 20px;
        }

        /* Animated Background Gradient */
        body::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 20% 50%, rgba(102, 126, 234, 0.3) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(118, 75, 162, 0.3) 0%, transparent 50%);
            animation: gradientMove 10s ease infinite;
        }

        @keyframes gradientMove {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(-50px, -50px); }
        }

        /* Success Container - OPTIMIZED FOR ALL SCREENS */
        .success-container {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            padding: 60px 70px;
            border-radius: 30px;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.25);
            text-align: center;
            max-width: 700px;
            width: 100%;
            position: relative;
            z-index: 10;
            animation: slideUpFade 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
            opacity: 0;
            transform: translateY(50px);
        }

        @keyframes slideUpFade {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Success Icon Circle */
        .success-icon-wrapper {
            width: 140px;
            height: 140px;
            margin: 0 auto 30px;
            position: relative;
            animation: scaleIn 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) 0.3s forwards;
            transform: scale(0);
        }

        @keyframes scaleIn {
            0% { transform: scale(0) rotate(-180deg); }
            60% { transform: scale(1.1) rotate(10deg); }
            100% { transform: scale(1) rotate(0deg); }
        }

        .success-icon-circle {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 15px 40px rgba(16, 185, 129, 0.4);
            position: relative;
        }

        .success-icon-circle::before {
            content: '';
            position: absolute;
            width: 120%;
            height: 120%;
            background: inherit;
            border-radius: 50%;
            opacity: 0.2;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.2; }
            50% { transform: scale(1.1); opacity: 0; }
        }

        .success-icon {
            font-size: 5rem;
            color: white;
            animation: checkmarkDraw 0.5s ease 0.8s forwards;
            opacity: 0;
        }

        @keyframes checkmarkDraw {
            to { opacity: 1; }
        }

        /* Text Content */
        h1 {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            animation: fadeIn 0.8s ease 0.5s forwards;
            opacity: 0;
        }

        @keyframes fadeIn {
            to { opacity: 1; }
        }

        .subtitle {
            color: #6b7280;
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 15px;
            animation: fadeIn 0.8s ease 0.7s forwards;
            opacity: 0;
        }

        .info-text {
            color: #9ca3af;
            font-size: 0.95rem;
            margin-bottom: 40px;
            animation: fadeIn 0.8s ease 0.9s forwards;
            opacity: 0;
        }

        /* Info Cards */
        .info-cards {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 40px;
            animation: fadeIn 0.8s ease 1s forwards;
            opacity: 0;
        }

        .info-card {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            padding: 24px 20px;
            border-radius: 16px;
            border: 2px solid rgba(102, 126, 234, 0.2);
            transition: all 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-5px);
            border-color: rgba(102, 126, 234, 0.4);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.2);
        }

        .info-card-icon {
            font-size: 2.2rem;
            margin-bottom: 12px;
        }

        .info-card-title {
            font-size: 0.85rem;
            color: #6b7280;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .info-card-value {
            font-size: 1.1rem;
            color: #667eea;
            font-weight: 700;
        }

        .info-card-link {
            text-decoration: none;
            display: block;
            cursor: pointer;
        }

        .info-card-link:hover .info-card {
            transform: translateY(-5px) rotate(2deg);
            border-color: rgba(102, 126, 234, 0.4);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.2);
        }

        /* Buttons */
        .button-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            animation: fadeIn 0.8s ease 1.2s forwards;
            opacity: 0;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 16px 32px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            position: relative;
            overflow: hidden;
            flex: 1;
            max-width: 250px;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            transition: left 0.3s ease;
            z-index: -1;
        }

        .btn-primary:hover::before {
            left: 0;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.6);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 16px 32px;
            background: rgba(255, 255, 255, 0.5);
            color: #667eea;
            text-decoration: none;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid rgba(102, 126, 234, 0.3);
            flex: 1;
            max-width: 250px;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.8);
            border-color: rgba(102, 126, 234, 0.5);
            transform: translateY(-3px);
        }

        /* Confetti & Particles */
        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background: #667eea;
            pointer-events: none;
            animation: confettiFall linear forwards;
            opacity: 0;
        }

        @keyframes confettiFall {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotate(720deg);
                opacity: 0;
            }
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            opacity: 0;
            animation: floatUp 6s ease-out forwards;
        }

        @keyframes floatUp {
            0% {
                transform: translateY(0) scale(0);
                opacity: 0;
            }
            20% {
                opacity: 0.8;
            }
            100% {
                transform: translateY(-300px) scale(1.5);
                opacity: 0;
            }
        }

        .star {
            position: absolute;
            font-size: 1.5rem;
            animation: starTwinkle 2s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes starTwinkle {
            0%, 100% { 
                opacity: 0.3; 
                transform: scale(1);
            }
            50% { 
                opacity: 1; 
                transform: scale(1.2);
            }
        }

        /* OPTIMIZED RESPONSIVE DESIGN */
        
        /* Large Desktop (1366x768 and above) - PERFECT! */
        @media (min-width: 1200px) {
            .success-container {
                max-width: 700px;
                padding: 60px 70px;
            }
        }

        /* Medium Desktop & Laptop (1024-1366px) */
        @media (max-width: 1366px) and (min-width: 1024px) {
            .success-container {
                max-width: 650px;
                padding: 50px 60px;
            }
            
            h1 {
                font-size: 2.3rem;
            }
        }

        /* Tablet Landscape (768-1024px) */
        @media (max-width: 1024px) and (min-width: 768px) {
            body {
                padding: 30px 20px;
            }
            
            .success-container {
                max-width: 600px;
                padding: 45px 50px;
            }

            .success-icon-wrapper {
                width: 120px;
                height: 120px;
            }

            .success-icon {
                font-size: 4.5rem;
            }

            h1 {
                font-size: 2.2rem;
            }

            .subtitle {
                font-size: 1.05rem;
            }

            .info-cards {
                gap: 15px;
            }

            .button-group {
                gap: 12px;
            }
        }

        /* Tablet Portrait (600-768px) */
        @media (max-width: 768px) {
            body {
                padding: 20px 15px;
            }
            
            .success-container {
                padding: 40px 35px;
                border-radius: 25px;
            }

            .success-icon-wrapper {
                width: 110px;
                height: 110px;
            }

            .success-icon {
                font-size: 4rem;
            }

            h1 {
                font-size: 2rem;
                margin-bottom: 18px;
            }

            .subtitle {
                font-size: 1rem;
                margin-bottom: 12px;
            }

            .info-text {
                font-size: 0.9rem;
                margin-bottom: 30px;
            }

            .info-cards {
                gap: 12px;
                margin-bottom: 30px;
            }

            .info-card {
                padding: 20px 18px;
            }

            .info-card-icon {
                font-size: 2rem;
            }

            .button-group {
                flex-direction: column;
                gap: 12px;
            }

            .btn-primary,
            .btn-secondary {
                width: 100%;
                max-width: 100%;
                padding: 14px 28px;
            }
        }

        /* Mobile Large (480-600px) */
        @media (max-width: 600px) {
            .success-container {
                padding: 35px 28px;
            }

            h1 {
                font-size: 1.85rem;
            }

            .info-cards {
                grid-template-columns: 1fr;
                gap: 10px;
            }
        }

        /* Mobile Standard (375-480px) */
        @media (max-width: 480px) {
            body {
                padding: 15px 10px;
            }
            
            .success-container {
                padding: 30px 24px;
                border-radius: 20px;
            }

            .success-icon-wrapper {
                width: 90px;
                height: 90px;
                margin-bottom: 25px;
            }

            .success-icon {
                font-size: 3.5rem;
            }

            h1 {
                font-size: 1.75rem;
                margin-bottom: 15px;
            }

            .subtitle {
                font-size: 0.95rem;
                line-height: 1.6;
            }

            .info-text {
                font-size: 0.85rem;
                margin-bottom: 25px;
            }

            .info-card {
                padding: 18px 16px;
            }

            .info-card-icon {
                font-size: 1.8rem;
                margin-bottom: 10px;
            }

            .info-card-title {
                font-size: 0.8rem;
            }

            .info-card-value {
                font-size: 1rem;
            }

            .btn-primary,
            .btn-secondary {
                padding: 13px 24px;
                font-size: 0.95rem;
            }

            .star {
                font-size: 1.2rem;
            }
        }

        /* Mobile Small (< 375px) */
        @media (max-width: 375px) {
            .success-container {
                padding: 25px 20px;
            }

            h1 {
                font-size: 1.6rem;
            }

            .success-icon-wrapper {
                width: 80px;
                height: 80px;
            }

            .success-icon {
                font-size: 3rem;
            }

            .subtitle {
                font-size: 0.9rem;
            }

            .info-card {
                padding: 16px 14px;
            }

            .btn-primary,
            .btn-secondary {
                padding: 12px 20px;
                font-size: 0.9rem;
            }
        }

        /* Landscape Mobile Fix */
        @media (max-height: 600px) and (orientation: landscape) {
            body {
                padding: 15px 10px;
            }
            
            .success-container {
                padding: 25px 30px;
                margin: 10px auto;
            }

            .success-icon-wrapper {
                width: 80px;
                height: 80px;
                margin-bottom: 15px;
            }

            .success-icon {
                font-size: 3rem;
            }

            h1 {
                font-size: 1.6rem;
                margin-bottom: 12px;
            }

            .subtitle,
            .info-text {
                font-size: 0.85rem;
                margin-bottom: 10px;
            }

            .info-cards {
                margin-bottom: 20px;
                gap: 10px;
            }

            .info-card {
                padding: 12px 15px;
            }

            .info-card-icon {
                font-size: 1.5rem;
                margin-bottom: 6px;
            }
        }
    </style>
</head>
<body>
    <!-- Stars for celebration -->
    <div class="star" style="top: 10%; left: 15%; animation-delay: 0s;">⭐</div>
    <div class="star" style="top: 15%; right: 20%; animation-delay: 0.5s;">✨</div>
    <div class="star" style="bottom: 20%; left: 10%; animation-delay: 1s;">⭐</div>
    <div class="star" style="bottom: 15%; right: 15%; animation-delay: 1.5s;">✨</div>

    <div class="success-container">
        <!-- Success Icon -->
        <div class="success-icon-wrapper">
            <div class="success-icon-circle">
                <div class="success-icon">✓</div>
            </div>
        </div>

        <!-- Text Content -->
        <h1> Pendaftaran Berhasil!</h1>
        <p class="subtitle">
            Terima kasih telah mendaftar PKL di Badan Pusat Statistik. Data Anda telah kami terima dan akan segera kami proses.
        </p>
        <p class="info-text">
            Mohon menunggu informasi selanjutnya dari kami melalui email yang terdaftar.
        </p>

        <!-- Info Cards -->
        <div class="info-cards">
            <a href="{{ route('profile') }}" class="info-card-link">
                <div class="info-card">
                    <div class="info-card-icon">📧</div>
                    <div class="info-card-title">Cek Notifikasi di Email anda</div>
                    <div class="info-card-value">1-2 Hari Kerja</div>
                </div>
            </a>
            <div class="info-card">
                <div class="info-card-icon">📱</div>
                <div class="info-card-title">Status Pendaftaran</div>
                <div class="info-card-value">Diproses</div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="button-group">
            <a href="/" class="btn-primary">
                🏠 Kembali ke Beranda
            </a>
            <a href="{{ route('informasi') }}" class="btn-secondary">
                📖 Lihat Informasi
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const body = document.body;
            const colors = ['#667eea', '#764ba2', '#10b981', '#f59e0b', '#ef4444'];
            
            // Generate floating particles (reduced for mobile performance)
            const particleCount = window.innerWidth < 768 ? 10 : 20;
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                
                const x = Math.random() * window.innerWidth;
                const y = window.innerHeight + Math.random() * 100;
                particle.style.left = `${x}px`;
                particle.style.top = `${y}px`;
                
                const size = Math.random() * 8 + 4;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                
                const color = colors[Math.floor(Math.random() * colors.length)];
                particle.style.background = color;
                particle.style.boxShadow = `0 0 10px ${color}`;
                
                const duration = Math.random() * 3 + 4;
                particle.style.animationDuration = `${duration}s`;
                
                const delay = Math.random() * 2;
                particle.style.animationDelay = `${delay}s`;
                
                body.appendChild(particle);
            }

            // Create confetti celebration (reduced for mobile)
            const confettiColors = ['#667eea', '#764ba2', '#10b981', '#f59e0b', '#ef4444', '#ec4899', '#8b5cf6'];
            
            function createConfetti() {
                const confettiCount = window.innerWidth < 768 ? 30 : 50;
                for (let i = 0; i < confettiCount; i++) {
                    setTimeout(() => {
                        const confetti = document.createElement('div');
                        confetti.classList.add('confetti');
                        
                        const x = Math.random() * window.innerWidth;
                        confetti.style.left = `${x}px`;
                        confetti.style.top = '-10px';
                        
                        const color = confettiColors[Math.floor(Math.random() * confettiColors.length)];
                        confetti.style.background = color;
                        
                        const size = Math.random() * 8 + 4;
                        confetti.style.width = `${size}px`;
                        confetti.style.height = `${size}px`;
                        
                        const duration = Math.random() * 2 + 3;
                        confetti.style.animationDuration = `${duration}s`;
                        
                        body.appendChild(confetti);
                        
                        setTimeout(() => confetti.remove(), duration * 1000);
                    }, i * 30);
                }
            }

            setTimeout(createConfetti, 800);

            // Button hover effects
            const buttons = document.querySelectorAll('.btn-primary, .btn-secondary');
            buttons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-3px) scale(1.02)';
                });
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Info cards hover effect
            const cards = document.querySelectorAll('.info-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px) rotate(2deg)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) rotate(0deg)';
                });
            });
        });
    </script>
</body>
</html>