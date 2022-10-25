<?php

namespace App\Form;

use App\Form\CommentFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentFormType extends AbstractType 
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
  
    ->add('content', TextareaType::class,[
        'label' =>'Votre message'
    ])

    ->add('rating', IntegerType::class)
    ->add('createdAt', DateTimeType::class);
  }
}
