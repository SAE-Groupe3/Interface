# 🌟 Gestion des Stages IUT - README

Bienvenue dans le projet **Gestion des Stages IUT** ! Ce document vous guidera pour cloner le projet, installer Docker et exécuter les commandes nécessaires pour démarrer rapidement.

---

## 🚀 Prérequis

Avant de commencer, assurez-vous d'avoir :

1. **Git** installé sur votre machine.
2. **Docker** et **Docker Compose** installés.

### 📦 Installation de Docker

- Suivez [ce guide officiel Docker](https://docs.docker.com/get-docker/) pour installer Docker sur votre système.
- Assurez-vous que Docker Compose est inclus ou installez-le séparément si nécessaire.

Pour vérifier que Docker est correctement installé :
```bash
docker --version
docker-compose --version
```

---

## 📥 Cloner le projet

Clonez ce dépôt en utilisant la commande suivante :

```bash
git clone https://github.com/votre-utilisateur/votre-repo.git
```

Déplacez-vous dans le répertoire du projet :

```bash
cd votre-repo
```

---

## 🛠️ Lancer le projet avec Docker

### Étape 1 : Construire les images Docker

Exécutez la commande suivante pour construire les images nécessaires :

```bash
docker-compose build
```

### Étape 2 : Lancer les conteneurs

Une fois la construction terminée, démarrez les services avec :

```bash
docker-compose up
```

💡 **Astuce** : Utilisez `docker-compose up -d` pour démarrer en mode détaché.

### Étape 3 : Accéder à l'application

- **Frontend** : [http://localhost:3000](http://localhost:3000)
- **Backend** : [http://localhost:8000](http://localhost:8000)

---

## 🔧 Commandes utiles

### Arrêter les conteneurs
```bash
docker-compose down
```

### Recréer un conteneur après des modifications
```bash
docker-compose up --build
```

### Vérifier les logs
```bash
docker-compose logs -f
```

---

## 🌟 Contribution

Nous accueillons toutes les contributions avec enthousiasme ! Voici comment vous pouvez aider :

1. Forkez le dépôt.
2. Créez une branche pour votre fonctionnalité ou correction de bug.
3. Ouvrez une Pull Request.

---

Merci d'avoir choisi **Gestion des Stages IUT** 🎉 !
