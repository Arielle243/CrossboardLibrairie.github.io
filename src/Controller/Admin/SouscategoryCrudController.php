<?php

namespace App\Controller\Admin;

use App\Entity\Souscategory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SouscategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Souscategory::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
