<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Media;
use App\Entity\Rayon;
use App\Entity\Comment;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Commande;
use App\Entity\Employes;
use App\Entity\Addresses;
use App\Entity\Souscategory;
use App\Entity\Transporteur;
use App\Entity\Lignecommande;
use App\Entity\SousCategories;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\Admin\ProductCrudController;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Admin\CategoryCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;


class DashboardController extends AbstractDashboardController
{


     public function __construct( 
       private AdminUrlGenerator $adminUrlGenerator 
    ) { 

    } 

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

            //$url = $this->adminUrlGenerator
                //->setController(RayonCrudController::class)
                //->generateUrl();


        //return $this->redirect($url);

        //return parent::index();
        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        //return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
         return $this->render('admin/dashboard.html.twig');
         
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('CrossboardLibrairie');
            
    }

    public function configureMenuItems(): iterable
    {
        
        //yield MenuItem::linkTo
        yield MenuItem::linkToRoute('Aller sur le site', 'fa fa-undo', routeName:'home-index');
        //yield MenuItem::section('Produits', 'fa fa-book');

        yield MenuItem::subMenu('Produits', 'fa fa-book')->setSubItems([
            MenuItem::linkToCrud('Ajouter un produit', 'fas fa-plus', Product::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste des produits', 'fas fa-eye', Product::class)
        ]);
       
        

        //yield MenuItem::section('Rayons', 'fa fa-list');
        yield MenuItem::subMenu('Rayon', 'fa fa-list')->setSubItems([
            MenuItem::linkToCrud('Ajouter un rayon', 'fas fa-plus', Rayon::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les rayons', 'fas fa-eye', Rayon::class)
        ]);

       
        //yield MenuItem::section('Catégories', 'fa-solid fa-table');
        yield MenuItem::subMenu('Catégories', 'fa-solid fa-table')->setSubItems([
            MenuItem::linkToCrud('Ajouter une catégorie', 'fas fa-plus', Category::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les catégories', 'fas fa-eye', Category::class)
        ]);

        //yield MenuItem::section('Sous-Catégories', 'fa-solid fa-tags');
        yield MenuItem::subMenu('Sous-catégories', 'fa-solid fa-tags')->setSubItems([
               MenuItem::linkToCrud('Ajouter une sous-catégorie', 'fas fa-plus', Souscategory::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Toutes les sous-catégories', 'fas fa-eye', Souscategory::class),
            
            ]);
       
        //yield MenuItem::section('Clients', 'fa-sharp fa-solid fa-address-card');
        yield MenuItem::subMenu('Clients', 'fa-solid fa-users')->setSubItems([
            MenuItem::linkToCrud('Ajouter un utilisateur', 'fas fa-plus', User::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste des clients', 'fas fa-eye', User::class),
           
    
        ]);


        yield MenuItem::subMenu('Transporteurs', 'fa-solid fa-users')->setSubItems([
        MenuItem::linkToCrud('Ajouter un transporteur', 'fas fa-plus', 
       Transporteur::class)->setAction(Crud::PAGE_NEW),
        MenuItem::linkToCrud('Liste des transporteurs', 'fas fa-eye', Transporteur::class),
    
        ]);


           yield MenuItem::subMenu('Adresses', 'fa-solid fa-users')
->setSubItems([
   MenuItem::linkToCrud('Ajouter une adresse', 'fas fa-plus', 
  Addresses::class)->setAction(Crud::PAGE_NEW),
   MenuItem::linkToCrud('Adresses', 'fas fa-eye', 
Addresses::class),
   ]);

        
        //yield MenuItem::section('Commandes', 'fa-sharp fa-solid fa-basket-shopping');
        yield MenuItem::subMenu('Commandes', 'fa-sharp fa-solid fa-basket-shopping')->setSubItems([
            //MenuItem::linkToCrud('Ajouter une commande', 'fas fa-plus', Commande::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste les commandes', 'fas fa-eye', Commande::class),
            MenuItem::linkToCrud('Liste les commandes', 'fas fa-eye',Lignecommande::class)
        ]);

        
           //yield MenuItem::section('Commentaires & notes', 'fa-sharp fa-solid fa-basket-shopping');
        yield MenuItem::subMenu('Commentaires & notes', 'fa-solid fa-comments')->setSubItems([
            MenuItem::linkToCrud('Ajouter un commentaire', 'fas fa-plus', Comment::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste les commentaires & notes', 'fas fa-eye', Comment::class)
        ]);


        //yield MenuItem::section('Media', 'fa-sharp fa-solid fa-basket-shopping');
        yield MenuItem::subMenu('Media', 'fas fa-photo-video')->setSubItems([
            MenuItem::linkToCrud('Ajouter une image', 'fas fa-plus', Media::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste les images', 'fas fa-eye', Media::class)
        ]);

    }
}
