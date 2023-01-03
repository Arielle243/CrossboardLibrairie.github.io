<?php

namespace App\Controller\Admin;

use App\Entity\Rayon;
use DatetimeIMMUTABLE;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RayonCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Rayon::class;
    }



    public function createEntity(string $entityFqcn)
    {
        $rayon= new Rayon();
        // $rayon->setUsers($this->getUser());
        $rayon->setCreatedAt (new DatetimeIMMUTABLE('now'));
        $rayon->setUpdatedAt (new DatetimeIMMUTABLE('now'));

        return $rayon;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->HideOnForm(),
            TextField::new('name'),
            TextEditorField::new('description'),
            DateTimeField::new('createdAt')
                ->HideOnForm()
                ->hideOnIndex(),
            DateTimeField::new('updatedAt')
                ->HideOnForm()
                ->hideOnIndex(),
            BooleanField::new('statut', 'Statut'),
        ];
    }
    
    public function configureCrud(Crud $crud) : Crud
    {
        return $crud
            ->setEntityLabelInPlural('Rayons')
            ->setEntityLabelInSingular('Rayon')
            ->setPageTitle('index', 'Crossroard Gestion des Rayons')
            ->setPageTitle('new', 'Crossroard Ajouter un rayon');
    }


      //--------------------- MODIFIER LES ACTIONS du crud----------------------------------- 
  public function configureActions(Actions $actions): Actions
  {
       return $actions
          // ...
      ->add(Crud::PAGE_INDEX, Action::DETAIL)
      ->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER);
  }
}
