<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;

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
           
            ImageField::new('picture', 'Photo de profil')
            ->setBasePath(self::USER_BASE_PATH)
            ->setUploadDir(self::USER_UPLOAD_DIR),
            TextField::new('name', 'Nom'),
            TextField::new('Firstname', 'Prénom'),
            TextField::new('Firstname', 'Prénom'),
            EmailField::new('email', 'Email'),
            //PasswordField::new('password', 'Mot de passe'),
            ChoiceField::new('roles', 'Rôles')
            ->allowMultipleChoices(),
            FormField::addRow(),


        ];
    }
    

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        // Usually it's better to call the parent method because that gives you a
        // user menu with some menu items already created ("sign out", "exit impersonation", etc.)
        // if you prefer to create the user menu from scratch, use: return UserMenu::new()->...
        return parent::configureUserMenu($user)
            // use the given $user object to get the user name
            ->setName($user->getFullName())
            // use this method if you don't want to display the name of the user
            ->displayUserName(false)


            // you can use any type of menu item, except submenus
            ->addMenuItems([
                MenuItem::linkToRoute('My Profile', 'fa fa-id-card', '...', ['...' => '...']),
                //MenuItem::linkToRoute('Settings', 'fa fa-user-cog', '...', ['...' => '...']),
                //MenuItem::section(),
                MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
            ]);
    }
}
