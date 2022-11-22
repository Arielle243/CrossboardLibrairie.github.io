<?php

namespace App\Form;

use App\Entity\Livraison;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class LivraisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('modeLivraison', ChoiceType::class, [
            'choices' => [
                'Domicile'=>'domicile',
                'Librairie'=>'Librairie',
            ],
           
             // pour faire une liste 
             'expanded'=>'false',
             'label'=>'Choisir le mode de livraison', 
             'choice_attr'=>[ 
                 'Domicile'=>['class'=>'me-1'], 
                 'Librairie'=>['class'=>'me-1 ms-5'], 
                 ], 
            'attr'=>['class'=>'form-control',]
            ])

            //->add('statutLivraison', BooleanType::class)
            ->add('dateLivraison', DateType::class, [
                 'mapped'=>false, 
                 'widget' => 'single_text', 
                     'input'  => 'datetime',  
                     'attr' => ['class'=>'form-control'], 
                     'label'=>'Date de livraison' 
             
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livraison::class,
        ]);
    }
}
