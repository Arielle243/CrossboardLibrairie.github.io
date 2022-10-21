<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{

     //pour faire appel au dossier images
    public const USER_BASE_PATH ='upload/images/users';
    public const USER_UPLOAD_DIR ='public/upload/images/users';

    public static function getEntityFqcn(): string
    {
        return User::class;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
           
            FormField::addPanel('Identité')
            ->setIcon('fa fa-card')->addCssClass('optional'),
            IdField::new('id')->hideOnForm(),
            ImageField::new('picture', 'Photo de profil')
            ->setBasePath(self::USER_BASE_PATH)
            ->setUploadDir(self::USER_UPLOAD_DIR),
            TextField::new('name', 'Nom'),
            TextField::new('Firstname', 'Prénom'),
            ArrayField::new('roles', 'Rôles')
            //->onlyOnDetail()
            ,
            DateTimeField::new('dateRegistration', 'Date d\'inscription')
            ->setFormat('dd.MM.yyyy HH:mm:ss')->hideWhenCreating()
            ->onlyOnDetail(),

            FormField::addPanel('Information de contact')
            ->setIcon('fa fa-phone')->addCssClass('optional'),
            //->setHelp('Phone number is preferred'),
            TextField::new('phoneNumber', 'Téléphone')->onlyOnDetail(),
            EmailField::new('email', 'Email')->onlyOnDetail(),
            TextField::new('address', 'Adresse')->onlyOnDetail(),

            FormField::addPanel('Statut'),
            BooleanField::new('statut'),


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
