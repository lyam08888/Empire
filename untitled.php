<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Untitled Document</title>
</head>a<?php
// Au début de chaque template de vue, vous auriez probablement besoin
// de récupérer les données spécifiques à l'utilisateur et à sa ville.
// $player_resources = $account->getResources($_SESSION['user_id']);
// $current_city_data = $city->getCityData($city->cid);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empire - Ville de [Nom de la ville]</title>
    
    <!-- Meta-tags pour empêcher la mise en cache du jeu -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #111827; /* Gris très foncé pour le fond */
        }
        /* Style pour les barres de défilement personnalisées */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #1f2937;
        }
        ::-webkit-scrollbar-thumb {
            background: #4b5563;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #6b7280;
        }
    </style>
</head>
<body class="text-gray-300">

    <div id="game-container" class="flex flex-col h-screen">

        <!-- 1. En-tête : Barre de ressources et informations du joueur -->
        <header class="bg-gray-900 shadow-lg z-20">
            <div class="container mx-auto px-4 py-2 flex justify-between items-center">
                <!-- Sélection de la ville -->
                <div class="flex items-center">
                     <select name="current_city" class="bg-gray-800 border border-gray-700 rounded-md p-2 text-white focus:ring-2 focus:ring-amber-500">
                        <option>Athènes</option>
                        <option>Sparte</option>
                        <option>Corinthe</option>
                    </select>
                </div>

                <!-- Ressources -->
                <div class="hidden md:flex flex-grow justify-center items-center space-x-4">
                    <div title="Bois" class="flex items-center bg-gray-800 px-3 py-1 rounded-full"><img src="https://placehold.co/24x24/854d0e/ffffff?text=W" class="w-6 h-6 mr-2 rounded-full"><span>5,000</span></div>
                    <div title="Vin" class="flex items-center bg-gray-800 px-3 py-1 rounded-full"><img src="https://placehold.co/24x24/581c87/ffffff?text=V" class="w-6 h-6 mr-2 rounded-full"><span>1,200</span></div>
                    <div title="Marbre" class="flex items-center bg-gray-800 px-3 py-1 rounded-full"><img src="https://placehold.co/24x24/e2e8f0/000000?text=M" class="w-6 h-6 mr-2 rounded-full"><span>850</span></div>
                    <div title="Cristal" class="flex items-center bg-gray-800 px-3 py-1 rounded-full"><img src="https://placehold.co/24x24/0e7490/ffffff?text=C" class="w-6 h-6 mr-2 rounded-full"><span>340</span></div>
                    <div title="Soufre" class="flex items-center bg-gray-800 px-3 py-1 rounded-full"><img src="https://placehold.co/24x24/ca8a04/ffffff?text=S" class="w-6 h-6 mr-2 rounded-full"><span>90</span></div>
                </div>

                <!-- Or et Options -->
                <div class="flex items-center space-x-4">
                    <div title="Or" class="flex items-center"><img src="https://placehold.co/24x24/a16207/ffffff?text=G" class="w-6 h-6 mr-2 rounded-full"><span>12,540</span></div>
                    <a href="?action=loginAvatar&function=logout" class="text-gray-400 hover:text-white" title="Déconnexion">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                    </a>
                </div>
            </div>
        </header>

        <div class="flex flex-1 overflow-hidden">
            <!-- 2. Barre de navigation latérale -->
            <nav class="w-16 md:w-56 bg-gray-800 p-2 md:p-4 overflow-y-auto shadow-md z-10">
                <ul class="space-y-2">
                    <li><a href="?view=city" class="flex items-center p-2 rounded-lg text-white bg-gray-700"><span class="md:ml-3">Ville</span></a></li>
                    <li><a href="?view=island" class="flex items-center p-2 rounded-lg hover:bg-gray-700"><span class="md:ml-3">Île</span></a></li>
                    <li><a href="?view=world" class="flex items-center p-2 rounded-lg hover:bg-gray-700"><span class="md:ml-3">Monde</span></a></li>
                    <li><a href="?view=barracks" class="flex items-center p-2 rounded-lg hover:bg-gray-700"><span class="md:ml-3">Armées</span></a></li>
                    <li><a href="?view=academy" class="flex items-center p-2 rounded-lg hover:bg-gray-700"><span class="md:ml-3">Recherche</span></a></li>
                    <li><a href="?view=diplomacy" class="flex items-center p-2 rounded-lg hover:bg-gray-700"><span class="md:ml-3">Diplomatie</span></a></li>
                </ul>
            </nav>

            <!-- 3. Contenu principal du jeu -->
            <main id="main-view" class="flex-1 p-4 md:p-6 overflow-y-auto">
                
                <!-- Le contenu de cette section sera chargé dynamiquement -->
                <!-- par le contrôleur PHP en fonction du paramètre 'view' -->
                
                <!-- Exemple : Vue de la ville (ce que Templates/city.php pourrait contenir) -->
                <div id="city-view-content">
                    <h1 class="text-3xl font-bold text-white mb-4">Vue de la ville : Athènes</h1>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <!-- Emplacement de bâtiment -->
                        <div class="border-2 border-dashed border-gray-600 rounded-lg h-32 flex items-center justify-center hover:bg-gray-700 cursor-pointer">
                            <span class="text-gray-500">Emplacement libre</span>
                        </div>
                        <!-- Bâtiment existant -->
                        <div class="bg-gray-800 border border-gray-700 rounded-lg h-32 flex flex-col items-center justify-center p-2">
                            <h3 class="font-bold text-amber-400">Hôtel de ville</h3>
                            <p class="text-sm">Niveau 5</p>
                        </div>
                         <div class="bg-gray-800 border border-gray-700 rounded-lg h-32 flex flex-col items-center justify-center p-2">
                            <h3 class="font-bold text-amber-400">Caserne</h3>
                            <p class="text-sm">Niveau 3</p>
                        </div>
                         <div class="bg-gray-800 border border-gray-700 rounded-lg h-32 flex flex-col items-center justify-center p-2">
                            <h3 class="font-bold text-amber-400">Académie</h3>
                            <p class="text-sm">Niveau 2</p>
                        </div>
                        <div class="border-2 border-dashed border-gray-600 rounded-lg h-32 flex items-center justify-center hover:bg-gray-700 cursor-pointer">
                            <span class="text-gray-500">Emplacement libre</span>
                        </div>
                    </div>
                </div>

            </main>
        </div>

    </div>

</body>
</html>


<body>
</body>
</html>

