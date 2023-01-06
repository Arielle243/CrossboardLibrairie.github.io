<?php

namespace App\Controller\Admin;

use DatetimeIMMUTABLE;
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



         public function createEntity(string $entityFqcn)
 {
     $souscategory= new Souscategory();
    //  $souscategory->setUsers($this->getUser());
     $souscategory->setCreatedAt (new DatetimeIMMUTABLE('now'));
     $souscategory->setUpdatedAt (new DatetimeIMMUTABLE('now'));
     return $souscategory;
 }
    
    public function configureFields(string $pageName): iterable
    {
        return [

            TextField::new('title', 'Nom'),
            TextField::new('description', 'Description')
                ->hideOnIndex(),
            DateTimeField::new('createdAt', 'Date d\'ajout')
                ->HideOnForm()
                ->hideOnIndex(),
            BooleanField::new('statut','Statut'),
        ];
    }
    


    public function configureCrud(Crud $crud) : Crud
    {
        return $crud
            ->setEntityLabelInPlural('Sous-catégories')
            ->setEntityLabelInSingular('Sous-catégorie')
            ->setPageTitle('index', 'Crossroard Gestion des sous-catégories')
            ->setPageTitle('new', 'Crossroard ajouter une sous-catégorie');
 
    }


    public function configureActions(Actions $actions): Actions
    {
         return $actions
            // ...
        ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER);
    }
}
