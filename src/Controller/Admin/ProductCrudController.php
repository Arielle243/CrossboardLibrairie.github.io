<?php

namespace App\Controller\Admin;

use DatetimeIMMUTABLE;

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
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{
    /* //pour faire appel au dossier qui contient les images */
    /* public const PRODUCTS_BASE_PATH ='upload/images/products'; */
    /* public const PRODUCTS_UPLOAD_DIR ='public/upload/images/products'; */



    public static function getEntityFqcn(): string
    {
        return Product::class;
    }


    public function createEntity(string $entityFqcn)
    {
        $product= new Product();
        $product->setUsers($this->getUser());
        $product->setCreatedAt (new DatetimeIMMUTABLE('now'));
        $product->setUpdatedAt (new \DatetimeIMMUTABLE('now'));

        return $product;
    }




    //---------------MODIFIER LES CHAMPS DU FORMULAIRES----------------------------------------------

    public function configureFields(string $pageName): iterable
    {
        

            yield   FormField::addPanel('Produit');
            yield   IdField::new('id', 'Référence produit')->hideOnForm();
            yield   AssociationField::new('featuredImage', 'Image du produit')
                        ->setColumns('col-sm-6 col-lg-5 col-xxl-3');
            /*         ->setBasePath(self::PRODUCTS_BASE_PATH) */
            /*         ->setUploadDir(self::PRODUCTS_UPLOAD_DIR), */
            yield   TextField::new('title', 'Nom du produit');
            yield   TextField::new('author', 'Auteurs')->hideOnIndex();
            yield   TextEditorField::new('excerpt', 'Résumé')->HideOnIndex();

            yield   TextEditorField::new('description', 'Description')
                        ->hideOnIndex()
                        ->HideOnForm();

            yield   FormField::addPanel('Caractéristiques du produit');
            yield   DateField::new('publishedAt', 'Date de parution')
                        ->setFormat('dd.MM.yyyy')
                        ->hideOnIndex()
                        ->setColumns('col-sm-6 col-lg-5 col-xxl-2');

            yield   ChoiceField::new('format', 'Format')
                        
                        ->hideOnIndex()
                        ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
                        ->setChoices([
                            'Poche'=>'poche',
                            'Broché'=>'broche',
                            'Relié'=>'relie',
                            'Audio'=>'audio',
                            'Dvd'=>'dvd',
                        ]);

            yield   MoneyField::new('price', 'Prix')->setCurrency('EUR');

            yield   TextField::new('isbn', 'ISBN')
                        ->hideOnIndex()
                        ->setColumns('col-sm-6 col-lg-5 col-xxl-3');

            yield   ChoiceField::new('langues', 'Langues')
                        ->hideOnIndex()
                        ->setChoices([
                           'Allemand'=>'allemand',
                            'Anglais'=>'anglais',
                            'Arabe'=>'arabe',
                            'Espagnol'=>'espagnol',
                            'Français'=>'francais',
                            'Italien'=>'italien',
                            'Mandarin'=>'mandarin',
                            'Portugais'=>'portugais',
                            'Russe'=>'russe',
                            'Swahili'=>'swahili',
                           

                        ]);
                    
            yield   TextField::new('age', 'Âges')
                        ->hideOnIndex()
                        ->setColumns('col-sm-6 col-lg-5 col-xxl-3');

            yield   TextField::new('editor', 'Éditeur')
                        ->hideOnIndex();


            yield   AssociationField::new('category', 'Les catégories')
                        ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
                        ->hideOnIndex()
                        ->setQueryBuilder(function (QueryBuilder $queryBuilder){ // pour montrer que les catégories actives.
                            $queryBuilder
                                ->where('entity.statut=true')
                                ->orderBy('entity.createdAt', 'DESC');
                        });
                    
            yield   AssociationField::new('rayons', 'Rayons')
                        ->hideOnIndex()
                        ->setQueryBuilder(function (QueryBuilder $queryBuilder){ 
                            $queryBuilder->where('entity.statut=true');
                        });
                
            yield   AssociationField::new('souscategory', 'Les sous-catégories')
                        ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
                        ->hideOnIndex()
                        ->setQueryBuilder(function (QueryBuilder $queryBuilder){
                          $queryBuilder
                                ->where('entity.statut=true');
                        });
                    
            yield   IntegerField::new('stock', 'Stock')
                        ->formatValue(function ($value) {
                        return $value < 5 ? sprintf('%d **STOCK FAIBLE**', $value) : $value;});
                        
                        
            yield   DateTimeField::new('createdAt', 'Date d\'ajout') 
                         ->setFormat('short', 'short')
                         ->hideOnIndex() 
                         ->hideOnForm();
                        

            yield   DateTimeField::new('updatedAt', 'Date de modification') 
                        ->hideOnForm() 
                        ->setFormat('short', 'short')
                        ->hideOnIndex();

            yield   AssociationField::new('users', 'Ajouté par ')
                        ->HideOnForm()
                        ->hideOnIndex();

        
            yield   BooleanField::new('bestSeller', 'Best-seller');
            yield   BooleanField::new('nouveaute', 'Nouveauté');
            yield   BooleanField::new('statut', 'Statut');
            yield   FormField::addRow();


        ;
    }


    //--------------------- MODIFIER LES ACTIONS du crud----------------------------------- 

    public function configureActions(Actions $actions): Actions
    {
         return $actions
            // ...
        ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER);
    }
    

    //----------------MODIFIER CRUD PRODUCT------------------------------------------------

    public function configureCrud(Crud $crud) : Crud
    {

        
        return $crud
            ->setEntityLabelInPlural('Produits')
            ->setEntityLabelInSingular('Produit')
            ->setPageTitle('index', 'Crossroards Gestion des produits')
            ->setPageTitle('new', 'Crossroards ajouter un produit')
            ->setDefaultSort(['createdAt' => 'DESC']);

        
            
    }


    

}
