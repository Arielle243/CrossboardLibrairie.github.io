<?php

namespace App\Controller\Admin;

use App\Entity\Category;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
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

    public function createEntity(string $entityFqcn)
    {
        $category = new Category();
        //$category->setUsers($this->getUser());
        $category->setCreatedAt (new DatetimeIMMUTABLE('now'));
        $category->setUpdatedAt (new DatetimeIMMUTABLE('now'));
        return $category;
    }


    
    public function configureFields(string $pageName): iterable
    {
        
            yield  TextField::new('title', 'Titre');
                    //TextField::new('illustration'),
            yield  TextEditorField::new('description', 'Description');

            yield  DateTimeField::new('createdAt', 'Date d\'ajout')
                ->hideOnForm()
                ->setFormat('short', 'short');
        
            yield  DateTimeField::new('updatedAt', 'Mise à jour')
                ->hideOnForm()
                ->setFormat('short', 'short')
                ->HideOnIndex()
                ->hideWhenUpdating();

            yield  BooleanField::new('statut');
           
    }

    public function configureCrud(Crud $crud) : Crud
    {
    return $crud
        ->setEntityLabelInPlural('Catégories')
        ->setEntityLabelInSingular('Catégorie')
        ->setPageTitle('index', 'Crossboard Gestion des catégories')
        ->setPageTitle('new', 'Crossboard ajouter une catégorie')
        ->setPageTitle('edit', 'Crossboard Modifier une catégorie')
        ->setPageTitle('detail', 'Crossboard détail de la catégorie')
        ->setDefaultSort(['createdAt' => 'DESC']);
        
    }

    public function configureActions(Actions $actions): Actions
    {
         return $actions
            // ...
        ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER);
    }
    
}
