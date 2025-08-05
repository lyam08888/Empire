<?php
// Inclusion du fichier de gestion de compte (à adapter si nécessaire)
// include("core/CAccount.php"); 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Meta-tags pour le référencement et l'information -->
    <title>Inscription - Empire - Le jeu de stratégie en ligne</title>
    <meta name="description" content="Rejoignez Empire, le jeu de stratégie gratuit par navigateur. Créez votre compte et commencez à bâtir votre civilisation dans le monde antique.">
    <meta name="keywords" content="inscription, créer un compte, jeu de stratégie, jeu en ligne, gratuit, empire">
    <meta name="author" content="Votre Nom/Studio">
    
    <!-- Favicon (à remplacer par votre propre icône) -->
    <link rel="icon" href="https://placehold.co/32x32/1e3a8a/ffffff?text=E" type="image/png">

    <!-- Tailwind CSS pour un design moderne et responsif -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts pour une typographie élégante -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">

    <style>
        /* Appliquer la police Inter à tout le corps du document */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0a192f; /* Un bleu nuit pour le fond */
        }
        /* Style pour le fond avec image et dégradé */
        .hero-background {
            background-image: linear-gradient(to bottom, rgba(10, 25, 47, 0.9), rgba(10, 25, 47, 1)), url('https://images.unsplash.com/photo-1519923834699-ef0b7cde4422?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
        }
        /* Style pour les messages d'erreur */
        .form-error {
            color: #ef4444; /* Rouge pour les erreurs */
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body class="text-gray-300">

    <div id="root" class="min-h-screen flex flex-col hero-background">

        <!-- En-tête et Navigation -->
        <header class="py-4 px-4 sm:px-6 lg:px-8">
            <div class="container mx-auto flex justify-between items-center">
                <a href="index.php" class="text-3xl font-black text-white tracking-wider">EMPIRE</a>
                <nav class="hidden md:flex items-center space-x-6">
                    <a href="tour_step1.php" class="hover:text-amber-400 transition duration-300">Visite du jeu</a>
                    <a href="board.php" target="_blank" class="hover:text-amber-400 transition duration-300">Forum</a>
                    <a href="index.php" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">Connexion</a>
                </nav>
                <!-- Menu burger pour mobile -->
                <button class="md:hidden text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
        </header>

        <!-- Contenu Principal : Formulaire d'inscription -->
        <main class="flex-grow flex items-center justify-center py-12">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 flex justify-center">
                <div class="w-full max-w-lg bg-slate-800 bg-opacity-70 backdrop-blur-sm p-8 rounded-2xl shadow-2xl border border-slate-700">
                    <h2 class="text-3xl font-bold text-white mb-8 text-center">Créez votre compte</h2>
                    <form id="RegisterForm" name="RegisterForm" action="register.php" method="post">
                        
                        <!-- Champ Monde -->
                        <div class="mb-4">
                            <label for="universe" class="block text-sm font-medium text-gray-300 mb-1">Choisissez votre monde</label>
                            <select id="universe" name="universe" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-2.5 focus:ring-amber-500 focus:border-amber-500">
                                <option selected>Alpha</option>
                                <option>Beta</option>
                                <option>Gamma</option>
                            </select>
                        </div>

                        <!-- Champ Nom d'utilisateur -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-300 mb-1">Nom d'utilisateur</label>
                            <input type="text" id="name" name="name" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-2.5 focus:ring-amber-500 focus:border-amber-500" placeholder="Ex: Cesar123" value="<?php /* echo $form->getValue('name'); */ ?>">
                            <div class="form-error"><?php /* echo $form->getError('name'); */ ?></div>
                        </div>

                        <!-- Champ Mot de passe -->
                        <div class="mb-4">
                            <label for="pw" class="block text-sm font-medium text-gray-300 mb-1">Mot de passe</label>
                            <input type="password" id="pw" name="pw" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-2.5 focus:ring-amber-500 focus:border-amber-500" placeholder="••••••••">
                            <div class="form-error"><?php /* echo $form->getError('pw'); */ ?></div>
                        </div>

                        <!-- Champ E-mail -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Adresse e-mail</label>
                            <input type="email" id="email" name="email" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-2.5 focus:ring-amber-500 focus:border-amber-500" placeholder="votre.email@exemple.com" value="<?php /* echo $form->getValue('email'); */ ?>">
                            <div class="form-error"><?php /* echo $form->getError('email'); */ ?></div>
                        </div>

                        <!-- Checkbox Conditions d'utilisation -->
                        <div class="mb-6">
                            <div class="flex items-center">
                                <input id="agb" name="agb" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-amber-600 focus:ring-amber-500 bg-slate-700">
                                <label for="agb" class="ml-2 block text-sm text-gray-300">
                                    J'accepte les <a href="conditions.htm" target="_blank" class="font-medium text-amber-400 hover:underline">Conditions d'utilisation</a>.
                                </label>
                            </div>
                            <div class="form-error"><?php /* echo $form->getError('agree'); */ ?></div>
                        </div>
                        
                        <!-- Bouton d'inscription -->
                        <button type="submit" name="loginMode" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 px-4 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                            S'inscrire
                        </button>
                        
                        <input name="ft" type="hidden" value="a1" />
                    </form>
                </div>
            </div>
        </main>

        <!-- Pied de page -->
        <footer class="py-6 px-4 sm:px-6 lg:px-8 mt-auto">
            <div class="container mx-auto text-center text-gray-500">
                <p>&copy; 2024 Empire - Tous droits réservés.</p>
            </div>
        </footer>

    </div>

</body>
</html>
