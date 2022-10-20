<?php

namespace App\Controller\Admin;

use App\Entity\Souscategory;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SouscategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Souscategory::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [

            TextField::new('title', 'Nom'),
            TextField::new('description'),
        ];
    }
    
}
