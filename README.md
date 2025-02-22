# function-php8-2025

## Development

Vieux site :

https://web.archive.org/web/20200301161335/https://listphp.webdev-cf2m.be/

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
/*
#[ORM\Column()]
    private ?bool $visibility = null;
Pour avoir true par défaut :
 */
#[ORM\Column(
        type: Types::BOOLEAN,
        options: ['default' => true]
    )]
    private ?bool $visibility = null;
# ...
/*
#[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $createdAt = null;
Pour avoir la date courante par défaut et ne pas pouvoir l'insérer côté Symfony :
 */
#[ORM\Column(
        type: Types::DATETIME_MUTABLE,
        options: [
            'default' => 'CURRENT_TIMESTAMP',
            'insertable' => false
        ]
    )]
    private ?DateTimeInterface $createdAt = null;
# ...
/*
#[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $updatedAt = null;
Pour mettre à jour la date courante à chaque modification en passant par Symfony :
 */
#[ORM\Column(
        type: Types::DATETIME_MUTABLE, 
        nullable: true,
        options: [
            'insertable' => false,
            'updateable' => true,
        ]
    )]
    private ?DateTimeInterface $updatedAt = null;
```

Préparation de la migration :

```bash
php bin/console make:migration
```
suivi de la migration :

```bash
php bin/console doctrine:migrations:migrate
> yes
```

### Tests unitaires avec `PHPUnit` de `PhpFunction`

Création du dossier `tests/Entity` :

Création du fichier `PhpFunctionTest.php` où seront effectués les tests unitaires :

    tests/Entity/PhpFunctionTest.php

Vérification des tests unitaires :

```bash
vendor/bin/phpunit --testdox tests/Entity/PhpFunctionTest.php
```

Pour le moment, nous vérifions que l'entité `PhpFunction` est bien instanciée.

#### Création d'un formulaire provisoire pour `PhpFunction`

```bash
php bin/console make:form
> PhpFunctionType
> PhpFunction
```

Le formulaire est créé dans le dossier `src/Form/PhpFunctionType.php`.

Voici son contenu par défaut :

```php
<?php
# src/Form/PhpFunctionType.php

namespace App\Form;

use App\Entity\PhpFunction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PhpFunctionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('slug')
            ->add('description')
            ->add('text')
            ->add('visibility')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('updatedAt', null, [
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PhpFunction::class,
        ]);
    }
}
```

### Création d'un contrôleur pour `Homepage`

```bash
php bin/console make:controller
> HomepageController
> PHPUnit tests? yes
```

3 fichiers sont créés :

on modifie le fichier `src/Controller/HomepageController.php` :

```php
# src/Controller/HomepageController.php
#...
#[Route('/', name: 'homepage')]
    public function index(): Response
    {
        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
        ]);
    }
#...
```

et son test unitaire `tests/Controller/HomepageControllerTest.php` :

```php
# tests/Controller/HomepageControllerTest.php
#...
    public function testSomething(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');
        self::assertResponseIsSuccessful();
    }
#...
```
## Création du `User`

```bash
php bin/console make:user
> User
> username
> email
> password
> ROLE_USER
```


## chargement de esayadmin

```bash
composer require easycorp/easyadmin-bundle
```

```bash
php bin/console make:admin:dashboard
```

## Création de login

```bash
php bin/console make:security:form-login 
```

```bash
php bin/console security:hash-password
```

## DB fphp

![DB fphp](datas/fphp8.png)