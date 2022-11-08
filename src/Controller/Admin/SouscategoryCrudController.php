<?php

namespace App\Controller\Admin;

use App\Entity\Souscategory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
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
            TextField::new('description', 'Description'),
            //DateTimeField::new('createdAt', 'Date d\'ajout'),
            BooleanField::new('statut','Statut'),
        ];
    }
    


    public function configureCrud(Crud $crud) : Crud
    {
        return $crud
            ->setEntityLabelInPlural('Sous-catégories')
            ->setEntityLabelInSingular('Sous-catégorie')
            ->setPageTitle('index', 'Crossboard Gestion des sous-catégories')
            ->setPageTitle('new', 'Crossboard ajouter une sous-catégorie');
 
    }


    public function configureActions(Actions $actions): Actions
    {
         return $actions
            // ...
        ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER);
    }
}
