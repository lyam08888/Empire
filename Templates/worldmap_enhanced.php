<?php
if(!isset($_SESSION['sessid']))
    header("Location: index.html");

if(!isset($_GET['islandX'])||!isset($_GET['islandY']))
    header("Location: ../index.html");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empire - Carte du Monde</title>
    <link href="css/common.css" rel="stylesheet" type="text/css" media="screen">
    <link href="css/worldmap_enhanced.css" rel="stylesheet" type="text/css" media="screen">
    <style>
        /* Styles pour la carte du monde améliorée */
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%);
            font-family: 'Arial', sans-serif;
            color: #e2e8f0;
            overflow: hidden;
        }

        .world-container {
            position: relative;
            width: 100vw;
            height: 100vh;
            background: 
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.15) 0%, transparent 50%),
                linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }

        .world-header {
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

        .world-title {
            font-size: 1.8rem;
            font-weight: bold;
            color: #fbbf24;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .world-controls {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .control-btn {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .control-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
        }

        .world-map {
            position: absolute;
            top: 80px;
            left: 0;
            right: 0;
            bottom: 0;
            overflow: hidden;
            cursor: grab;
        }

        .world-map:active {
            cursor: grabbing;
        }

        .map-grid {
            position: relative;
            width: 2000px;
            height: 2000px;
            transform-origin: center;
            transition: transform 0.3s ease;
        }

        .island-tile {
            position: absolute;
            width: 120px;
            height: 120px;
            cursor: pointer;
            transition: all 0.3s ease;
            border-radius: 8px;
            overflow: hidden;
        }

        .island-tile:hover {
            transform: scale(1.1);
            z-index: 100;
            box-shadow: 0 10px 30px rgba(251, 191, 36, 0.3);
        }

        .island-content {
            position: relative;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(34, 197, 94, 0.2) 0%, rgba(21, 128, 61, 0.1) 100%);
            border: 2px solid rgba(34, 197, 94, 0.3);
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .ocean-tile .island-content {
            background: radial-gradient(circle, rgba(59, 130, 246, 0.2) 0%, rgba(29, 78, 216, 0.1) 100%);
            border-color: rgba(59, 130, 246, 0.3);
        }

        .city-icon {
            width: 48px;
            height: 48px;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            margin-bottom: 0.5rem;
            filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.3));
        }

        /* Types de villes avec les assets */
        .city-vicus .city-icon { background-image: url('../Ville/vicus_asset.png'); }
        .city-civitas .city-icon { background-image: url('../Ville/civitas_asset.png'); }
        .city-municipium .city-icon { background-image: url('../Ville/municipium_asset.png'); }
        .city-urbs .city-icon { background-image: url('../Ville/urbs_asset.png'); }
        .city-castra .city-icon { background-image: url('../Ville/castra_asset.png'); }
        .city-castrum .city-icon { background-image: url('../Ville/castrum_asset.png'); }
        .city-imperial .city-icon { background-image: url('../Ville/imperial_rome_asset.png'); }
        .city-port .city-icon { background-image: url('../Ville/urbs_port_asset.png'); }

        .city-name {
            font-size: 0.7rem;
            font-weight: bold;
            text-align: center;
            color: #e2e8f0;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7);
            max-width: 100px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .city-level {
            font-size: 0.6rem;
            color: #fbbf24;
            margin-top: 0.2rem;
        }

        .own-city {
            border-color: #10b981 !important;
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.3);
        }

        .ally-city {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
        }

        .enemy-city {
            border-color: #ef4444 !important;
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.3);
        }

        .world-sidebar {
            position: fixed;
            right: 0;
            top: 80px;
            bottom: 0;
            width: 300px;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(10px);
            border-left: 1px solid rgba(148, 163, 184, 0.2);
            z-index: 900;
            padding: 1rem;
            overflow-y: auto;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        }

        .world-sidebar.active {
            transform: translateX(0);
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

        .city-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .city-item {
            display: flex;
            align-items: center;
            padding: 0.5rem;
            margin-bottom: 0.5rem;
            background: rgba(30, 41, 59, 0.5);
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .city-item:hover {
            background: rgba(30, 41, 59, 0.8);
            transform: translateX(-5px);
        }

        .city-item-icon {
            width: 32px;
            height: 32px;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            margin-right: 0.5rem;
        }

        .city-item-info {
            flex: 1;
        }

        .city-item-name {
            font-weight: bold;
            color: #e2e8f0;
            font-size: 0.9rem;
        }

        .city-item-coords {
            font-size: 0.7rem;
            color: #94a3b8;
        }

        .minimap {
            width: 100%;
            height: 200px;
            background: rgba(30, 41, 59, 0.5);
            border-radius: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .minimap-viewport {
            position: absolute;
            border: 2px solid #fbbf24;
            background: rgba(251, 191, 36, 0.1);
            pointer-events: none;
        }

        .zoom-controls {
            position: fixed;
            bottom: 2rem;
            left: 2rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            z-index: 1000;
        }

        .zoom-btn {
            width: 50px;
            height: 50px;
            background: rgba(15, 23, 42, 0.9);
            border: 1px solid rgba(148, 163, 184, 0.3);
            border-radius: 50%;
            color: #e2e8f0;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .zoom-btn:hover {
            background: rgba(59, 130, 246, 0.8);
            transform: scale(1.1);
        }

        .coordinates-display {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: rgba(15, 23, 42, 0.9);
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid rgba(148, 163, 184, 0.3);
            font-size: 0.9rem;
            z-index: 1000;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .loading-tile {
            animation: pulse 2s infinite;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .world-sidebar {
                width: 100%;
                transform: translateY(100%);
            }
            
            .world-sidebar.active {
                transform: translateY(0);
            }
            
            .world-controls {
                gap: 0.5rem;
            }
            
            .control-btn {
                padding: 0.4rem 0.8rem;
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="world-container">
        <!-- En-tête -->
        <header class="world-header">
            <h1 class="world-title">Empire - Carte du Monde</h1>
            <div class="world-controls">
                <button class="control-btn" onclick="toggleSidebar()">Mes Cités</button>
                <button class="control-btn" onclick="centerOnCapital()">Capitale</button>
                <button class="control-btn" onclick="showFilters()">Filtres</button>
                <button class="control-btn" onclick="goToCity()">Retour Cité</button>
            </div>
        </header>

        <!-- Carte principale -->
        <div class="world-map" id="worldMap">
            <div class="map-grid" id="mapGrid">
                <!-- Les îles seront générées dynamiquement -->
            </div>
        </div>

        <!-- Contrôles de zoom -->
        <div class="zoom-controls">
            <button class="zoom-btn" onclick="zoomIn()">+</button>
            <button class="zoom-btn" onclick="zoomOut()">-</button>
        </div>

        <!-- Affichage des coordonnées -->
        <div class="coordinates-display" id="coordsDisplay">
            Position: [<?php echo $_GET['islandX']; ?>:<?php echo $_GET['islandY']; ?>]
        </div>

        <!-- Sidebar -->
        <div class="world-sidebar" id="worldSidebar">
            <div class="sidebar-section">
                <h3 class="sidebar-title">Mes Cités</h3>
                <ul class="city-list" id="myCitiesList">
                    <?php 
                    for($i=0; $i<count($session->cities); $i++){
                        $cid = $session->cities[$i];
                        $iid = $database->getCityField($cid,"iid");
                        $x = $database->getIslandField($iid,"x");
                        $y = $database->getIslandField($iid,"y");
                        $cityName = $database->getCityField($cid,"name");
                        $cityLevel = $database->getCityField($cid,"level");
                        
                        // Déterminer le type de ville selon le niveau
                        $cityType = "vicus";
                        if($cityLevel >= 20) $cityType = "imperial";
                        else if($cityLevel >= 15) $cityType = "urbs";
                        else if($cityLevel >= 10) $cityType = "municipium";
                        else if($cityLevel >= 5) $cityType = "civitas";
                    ?>
                    <li class="city-item" onclick="goToIsland(<?php echo $x; ?>, <?php echo $y; ?>)">
                        <div class="city-item-icon city-<?php echo $cityType; ?>"></div>
                        <div class="city-item-info">
                            <div class="city-item-name"><?php echo $cityName; ?></div>
                            <div class="city-item-coords">[<?php echo $x; ?>:<?php echo $y; ?>] - Niveau <?php echo $cityLevel; ?></div>
                        </div>
                    </li>
                    <?php } ?>
                </ul>
            </div>

            <div class="sidebar-section">
                <h3 class="sidebar-title">Minimap</h3>
                <div class="minimap" id="minimap">
                    <div class="minimap-viewport" id="minimapViewport"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Variables globales
        let currentX = <?php echo $_GET['islandX']; ?>;
        let currentY = <?php echo $_GET['islandY']; ?>;
        let zoomLevel = 1;
        let isDragging = false;
        let dragStart = { x: 0, y: 0 };
        let mapOffset = { x: 0, y: 0 };

        // Données des îles (à remplacer par des données dynamiques)
        const islandData = {};
        
        <?php 
        // Générer les données des îles depuis PHP
        for($i=0; $i<count($session->cities); $i++){
            $cid = $session->cities[$i];
            $iid = $database->getCityField($cid,"iid");
            $x = $database->getIslandField($iid,"x");
            $y = $database->getIslandField($iid,"y");
            $cityName = $database->getCityField($cid,"name");
            $cityLevel = $database->getCityField($cid,"level");
            
            $cityType = "vicus";
            if($cityLevel >= 20) $cityType = "imperial";
            else if($cityLevel >= 15) $cityType = "urbs";
            else if($cityLevel >= 10) $cityType = "municipium";
            else if($cityLevel >= 5) $cityType = "civitas";
            
            echo "islandData['{$x}_{$y}'] = {
                x: $x,
                y: $y,
                name: '$cityName',
                level: $cityLevel,
                type: '$cityType',
                owner: 'own'
            };\n";
        }
        ?>

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            initializeMap();
            setupEventListeners();
            generateMapTiles();
            centerMap();
        });

        function initializeMap() {
            const mapGrid = document.getElementById('mapGrid');
            mapGrid.style.transform = `scale(${zoomLevel}) translate(${mapOffset.x}px, ${mapOffset.y}px)`;
        }

        function setupEventListeners() {
            const worldMap = document.getElementById('worldMap');
            
            // Événements de glisser-déposer
            worldMap.addEventListener('mousedown', startDrag);
            worldMap.addEventListener('mousemove', drag);
            worldMap.addEventListener('mouseup', endDrag);
            worldMap.addEventListener('mouseleave', endDrag);
            
            // Événements tactiles
            worldMap.addEventListener('touchstart', handleTouch);
            worldMap.addEventListener('touchmove', handleTouch);
            worldMap.addEventListener('touchend', endDrag);
            
            // Zoom avec la molette
            worldMap.addEventListener('wheel', handleWheel);
        }

        function generateMapTiles() {
            const mapGrid = document.getElementById('mapGrid');
            const viewSize = 20; // Taille de la vue (20x20 tiles)
            
            for(let x = currentX - viewSize/2; x < currentX + viewSize/2; x++) {
                for(let y = currentY - viewSize/2; y < currentY + viewSize/2; y++) {
                    createTile(x, y);
                }
            }
        }

        function createTile(x, y) {
            const mapGrid = document.getElementById('mapGrid');
            const tile = document.createElement('div');
            const key = `${x}_${y}`;
            
            tile.className = 'island-tile';
            tile.id = `tile_${x}_${y}`;
            tile.style.left = `${(x - currentX + 10) * 130}px`;
            tile.style.top = `${(y - currentY + 10) * 130}px`;
            
            const content = document.createElement('div');
            content.className = 'island-content';
            
            if(islandData[key]) {
                const island = islandData[key];
                tile.classList.add(`city-${island.type}`);
                tile.classList.add(`${island.owner}-city`);
                
                const icon = document.createElement('div');
                icon.className = 'city-icon';
                
                const name = document.createElement('div');
                name.className = 'city-name';
                name.textContent = island.name;
                
                const level = document.createElement('div');
                level.className = 'city-level';
                level.textContent = `Niveau ${island.level}`;
                
                content.appendChild(icon);
                content.appendChild(name);
                content.appendChild(level);
                
                tile.onclick = () => goToCity(island.x, island.y);
            } else {
                tile.classList.add('ocean-tile');
                content.innerHTML = '<div style="color: #64748b; font-size: 0.8rem;">Océan</div>';
            }
            
            tile.appendChild(content);
            mapGrid.appendChild(tile);
        }

        function startDrag(e) {
            isDragging = true;
            dragStart.x = e.clientX || e.touches[0].clientX;
            dragStart.y = e.clientY || e.touches[0].clientY;
        }

        function drag(e) {
            if(!isDragging) return;
            
            e.preventDefault();
            const clientX = e.clientX || (e.touches && e.touches[0].clientX);
            const clientY = e.clientY || (e.touches && e.touches[0].clientY);
            
            const deltaX = clientX - dragStart.x;
            const deltaY = clientY - dragStart.y;
            
            mapOffset.x += deltaX / zoomLevel;
            mapOffset.y += deltaY / zoomLevel;
            
            updateMapTransform();
            
            dragStart.x = clientX;
            dragStart.y = clientY;
        }

        function endDrag() {
            isDragging = false;
        }

        function handleTouch(e) {
            e.preventDefault();
            if(e.type === 'touchstart') {
                startDrag(e);
            } else if(e.type === 'touchmove') {
                drag(e);
            }
        }

        function handleWheel(e) {
            e.preventDefault();
            const delta = e.deltaY > 0 ? -0.1 : 0.1;
            zoomLevel = Math.max(0.5, Math.min(3, zoomLevel + delta));
            updateMapTransform();
        }

        function updateMapTransform() {
            const mapGrid = document.getElementById('mapGrid');
            mapGrid.style.transform = `scale(${zoomLevel}) translate(${mapOffset.x}px, ${mapOffset.y}px)`;
        }

        function zoomIn() {
            zoomLevel = Math.min(3, zoomLevel + 0.2);
            updateMapTransform();
        }

        function zoomOut() {
            zoomLevel = Math.max(0.5, zoomLevel - 0.2);
            updateMapTransform();
        }

        function centerMap() {
            mapOffset.x = 0;
            mapOffset.y = 0;
            updateMapTransform();
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('worldSidebar');
            sidebar.classList.toggle('active');
        }

        function goToIsland(x, y) {
            window.location.href = `?view=worldmap_enhanced&islandX=${x}&islandY=${y}`;
        }

        function goToCity(x, y) {
            // Trouver la première ville sur cette île
            const key = `${x}_${y}`;
            if(islandData[key]) {
                window.location.href = `?view=island&id=${x}_${y}`;
            }
        }

        function centerOnCapital() {
            // Centrer sur la première ville (capitale)
            const firstCity = Object.values(islandData)[0];
            if(firstCity) {
                goToIsland(firstCity.x, firstCity.y);
            }
        }

        function showFilters() {
            alert('Filtres à implémenter');
        }

        // Mise à jour des coordonnées
        setInterval(() => {
            const coordsDisplay = document.getElementById('coordsDisplay');
            coordsDisplay.textContent = `Position: [${currentX}:${currentY}] - Zoom: ${Math.round(zoomLevel * 100)}%`;
        }, 100);
    </script>
</body>
</html>