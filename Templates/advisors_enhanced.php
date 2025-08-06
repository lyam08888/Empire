<?php
if(!isset($_SESSION['sessid']))
    header("Location: ../index.html");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empire - Conseil Impérial</title>
    <link href="css/common.css" rel="stylesheet" type="text/css" media="screen">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #581c87 0%, #1e1b4b 100%);
            font-family: 'Arial', sans-serif;
            color: #e2e8f0;
            overflow-x: hidden;
        }

        .advisors-container {
            position: relative;
            min-height: 100vh;
            background: 
                radial-gradient(circle at 30% 70%, rgba(147, 51, 234, 0.1) 0%, transparent 50%),
                linear-gradient(135deg, #581c87 0%, #1e1b4b 100%);
        }

        .advisors-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 80px;
            background: rgba(30, 27, 75, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(147, 51, 234, 0.3);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
        }

        .advisors-title {
            font-size: 1.8rem;
            font-weight: bold;
            color: #a855f7;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .advisors-nav {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .nav-btn {
            background: linear-gradient(135deg, #a855f7, #9333ea);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-block;
        }

        .nav-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(168, 85, 247, 0.4);
        }

        .advisors-main {
            margin-top: 80px;
            padding: 2rem;
            min-height: calc(100vh - 80px);
        }

        .council-chamber {
            background: rgba(30, 27, 75, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            border: 1px solid rgba(147, 51, 234, 0.3);
            padding: 2rem;
            margin-bottom: 2rem;
            text-align: center;
        }

        .chamber-title {
            font-size: 2rem;
            font-weight: bold;
            color: #a855f7;
            margin-bottom: 1rem;
        }

        .chamber-subtitle {
            font-size: 1.1rem;
            color: #94a3b8;
            margin-bottom: 2rem;
        }

        .advisors-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .advisor-card {
            background: rgba(15, 23, 42, 0.8);
            border: 2px solid rgba(147, 51, 234, 0.3);
            border-radius: 1rem;
            padding: 2rem;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .advisor-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(147, 51, 234, 0.3);
            border-color: #fbbf24;
        }

        .advisor-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #a855f7, #fbbf24);
        }

        .advisor-portrait {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-size: cover;
            background-position: center;
            margin: 0 auto 1.5rem;
            border: 4px solid #a855f7;
            box-shadow: 0 0 30px rgba(168, 85, 247, 0.4);
            position: relative;
        }

        .advisor-status {
            position: absolute;
            bottom: 5px;
            right: 5px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid white;
        }

        .status-available { background-color: #10b981; }
        .status-busy { background-color: #f59e0b; }
        .status-away { background-color: #ef4444; }

        .advisor-name {
            font-size: 1.3rem;
            font-weight: bold;
            color: #e2e8f0;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .advisor-title {
            font-size: 1rem;
            color: #a855f7;
            text-align: center;
            margin-bottom: 1rem;
            font-style: italic;
        }

        .advisor-specialties {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .specialty-tag {
            background: rgba(168, 85, 247, 0.2);
            color: #a855f7;
            padding: 0.3rem 0.8rem;
            border-radius: 1rem;
            font-size: 0.8rem;
            border: 1px solid rgba(168, 85, 247, 0.3);
        }

        .advisor-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: #10b981;
            display: block;
        }

        .stat-label {
            font-size: 0.8rem;
            color: #94a3b8;
        }

        .advisor-actions {
            display: flex;
            gap: 0.5rem;
        }

        .advisor-btn {
            flex: 1;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .advisor-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(99, 102, 241, 0.4);
        }

        .advisor-btn.primary {
            background: linear-gradient(135deg, #a855f7, #9333ea);
        }

        .advisor-btn.primary:hover {
            box-shadow: 0 5px 15px rgba(168, 85, 247, 0.4);
        }

        .advisor-description {
            font-size: 0.9rem;
            color: #94a3b8;
            text-align: center;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        /* Portraits spécifiques pour chaque conseiller */
        .advisor-military .advisor-portrait { 
            background-image: url('../Romain/Quintus_Cornelius_Crassus_asset_pack/legatus_homme_bust.png');
            border-color: #ef4444;
            box-shadow: 0 0 30px rgba(239, 68, 68, 0.4);
        }
        
        .advisor-economic .advisor-portrait { 
            background-image: url('../Romain/Lucius_Cornelius_Crassus_asset_pack/patrician_male_homme_bust.png');
            border-color: #10b981;
            box-shadow: 0 0 30px rgba(16, 185, 129, 0.4);
        }
        
        .advisor-diplomatic .advisor-portrait { 
            background-image: url('../Romain/Valeria_Drusilla_asset_pack/patrician_female_femme_bust.png');
            border-color: #3b82f6;
            box-shadow: 0 0 30px rgba(59, 130, 246, 0.4);
        }
        
        .advisor-research .advisor-portrait { 
            background-image: url('../Romain/Fabia_Maxima_asset_pack/vestal_femme_bust.png');
            border-color: #8b5cf6;
            box-shadow: 0 0 30px rgba(139, 92, 246, 0.4);
        }
        
        .advisor-construction .advisor-portrait { 
            background-image: url('../Romain/Titus_Fabius_Brutus_asset_pack/plebeian_male_homme_bust.png');
            border-color: #f59e0b;
            box-shadow: 0 0 30px rgba(245, 158, 11, 0.4);
        }
        
        .advisor-espionage .advisor-portrait { 
            background-image: url('../Romain/Decimus_Fabius_Magnus_asset_pack/gladiator_homme_bust.png');
            border-color: #6b7280;
            box-shadow: 0 0 30px rgba(107, 114, 128, 0.4);
        }

        .council-decisions {
            background: rgba(15, 23, 42, 0.8);
            border-radius: 1rem;
            border: 1px solid rgba(147, 51, 234, 0.3);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .decisions-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #a855f7;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .decision-item {
            background: rgba(30, 27, 75, 0.6);
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border-left: 4px solid #a855f7;
        }

        .decision-title {
            font-weight: bold;
            color: #e2e8f0;
            margin-bottom: 0.5rem;
        }

        .decision-description {
            color: #94a3b8;
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .decision-options {
            display: flex;
            gap: 1rem;
        }

        .decision-btn {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.3rem;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .decision-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(16, 185, 129, 0.4);
        }

        .decision-btn.reject {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        .decision-btn.reject:hover {
            box-shadow: 0 3px 10px rgba(239, 68, 68, 0.4);
        }

        .recent-reports {
            background: rgba(15, 23, 42, 0.8);
            border-radius: 1rem;
            border: 1px solid rgba(147, 51, 234, 0.3);
            padding: 2rem;
        }

        .reports-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #a855f7;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .report-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            background: rgba(30, 27, 75, 0.6);
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .report-item:hover {
            background: rgba(30, 27, 75, 0.8);
            transform: translateX(5px);
        }

        .report-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-size: cover;
            background-position: center;
            margin-right: 1rem;
            border: 2px solid #a855f7;
        }

        .report-content {
            flex: 1;
        }

        .report-title {
            font-weight: bold;
            color: #e2e8f0;
            margin-bottom: 0.3rem;
        }

        .report-description {
            font-size: 0.9rem;
            color: #94a3b8;
        }

        .report-time {
            font-size: 0.8rem;
            color: #6b7280;
            margin-left: 1rem;
        }

        @media (max-width: 1200px) {
            .advisors-grid {
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .advisors-header {
                padding: 0 1rem;
            }
            
            .advisors-title {
                font-size: 1.4rem;
            }
            
            .advisors-grid {
                grid-template-columns: 1fr;
            }
            
            .advisor-card {
                padding: 1.5rem;
            }
            
            .advisor-portrait {
                width: 100px;
                height: 100px;
            }
        }
    </style>
</head>
<body>
    <div class="advisors-container">
        <!-- En-tête -->
        <header class="advisors-header">
            <h1 class="advisors-title">Conseil Impérial</h1>
            <nav class="advisors-nav">
                <a href="?view=city_enhanced&id=<?php echo $city->cid;?>" class="nav-btn">Retour Cité</a>
                <a href="?view=palace&id=<?php echo $city->cid;?>" class="nav-btn">Palais</a>
                <a href="?view=senate" class="nav-btn">Sénat</a>
            </nav>
        </header>

        <main class="advisors-main">
            <!-- Chambre du Conseil -->
            <section class="council-chamber">
                <h2 class="chamber-title">🏛️ Senatus Populusque Romanus</h2>
                <p class="chamber-subtitle">Vos conseillers les plus fidèles vous attendent pour guider l'Empire vers la gloire</p>
            </section>

            <!-- Grille des Conseillers -->
            <section class="advisors-grid">
                <!-- Conseiller Militaire -->
                <div class="advisor-card advisor-military" onclick="openAdvisor('military')">
                    <div class="advisor-portrait">
                        <div class="advisor-status status-available"></div>
                    </div>
                    <h3 class="advisor-name">Quintus Cornelius Crassus</h3>
                    <p class="advisor-title">Legatus Legionis - Conseiller Militaire</p>
                    <div class="advisor-specialties">
                        <span class="specialty-tag">Stratégie</span>
                        <span class="specialty-tag">Tactique</span>
                        <span class="specialty-tag">Logistique</span>
                    </div>
                    <p class="advisor-description">
                        Vétéran de nombreuses campagnes, Quintus excelle dans l'art de la guerre et la gestion des légions.
                    </p>
                    <div class="advisor-stats">
                        <div class="stat-item">
                            <span class="stat-value">95</span>
                            <span class="stat-label">Commandement</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">88</span>
                            <span class="stat-label">Tactique</span>
                        </div>
                    </div>
                    <div class="advisor-actions">
                        <button class="advisor-btn primary">Consulter</button>
                        <button class="advisor-btn">Rapports</button>
                    </div>
                </div>

                <!-- Conseiller Économique -->
                <div class="advisor-card advisor-economic" onclick="openAdvisor('economic')">
                    <div class="advisor-portrait">
                        <div class="advisor-status status-available"></div>
                    </div>
                    <h3 class="advisor-name">Lucius Cornelius Crassus</h3>
                    <p class="advisor-title">Quaestor - Conseiller Économique</p>
                    <div class="advisor-specialties">
                        <span class="specialty-tag">Commerce</span>
                        <span class="specialty-tag">Finances</span>
                        <span class="specialty-tag">Ressources</span>
                    </div>
                    <p class="advisor-description">
                        Patricien fortuné et fin négociateur, Lucius maîtrise les arcanes du commerce et de la finance.
                    </p>
                    <div class="advisor-stats">
                        <div class="stat-item">
                            <span class="stat-value">92</span>
                            <span class="stat-label">Commerce</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">89</span>
                            <span class="stat-label">Gestion</span>
                        </div>
                    </div>
                    <div class="advisor-actions">
                        <button class="advisor-btn primary">Consulter</button>
                        <button class="advisor-btn">Finances</button>
                    </div>
                </div>

                <!-- Conseillère Diplomatique -->
                <div class="advisor-card advisor-diplomatic" onclick="openAdvisor('diplomatic')">
                    <div class="advisor-portrait">
                        <div class="advisor-status status-busy"></div>
                    </div>
                    <h3 class="advisor-name">Valeria Drusilla</h3>
                    <p class="advisor-title">Legata - Conseillère Diplomatique</p>
                    <div class="advisor-specialties">
                        <span class="specialty-tag">Négociation</span>
                        <span class="specialty-tag">Alliances</span>
                        <span class="specialty-tag">Espionnage</span>
                    </div>
                    <p class="advisor-description">
                        Noble dame de haute lignée, Valeria excelle dans l'art de la diplomatie et des relations internationales.
                    </p>
                    <div class="advisor-stats">
                        <div class="stat-item">
                            <span class="stat-value">94</span>
                            <span class="stat-label">Diplomatie</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">87</span>
                            <span class="stat-label">Intrigue</span>
                        </div>
                    </div>
                    <div class="advisor-actions">
                        <button class="advisor-btn primary">Consulter</button>
                        <button class="advisor-btn">Traités</button>
                    </div>
                </div>

                <!-- Conseillère Recherche -->
                <div class="advisor-card advisor-research" onclick="openAdvisor('research')">
                    <div class="advisor-portrait">
                        <div class="advisor-status status-available"></div>
                    </div>
                    <h3 class="advisor-name">Fabia Maxima</h3>
                    <p class="advisor-title">Virgo Vestalis - Conseillère Recherche</p>
                    <div class="advisor-specialties">
                        <span class="specialty-tag">Sciences</span>
                        <span class="specialty-tag">Technologie</span>
                        <span class="specialty-tag">Médecine</span>
                    </div>
                    <p class="advisor-description">
                        Vestale érudite et gardienne des savoirs anciens, Fabia guide les progrès scientifiques de l'Empire.
                    </p>
                    <div class="advisor-stats">
                        <div class="stat-item">
                            <span class="stat-value">96</span>
                            <span class="stat-label">Recherche</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">91</span>
                            <span class="stat-label">Innovation</span>
                        </div>
                    </div>
                    <div class="advisor-actions">
                        <button class="advisor-btn primary">Consulter</button>
                        <button class="advisor-btn">Projets</button>
                    </div>
                </div>

                <!-- Conseiller Construction -->
                <div class="advisor-card advisor-construction" onclick="openAdvisor('construction')">
                    <div class="advisor-portrait">
                        <div class="advisor-status status-available"></div>
                    </div>
                    <h3 class="advisor-name">Titus Fabius Brutus</h3>
                    <p class="advisor-title">Architectus - Conseiller Construction</p>
                    <div class="advisor-specialties">
                        <span class="specialty-tag">Architecture</span>
                        <span class="specialty-tag">Ingénierie</span>
                        <span class="specialty-tag">Urbanisme</span>
                    </div>
                    <p class="advisor-description">
                        Architecte de génie et ingénieur expérimenté, Titus supervise tous les grands projets de construction.
                    </p>
                    <div class="advisor-stats">
                        <div class="stat-item">
                            <span class="stat-value">93</span>
                            <span class="stat-label">Architecture</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">90</span>
                            <span class="stat-label">Ingénierie</span>
                        </div>
                    </div>
                    <div class="advisor-actions">
                        <button class="advisor-btn primary">Consulter</button>
                        <button class="advisor-btn">Projets</button>
                    </div>
                </div>

                <!-- Conseiller Espionnage -->
                <div class="advisor-card advisor-espionage" onclick="openAdvisor('espionage')">
                    <div class="advisor-portrait">
                        <div class="advisor-status status-away"></div>
                    </div>
                    <h3 class="advisor-name">Decimus Fabius Magnus</h3>
                    <p class="advisor-title">Speculator - Maître Espion</p>
                    <div class="advisor-specialties">
                        <span class="specialty-tag">Espionnage</span>
                        <span class="specialty-tag">Infiltration</span>
                        <span class="specialty-tag">Sabotage</span>
                    </div>
                    <p class="advisor-description">
                        Ancien gladiateur devenu maître espion, Decimus opère dans l'ombre pour protéger l'Empire.
                    </p>
                    <div class="advisor-stats">
                        <div class="stat-item">
                            <span class="stat-value">97</span>
                            <span class="stat-label">Discrétion</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">85</span>
                            <span class="stat-label">Combat</span>
                        </div>
                    </div>
                    <div class="advisor-actions">
                        <button class="advisor-btn primary">Consulter</button>
                        <button class="advisor-btn">Missions</button>
                    </div>
                </div>
            </section>

            <!-- Décisions du Conseil -->
            <section class="council-decisions">
                <h3 class="decisions-title">📜 Décisions en Attente</h3>
                
                <div class="decision-item">
                    <div class="decision-title">Expansion Militaire</div>
                    <div class="decision-description">
                        Quintus Cornelius Crassus propose de recruter 200 légionnaires supplémentaires pour renforcer nos défenses. 
                        Coût estimé : 10,000 pièces d'or et 500 unités de bois.
                    </div>
                    <div class="decision-options">
                        <button class="decision-btn" onclick="approveDecision('military_expansion')">Approuver</button>
                        <button class="decision-btn reject" onclick="rejectDecision('military_expansion')">Rejeter</button>
                    </div>
                </div>

                <div class="decision-item">
                    <div class="decision-title">Nouvelle Route Commerciale</div>
                    <div class="decision-description">
                        Lucius Cornelius Crassus suggère d'établir une nouvelle route commerciale avec les îles du Sud. 
                        Investissement initial : 5,000 pièces d'or. Revenus estimés : +200 or/jour.
                    </div>
                    <div class="decision-options">
                        <button class="decision-btn" onclick="approveDecision('trade_route')">Approuver</button>
                        <button class="decision-btn reject" onclick="rejectDecision('trade_route')">Rejeter</button>
                    </div>
                </div>
            </section>

            <!-- Rapports Récents -->
            <section class="recent-reports">
                <h3 class="reports-title">📋 Rapports Récents</h3>
                
                <div class="report-item">
                    <div class="report-icon" style="background-image: url('../Romain/Quintus_Cornelius_Crassus_asset_pack/legatus_homme_bust.png');"></div>
                    <div class="report-content">
                        <div class="report-title">Rapport Militaire</div>
                        <div class="report-description">Les légions sont prêtes pour la campagne d'automne. Moral élevé.</div>
                    </div>
                    <div class="report-time">Il y a 2h</div>
                </div>

                <div class="report-item">
                    <div class="report-icon" style="background-image: url('../Romain/Valeria_Drusilla_asset_pack/patrician_female_femme_bust.png');"></div>
                    <div class="report-content">
                        <div class="report-title">Négociations Diplomatiques</div>
                        <div class="report-description">Traité de paix signé avec l'Alliance du Nord. Durée : 2 ans.</div>
                    </div>
                    <div class="report-time">Il y a 4h</div>
                </div>

                <div class="report-item">
                    <div class="report-icon" style="background-image: url('../Romain/Fabia_Maxima_asset_pack/vestal_femme_bust.png');"></div>
                    <div class="report-content">
                        <div class="report-title">Avancée Technologique</div>
                        <div class="report-description">Recherche sur l'architecture avancée terminée. Nouveaux bâtiments disponibles.</div>
                    </div>
                    <div class="report-time">Il y a 6h</div>
                </div>
            </section>
        </main>
    </div>

    <script>
        function openAdvisor(advisorType) {
            // Rediriger vers la page spécifique du conseiller
            switch(advisorType) {
                case 'military':
                    window.location.href = '?view=militaryAdvisor&id=<?php echo $city->cid; ?>';
                    break;
                case 'economic':
                    window.location.href = '?view=tradeAdvisor&id=<?php echo $city->cid; ?>';
                    break;
                case 'diplomatic':
                    window.location.href = '?view=diplomacyAdvisor&id=<?php echo $city->cid; ?>';
                    break;
                case 'research':
                    window.location.href = '?view=researchAdvisor&id=<?php echo $city->cid; ?>';
                    break;
                case 'construction':
                    window.location.href = '?view=architect&id=<?php echo $city->cid; ?>';
                    break;
                case 'espionage':
                    window.location.href = '?view=safehouse&id=<?php echo $city->cid; ?>';
                    break;
            }
        }

        function approveDecision(decisionId) {
            if(confirm('Êtes-vous sûr de vouloir approuver cette décision ?')) {
                alert(`Décision ${decisionId} approuvée !`);
                // Logique d'approbation
            }
        }

        function rejectDecision(decisionId) {
            if(confirm('Êtes-vous sûr de vouloir rejeter cette décision ?')) {
                alert(`Décision ${decisionId} rejetée !`);
                // Logique de rejet
            }
        }

        // Animation d'entrée
        document.addEventListener('DOMContentLoaded', function() {
            const advisorCards = document.querySelectorAll('.advisor-card');
            advisorCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 150);
            });

            // Animation des rapports
            const reportItems = document.querySelectorAll('.report-item');
            reportItems.forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateX(-20px)';
                setTimeout(() => {
                    item.style.transition = 'all 0.4s ease';
                    item.style.opacity = '1';
                    item.style.transform = 'translateX(0)';
                }, 1000 + index * 100);
            });
        });

        // Mise à jour du statut des conseillers
        function updateAdvisorStatus() {
            const statuses = document.querySelectorAll('.advisor-status');
            statuses.forEach(status => {
                // Simulation de changement de statut
                const random = Math.random();
                if(random < 0.7) {
                    status.className = 'advisor-status status-available';
                } else if(random < 0.9) {
                    status.className = 'advisor-status status-busy';
                } else {
                    status.className = 'advisor-status status-away';
                }
            });
        }

        // Mettre à jour les statuts toutes les 30 secondes
        setInterval(updateAdvisorStatus, 30000);
    </script>
</body>
</html>