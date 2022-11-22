<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CommandeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commande::class;
    }

    
 /*    public function configureFields(string $pageName): iterable */
 /*    { *

 /*        //yield    IdField::new('id', 'Numéro de commande'); */
 /*       // yield    TextField::new('title', 'Nom de la commande'); */
 /*        //yield    TextEditorField::new('description', 'Description'); */
 /*     */
 /*    } */
    


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
            ->setPageTitle('index', 'Crossboard Gestion des commandes')
            ->setPageTitle('new', 'Crossboard ajouter une commande')
            ->setDefaultSort(['dateCommande' => 'ASC']);

        
            
    }

 
}
