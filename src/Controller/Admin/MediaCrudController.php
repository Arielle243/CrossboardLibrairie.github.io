<?php

namespace App\Controller\Admin;

use App\Entity\Media;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\Model\FileUploadState;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\User\UserInterface;
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

        $imageField = ImageField::new('filename', 'Média')
            ->setBasePath($productsDir)
            ->setUploadDir($mediasDir)
            ->setUploadedFileNamePattern('[slug].[extension]');

            if (Crud::PAGE_EDIT == $pageName) {
                $imageField->setRequired(false);
            }
    
            yield $imageField;


             if ($pageName  == Crud::PAGE_DETAIL) {
                $imageField[] = $imageField;
            }
            yield $imageField;



    }


    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        /** @var Media $media */
        $media = $entityInstance;

        $media->setName($media->getFilename());
        //$media->setCreatedAt(new \DateTime());

        parent::persistEntity($entityManager, $media);
    }

    
}
