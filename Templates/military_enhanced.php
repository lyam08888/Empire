<?php
if(!isset($_SESSION['sessid']))
    header("Location: ../index.html");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empire - Forces Militaires</title>
    <link href="css/common.css" rel="stylesheet" type="text/css" media="screen">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #7c2d12 0%, #1c1917 100%);
            font-family: 'Arial', sans-serif;
            color: #e2e8f0;
            overflow-x: hidden;
        }

        .military-container {
            position: relative;
            min-height: 100vh;
            background: 
                radial-gradient(circle at 20% 80%, rgba(239, 68, 68, 0.1) 0%, transparent 50%),
                linear-gradient(135deg, #7c2d12 0%, #1c1917 100%);
        }

        .military-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 80px;
            background: rgba(28, 25, 23, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(239, 68, 68, 0.3);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
        }

        .military-title {
            font-size: 1.8rem;
            font-weight: bold;
            color: #ef4444;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .military-nav {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .nav-btn {
            background: linear-gradient(135deg, #ef4444, #dc2626);
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
            box-shadow: 0 5px 15px rgba(239, 68, 68, 0.4);
        }

        .military-main {
            margin-top: 80px;
            padding: 2rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            min-height: calc(100vh - 80px);
        }

        .army-section,
        .fleet-section {
            background: rgba(28, 25, 23, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            border: 1px solid rgba(239, 68, 68, 0.3);
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #ef4444;
            margin-bottom: 2rem;
            text-align: center;
            border-bottom: 2px solid rgba(239, 68, 68, 0.3);
            padding-bottom: 1rem;
        }

        .units-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .unit-card {
            background: rgba(15, 23, 42, 0.6);
            border: 2px solid rgba(239, 68, 68, 0.3);
            border-radius: 0.5rem;
            padding: 1rem;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .unit-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(239, 68, 68, 0.3);
            border-color: #fbbf24;
        }

        .unit-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-size: cover;
            background-position: center;
            margin: 0 auto 1rem;
            border: 3px solid #ef4444;
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.3);
        }

        .unit-name {
            font-weight: bold;
            color: #e2e8f0;
            text-align: center;
            margin-bottom: 0.5rem;
            font-size: 1rem;
        }

        .unit-type {
            text-align: center;
            font-size: 0.8rem;
            color: #94a3b8;
            margin-bottom: 1rem;
        }

        .unit-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .stat-item {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
        }

        .stat-label {
            color: #94a3b8;
        }

        .stat-value {
            color: #10b981;
            font-weight: bold;
        }

        .unit-count {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            padding: 0.5rem;
            border-radius: 0.3rem;
            text-align: center;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .unit-actions {
            display: flex;
            gap: 0.5rem;
        }

        .unit-btn {
            flex: 1;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: white;
            border: none;
            padding: 0.4rem 0.8rem;
            border-radius: 0.3rem;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.7rem;
        }

        .unit-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(99, 102, 241, 0.4);
        }

        /* Types d'unités terrestres avec assets */
        .unit-legionary .unit-avatar { background-image: url('../Romain/Lucius_Julius_Scipio_asset_pack/legionary_homme_full_body.png'); }
        .unit-centurion .unit-avatar { background-image: url('../Romain/Quintus_Valerius_Cicero_asset_pack/centurion_homme_full_body.png'); }
        .unit-praetorian .unit-avatar { background-image: url('../Romain/Titus_Fabius_Scipio_asset_pack/praetorian_homme_full_body.png'); }
        .unit-auxilia .unit-avatar { background-image: url('../Romain/Lucius_Claudius_Cicero_asset_pack/auxilia_homme_full_body.png'); }
        .unit-equites .unit-avatar { background-image: url('../Romain/Titus_Fabius_Crassus_asset_pack/equites_homme_full_body.png'); }
        .unit-gladiator .unit-avatar { background-image: url('../Romain/Decimus_Fabius_Magnus_asset_pack/gladiator_homme_full_body.png'); }

        .fleet-units {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .ship-card {
            background: rgba(15, 23, 42, 0.6);
            border: 2px solid rgba(59, 130, 246, 0.3);
            border-radius: 0.5rem;
            padding: 1rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .ship-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
            border-color: #fbbf24;
        }

        .ship-image {
            width: 100%;
            height: 120px;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            margin-bottom: 1rem;
            border-radius: 0.5rem;
            background-color: rgba(59, 130, 246, 0.1);
        }

        /* Types de navires avec assets */
        .ship-trireme .ship-image { background-image: url('../Bateau/trireme_asset.png'); }
        .ship-liburna .ship-image { background-image: url('../Bateau/liburna_asset.png'); }
        .ship-corbita .ship-image { background-image: url('../Bateau/corbita_asset.png'); }
        .ship-navis .ship-image { background-image: url('../Bateau/navis_oneraria_asset.png'); }

        .ship-name {
            font-weight: bold;
            color: #e2e8f0;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .ship-type {
            text-align: center;
            font-size: 0.8rem;
            color: #94a3b8;
            margin-bottom: 1rem;
        }

        .recruitment-panel {
            background: rgba(15, 23, 42, 0.8);
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-top: 2rem;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .recruitment-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #fbbf24;
            margin-bottom: 1rem;
            text-align: center;
        }

        .recruitment-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
        }

        .recruit-btn {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }

        .recruit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
        }

        .recruit-icon {
            width: 40px;
            height: 40px;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            margin: 0 auto 0.5rem;
        }

        .recruit-name {
            font-weight: bold;
            margin-bottom: 0.3rem;
        }

        .recruit-cost {
            font-size: 0.8rem;
            color: #fbbf24;
        }

        .battle-history {
            background: rgba(15, 23, 42, 0.6);
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 1rem;
        }

        .history-title {
            font-weight: bold;
            color: #fbbf24;
            margin-bottom: 1rem;
        }

        .battle-item {
            display: flex;
            align-items: center;
            padding: 0.5rem;
            background: rgba(28, 25, 23, 0.5);
            border-radius: 0.3rem;
            margin-bottom: 0.5rem;
        }

        .battle-result {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-right: 0.5rem;
        }

        .victory { background-color: #10b981; }
        .defeat { background-color: #ef4444; }

        .battle-info {
            flex: 1;
            font-size: 0.9rem;
        }

        .battle-date {
            font-size: 0.7rem;
            color: #94a3b8;
        }

        @media (max-width: 1200px) {
            .military-main {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
        }

        @media (max-width: 768px) {
            .military-header {
                padding: 0 1rem;
            }
            
            .military-title {
                font-size: 1.4rem;
            }
            
            .units-grid {
                grid-template-columns: 1fr;
            }
            
            .fleet-units {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="military-container">
        <!-- En-tête -->
        <header class="military-header">
            <h1 class="military-title">Forces Militaires</h1>
            <nav class="military-nav">
                <a href="?view=city_enhanced&id=<?php echo $city->cid;?>" class="nav-btn">Retour Cité</a>
                <a href="?view=barracks&id=<?php echo $city->cid;?>" class="nav-btn">Caserne</a>
                <a href="?view=shipyard&id=<?php echo $city->cid;?>" class="nav-btn">Chantier Naval</a>
                <a href="?view=militaryAdvisor&id=<?php echo $city->cid;?>" class="nav-btn">Conseiller</a>
            </nav>
        </header>

        <main class="military-main">
            <!-- Section Armée -->
            <section class="army-section">
                <h2 class="section-title">🏛️ Légions Romaines</h2>
                
                <div class="units-grid">
                    <div class="unit-card unit-legionary">
                        <div class="unit-avatar"></div>
                        <div class="unit-name">Légionnaires</div>
                        <div class="unit-type">Infanterie Lourde</div>
                        <div class="unit-count">245 unités</div>
                        <div class="unit-stats">
                            <div class="stat-item">
                                <span class="stat-label">Attaque:</span>
                                <span class="stat-value">85</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Défense:</span>
                                <span class="stat-value">90</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Vitesse:</span>
                                <span class="stat-value">60</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Moral:</span>
                                <span class="stat-value">95</span>
                            </div>
                        </div>
                        <div class="unit-actions">
                            <button class="unit-btn">Déployer</button>
                            <button class="unit-btn">Entraîner</button>
                        </div>
                    </div>

                    <div class="unit-card unit-centurion">
                        <div class="unit-avatar"></div>
                        <div class="unit-name">Centurions</div>
                        <div class="unit-type">Commandement</div>
                        <div class="unit-count">12 unités</div>
                        <div class="unit-stats">
                            <div class="stat-item">
                                <span class="stat-label">Attaque:</span>
                                <span class="stat-value">95</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Défense:</span>
                                <span class="stat-value">100</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Vitesse:</span>
                                <span class="stat-value">70</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Leadership:</span>
                                <span class="stat-value">100</span>
                            </div>
                        </div>
                        <div class="unit-actions">
                            <button class="unit-btn">Déployer</button>
                            <button class="unit-btn">Promouvoir</button>
                        </div>
                    </div>

                    <div class="unit-card unit-praetorian">
                        <div class="unit-avatar"></div>
                        <div class="unit-name">Prétoriens</div>
                        <div class="unit-type">Garde d'Élite</div>
                        <div class="unit-count">50 unités</div>
                        <div class="unit-stats">
                            <div class="stat-item">
                                <span class="stat-label">Attaque:</span>
                                <span class="stat-value">100</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Défense:</span>
                                <span class="stat-value">110</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Vitesse:</span>
                                <span class="stat-value">80</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Loyauté:</span>
                                <span class="stat-value">100</span>
                            </div>
                        </div>
                        <div class="unit-actions">
                            <button class="unit-btn">Déployer</button>
                            <button class="unit-btn">Garder</button>
                        </div>
                    </div>

                    <div class="unit-card unit-equites">
                        <div class="unit-avatar"></div>
                        <div class="unit-name">Équites</div>
                        <div class="unit-type">Cavalerie</div>
                        <div class="unit-count">80 unités</div>
                        <div class="unit-stats">
                            <div class="stat-item">
                                <span class="stat-label">Attaque:</span>
                                <span class="stat-value">90</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Défense:</span>
                                <span class="stat-value">70</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Vitesse:</span>
                                <span class="stat-value">120</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Mobilité:</span>
                                <span class="stat-value">100</span>
                            </div>
                        </div>
                        <div class="unit-actions">
                            <button class="unit-btn">Éclaireur</button>
                            <button class="unit-btn">Charge</button>
                        </div>
                    </div>
                </div>

                <div class="recruitment-panel">
                    <h3 class="recruitment-title">Recrutement Terrestre</h3>
                    <div class="recruitment-options">
                        <button class="recruit-btn" onclick="recruitUnit('legionary')">
                            <div class="recruit-icon" style="background-image: url('../Romain/Lucius_Julius_Scipio_asset_pack/legionary_homme_bust.png');"></div>
                            <div class="recruit-name">Légionnaire</div>
                            <div class="recruit-cost">50 Or, 2h</div>
                        </button>
                        <button class="recruit-btn" onclick="recruitUnit('auxilia')">
                            <div class="recruit-icon" style="background-image: url('../Romain/Lucius_Claudius_Cicero_asset_pack/auxilia_homme_bust.png');"></div>
                            <div class="recruit-name">Auxiliaire</div>
                            <div class="recruit-cost">30 Or, 1h</div>
                        </button>
                        <button class="recruit-btn" onclick="recruitUnit('equites')">
                            <div class="recruit-icon" style="background-image: url('../Romain/Titus_Fabius_Crassus_asset_pack/equites_homme_bust.png');"></div>
                            <div class="recruit-name">Cavalier</div>
                            <div class="recruit-cost">80 Or, 3h</div>
                        </button>
                    </div>
                </div>

                <div class="battle-history">
                    <div class="history-title">Historique des Batailles</div>
                    <div class="battle-item">
                        <div class="battle-result victory"></div>
                        <div class="battle-info">
                            <div>Victoire contre Barbares du Nord</div>
                            <div class="battle-date">Il y a 2 jours</div>
                        </div>
                    </div>
                    <div class="battle-item">
                        <div class="battle-result victory"></div>
                        <div class="battle-info">
                            <div>Défense de la cité réussie</div>
                            <div class="battle-date">Il y a 5 jours</div>
                        </div>
                    </div>
                    <div class="battle-item">
                        <div class="battle-result defeat"></div>
                        <div class="battle-info">
                            <div>Raid échoué sur l'île voisine</div>
                            <div class="battle-date">Il y a 1 semaine</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section Flotte -->
            <section class="fleet-section">
                <h2 class="section-title">⚓ Flotte Impériale</h2>
                
                <div class="fleet-units">
                    <div class="ship-card ship-trireme">
                        <div class="ship-image"></div>
                        <div class="ship-name">Trirèmes de Guerre</div>
                        <div class="ship-type">Navire de Combat</div>
                        <div class="unit-count">8 navires</div>
                        <div class="unit-stats">
                            <div class="stat-item">
                                <span class="stat-label">Attaque:</span>
                                <span class="stat-value">120</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Défense:</span>
                                <span class="stat-value">80</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Vitesse:</span>
                                <span class="stat-value">90</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Capacité:</span>
                                <span class="stat-value">50</span>
                            </div>
                        </div>
                        <div class="unit-actions">
                            <button class="unit-btn">Patrouiller</button>
                            <button class="unit-btn">Attaquer</button>
                        </div>
                    </div>

                    <div class="ship-card ship-liburna">
                        <div class="ship-image"></div>
                        <div class="ship-name">Liburnes Rapides</div>
                        <div class="ship-type">Éclaireur Naval</div>
                        <div class="unit-count">15 navires</div>
                        <div class="unit-stats">
                            <div class="stat-item">
                                <span class="stat-label">Attaque:</span>
                                <span class="stat-value">70</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Défense:</span>
                                <span class="stat-value">60</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Vitesse:</span>
                                <span class="stat-value">130</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Capacité:</span>
                                <span class="stat-value">20</span>
                            </div>
                        </div>
                        <div class="unit-actions">
                            <button class="unit-btn">Éclaireur</button>
                            <button class="unit-btn">Raid</button>
                        </div>
                    </div>

                    <div class="ship-card ship-corbita">
                        <div class="ship-image"></div>
                        <div class="ship-name">Corbites Marchandes</div>
                        <div class="ship-type">Transport Commercial</div>
                        <div class="unit-count">12 navires</div>
                        <div class="unit-stats">
                            <div class="stat-item">
                                <span class="stat-label">Attaque:</span>
                                <span class="stat-value">30</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Défense:</span>
                                <span class="stat-value">40</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Vitesse:</span>
                                <span class="stat-value">70</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Capacité:</span>
                                <span class="stat-value">200</span>
                            </div>
                        </div>
                        <div class="unit-actions">
                            <button class="unit-btn">Commerce</button>
                            <button class="unit-btn">Transport</button>
                        </div>
                    </div>

                    <div class="ship-card ship-navis">
                        <div class="ship-image"></div>
                        <div class="ship-name">Navis Oneraria</div>
                        <div class="ship-type">Transport Lourd</div>
                        <div class="unit-count">5 navires</div>
                        <div class="unit-stats">
                            <div class="stat-item">
                                <span class="stat-label">Attaque:</span>
                                <span class="stat-value">20</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Défense:</span>
                                <span class="stat-value">60</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Vitesse:</span>
                                <span class="stat-value">50</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Capacité:</span>
                                <span class="stat-value">500</span>
                            </div>
                        </div>
                        <div class="unit-actions">
                            <button class="unit-btn">Coloniser</button>
                            <button class="unit-btn">Ravitailler</button>
                        </div>
                    </div>
                </div>

                <div class="recruitment-panel">
                    <h3 class="recruitment-title">Construction Navale</h3>
                    <div class="recruitment-options">
                        <button class="recruit-btn" onclick="buildShip('liburna')">
                            <div class="recruit-icon" style="background-image: url('../Bateau/liburna_asset.png');"></div>
                            <div class="recruit-name">Liburne</div>
                            <div class="recruit-cost">200 Or, 4h</div>
                        </button>
                        <button class="recruit-btn" onclick="buildShip('trireme')">
                            <div class="recruit-icon" style="background-image: url('../Bateau/trireme_asset.png');"></div>
                            <div class="recruit-name">Trirème</div>
                            <div class="recruit-cost">500 Or, 8h</div>
                        </button>
                        <button class="recruit-btn" onclick="buildShip('corbita')">
                            <div class="recruit-icon" style="background-image: url('../Bateau/corbita_asset.png');"></div>
                            <div class="recruit-name">Corbite</div>
                            <div class="recruit-cost">300 Or, 6h</div>
                        </button>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script>
        function recruitUnit(unitType) {
            if(confirm(`Voulez-vous recruter cette unité ?`)) {
                // Logique de recrutement
                alert(`Recrutement de ${unitType} lancé !`);
            }
        }

        function buildShip(shipType) {
            if(confirm(`Voulez-vous construire ce navire ?`)) {
                // Logique de construction
                alert(`Construction de ${shipType} lancée !`);
            }
        }

        // Animation d'entrée
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.unit-card, .ship-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>