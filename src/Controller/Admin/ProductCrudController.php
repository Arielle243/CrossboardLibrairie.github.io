<?php

namespace App\Controller\Admin;

use App\Entity\Product;

use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{
    //pour faire appel au dossier images
    public const PRODUCTS_BASE_PATH ='upload/images/products';
    public const PRODUCTS_UPLOAD_DIR ='public/upload/images/products';

    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            //IdField::new('id'),
            ImageField::new('illustration', 'Image du produit')
            ->setBasePath(self::PRODUCTS_BASE_PATH)
            ->setUploadDir(self::PRODUCTS_UPLOAD_DIR),

            TextField::new('title', 'Nom du produit'),
            TextEditorField::new('excerpt', 'Résumé'),
            TextEditorField::new('description', 'Description'),
            TextField::new('author', 'Auteurs'),
            DateField::new('publishedAt', 'Date de parution'),
            TextField::new('format', 'Format'),
            MoneyField::new('price', 'Prix')->setCurrency('EUR'),
            TextField::new('isbn', 'ISBN'),
            TextField::new('langues', 'Langues'),
            TextField::new('age', 'Âges'),
            BooleanField::new('statut', 'Statut'),
            AssociationField::new('category', 'Choisir les catégories'),
            //AssociationField::new('souscategory', 'Choisir les sous-catégories'),
            IntegerField::new('stock', 'Stock'),
            DateTimeField::new('createdAt', 'Ajouter le')->hideOnForm(),
            DateTimeField::new('updatedAt', 'Modifier le')->hideWhenCreating(),
            TextField::new('createdBy','Ajouter par'),

        ];
    }
    
}
