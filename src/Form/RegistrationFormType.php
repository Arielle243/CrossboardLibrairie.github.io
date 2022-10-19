<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
         
         ->add('picture', FileType::class, [
         'required' => false,
         'constraints' => [
             new File([
                 'maxSize'=>'16384k',
                 'maxSizeMessage'=>'Taille de fichier trop grande',
                 'mimeTypes'=>[
                     'image/jpeg',
                     'image/png',
                 ],
                 'mimeTypesMessage'=>'Extension de fichier invalide',
             ])
             ],
         'attr'=>[
             'class'=>'form-control',

         ],
         'data_class'=>null,
     ]) 
         
        ->add('name', TextType::class)
        ->add('firstname', TextType::class)
        ->add('pseudo', TextType::class)
        ->add('birthDate' , DateType::class,[
            'widget' => 'choice',
            'years' => range(date('Y')-100,date('Y'))
        ])
        ->add('phoneNumber',TextType::class )
        ->add('address',TextType::class)
        ->add('city', TextType::class)
        ->add('zipCode', TextType::class)
       // ->add('roles', ChoiceType::class)
         
         
            ->add('email')
          /*   ->add('agreeTerms', CheckboxType::class, [ */
          /*       'mapped' => false, */
          /*       'constraints' => [ */
          /*           new IsTrue([ */
          /*               'message' => 'You should agree to our terms.', */
          /*           ]), */
          /*       ], */
          /*   ]) */
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => 'true',
                'invalid_message' => 'Les mdp ne correspondent pas',
                'first_options' => [
                    'label' => 'Entrez un mot de passe',
                    'attr' => ['class' => 'form-control']
                ],
                'second_options' => [
                    'label' => 'Confirmer le mot de passe',
                    'attr' => ['class' => 'form-control']
                ],
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
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
