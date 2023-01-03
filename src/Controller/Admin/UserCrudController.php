<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;



class UserCrudController extends AbstractCrudController
{

    /*  //pour faire appel au dossier images */
     public const USERS_BASE_PATH ='upload/images/users'; 
     public const USERS_UPLOAD_DIR ='public/upload/images/users'; 

    
    public function __construct(
        private EntityRepository $entityRepository,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $user = new User();
        $user->setCreatedAt(new \DatetimeImmutable('now'));
        $user->setUpdatedAt(new \DatetimeImmutable('now'));
        return $user;
    }


    public function configureFields(string $pageName): iterable
    {
        
           
            yield  FormField::addPanel('Identité')->setIcon('fa fa-user')->addCssClass('optional');
            yield  IdField::new('id', 'Identifiant')->hideOnForm();
            yield  ImageField::new('picture', 'Photo de profil')
                    ->setBasePath(self::USERS_BASE_PATH) 
                    ->setUploadDir(self::USERS_UPLOAD_DIR) 
                    ->hideOnIndex();
            yield   TextField::new('name', 'Nom')->setColumns('col-sm-6 col-lg-5 col-xxl-3');
            yield   TextField::new('Firstname', 'Prénom');
            yield   DateField::new('birthDate', 'Date de naissance')
                    ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
                    ->hideOnIndex();

            yield  ChoiceField::new('roles', 'Rôles')
                    ->allowMultipleChoices()
                    ->renderAsBadges([
                        'ROLE_ADMIN' => 'danger',
                        'ROLE_CLIENT' => 'success',
                        'ROLE_EMPLOYE'=>'warning',
                        'ROLE_INTERVENANT'=>'primary'
                        ])
                    ->setChoices([
                        'Administrateur' => 'ROLE_ADMIN',
                        'Client' => 'ROLE_CLIENT',
                        'Employé' => 'ROLE_EMPLOYE',
                        'Intervenant' => 'ROLE_INTERVENANT'
                    ]);


            yield  FormField::addPanel('Information de contact')->setIcon('fa fa-phone');
            yield  TextField::new('phoneNumber', 'Téléphone')
                    ->hideOnIndex()
                    ->setColumns('col-sm-6 col-lg-5 col-xxl-3');
            yield  TextField::new('address', 'Adresse Postale')->hideOnIndex();
            yield  TextField::new('city', 'Ville')
                    ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
                    ->hideOnIndex();
            yield  IntegerField::new('zipCode', 'Code postal')->hideOnIndex();
            yield  FormField::addPanel('Email')->setIcon('fa fa-envelope');
            yield  EmailField::new('email', 'Email')->setColumns('col-sm-6 col-lg-5 col-xxl-3');
            yield  TextField::new('password', 'Mot de passe')
                    ->setFormType(PasswordType::class)
                    ->OnlyOnForms();
            yield  FormField::addPanel('Statut')->setIcon('');
            yield  BooleanField::new('statut');

            yield  DateTimeField::new('createdAt', 'Date d\'inscription')
            ->setFormat('dd.MM.yyyy HH:mm:ss')
            ->hideOnForm()
            ->hideOnIndex();

            yield  DateTimeField::new('updatedAt', 'Date de modification')
                ->setFormat('dd.MM.yyyy HH:mm:ss')
                ->hideOnForm()
                ->hideOnIndex();


        
    }
    
                    // configuration des actions

            public function configureActions(Actions $actions): Actions
            {
                 return $actions
                    // ...
                ->add(Crud::PAGE_INDEX, Action::DETAIL)
                ->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER);
            }

                   // configuration du crud

            public function configureCrud(Crud $crud) : Crud
            {
                return $crud
                    ->setEntityLabelInPlural('Utilisateurs')
                    ->setEntityLabelInSingular('Utilisateur')
                    ->setPageTitle('index', 'Crossboard Gestion des utilisateurs')
                    ->setPageTitle('new', 'Crossboard ajouter un utilisateur')
                    ->setPageTitle('detail', 'Crossboard profil utilisateur')
                    ->setDefaultSort(['createdAt' => 'DESC'])
                    // use dots (e.g. 'seller.email') to search in Doctrine associations
                    ->setSearchFields(['name', 'description', 'seller.email', 'seller.address.zipCode'])
                    // set it to null to disable and hide the search box
                    ->setSearchFields(null)
                    // call this method to focus the search input automatically when loading the 'index' page
                    ->setAutofocusSearch();

                    
            }


            // fonction pour crypter le mot de passe 

            public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
            {
                /** @var User $user */
                $user = $entityInstance;
        
                $plainPassword = $user->getPassword();
                $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);
        
                $user->setPassword($hashedPassword);
        
                parent::persistEntity($entityManager, $user);
            }

}
