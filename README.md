# **Gestion Financière - Application Web**

## **Description**
Cette application web de gestion financière est conçue pour faciliter la saisie des états financiers et le diagnostic financier. Développée avec **Laravel**, permet de gérer les comptes annuels, d'effectuer des analyses financières, et de produire des rapports financiers.

### **Architecture de Dossier**

Le projet est organisé de la manière suivante :

- `src/` : Dossier contenant le code source de l'application.
- `docs/` : Dossier contenant la documentation technique et la présentation.
- `data/` : Dossier contenant les exemples de données utilisées.
- `pix/` : Dossier contenant les illustrations utilisées dans le site.
- `screenshots/` : Dossier contenant les captures d'écran de l'application.

### **Auteurs**

Ce projet est dévéloppé par deux personnes :
- `BOTOTALA Anniella Stephanie`: anniella3355@gmail.com
- `RAJAONARISOA Jeannique Ronaldine`: rajaonarisoajeannique@gmail.com

## **Fonctionnalités**

### **Authentification et Gestion des Utilisateurs**
- **Authentification Sécurisée** : Inscription, connexion, et gestion des sessions des utilisateurs.
- **Gestion des Rôles** : Attribution de rôles (Administrateur ou Gestionnaire) avec des permissions spécifiques pour chaque rôle.
- **Gestion des Utilisateurs** : Création, modification, et suppression des utilisateurs avec possibilité de définir leur rôle et leurs informations.

### **Gestion des États Financiers**
- **Saisie des États Financiers** : Interface pour entrer les données financières périodiques (bilan, compte de résultat).
- **Gestion des Actifs et Passifs** : Enregistrement et gestion des actifs (courants et non courants) et passifs (courants et non courants).

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
  ```bash
  php -v
  ```

#### **Extensions nécessaires**
- Activer les extensions dans le fichier `php.ini`
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
- **Version requise** : Git >= 2.X
  ```bash
  git --version
  ```

### **Composer**
- **Version requise** : Composer >= 2.X
  ```bash
  composer --version
  ```

### **Laravel**
- **Version requise** : Laravel >= 10.X

### **Base de données**
- **Type requis** : SQLite

  ```bash
  php -i | grep sqlite
  ```

### **Laravel Livewire**
- **Version requise** : Laravel Livewire >= 3.x

## **Installation**

Suivez ces étapes pour installer et configurer l'application web de gestion financière :

1. **Cloner le dépôt**
   - Clonez le dépôt Git contenant le code source de l'application. A noter que le code source de l'application se trouve dans le dossier `src`.
   ```bash
   git clone https://github.com/Stephanie1351/MIA_L3_GF2024.git
   cd MIA_L3_GF2024/src
   git clone https://github.com/Stephanie1351/MIA_L3_GF2024.git
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

## **Utilisation**

- **Administrateur** :
  - Accès: anniella3355@gmail.com / default
  - Gestion des utilisateurs, gestion des opérations, Gestion des formules.
- **Gestionnaire** :
  - Accès: rajaonarisoajeannique@gmail.com / default
  - Saisi des états financiers, analyse des résultats
