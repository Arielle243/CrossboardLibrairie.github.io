<?php

namespace App\Controller\Admin;

use App\Entity\Rayon;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RayonCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Rayon::class;
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
