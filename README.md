# **Gestion Financière - Application Web**

## **Description**
Cette application web de gestion financière est conçue pour les entreprises afin de faciliter la saisie des états financiers et le diagnostic financier. Développée avec **Laravel** (un framework PHP), elle permet aux utilisateurs de gérer les comptes annuels, d'effectuer des analyses financières approfondies, de simuler des performances futures, et de produire des rapports financiers. L'application offre une interface intuitive et des fonctionnalités robustes pour une gestion efficace des données financières.

### **Architecture de Dossier**

Le projet est organisé de la manière suivante :

- `src/` : Dossier contenant le code source de l'application.
- `docs/` : Dossier contenant la documentation technique et la présentation.
- `data/` : Dossier contenant les exemples de données utilisées.
- `pix/` : Dossier contenant les illustrations utilisées dans le site.
- `screenshots/` : Dossier contenant les captures d'écran de l'application.

### **Auteurs**

Ce projet est dévéloppé par deux développeurs :
- `RAZAFIMANANA Geraldo`: raharimananageraldo@gmail.com
- `RAFANOMEZANJANAHARY Larissia Louisette`: rafanomezanjanahary7@gmail.com

## **Fonctionnalités**

### **Authentification et Gestion des Utilisateurs**
- **Authentification Sécurisée** : Inscription, connexion, et gestion des sessions des utilisateurs.
- **Gestion des Rôles** : Attribution de rôles (Administrateur ou Gestionnaire) avec des permissions spécifiques pour chaque rôle.
- **Gestion des Utilisateurs** : Création, modification, et suppression des utilisateurs avec possibilité de définir leur rôle et leurs informations.

### **Gestion des États Financiers**
- **Saisie des États Financiers** : Interface pour entrer les données financières périodiques telles que les bilans, les comptes de résultat, et les flux de trésorerie.
- **Importation de Comptes Annuels** : Fonctionnalité pour importer les données des comptes annuels depuis des fichiers Excel ou CSV.
- **Gestion des Actifs et Passifs** : Enregistrement et gestion des actifs (courants et non courants) et passifs (courants et non courants) avec possibilité de modification et suppression.

### **Analyse Financière**
- **Calcul des Ratios Financiers** : Calcul automatique des ratios financiers clés tels que :
  - **Liquidité** : Capacité à couvrir les obligations à court terme.
  - **Solvabilité** : Capacité à couvrir les obligations à long terme.
  - **Rentabilité** : Analyse de la capacité à générer des bénéfices.
- **Analyse de la Structure Financière** : Évaluation de la répartition des actifs et passifs pour comprendre la structure financière globale de l'entreprise.
- **Prévisions Financières** : Simulation des performances futures basées sur les données historiques et les tendances financières actuelles.

## **Prérequis**

Avant de commencer l'installation de l'application web de gestion financière, assurez-vous que votre environnement de développement répond aux exigences suivantes :

### **PHP**
- **Version requise** : PHP >= 8.1
- **Installation** : Assurez-vous que PHP est correctement installé sur votre machine. Vous pouvez vérifier la version installée en utilisant la commande :
  ```bash
  php -v
  ```

#### **Activation des extensions nécessaires**
- Pour activer les extensions nécessaires, décommentez les lignes suivantes dans `php.ini`
  ```ini
  extension=bcmath
  extension=ctype
  extension=fileinfo
  extension=json
  extension=mbstring
  extension=openssl
  extension=pdo
  extension=tokenizer
  extension=xml
  extension=gzip
  extension=intl
  ```

### **Git**
- **Version requise** : **Git** (système de contrôle de version)
- **Installation** : Assurez-vous d'avoir Git installé sur votre machine pour gérer les versions de votre projet. Vous pouvez télécharger et installer Git en suivant les instructions sur [git-scm.com](https://git-scm.com/downloads). Vérifiez l'installation avec la commande suivante :
  ```bash
  git --version
  ```

### **Composer**
- **Version requise** : Composer (gestionnaire de dépendances PHP)
- **Installation** : Composer doit être installé pour gérer les dépendances PHP. Vous pouvez installer Composer en suivant les instructions sur [getcomposer.org](https://getcomposer.org/download/). Vérifiez l'installation avec :
  ```bash
  composer --version
  ```

### **Laravel**
- **Version requise** : Laravel >= 10.x
- **Installation** : Laravel sera installé via Composer. Vous n'avez pas besoin de l'installer séparément si vous suivez les instructions d'installation du projet.

### **Base de données**
- **Type requis** : SQLite
- **Installation** : SQLite est une base de données légère qui ne nécessite pas de serveur de base de données dédié. Assurez-vous que l'extension SQLite est activée dans votre configuration PHP. Vous pouvez vérifier la présence de SQLite avec :
  ```bash
  php -i | grep sqlite
  ```

### **Laravel Livewire**
- **Version requise** : Laravel Livewire >= 3.x
- **Installation** : Laravel Livewire sera installé via Composer. Vous n'avez pas besoin de l'installer séparément si vous suivez les instructions d'installation du projet.

## **Installation**

Suivez ces étapes pour installer et configurer l'application web de gestion financière :

1. **Cloner le dépôt**
   - Clonez le dépôt Git contenant le code source de l'application. A noter que le code source de l'application se trouve dans le dossier `src`.
   ```bash
   git clone https://github.com/geraldo-razafimanana/MIA_L3_GF2024.git
   cd MIA_L3_GF2024/src
   git clone https://github.com/geraldo-razafimanana/MIA_L3_GF2024.git
   cd MIA_L3_GF2024/src
   ```

2. **Installer les dépendances PHP**
   - Utilisez Composer pour installer les dépendances PHP spécifiées dans le fichier `composer.json`.
   ```bash
   composer install
   ```

3. **Configurer l'environnement**
   - Dupliquez le fichier `.env.example` et renommez-le en `.env`. Ce fichier contient les variables d'environnement nécessaires pour configurer l'application.
   ```bash
   cp .env.example .env
   ```
   - Ouvrez le fichier `.env` avec un éditeur de texte et configurez les paramètres suivants :
     - **DB_CONNECTION** : SQLite
       ```env
       DB_CONNECTION=sqlite
       ```
     - **Chemin de la base de données SQLite** : Par défaut, Laravel stocke les fichiers de base de données SQLite dans le dossier `database` du projet. Assurez-vous que le fichier de base de données SQLite est situé à l'emplacement suivant :
       ```env
       DB_DATABASE=database/database.sqlite
       ```
     - Vous pouvez laisser cette valeur telle quelle pour utiliser le chemin par défaut de Laravel.

4. **Générer la clé de l'application**
   - Laravel utilise une clé d'application pour sécuriser les sessions et autres données cryptées. Générez cette clé en exécutant la commande suivante :
   ```bash
   php artisan key:generate
   ```

5. **Migrer la base de données (Facultatif)**
   - Une base de donnée est déjà présent dans l'application qui se trouve dans `src/database/database.sqlite`
   - Si vous voulez utiliser l'applicarion avec une base de données fraîche, exécutez les migrations pour créer les tables nécessaires dans la nouvelle base de données SQLite qui sont dans le dossier `database/migrations`.
   ```bash
   php artisan migrate:fresh
   ```

6. **Lancer le serveur de développement**
   - Démarrez le serveur de développement Laravel. L'application sera accessible à l'adresse `http://localhost:8000` par défaut.
   ```bash
   php artisan serve
   ```

   Vous pouvez modifier le port ou l'adresse en ajoutant les options `--port` ou `--host` si nécessaire.

## **Utilisation**

- **Administrateur** :
  - Pour l'accès: raharimananageraldo@gmail.com / Test.2024
  - Accédez au tableau de bord pour gérer les utilisateurs, surveiller les activités et configurer l'application.
  - Ajouter des formules et les structures des tableaux
- **Gestionnaire** :
  - Pour l'accès: rafanomezanjanahary7@gmail.com / Default
  - Saisissez les états financiers, effectuez des analyses et voir les résultats.