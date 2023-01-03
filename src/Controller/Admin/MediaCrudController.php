<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Media;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Filesystem\Filesystem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\Model\FileUploadState;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MediaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Media::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        $mediasDir = $this->getParameter('medias_directory');
        $productsDir = $this->getParameter('products_directory');

        yield TextField::new('name', 'Nom');
        yield DateTimeField::new('createdAt', 'Crée le')
                ->HideOnForm();
        yield DateTimeField::new('updatedAt', 'Modifié le')
                ->hideOnIndex()
                ->HideOnForm();

                $imageField = ImageField::new('filename', 'Média')
                    ->setBasePath($productsDir)
                    ->setUploadDir($mediasDir)
                    ->setUploadedFileNamePattern('[slug].[extension]');

                    if (Crud::PAGE_EDIT == $pageName) {
                        $imageField->setRequired(false);
                    }

        yield $imageField;


             if ($pageName  == Crud::PAGE_DETAIL) {
                $imageField = $imageField;
            }
        yield $imageField;



    }


    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        /** @var Media $media */
        $media = $entityInstance;

        $media->setName($media->getFilename());
        $media->setCreatedAt (new \DateTimeImmutable('now'));
        $media->setUpdatedAt (new \DateTimeImmutable('now'));

        parent::persistEntity($entityManager, $media);
    }


        public function configureActions(Actions $actions): Actions
        {
             return $actions
                // ...
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER);
        }
    
}
