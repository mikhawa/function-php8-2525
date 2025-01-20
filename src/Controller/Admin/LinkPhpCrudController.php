<?php

namespace App\Controller\Admin;

use App\Entity\LinkPhp;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LinkPhpCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LinkPhp::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [

            TextField::new('title'),
            TextEditorField::new('description'),
            TextField::new('url'),
        ];
    }

}
