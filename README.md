# 🚀 Projet Gestion des Stages

Ce projet est une **application web PHP avec PostgreSQL** permettant de gérer les stages des étudiants. Elle offre des fonctionnalités pour gérer les utilisateurs, les stages, les actions, et les entreprises.

## 📋 Prérequis

Avant de commencer, assurez-vous d'avoir installé :
- **Apache** (ou un autre serveur web compatible PHP)
- **PHP 7.4+**
- **PostgreSQL**
- **Git**

## 📂 Structure du projet
```
/gestion-stages/
├── /config/
│   └── database.php          # Configuration de la base de données
├── /public/
│   ├── index.php             # Point d'entrée principal
│   └── /frontend/            # Dossier contenant le frontend
│       ├── index.html        # Page d'accueil
│       ├── style.css         # Fichier CSS
│       └── app.js            # Fichier JavaScript pour les appels API
├── /routes/
│   ├── utilisateurs.php      # Routes pour la gestion des utilisateurs
│   ├── stages.php            # Routes pour la gestion des stages
│   └── actions.php           # Routes pour la gestion des actions
├── /models/
│   ├── Utilisateur.php       # Modèle de la table Utilisateur
│   ├── Stage.php             # Modèle de la table Stage
│   └── Action.php            # Modèle de la table Action
├── /utils/
│   └── Response.php          # Classe utilitaire pour les réponses JSON
└── .env                      # Fichier de configuration des variables d'environnement
```

## ⚙️ Installation

### 1️⃣ **Cloner le dépôt**
```bash
git clone https://github.com/ton-projet/gestion-stages.git
cd gestion-stages
```

### 2️⃣ **Configurer la base de données PostgreSQL**
Créez la base de données PostgreSQL en exécutant les commandes suivantes :
```sql
CREATE DATABASE gestion_stages;
```
Importez le fichier SQL fourni :
```bash
psql -U postgres -d gestion_stages -f chemin/vers/gestion_stages_sql.sql
```

### 3️⃣ **Configurer le fichier `.env`**
Créez un fichier `.env` à la racine du projet avec le contenu suivant :
```
DB_USER=postgres
DB_PASSWORD=ton_mot_de_passe
DB_NAME=gestion_stages
DB_HOST=localhost
DB_PORT=5432
```

### 4️⃣ **Déplacer le projet dans le dossier racine du serveur Apache**
Sur macOS :
```bash
sudo cp -r gestion-stages /Library/WebServer/Documents/
```
Sur Linux :
```bash
sudo cp -r gestion-stages /var/www/html/
```

### 5️⃣ **Démarrer le serveur Apache**
Sur macOS :
```bash
sudo apachectl start
```
Sur Linux :
```bash
sudo service apache2 start
```

### 6️⃣ **Accéder au projet**
Ouvrez votre navigateur et accédez à l'adresse suivante :
```
http://localhost/gestion-stages/public/frontend/index.html
```

## 📋 Fonctionnalités
- Gestion des utilisateurs (création, récupération)
- Gestion des stages (création, mise à jour, suppression)
- Gestion des actions liées aux stages
- Notifications automatiques

## 🔒 Sécurisation
Pour sécuriser votre application :
1. Ne partagez jamais votre fichier `.env`.
2. Utilisez des requêtes préparées pour éviter les attaques par injection SQL.
3. Désactivez l'affichage des erreurs PHP en production :
   - Modifiez le fichier **`php.ini`** :
     ```ini
     display_errors = Off
     log_errors = On
     ```

## 🛠️ Déploiement en ligne
Pour déployer votre projet en ligne :
1. **Transférez les fichiers** sur un serveur distant via **FTP** ou **SSH**.
2. **Configurez le serveur Apache** pour pointer vers le dossier du projet.
3. Accédez à votre projet depuis une URL publique.

## 📧 Contact
Pour toute question, contactez :
- **Nom** : [Votre Nom]
- **Email** : [Votre Email]

---

© 2025 Gestion des Stages. Tous droits réservés.

