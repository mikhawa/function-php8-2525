<?php

namespace App\Controller\Admin;

use App\Entity\PhpFunction;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PhpFunctionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PhpFunction::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // classés par titre croissant
            ->setDefaultSort(['title' => 'ASC'])
            // Nombre d'articles par page
            ->setPaginatorPageSize(20)
            // Titres des pages
            ->setPageTitle('index', 'Liste des fonctions')
            ->setPageTitle('new', 'Créer une fonction')
            ->setPageTitle('edit', 'Modifier une fonction');

    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextField::new('slug'),
            TextField::new('description'),
            TextEditorField::new('text'),

        ];
    }

}
