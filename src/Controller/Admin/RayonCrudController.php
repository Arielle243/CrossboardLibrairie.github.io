<?php

namespace App\Controller\Admin;

use App\Entity\Rayon;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
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


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->HideOnForm(),
            TextField::new('name'),
            TextEditorField::new('description'),
            DateTimeField::new('createdAt')->HideOnForm(),
            DateTimeField::new('updatedAt')->HideOnForm(),
            BooleanField::new('statut', 'Statut'),
        ];
    }
    
    public function configureCrud(Crud $crud) : Crud
    {
        return $crud
            ->setEntityLabelInPlural('Rayons')
            ->setEntityLabelInSingular('Rayon')
            ->setPageTitle('index', 'Crossboard Gestion des Rayons')
            ->setPageTitle('new', 'Crossboard Ajouter un rayon');
    }
}
