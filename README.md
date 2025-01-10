# function-php8-2025

Pour mettre à jour la version de MariaDB, il faut d'abord arrêter le service MariaDB et ajouter dans son fichier de configuration `my.ini` les lignes suivantes :

```bash
[mysqld]
port=3307
character-set-server=utf8mb4
collation-server=utf8mb4_unicode_ci
```

Ensuite, on redémarre le service MariaDB et on se connecte à la base de données pour vérifier que les modifications ont bien été prises en compte, voir `.env.dev` :

```bash
php bin/console doctrine:database:create
```