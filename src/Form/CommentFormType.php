<?php

namespace App\Form;

use App\Form\CommentFormType;
use App\Entity\Comment;
use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentFormType extends AbstractType 
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
  
    ->add('content', TextareaType::class,[
        'label' =>'Votre message'
    ])

    ->add('rating', IntegerType::class, [
      'attr' => ['class' => 'form-rating v-model="value"']
    ])
    ->add('createdAt', DateTimeType::class)
    ->add('product', HiddenType::class)
    ->add('send', SubmitType::class, [
        'label' => 'Envoyer'
    ]);
  


  $builder->get('product') 
  ->addModelTransformer(new CallbackTransformer(
     fn (Product $product) => $product->getId(),
     fn (Product $product) => $product->getTitle()));
}


  public function configureOptions(OptionsResolver $resolver)
  {
      $resolver->setDefaults([
          'data_class' => Comment::class,
          'csrf_token_id' => 'comment-add'
      ]);
  }
}
