# temp
Voici les étapes pour cloner le projet, utiliser Docker Compose, et importer une base de données dans PHPMyAdmin :

---

## Étape 1 : Cloner le projet en local
1. **Ouvrez un terminal.**
2. **Naviguez vers le dossier où vous souhaitez cloner le projet :**
   ```bash
   cd /chemin/vers/votre/dossier
   ```
3. **Clonez le projet :**
   ```bash
   git clone https://github.com/mohammedAhadjji/temp.git
   ```
4. **Entrez dans le dossier du projet :**
   ```bash
   cd temp.git
   ```

---

## Étape 2 : Configurer Docker
1. **Assurez-vous que Docker et Docker Compose sont installés sur votre machine.**  
   Vous pouvez vérifier avec :  
   ```bash
   docker --version
   docker-compose --version
   ```

2. **Vérifiez le fichier `docker-compose.yml` dans le projet** pour s'assurer qu'il contient les services nécessaires (comme `php`, `mysql`, `phpmyadmin`, etc.).

3. **Lancer les conteneurs avec Docker Compose :**
   ```bash
   docker-compose up -d
   ```
   - **Options importantes :**
     - `-d` : Exécute les conteneurs en arrière-plan.
     - Sans `-d`, vous pouvez voir les logs en direct.

4. **Vérifiez que les conteneurs sont démarrés :**
   ```bash
   docker ps
   ```

---

## Étape 3 : Accéder à PHPMyAdmin
1. **Ouvrez votre navigateur et accédez à PHPMyAdmin :**
   ```
   http://localhost:9110
   ```
   
2. **Connectez-vous :**
   - Serveur : `mysql`
   - Nom d'utilisateur : `root`
   - Mot de passe : `root` par défaut.

---

## Étape 4 : Importer la base de données
1. Dans PHPMyAdmin :
   - Sélectionnez ou créez une nouvelle base de données.
   - Cliquez sur l'onglet **Importer**.

2. **Téléchargez le fichier SQL :**
   - Localisez et sélectionnez le fichier `DB/db.sql` du projet.

3. **Lancez l'importation.**  
   Si tout est correctement configuré, les tables de la base de données seront importées.

---

## Étape 5 : Tester l'application
1. **Ouvrez votre navigateur et accédez à l'application Symfony :**
   ```
   http://localhost:8080
   ```
