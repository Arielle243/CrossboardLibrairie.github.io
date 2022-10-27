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
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class ProductCrudController extends AbstractCrudController
{
    //pour faire appel au dossier qui contient les images
    public const PRODUCTS_BASE_PATH ='upload/images/products';
    public const PRODUCTS_UPLOAD_DIR ='public/upload/images/products';



    public static function getEntityFqcn(): string
    {
        return Product::class;
    }


    public function createEntity(string $entityFqcn)
    {
        $product= new Product();
        $product->setUsers($this->getUser());
        $date = new \Datetime('now');

        return $product;
    }



    //---------------MODIFIER LES CHAMPS DU FORMULAIRES----------------------------------------------

    public function configureFields(string $pageName): iterable
    {
        return [

            IdField::new('id', 'Référence produit')->hideOnForm(),

            ImageField::new('illustration', 'Image du produit')
                ->setBasePath(self::PRODUCTS_BASE_PATH)
                ->setUploadDir(self::PRODUCTS_UPLOAD_DIR),

            TextField::new('title', 'Nom du produit'),

            TextEditorField::new('excerpt', 'Résumé'),

            TextEditorField::new('description', 'Description')
            ->hideOnIndex(),

            TextField::new('author', 'Auteurs')
            ->hideOnIndex(),

            DateField::new('publishedAt', 'Date de parution')
                ->setFormat('dd.MM.yyyy')
                ->hideOnIndex(),

            ChoiceField::new('format', 'Format')
                ->hideOnIndex()
                ->setChoices([
                    'Poche'=>'poche',
                    'Broché'=>'broche',
                    'Relié'=>'relie',
                    'Audio'=>'audio',
                    'Dvd'=>'dvd',
                
                ]),

            MoneyField::new('price', 'Prix')->setCurrency('EUR'),

            TextField::new('isbn', 'ISBN')->hideOnIndex(),

            ChoiceField::new('langues', 'Langues')
            ->hideOnIndex()
            ->setChoices([
                'Français'=>'francais',
                'Anglais'=>'anglais',   
                ]),
            
            TextField::new('age', 'Âges')
            ->hideOnIndex(),

            TextField::new('editor', 'Éditeur')
            ->hideOnIndex(),
  
            
            AssociationField::new('category', 'Les catégories')
                ->hideOnIndex()
                ->setQueryBuilder(function (QueryBuilder $queryBuilder){ // pour montrer que les catégories actives.
                    $queryBuilder
                        ->where('entity.statut=true')
                        ->orderBy('entity.createdAt', 'DESC');
                }),

            //AssociationField::new('lignecommande', 'Ajouter par'),
                //->setQueryBuilder(function (QueryBuilder $queryBuilder){ 
                //$queryBuilder->where('entity.statut=true');
            //}),

            AssociationField::new('souscategory', 'Les sous-catégories')
                ->hideOnIndex()
                ->setQueryBuilder(function (QueryBuilder $queryBuilder){
                  $queryBuilder
                        ->where('entity.statut=true');
              }),

            IntegerField::new('stock', 'Stock')
                ->formatValue(function ($value) {
                return $value < 5 ? sprintf('%d **STOCK FAIBLE**', $value) : $value;}),


            DateTimeField::new('createdAt', 'Date d\'ajout')
                ->setFormat('dd.MM.yyyy HH:mm')
                ->hideOnIndex()
                ->hideOnForm(),
               

            DateTimeField::new('updatedAt', 'Date de modification')
                ->hideOnForm()
                ->setFormat('dd.MM.yyyy HH:mm')
                ->hideOnIndex(),

            AssociationField::new('users', 'Nom de User')
                ->HideOnForm(),
            
        
            BooleanField::new('statut', 'Statut'),
            FormField::addRow(),


        ];
    }


    //--------------------- MODIFIER LES ACTIONS----------------------------------- 

    public function configureActions(Actions $actions): Actions
    {
         return $actions
            // ...
        ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER);
    }
    

    public function configureCrud(Crud $crud) : Crud
    {
        return $crud
            ->setEntityLabelInPlural('Produits')
            ->setEntityLabelInSingular('Produit');
    }




}

class ProductRepository extends ServiceEntityRepository
{
    public function findAllGreaterThanPrice(int $price, bool $includeUnavailableProducts = false): array
    {
        // automatically knows to select Products
        // the "p" is an alias you'll use in the rest of the query
        $qb = $this->createQueryBuilder('p')
            ->where('p.price > :price')
            ->setParameter('price', $price)
            ->orderBy('p.price', 'ASC');

        if (!$includeUnavailableProducts) {
            $qb->andWhere('p.statut = TRUE');
        }

        $query = $qb->getQuery();

        return $query->execute();

        // to get just one result:
        // $product = $query->setMaxResults(1)->getOneOrNullResult();
    }


}
