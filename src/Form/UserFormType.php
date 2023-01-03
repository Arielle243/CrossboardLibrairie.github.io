<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label'=>false,
                'attr'=>[
                    'readonly class'=>'form-control-plaintext',
                ],
                
            ])
            // ->add('password')
            ->add('picture', FileType::class, [
                'label' =>'Photo de profil',
                'mapped' => true,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize'=>'16384k',
                        'maxSizeMessage'=>'Taille de fichier trop grande',
                        'mimeTypes'=>[
                            'image/jpeg',
                            'image/png',
                            'image/svg',
                        ],
                        'mimeTypesMessage'=>'Extension de fichier invalide',
                    ])
                    ],
                'attr'=>[
                    'class'=>'form-control',
                ],
                'data_class'=>null,
            ])
            ->add('pseudo', TextType::class, [
                'label' =>'Pseudo',
                 'attr'=>[
                        'class'=>'form-control',
                    ],
                              
             ])
            ->add('name', TextType::class, [
                'label' =>'Nom',
                    'attr'=>[
                    'class'=>'form-control',
                ],
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'attr'=>[
                    'class'=>'form-control',
                ],
                        
             ])
            ->add('address', TextType::class, [
                'label' =>'Adresse',
                    'attr'=>[
                    'class'=>'form-control',
                ],
            ])
            ->add('zipCode',TextType::class,[
                'label' =>'Code postal',
                    'attr'=>[
                    'class'=>'form-control',
                ],
            ])
            ->add('city', TextType::class, [
                'label' =>'Ville',
                    'attr'=>[
                    'class'=>'form-control',
                ],
            ]) 
            ->add('phoneNumber', TextType::class, [
                'label' => 'Numéro de téléphone',
                    'attr'=>[
                        'class'=>'form-control',
                    ],
            ])
            ->add('birthDate' , DateType::class,[
                'widget' => 'choice',
                'years' => range(date('Y')-100,date('Y')),
                'label' =>'Date de naissance',
                    'attr'=>[
                        'class'=>'form-control',
                    ],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
