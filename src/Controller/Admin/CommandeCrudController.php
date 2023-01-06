<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CommandeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commande::class;
    }

    
     public function configureFields(string $pageName): iterable 
     { 

        yield    IdField::new('id', 'Numéro de commande'); 
        yield    TextField::new('title', 'Nom de la commande')
                    ->hideOnIndex(); 
        yield    TextField::new('statutcommande', 'Statut de la commande');
        yield    DateTimeField::new('createdAt', 'Date de la commande');
        yield    AssociationField::new('user', 'Client');
        yield    AssociationField::new('lignecommandes', 'Les produits')
                        ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
                        ->hideOnIndex()
                        ->setQueryBuilder(function (QueryBuilder $queryBuilder){
                          $queryBuilder
                                ->where('entity.statut=true')
                                ->setParameter();
                        });


        yield    NumberField::new('quantite', 'Quantité')->hideOnIndex();
     } 
    


     //--------------------- MODIFIER LES ACTIONS du crud----------------------------------- 
 public function configureActions(Actions $actions): Actions
 {
      return $actions
         // ...
     ->add(Crud::PAGE_INDEX, Action::DETAIL)
     ->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER);
 }


        //----------------MODIFIER CRUD ------------------------------------------------

    public function configureCrud(Crud $crud) : Crud
    {

        
        return $crud
            ->setEntityLabelInPlural('Commandes')
            ->setEntityLabelInSingular('Commande')
            ->setPageTitle('index', 'Crossroard Gestion des commandes')
            ->setPageTitle('new', 'Crossroard ajouter une commande')
            ->setDefaultSort(['createdAt' => 'ASC']);

        
            
    }

 
}
