# Déploiement Sounkoue sur Render

## Configuration PostgreSQL

Votre base de données PostgreSQL Render est configurée avec :
- Host: `dpg-d4mun11r0fns73ah6e1g-a.oregon-postgres.render.com`
- Port: `5432`
- Database: `sounkoue_db`
- Username: `sounkoue_user`
- Password: `o1oaDCavj9OqpITOPvJtsObq1NXbgZXo`

## Fichiers de configuration

1. **`.env.production`** - Configuration de production avec PostgreSQL
2. **`render.yaml`** - Configuration automatique pour Render
3. **`docker/start.sh`** - Script de démarrage amélioré avec retry de connexion DB

## Déploiement sur Render

### Option 1: Via render.yaml (Recommandé)
1. Commitez tous les fichiers
2. Connectez votre repo GitHub à Render
3. Le fichier `render.yaml` configurera automatiquement le service

### Option 2: Configuration manuelle
1. Créez un nouveau Web Service sur Render
2. Connectez votre repo GitHub
3. Configurez les variables d'environnement :
   ```
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://sounkoue.onrender.com
   DB_CONNECTION=pgsql
   DB_HOST=dpg-d4mun11r0fns73ah6e1g-a.oregon-postgres.render.com
   DB_PORT=5432
   DB_DATABASE=sounkoue_db
   DB_USERNAME=sounkoue_user
   DB_PASSWORD=o1oaDCavj9OqpITOPvJtsObq1NXbgZXo
   DB_SSLMODE=require
   ```

## Test local avec Docker

```bash
# Build et test
./build-and-test.sh

# Ou manuellement
docker build -t sounkoue-app .
docker run -p 8080:80 sounkoue-app
```

## Vérification

- Health check: `https://sounkoue.onrender.com/health.php`
- Application: `https://sounkoue.onrender.com`

## Résolution des problèmes

1. **Connexion DB échoue** : Vérifiez que SSL est activé (`sslmode=require`)
2. **Timeout de connexion** : Le script de démarrage retry automatiquement 30 fois
3. **Migrations échouent** : Vérifiez les logs Render pour les erreurs spécifiques