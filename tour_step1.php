<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Meta-tags pour le référencement et l'information -->
    <title>Visite du jeu - Empire</title>
    <meta name="description" content="Découvrez les fonctionnalités principales du jeu de stratégie Empire. Apprenez à construire votre cité, explorer le monde et forger des alliances.">
    <meta name="keywords" content="visite du jeu, tutoriel, comment jouer, jeu de stratégie, empire">
    <meta name="author" content="Empire Game Studio">
    
    <!-- Favicon local -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' fill='%231e3a8a'/><text x='16' y='20' text-anchor='middle' fill='white' font-family='Arial' font-size='18' font-weight='bold'>E</text></svg>" type="image/svg+xml">

    <style>
        /* Styles de base, reset et animations */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #0a192f 0%, #1e3a8a 100%);
            color: #e2e8f0;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideIn {
            from { transform: translateX(-100%); }
            to { transform: translateX(0); }
        }

        /* Header */
        .header {
            padding: 1rem 2rem;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(148, 163, 184, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 2rem;
            font-weight: 900;
            color: #fbbf24;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            animation: slideIn 1s ease-out;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .nav-links a {
            color: #cbd5e1;
            text-decoration: none;
            transition: color 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
        }

        .nav-links a:hover {
            color: #fbbf24;
            background: rgba(251, 191, 36, 0.1);
        }

        /* Contenu principal */
        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 4rem 2rem;
        }

        .content-container {
            width: 100%;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(10px);
            padding: 2.5rem;
            border-radius: 1rem;
            border: 1px solid rgba(148, 163, 184, 0.1);
            animation: fadeIn 1s ease-out 0.5s both;
        }

        .content-title {
            font-size: 2.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 1rem;
            color: #fbbf24;
        }
        
        .content-intro {
            text-align: center;
            margin-bottom: 3rem;
            color: #94a3b8;
            font-size: 1.1rem;
            line-height: 1.6;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .feature-card {
            background: rgba(30, 41, 59, 0.8);
            border: 1px solid rgba(148, 163, 184, 0.2);
            border-radius: 0.5rem;
            padding: 1.5rem;
            text-align: center;
        }
        
        .feature-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }
        
        .feature-card h3 {
            font-size: 1.5rem;
            color: #fbbf24;
            margin-bottom: 0.5rem;
        }
        
        .feature-card p {
            color: #94a3b8;
            line-height: 1.5;
        }

        /* Footer */
        .footer {
            background: rgba(15, 23, 42, 0.9);
            padding: 2rem;
            text-align: center;
            border-top: 1px solid rgba(148, 163, 184, 0.1);
        }
        .footer-content {
            color: #64748b;
        }
        
        /* Particules */
        .particles { position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: -10; }
        .particle { position: absolute; width: 2px; height: 2px; background: rgba(251, 191, 36, 0.3); border-radius: 50%; animation: float 6s infinite linear; }
        @keyframes float {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100px) rotate(360deg); opacity: 0; }
        }
    </style>
</head>
<body>
    <div class="particles" id="particles"></div>

    <!-- En-tête -->
    <header class="header">
        <div class="nav-container">
            <a href="index.html" class="logo">EMPIRE</a>
            <nav class="nav-links">
                <a href="index.html">Connexion</a>
                <a href="register.html">Inscription</a>
                <a href="tour.html" style="color: #fbbf24;">Visite du jeu</a>
                <a href="#" target="_blank">Forum</a>
            </nav>
        </div>
    </header>

    <!-- Contenu Principal -->
    <main class="main-content">
        <div class="content-container">
            <h1 class="content-title">Visite du jeu</h1>
            <p class="content-intro">
                Bienvenue, futur empereur ! Découvrez les piliers qui soutiendront votre règne et vous mèneront à la gloire.
            </p>
            
            <div class="features-grid">
                <div class="feature-card">
                    <img src="https://placehold.co/600x400/1e3a8a/fbbf24?text=Bâtissez" alt="Illustration d'une cité antique">
                    <h3>Bâtissez votre Cité</h3>
                    <p>Développez votre humble village en une métropole prospère. Construisez des casernes, des académies et des marchés pour subvenir aux besoins de votre peuple et de vos armées.</p>
                </div>
                <div class="feature-card">
                    <img src="https://placehold.co/600x400/1e3a8a/fbbf24?text=Explorez" alt="Illustration d'une carte du monde">
                    <h3>Explorez le Monde</h3>
                    <p>Le monde est vaste et rempli de ressources précieuses et d'îles à découvrir. Envoyez vos navires et vos espions pour cartographier les environs et trouver de nouvelles opportunités.</p>
                </div>
                <div class="feature-card">
                    <img src="https://placehold.co/600x400/1e3a8a/fbbf24?text=Conquérez" alt="Illustration de soldats antiques">
                    <h3>Forgez des Alliances</h3>
                    <p>Vous n'êtes pas seul. Formez de puissantes alliances avec d'autres joueurs pour échanger des ressources, coordonner des attaques et dominer le monde ensemble.</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Pied de page -->
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2024 Empire - Tous droits réservés.</p>
        </div>
    </footer>

    <script>
        // Script pour les particules
        document.addEventListener('DOMContentLoaded', function() {
            const particlesContainer = document.getElementById('particles');
            if (!particlesContainer) return;
            const particleCount = 50;
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 6 + 's';
                particle.style.animationDuration = (Math.random() * 3 + 3) + 's';
                particlesContainer.appendChild(particle);
            }
        });
    </script>
</body>
</html>
