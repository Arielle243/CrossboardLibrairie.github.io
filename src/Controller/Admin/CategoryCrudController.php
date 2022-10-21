<?php

namespace App\Controller\Admin;

use App\Entity\Category;

use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Titre'),
            //TextField::new('illustration'),
            TextEditorField::new('description', 'Description'),
            DateTimeField::new('createdAt', 'Date d\'ajout')->hideOnForm(),
            DateTimeField::new('updatedAt', 'Mise à jour')->hideWhenCreating(),
            BooleanField::new('statut'),
           
        ];
    }
    
}
