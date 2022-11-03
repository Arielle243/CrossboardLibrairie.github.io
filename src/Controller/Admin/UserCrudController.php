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





/**
 * @method User getUser
 */

class UserCrudController extends AbstractCrudController
{

     //pour faire appel au dossier images
    public const USER_BASE_PATH ='upload/images/users';
    public const USER_UPLOAD_DIR ='public/upload/images/users';

    
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
        $date = new \DatetimeImmutable('now');
        $user->setDateRegistration($date);
        return $user;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
           
            FormField::addPanel('Identité')
                ->setIcon('fa fa-user')->addCssClass('optional'),
            
            IdField::new('id', 'Identifiant')->hideOnForm(),

            ImageField::new('picture', 'Photo de profil')
                ->setBasePath(self::USER_BASE_PATH)
                ->setUploadDir(self::USER_UPLOAD_DIR)
                //->hideOnIndex()
                ,

            TextField::new('name', 'Nom')
                ->setColumns('col-sm-6 col-lg-5 col-xxl-3'),

            TextField::new('Firstname', 'Prénom'),
            DateField::new('birthdate', 'Date de naissance')
            ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
            ->hideOnIndex(),

            ChoiceField::new('roles', 'Rôles')
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
                    'Employé' => 'ROLE_EMPLOYE'
                ]),


            FormField::addPanel('Information de contact')
                ->setIcon('fa fa-phone'),
          
            TextField::new('phoneNumber', 'Téléphone')
                ->hideOnIndex()
                ->setColumns('col-sm-6 col-lg-5 col-xxl-3'),
            TextField::new('address', 'Adresse Postale')
            ->hideOnIndex(),
            TextField::new('city', 'Ville')
            ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
            ->hideOnIndex(),
            IntegerField::new('zipCode', 'Code postal')
            ->hideOnIndex(),
          

            FormField::addPanel('Email')
            ->setIcon('fa fa-envelope'),

            EmailField::new('email', 'Email')
            ->setColumns('col-sm-6 col-lg-5 col-xxl-3'),
            TextField::new('password', 'Mot de passe')
                ->setFormType(PasswordType::class)
                ->OnlyOnForm(),

            FormField::addPanel('Statut')
                ->setIcon(''),
            BooleanField::new('statut'),

            DateTimeField::new('dateRegistration', 'Date d\'inscription')
            ->setFormat('dd.MM.yyyy HH:mm:ss')
            ->hideOnForm()
            ->hideOnIndex(),


        ];
    }

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
                    ->setEntityLabelInPlural('Utilisateurs')
                    ->setEntityLabelInSingular('Utilisateur')
                    ->setPageTitle('index', 'Crossboard Gestion des utilisateurs')
                    ->setPageTitle('new', 'Crossboard ajouter un utilisateur')
                    ->setPageTitle('detail', 'Crossboard profil utilisateur')
                    ->setDefaultSort(['dateRegistration' => 'DESC']);
        
                    
            }



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
