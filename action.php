<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Meta-tags -->
    <title>Empire - Votre Cité</title>
    <meta name="description" content="Interface principale du jeu de stratégie Empire. Gérez votre cité, vos ressources et vos armées.">
    <meta name="author" content="Empire Game Studio">
    
    <!-- Favicon local -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' fill='%231e3a8a'/><text x='16' y='20' text-anchor='middle' fill='white' font-family='Arial' font-size='18' font-weight='bold'>E</text></svg>" type="image/svg+xml">

    <style>
        /* Styles de base et reset (similaires aux pages précédentes) */
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
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Layout principal du jeu */
        .game-container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header du jeu avec ressources */
        .game-header {
            padding: 0.5rem 2rem;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(148, 163, 184, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
            animation: fadeIn 0.5s ease-out;
        }

        .header-content {
            max-width: 1400px;
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
        }

        .resources {
            display: flex;
            gap: 1.5rem;
            background: rgba(30, 41, 59, 0.7);
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            border: 1px solid rgba(148, 163, 184, 0.2);
        }

        .resource-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
            font-weight: bold;
        }
        .resource-item span {
             color: #fbbf24;
        }

        /* Contenu principal du jeu (sidebar + vue centrale) */
        .game-body {
            display: flex;
            flex-grow: 1;
            max-width: 1400px;
            width: 100%;
            margin: 0 auto;
            padding: 1.5rem 2rem;
            gap: 1.5rem;
        }

        /* Sidebar de navigation */
        .game-sidebar {
            width: 200px;
            flex-shrink: 0;
            background: rgba(15, 23, 42, 0.5);
            padding: 1.5rem;
            border-radius: 1rem;
            border: 1px solid rgba(148, 163, 184, 0.1);
            animation: fadeIn 0.7s ease-out 0.2s both;
        }

        .sidebar-nav ul {
            list-style: none;
        }

        .sidebar-nav li a {
            display: block;
            color: #cbd5e1;
            text-decoration: none;
            padding: 0.75rem 1rem;
            margin-bottom: 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .sidebar-nav li a:hover, .sidebar-nav li a.active {
            color: #fbbf24;
            background: rgba(251, 191, 36, 0.1);
            transform: translateX(5px);
        }

        /* Vue centrale (ville, carte, etc.) */
        .main-view {
            flex-grow: 1;
            animation: fadeIn 0.7s ease-out 0.4s both;
        }

        .city-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 1rem;
            background: rgba(15, 23, 42, 0.5);
            padding: 1.5rem;
            border-radius: 1rem;
            border: 1px solid rgba(148, 163, 184, 0.1);
        }

        .building-slot {
            aspect-ratio: 1 / 1;
            background: rgba(30, 41, 59, 0.8);
            border: 2px dashed rgba(148, 163, 184, 0.2);
            border-radius: 0.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .building-slot:hover {
            border-color: #fbbf24;
            background: rgba(251, 191, 36, 0.1);
        }
        
        .building-slot.occupied {
             border-style: solid;
             border-color: rgba(59, 130, 246, 0.5);
        }

        .building-slot .name {
            font-weight: bold;
            font-size: 0.9rem;
        }
        .building-slot .level {
            font-size: 0.8rem;
            color: #94a3b8;
        }
        .building-slot .icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        /* Panneau d'information (droite) */
        .info-panel {
            width: 280px;
            flex-shrink: 0;
            background: rgba(15, 23, 42, 0.5);
            padding: 1.5rem;
            border-radius: 1rem;
            border: 1px solid rgba(148, 163, 184, 0.1);
            animation: fadeIn 0.7s ease-out 0.6s both;
        }
        .info-panel h3 {
            color: #fbbf24;
            margin-bottom: 1rem;
            border-bottom: 1px solid rgba(148, 163, 184, 0.1);
            padding-bottom: 0.5rem;
        }
        .info-list li {
            list-style: none;
            background: rgba(30, 41, 59, 0.6);
            padding: 0.75rem;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        /* Particules (identique aux pages précédentes) */
        .particles {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: -10;
        }
        .particle {
            position: absolute; width: 2px; height: 2px; background: rgba(251, 191, 36, 0.3); border-radius: 50%; animation: float 6s infinite linear;
        }
        @keyframes float {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100px) rotate(360deg); opacity: 0; }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .game-body {
                flex-direction: column;
            }
            .game-sidebar, .info-panel {
                width: 100%;
            }
        }
         @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }
            .resources {
                flex-wrap: wrap;
                justify-content: center;
            }
        }

    </style>
</head>
<body>
    <div class="particles" id="particles"></div>

    <div class="game-container">
        <!-- En-tête du jeu -->
        <header class="game-header">
            <div class="header-content">
                <h1 class="logo">EMPIRE</h1>
                <div class="resources">
                    <div class="resource-item" title="Bois">🌲 <span>10,540</span></div>
                    <div class="resource-item" title="Pierre">⛰️ <span>8,210</span></div>
                    <div class="resource-item" title="Or">💰 <span>1,500</span></div>
                    <div class="resource-item" title="Population">👥 <span>150 / 200</span></div>
                </div>
                <div class="user-actions">
                    <!-- Ici on pourrait mettre un menu pour les options, déconnexion etc. -->
                </div>
            </div>
        </header>

        <!-- Corps principal du jeu -->
        <main class="game-body">
            <!-- Barre de navigation latérale -->
            <aside class="game-sidebar">
                <nav class="sidebar-nav">
                    <ul>
                        <li><a href="?view=city" class="active">🏛️ Cité</a></li>
                        <li><a href="?view=island">🏝️ Île</a></li>
                        <li><a href="?view=world">🌍 Monde</a></li>
                        <li><a href="#">⚔️ Armées</a></li>
                        <li><a href="#">📊 Rapports</a></li>
                        <li><a href="#">✉️ Messages</a></li>
                        <li><a href="?view=options">⚙️ Options</a></li>
                    </ul>
                </nav>
            </aside>

            <!-- Vue principale (ici, la ville) -->
            <section class="main-view">
                <div class="city-grid">
                    <!-- Bâtiments existants -->
                    <div class="building-slot occupied">
                        <div class="icon">🏛️</div>
                        <div class="name">Hôtel de Ville</div>
                        <div class="level">Niv. 3</div>
                    </div>
                    <div class="building-slot occupied">
                         <div class="icon">⚔️</div>
                        <div class="name">Caserne</div>
                        <div class="level">Niv. 1</div>
                    </div>
                    <div class="building-slot occupied">
                         <div class="icon">🏘️</div>
                        <div class="name">Ferme</div>
                        <div class="level">Niv. 2</div>
                    </div>
                     <div class="building-slot occupied">
                         <div class="icon">🧱</div>
                        <div class="name">Entrepôt</div>
                        <div class="level">Niv. 2</div>
                    </div>

                    <!-- Emplacements vides -->
                    <div class="building-slot"><div class="name">+ Construire</div></div>
                    <div class="building-slot"><div class="name">+ Construire</div></div>
                    <div class="building-slot"><div class="name">+ Construire</div></div>
                    <div class="building-slot"><div class="name">+ Construire</div></div>
                    <div class="building-slot"><div class="name">+ Construire</div></div>
                    <div class="building-slot"><div class="name">+ Construire</div></div>
                    <div class="building-slot"><div class="name">+ Construire</div></div>
                    <div class="building-slot"><div class="name">+ Construire</div></div>
                </div>
            </section>

            <!-- Panneau d'informations -->
            <aside class="info-panel">
                <h3>Constructions</h3>
                <ul class="info-list">
                    <li>Scierie (Niv. 3) - 00:15:32</li>
                    <li>Marché (Niv. 1) - 01:05:10</li>
                </ul>

                <h3>Unités en formation</h3>
                 <ul class="info-list">
                    <li>10x Hoplite - 00:05:20</li>
                </ul>
            </aside>
        </main>
    </div>

    <script>
        // Script pour les particules (identique aux pages précédentes)
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
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Meta-tags -->
    <title>Empire - Votre Cité</title>
    <meta name="description" content="Interface principale du jeu de stratégie Empire. Gérez votre cité, vos ressources et vos armées.">
    <meta name="author" content="Empire Game Studio">
    
    <!-- Favicon local -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' fill='%231e3a8a'/><text x='16' y='20' text-anchor='middle' fill='white' font-family='Arial' font-size='18' font-weight='bold'>E</text></svg>" type="image/svg+xml">

    <style>
        /* Styles de base et reset (similaires aux pages précédentes) */
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
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Layout principal du jeu */
        .game-container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header du jeu avec ressources */
        .game-header {
            padding: 0.5rem 2rem;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(148, 163, 184, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
            animation: fadeIn 0.5s ease-out;
        }

        .header-content {
            max-width: 1400px;
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
        }

        .resources {
            display: flex;
            gap: 1.5rem;
            background: rgba(30, 41, 59, 0.7);
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            border: 1px solid rgba(148, 163, 184, 0.2);
        }

        .resource-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
            font-weight: bold;
        }
        .resource-item span {
             color: #fbbf24;
        }

        /* Contenu principal du jeu (sidebar + vue centrale) */
        .game-body {
            display: flex;
            flex-grow: 1;
            max-width: 1400px;
            width: 100%;
            margin: 0 auto;
            padding: 1.5rem 2rem;
            gap: 1.5rem;
        }

        /* Sidebar de navigation */
        .game-sidebar {
            width: 200px;
            flex-shrink: 0;
            background: rgba(15, 23, 42, 0.5);
            padding: 1.5rem;
            border-radius: 1rem;
            border: 1px solid rgba(148, 163, 184, 0.1);
            animation: fadeIn 0.7s ease-out 0.2s both;
        }

        .sidebar-nav ul {
            list-style: none;
        }

        .sidebar-nav li a {
            display: block;
            color: #cbd5e1;
            text-decoration: none;
            padding: 0.75rem 1rem;
            margin-bottom: 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .sidebar-nav li a:hover, .sidebar-nav li a.active {
            color: #fbbf24;
            background: rgba(251, 191, 36, 0.1);
            transform: translateX(5px);
        }

        /* Vue centrale (ville, carte, etc.) */
        .main-view {
            flex-grow: 1;
            animation: fadeIn 0.7s ease-out 0.4s both;
        }

        .city-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 1rem;
            background: rgba(15, 23, 42, 0.5);
            padding: 1.5rem;
            border-radius: 1rem;
            border: 1px solid rgba(148, 163, 184, 0.1);
        }

        .building-slot {
            aspect-ratio: 1 / 1;
            background: rgba(30, 41, 59, 0.8);
            border: 2px dashed rgba(148, 163, 184, 0.2);
            border-radius: 0.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .building-slot:hover {
            border-color: #fbbf24;
            background: rgba(251, 191, 36, 0.1);
        }
        
        .building-slot.occupied {
             border-style: solid;
             border-color: rgba(59, 130, 246, 0.5);
        }

        .building-slot .name {
            font-weight: bold;
            font-size: 0.9rem;
        }
        .building-slot .level {
            font-size: 0.8rem;
            color: #94a3b8;
        }
        .building-slot .icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        /* Panneau d'information (droite) */
        .info-panel {
            width: 280px;
            flex-shrink: 0;
            background: rgba(15, 23, 42, 0.5);
            padding: 1.5rem;
            border-radius: 1rem;
            border: 1px solid rgba(148, 163, 184, 0.1);
            animation: fadeIn 0.7s ease-out 0.6s both;
        }
        .info-panel h3 {
            color: #fbbf24;
            margin-bottom: 1rem;
            border-bottom: 1px solid rgba(148, 163, 184, 0.1);
            padding-bottom: 0.5rem;
        }
        .info-list li {
            list-style: none;
            background: rgba(30, 41, 59, 0.6);
            padding: 0.75rem;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        /* Particules (identique aux pages précédentes) */
        .particles {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: -10;
        }
        .particle {
            position: absolute; width: 2px; height: 2px; background: rgba(251, 191, 36, 0.3); border-radius: 50%; animation: float 6s infinite linear;
        }
        @keyframes float {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100px) rotate(360deg); opacity: 0; }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .game-body {
                flex-direction: column;
            }
            .game-sidebar, .info-panel {
                width: 100%;
            }
        }
         @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }
            .resources {
                flex-wrap: wrap;
                justify-content: center;
            }
        }

    </style>
</head>
<body>
    <div class="particles" id="particles"></div>

    <div class="game-container">
        <!-- En-tête du jeu -->
        <header class="game-header">
            <div class="header-content">
                <h1 class="logo">EMPIRE</h1>
                <div class="resources">
                    <div class="resource-item" title="Bois">🌲 <span>10,540</span></div>
                    <div class="resource-item" title="Pierre">⛰️ <span>8,210</span></div>
                    <div class="resource-item" title="Or">💰 <span>1,500</span></div>
                    <div class="resource-item" title="Population">👥 <span>150 / 200</span></div>
                </div>
                <div class="user-actions">
                    <!-- Ici on pourrait mettre un menu pour les options, déconnexion etc. -->
                </div>
            </div>
        </header>

        <!-- Corps principal du jeu -->
        <main class="game-body">
            <!-- Barre de navigation latérale -->
            <aside class="game-sidebar">
                <nav class="sidebar-nav">
                    <ul>
                        <li><a href="?view=city" class="active">🏛️ Cité</a></li>
                        <li><a href="?view=island">🏝️ Île</a></li>
                        <li><a href="?view=world">🌍 Monde</a></li>
                        <li><a href="#">⚔️ Armées</a></li>
                        <li><a href="#">📊 Rapports</a></li>
                        <li><a href="#">✉️ Messages</a></li>
                        <li><a href="?view=options">⚙️ Options</a></li>
                    </ul>
                </nav>
            </aside>

            <!-- Vue principale (ici, la ville) -->
            <section class="main-view">
                <div class="city-grid">
                    <!-- Bâtiments existants -->
                    <div class="building-slot occupied">
                        <div class="icon">🏛️</div>
                        <div class="name">Hôtel de Ville</div>
                        <div class="level">Niv. 3</div>
                    </div>
                    <div class="building-slot occupied">
                         <div class="icon">⚔️</div>
                        <div class="name">Caserne</div>
                        <div class="level">Niv. 1</div>
                    </div>
                    <div class="building-slot occupied">
                         <div class="icon">🏘️</div>
                        <div class="name">Ferme</div>
                        <div class="level">Niv. 2</div>
                    </div>
                     <div class="building-slot occupied">
                         <div class="icon">🧱</div>
                        <div class="name">Entrepôt</div>
                        <div class="level">Niv. 2</div>
                    </div>

                    <!-- Emplacements vides -->
                    <div class="building-slot"><div class="name">+ Construire</div></div>
                    <div class="building-slot"><div class="name">+ Construire</div></div>
                    <div class="building-slot"><div class="name">+ Construire</div></div>
                    <div class="building-slot"><div class="name">+ Construire</div></div>
                    <div class="building-slot"><div class="name">+ Construire</div></div>
                    <div class="building-slot"><div class="name">+ Construire</div></div>
                    <div class="building-slot"><div class="name">+ Construire</div></div>
                    <div class="building-slot"><div class="name">+ Construire</div></div>
                </div>
            </section>

            <!-- Panneau d'informations -->
            <aside class="info-panel">
                <h3>Constructions</h3>
                <ul class="info-list">
                    <li>Scierie (Niv. 3) - 00:15:32</li>
                    <li>Marché (Niv. 1) - 01:05:10</li>
                </ul>

                <h3>Unités en formation</h3>
                 <ul class="info-list">
                    <li>10x Hoplite - 00:05:20</li>
                </ul>
            </aside>
        </main>
    </div>

    <script>
        // Script pour les particules (identique aux pages précédentes)
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
