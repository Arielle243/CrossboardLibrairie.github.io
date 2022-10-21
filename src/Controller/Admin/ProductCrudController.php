<?php

namespace App\Controller\Admin;

use App\Entity\Product;

use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
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

            IdField::new('id')->hideOnForm(),
            ImageField::new('illustration', 'Image du produit')
                ->setBasePath(self::PRODUCTS_BASE_PATH)
                ->setUploadDir(self::PRODUCTS_UPLOAD_DIR),

            TextField::new('title', 'Nom du produit'),
            TextEditorField::new('excerpt', 'Résumé'),
            TextEditorField::new('description', 'Description'),
            TextField::new('author', 'Auteurs'),
            DateField::new('publishedAt', 'Date de parution')
                ->setFormat('dd.MM.yyyy'),

            ChoiceField::new('format', 'Format')
                ->setChoices([
                'Poche'=>'poche',
                'Broché'=>'broche',
                'Relié'=>'relie',
                'Audio'=>'audio',
                
            ]),

            MoneyField::new('price', 'Prix')->setCurrency('EUR'),
            TextField::new('isbn', 'ISBN'),
            ChoiceField::new('langues', 'Langues')
            ->setChoices([
                'Français'=>'francais',
                'Anglais'=>'anglais',
                
            ]),
            TextField::new('age', 'Âges'),
            TextField::new('editor', 'Éditeur'),
  
            
            AssociationField::new('category', 'Choisir les catégories')
                ->setQueryBuilder(function (QueryBuilder $queryBuilder){ // pour montrer que les catégories actives.
                    $queryBuilder
                        ->where('entity.statut=true')
                        ->orderBy('entity.createdAt', 'ASC');
                }),
            //AssociationField::new('lignecommande', 'Ajouter par'),
                //->setQueryBuilder(function (QueryBuilder $queryBuilder){ 
                //$queryBuilder->where('entity.statut=true');
            //}),
            AssociationField::new('souscategory', 'Choisir les sous-catégories')
                ->setQueryBuilder(function (QueryBuilder $queryBuilder){
                  $queryBuilder
                        ->where('entity.statut=true');
              }), 

            IntegerField::new('stock', 'Stock')
                ->formatValue(function ($value) {
                return $value < 10 ? sprintf('%d **LOW STOCK**', $value) : $value;}),

            DateTimeField::new('createdAt', 'Ajouter le')
                ->setFormat('dd.MM.yyyy HH:mm'),

            DateTimeField::new('updatedAt', 'Modifier le')
                ->hideWhenCreating()
                ->setFormat('dd.MM.yyyy HH:mm'),
            BooleanField::new('statut', 'Statut'),
            AssociationField::new('users', 'Ajouter par'),
            FormField::addRow(),


        ];
    }



    public function configureActions(Actions $actions): Actions
    {
         return $actions
            // ...
        ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER);
    }
    
}
