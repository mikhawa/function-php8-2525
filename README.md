# function-php8-2025

## Development

### Date : 2025-01-13

Versions : 

- Symfony 7.2.2
- PHP 8.3.14
- MariaDB 11.5.2

### DB MariaDB utf8mb4_general_ci

Pour mettre à jour la version de **MariaDB** en `utf8mb4_general_ci`, il faut d'abord arrêter le service **MariaDB** et ajouter dans son fichier de configuration `my.ini` les lignes suivantes :

```bash
[mysqld]
port=3307
character-set-server=utf8mb4
collation-server=utf8mb4_general_ci
```

Ensuite, on redémarre le service **MariaDB**.

Le fichier `.env.dev` doit être mis à jour avec le port de MariaDB :

```bash
###> doctrine/doctrine-bundle ###
DATABASE_URL="mysql://root:@127.0.0.1:3307/fphp8?serverVersion=11.5.2-MariaDB&charset=utf8mb4"
###< doctrine/doctrine-bundle ###
```

On crée la base de données pour vérifier que les modifications ont bien été prises en compte, voir `.env.dev` :

```bash
php bin/console doctrine:database:create
```

### Dossier `datas`

Ce dossier contiendra les données de création de la base de données, ainsi que le template utilisé pour le site.

## Les entités

Elles seront créées dans le dossier `src/Entity` via la commande :

```bash
php bin/console make:entity
```

### Entité `PhpFunction`

```bash
php bin/console make:entity 
> PhpFunction
> no

> title
> string
> 120
> no

> slug
> string
> 125
> no

> description
> string
> 255
> no

> text
> text
> no

> visibility
> boolean
> no

> createdAt
> datetime
> no

> updatedAt
> datetime
> yes

```

#### Améliorations pour `MariaDB` avant la migration

```php
# src/Entity/PhpFunction.php
# ...
# DateTimeInterface
use DateTimeInterface;
# ...
/*
 #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
transformation en unsigned :
 */
#[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(
        type: Types::INTEGER,
        options: ['unsigned' => true]
    )]
    private ?int $id = null;
# ...

```

Préparation de la migration :

```bash
php bin/console make:migration
```
