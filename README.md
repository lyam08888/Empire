# 🏛️ Empire - Jeu de Stratégie

Un jeu de stratégie complet et immersif inspiré des grands empires antiques, développé en HTML5, CSS3 et JavaScript vanilla.

## 🎮 Comment jouer

### Démarrage rapide
1. Ouvrez `action.html` dans votre navigateur
2. Suivez le tutoriel de bienvenue
3. Commencez par construire des bâtiments de production
4. Explorez les différentes vues du jeu

### Interface principale
- **Header** : Ressources, niveau du joueur, achievements
- **Navigation gauche** : Accès aux différentes vues
- **Vue centrale** : Contenu principal (ville, monde, recherche, etc.)
- **Panneau droit** : Informations contextuelles et files d'attente
- **Footer** : Journal d'événements et boutons d'action

## 🏗️ Système de construction

### Types de bâtiments
- **Hôtel de Ville** : Augmente population et revenus
- **Académie** : Génère des points de recherche
- **Caserne** : Permet le recrutement d'unités
- **Entrepôt** : Augmente la capacité de stockage
- **Bâtiments de production** : Foresterie, Cave à Vin, Carrière, etc.
- **Bâtiments défensifs** : Muraille, Tours de guet
- **Bâtiments spécialisés** : Marché, Port, Chantier Naval

### Mécaniques
- Chaque bâtiment peut être amélioré jusqu'au niveau 2
- Les coûts augmentent avec le niveau
- Certains bâtiments génèrent des ressources passivement
- Les bâtiments spécialisés offrent des bonus uniques

## 💰 Système de ressources

### 7 types de ressources
1. **🌲 Bois** : Ressource de base pour la construction
2. **🍇 Vin** : Luxe, améliore le bonheur
3. **🏛️ Marbre** : Construction de bâtiments prestigieux
4. **💎 Cristal** : Recherche et magie
5. **🔥 Soufre** : Unités militaires et armes
6. **💰 Or** : Commerce et recrutement
7. **🔬 Recherche** : Développement technologique

### Production
- Production de base automatique
- Bonus des bâtiments spécialisés
- Bonus de niveau du joueur
- Production hors ligne calculée au retour

## 🔬 Système de recherche

### 4 branches technologiques

#### 💰 Économie
- **Commerce** : +25% revenus en or
- **Expansion** : Permet la colonisation
- **Banque** : Génère des intérêts
- **Routes Commerciales** : -50% coûts de transport

#### ⚔️ Militaire
- **Tactiques** : +15% attaque des unités
- **Balistique** : Améliore les catapultes
- **Fortification** : +30% défense des murailles
- **Poudre à Canon** : Débloque unités avancées

#### 🔬 Science
- **Philosophie** : +20% production de recherche
- **Mathématiques** : -15% temps de construction
- **Ingénierie** : Débloque bâtiments avancés
- **Alchimie** : Transmutation des ressources

#### ⛵ Navigation
- **Cartographie** : Révèle 3 îles aléatoirement
- **Navigation** : +25% vitesse des navires
- **Astronomie** : Améliore l'exploration
- **Boussole** : -40% coûts d'exploration

## ⚔️ Système militaire

### 8 types d'unités
- **🛡️ Hoplite** : Unité de base défensive
- **🏹 Archer** : Attaque à distance
- **🏹 Catapulte** : Siège anti-bâtiments
- **🐎 Cavalier** : Unité rapide et mobile
- **🛡️ Phalange** : Formation défensive
- **👁️ Éclaireur** : Reconnaissance rapide
- **🐏 Bélier** : Destruction de murailles
- **⚕️ Médecin** : Soins aux unités

### Combat
- Simulateur de bataille interactif
- Calculs basés sur l'attaque et la défense
- Pertes proportionnelles réalistes
- Système de butin variable

## 🌍 Exploration et colonisation

### Carte du monde
- Grille 15x15 avec îles à découvrir
- 3 actions possibles : Explorer, Coloniser, Attaquer
- Coûts en ressources pour chaque action
- Révélation progressive du monde

### Types de territoires
- **Îles neutres** : À coloniser
- **Îles ennemies** : À attaquer
- **Îles alliées** : Partenaires commerciaux
- **Îles de ressources** : Bonus spéciaux

## 🏆 Système de progression

### Niveaux et XP
- Gain d'XP pour toutes les actions
- Bonus de +10% ressources à chaque niveau
- XP requis : niveau × 100

### 13 Achievements à débloquer
- **Constructeur** : 5, 15, 30 bâtiments
- **Chercheur** : 3, 8 recherches
- **Militaire** : 20, 50 unités
- **Économique** : 10k, 50k or
- **Exploration** : 10 îles, 3 colonies
- **Progression** : Niveaux 5 et 10

## 📱 Compatibilité

### Desktop
- Interface complète avec tous les panneaux
- Navigation par clics
- Tooltips détaillés
- Files d'attente visibles

### Mobile
- Navigation par onglets en bas
- Interface adaptée aux petits écrans
- Modales pour les actions
- Optimisé pour le tactile

## 🔧 Fonctionnalités techniques

### Sauvegarde
- Sauvegarde automatique toutes les 30 secondes
- Sauvegarde manuelle disponible
- Données stockées localement (localStorage)
- Migration automatique des anciennes sauvegardes

### Performance
- Boucle de jeu optimisée (1 seconde)
- Gestion d'erreurs robuste
- Production hors ligne calculée
- Interface réactive

## 🎯 Conseils de jeu

### Débutants
1. Construisez d'abord des bâtiments de production
2. Recherchez "Commerce" pour augmenter vos revenus
3. Explorez les îles proches pour étendre votre territoire
4. Équilibrez construction et recherche

### Avancés
1. Optimisez vos chaînes de production
2. Planifiez vos recherches selon vos objectifs
3. Utilisez le simulateur de bataille avant d'attaquer
4. Visez les achievements pour des bonus XP

## 🐛 Dépannage

### Problèmes courants
- **Jeu qui ne se charge pas** : Vérifiez la console du navigateur
- **Sauvegarde perdue** : Vérifiez le localStorage du navigateur
- **Interface cassée** : Actualisez la page (F5)
- **Ressources négatives** : Utilisez le bouton Reset

### Reset du jeu
Utilisez le bouton "🔄 Reset" dans le footer pour recommencer complètement.

## 📞 Support

Pour signaler des bugs ou suggérer des améliorations, consultez le fichier `AMELIORATIONS.md` qui détaille toutes les fonctionnalités implémentées.

---

**Amusez-vous bien dans votre conquête de l'empire ! 🏛️👑**