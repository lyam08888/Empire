<?php
if(!isset($_SESSION['sessid']))
    header("Location: ../index.html");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empire - <?php echo $city->cname; ?></title>
    <link href="css/common.css" rel="stylesheet" type="text/css" media="screen">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            font-family: 'Arial', sans-serif;
            color: #e2e8f0;
            overflow-x: hidden;
        }

        .city-container {
            position: relative;
            min-height: 100vh;
            background: 
                radial-gradient(circle at 30% 70%, rgba(251, 191, 36, 0.1) 0%, transparent 50%),
                linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }

        .city-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 80px;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(148, 163, 184, 0.2);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
        }

        .city-title {
            font-size: 1.8rem;
            font-weight: bold;
            color: #fbbf24;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .city-nav {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .nav-btn {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
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
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
        }

        .city-main {
            margin-top: 80px;
            display: grid;
            grid-template-columns: 300px 1fr 300px;
            gap: 2rem;
            padding: 2rem;
            min-height: calc(100vh - 80px);
        }

        .city-sidebar {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            border: 1px solid rgba(148, 163, 184, 0.2);
            padding: 1.5rem;
            height: fit-content;
            position: sticky;
            top: 100px;
        }

        .sidebar-section {
            margin-bottom: 2rem;
        }

        .sidebar-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #fbbf24;
            margin-bottom: 1rem;
            border-bottom: 1px solid rgba(148, 163, 184, 0.2);
            padding-bottom: 0.5rem;
        }

        .resource-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(148, 163, 184, 0.1);
        }

        .resource-icon {
            width: 24px;
            height: 24px;
            background-size: contain;
            background-repeat: no-repeat;
            margin-right: 0.5rem;
        }

        .resource-name {
            flex: 1;
            font-size: 0.9rem;
        }

        .resource-amount {
            font-weight: bold;
            color: #10b981;
        }

        .city-view {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            border: 1px solid rgba(148, 163, 184, 0.2);
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .city-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                url('../img/city/city_background.jpg') center/cover,
                linear-gradient(135deg, rgba(15, 23, 42, 0.8) 0%, rgba(30, 41, 59, 0.8) 100%);
            background-blend-mode: overlay;
            z-index: 1;
        }

        .buildings-grid {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-top: 2rem;
        }

        .building-slot {
            aspect-ratio: 1;
            background: rgba(30, 41, 59, 0.6);
            border: 2px dashed rgba(148, 163, 184, 0.3);
            border-radius: 0.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .building-slot:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(251, 191, 36, 0.2);
            border-color: #fbbf24;
        }

        .building-slot.occupied {
            border: 2px solid #10b981;
            background: rgba(16, 185, 129, 0.1);
        }

        .building-slot.occupied:hover {
            border-color: #fbbf24;
            box-shadow: 0 10px 30px rgba(251, 191, 36, 0.3);
        }

        .building-icon {
            width: 64px;
            height: 64px;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            margin-bottom: 0.5rem;
            filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.3));
        }

        .building-name {
            font-size: 0.8rem;
            font-weight: bold;
            text-align: center;
            color: #e2e8f0;
            margin-bottom: 0.2rem;
        }

        .building-level {
            font-size: 0.7rem;
            color: #fbbf24;
        }

        .building-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: rgba(30, 41, 59, 0.8);
            overflow: hidden;
        }

        .building-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #10b981, #34d399);
            transition: width 0.3s ease;
        }

        /* Types de bâtiments avec assets */
        .building-palatium .building-icon { background-image: url('../Batiment/palatium_asset.png'); }
        .building-basilica .building-icon { background-image: url('../Batiment/basilica_asset.png'); }
        .building-amphitheatrum .building-icon { background-image: url('../Batiment/amphitheatrum_asset.png'); }
        .building-thermae .building-icon { background-image: url('../Batiment/thermae_asset.png'); }
        .building-bibliotheca .building-icon { background-image: url('../Batiment/bibliotheca_asset.png'); }
        .building-horreum .building-icon { background-image: url('../Batiment/horreum_asset.png'); }
        .building-macellum .building-icon { background-image: url('../Batiment/macellum_asset.png'); }
        .building-portus .building-icon { background-image: url('../Batiment/portus_asset.png'); }
        .building-templum .building-icon { background-image: url('../Batiment/templum_asset.png'); }
        .building-theatrum .building-icon { background-image: url('../Batiment/theatrum_asset.png'); }
        .building-domus .building-icon { background-image: url('../Batiment/domus_asset.png'); }
        .building-insula .building-icon { background-image: url('../Batiment/insula_asset.png'); }
        .building-taberna .building-icon { background-image: url('../Batiment/taberna_asset.png'); }
        .building-curia .building-icon { background-image: url('../Batiment/curia_asset.png'); }
        .building-aqueductus .building-icon { background-image: url('../Batiment/aqueductus_asset.png'); }

        .advisor-panel {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            border: 1px solid rgba(148, 163, 184, 0.2);
            padding: 1.5rem;
            height: fit-content;
            position: sticky;
            top: 100px;
        }

        .advisor-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-size: cover;
            background-position: center;
            margin: 0 auto 1rem;
            border: 3px solid #fbbf24;
            box-shadow: 0 0 20px rgba(251, 191, 36, 0.3);
        }

        .advisor-name {
            text-align: center;
            font-weight: bold;
            color: #fbbf24;
            margin-bottom: 0.5rem;
        }

        .advisor-title {
            text-align: center;
            font-size: 0.8rem;
            color: #94a3b8;
            margin-bottom: 1rem;
        }

        .advisor-actions {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .advisor-btn {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.8rem;
        }

        .advisor-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(99, 102, 241, 0.4);
        }

        .quick-actions {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .quick-action {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .quick-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
        }

        .action-icon {
            width: 20px;
            height: 20px;
            background-size: contain;
            background-repeat: no-repeat;
        }

        .city-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: rgba(30, 41, 59, 0.6);
            border-radius: 0.5rem;
            padding: 1rem;
            border: 1px solid rgba(148, 163, 184, 0.2);
        }

        .stat-title {
            font-size: 0.8rem;
            color: #94a3b8;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: #10b981;
        }

        .construction-queue {
            background: rgba(30, 41, 59, 0.6);
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 1rem;
        }

        .queue-title {
            font-weight: bold;
            color: #fbbf24;
            margin-bottom: 1rem;
        }

        .queue-item {
            display: flex;
            align-items: center;
            padding: 0.5rem;
            background: rgba(15, 23, 42, 0.5);
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .queue-icon {
            width: 32px;
            height: 32px;
            background-size: contain;
            background-repeat: no-repeat;
            margin-right: 0.5rem;
        }

        .queue-info {
            flex: 1;
        }

        .queue-name {
            font-weight: bold;
            font-size: 0.9rem;
        }

        .queue-time {
            font-size: 0.7rem;
            color: #94a3b8;
        }

        @media (max-width: 1200px) {
            .city-main {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .city-sidebar,
            .advisor-panel {
                position: static;
            }
        }

        @media (max-width: 768px) {
            .city-header {
                padding: 0 1rem;
            }
            
            .city-title {
                font-size: 1.4rem;
            }
            
            .city-nav {
                gap: 0.5rem;
            }
            
            .nav-btn {
                padding: 0.4rem 0.8rem;
                font-size: 0.8rem;
            }
            
            .buildings-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="city-container">
        <!-- En-tête -->
        <header class="city-header">
            <h1 class="city-title"><?php echo $city->cname; ?></h1>
            <nav class="city-nav">
                <a href="?view=worldmap_enhanced&islandX=<?php echo $city->x;?>&islandY=<?php echo $city->y;?>" class="nav-btn">Carte du Monde</a>
                <a href="?view=island&id=<?php echo $city->iid;?>" class="nav-btn">Île</a>
                <a href="?view=cityMilitary-army&id=<?php echo $city->cid;?>" class="nav-btn">Armée</a>
                <a href="?view=cityMilitary-fleet&id=<?php echo $city->cid;?>" class="nav-btn">Flotte</a>
            </nav>
        </header>

        <main class="city-main">
            <!-- Sidebar gauche - Ressources -->
            <aside class="city-sidebar">
                <div class="sidebar-section">
                    <h3 class="sidebar-title">Ressources</h3>
                    <div class="resource-item">
                        <div class="resource-icon" style="background-image: url('../img/resource/wood.png');"></div>
                        <span class="resource-name">Bois</span>
                        <span class="resource-amount">1,250</span>
                    </div>
                    <div class="resource-item">
                        <div class="resource-icon" style="background-image: url('../img/resource/marble.png');"></div>
                        <span class="resource-name">Marbre</span>
                        <span class="resource-amount">850</span>
                    </div>
                    <div class="resource-item">
                        <div class="resource-icon" style="background-image: url('../img/resource/crystal.png');"></div>
                        <span class="resource-name">Cristal</span>
                        <span class="resource-amount">420</span>
                    </div>
                    <div class="resource-item">
                        <div class="resource-icon" style="background-image: url('../img/resource/sulfur.png');"></div>
                        <span class="resource-name">Soufre</span>
                        <span class="resource-amount">320</span>
                    </div>
                    <div class="resource-item">
                        <div class="resource-icon" style="background-image: url('../img/resource/wine.png');"></div>
                        <span class="resource-name">Vin</span>
                        <span class="resource-amount">180</span>
                    </div>
                    <div class="resource-item">
                        <div class="resource-icon" style="background-image: url('../img/resource/gold.png');"></div>
                        <span class="resource-name">Or</span>
                        <span class="resource-amount">2,450</span>
                    </div>
                </div>

                <div class="sidebar-section">
                    <h3 class="sidebar-title">Population</h3>
                    <div class="resource-item">
                        <span class="resource-name">Citoyens</span>
                        <span class="resource-amount">1,847</span>
                    </div>
                    <div class="resource-item">
                        <span class="resource-name">Satisfaction</span>
                        <span class="resource-amount" style="color: #10b981;">85%</span>
                    </div>
                </div>

                <div class="construction-queue">
                    <div class="queue-title">File de Construction</div>
                    <?php if($city->GetBuildingFinishTime() > time()) { ?>
                    <div class="queue-item">
                        <div class="queue-icon building-basilica"></div>
                        <div class="queue-info">
                            <div class="queue-name">Basilique</div>
                            <div class="queue-time" id="constructionTimer">
                                <?php 
                                $time = $generator->getTimeFormat($city->GetBuildingFinishTime()-time());
                                if($time["h"]) echo $time["h"]."h ";
                                if($time["m"]) echo $time["m"]."m ";
                                if($time["s"]) echo $time["s"]."s ";
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div style="text-align: center; color: #94a3b8; font-size: 0.9rem;">
                        Aucune construction en cours
                    </div>
                    <?php } ?>
                </div>
            </aside>

            <!-- Vue principale de la ville -->
            <section class="city-view">
                <div class="city-background"></div>
                
                <div class="city-stats">
                    <div class="stat-card">
                        <div class="stat-title">Niveau de la Ville</div>
                        <div class="stat-value"><?php echo $city->GetBuildingLevel(0); ?></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-title">Bâtiments</div>
                        <div class="stat-value"><?php echo count(array_filter($city->buildingsLevels, function($level) { return $level > 0; })); ?></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-title">Défense</div>
                        <div class="stat-value"><?php echo $city->GetBuildingLevel(14); ?></div>
                    </div>
                </div>

                <div class="quick-actions">
                    <button class="quick-action" onclick="location.href='?view=buildingGround&id=<?php echo $city->cid;?>'">
                        <div class="action-icon" style="background-image: url('../img/icons/build.png');"></div>
                        Construire
                    </button>
                    <button class="quick-action" onclick="location.href='?view=barracks&id=<?php echo $city->cid;?>'">
                        <div class="action-icon" style="background-image: url('../img/icons/military.png');"></div>
                        Recruter
                    </button>
                    <button class="quick-action" onclick="location.href='?view=port&id=<?php echo $city->cid;?>'">
                        <div class="action-icon" style="background-image: url('../img/icons/trade.png');"></div>
                        Commerce
                    </button>
                    <button class="quick-action" onclick="location.href='?view=researchAdvisor&id=<?php echo $city->cid;?>'">
                        <div class="action-icon" style="background-image: url('../img/icons/research.png');"></div>
                        Recherche
                    </button>
                </div>

                <div class="buildings-grid">
                    <?php 
                    $buildingTypes = [
                        1 => ['name' => 'Académie', 'class' => 'bibliotheca'],
                        2 => ['name' => 'Caserne', 'class' => 'domus'],
                        3 => ['name' => 'Port Commercial', 'class' => 'portus'],
                        4 => ['name' => 'Chantier Naval', 'class' => 'portus'],
                        5 => ['name' => 'Muraille', 'class' => 'curia'],
                        6 => ['name' => 'Entrepôt', 'class' => 'horreum'],
                        7 => ['name' => 'Marché', 'class' => 'macellum'],
                        8 => ['name' => 'Palais', 'class' => 'palatium'],
                        9 => ['name' => 'Taverne', 'class' => 'taberna'],
                        10 => ['name' => 'Cachette', 'class' => 'domus'],
                        11 => ['name' => 'Temple', 'class' => 'templum'],
                        12 => ['name' => 'Bûcheron', 'class' => 'insula'],
                        13 => ['name' => 'Alchimiste', 'class' => 'insula'],
                        17 => ['name' => 'Atelier', 'class' => 'insula'],
                        18 => ['name' => 'Artificier', 'class' => 'insula'],
                        19 => ['name' => 'Musée', 'class' => 'basilica'],
                        20 => ['name' => 'Architecte', 'class' => 'insula']
                    ];
                    
                    for($i = 1; $i <= 14; $i++) {
                        $isEmpty = $city->IsSiteEmpty($i);
                        $buildingType = $city->buildingsLevels["b{$i}t"];
                        $buildingLevel = $city->GetBuildingLevel($i);
                        $isReady = $city->IsBuildingReady($i);
                        
                        if($isEmpty) {
                            echo "<div class='building-slot' onclick=\"location.href='?view=buildingGround&id={$city->cid}&position={$i}'\">
                                    <div class='building-icon' style='background-image: url(\"../img/icons/empty_slot.png\");'></div>
                                    <div class='building-name'>Emplacement Libre</div>
                                  </div>";
                        } else {
                            $building = $buildingTypes[$buildingType] ?? ['name' => 'Bâtiment', 'class' => 'domus'];
                            $buildingClass = $building['class'];
                            $buildingName = $building['name'];
                            
                            echo "<div class='building-slot occupied building-{$buildingClass}' onclick=\"location.href='?view=" . $city->GetBuildingNameFromPos($i) . "&id={$city->cid}&position={$i}'\">
                                    <div class='building-icon'></div>
                                    <div class='building-name'>{$buildingName}</div>
                                    <div class='building-level'>Niveau {$buildingLevel}</div>";
                            
                            if(!$isReady) {
                                $progress = 100 - (($city->GetBuildingFinishTime() - time()) / ($city->GetBuildingFinishTime() - $city->GetBuildingStartTime()) * 100);
                                echo "<div class='building-progress'>
                                        <div class='building-progress-bar' style='width: {$progress}%'></div>
                                      </div>";
                            }
                            
                            echo "</div>";
                        }
                    }
                    ?>
                </div>
            </section>

            <!-- Sidebar droite - Conseillers -->
            <aside class="advisor-panel">
                <div class="sidebar-section">
                    <h3 class="sidebar-title">Conseiller</h3>
                    <div class="advisor-avatar" style="background-image: url('../Romain/Lucius_Cornelius_Crassus_asset_pack/patrician_male_homme_bust.png');"></div>
                    <div class="advisor-name">Marcus Aurelius</div>
                    <div class="advisor-title">Gouverneur de la Cité</div>
                    <div class="advisor-actions">
                        <button class="advisor-btn" onclick="location.href='?view=finances&id=<?php echo $city->cid;?>'">Finances</button>
                        <button class="advisor-btn" onclick="location.href='?view=militaryAdvisor&id=<?php echo $city->cid;?>'">Militaire</button>
                        <button class="advisor-btn" onclick="location.href='?view=diplomacyAdvisor&id=<?php echo $city->cid;?>'">Diplomatie</button>
                        <button class="advisor-btn" onclick="location.href='?view=tradeAdvisor&id=<?php echo $city->cid;?>'">Commerce</button>
                    </div>
                </div>

                <div class="sidebar-section">
                    <h3 class="sidebar-title">Événements</h3>
                    <div style="font-size: 0.8rem; color: #94a3b8; text-align: center;">
                        Aucun événement récent
                    </div>
                </div>
            </aside>
        </main>
    </div>

    <script>
        // Mise à jour du timer de construction
        <?php if($city->GetBuildingFinishTime() > time()) { ?>
        function updateConstructionTimer() {
            const endTime = <?php echo $city->GetBuildingFinishTime(); ?>;
            const now = Math.floor(Date.now() / 1000);
            const remaining = endTime - now;
            
            if(remaining <= 0) {
                location.reload();
                return;
            }
            
            const hours = Math.floor(remaining / 3600);
            const minutes = Math.floor((remaining % 3600) / 60);
            const seconds = remaining % 60;
            
            let timeString = '';
            if(hours > 0) timeString += hours + 'h ';
            if(minutes > 0) timeString += minutes + 'm ';
            timeString += seconds + 's';
            
            document.getElementById('constructionTimer').textContent = timeString;
        }
        
        setInterval(updateConstructionTimer, 1000);
        <?php } ?>

        // Animation d'entrée
        document.addEventListener('DOMContentLoaded', function() {
            const buildingSlots = document.querySelectorAll('.building-slot');
            buildingSlots.forEach((slot, index) => {
                slot.style.opacity = '0';
                slot.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    slot.style.transition = 'all 0.5s ease';
                    slot.style.opacity = '1';
                    slot.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>