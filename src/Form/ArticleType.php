<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title',TextType::class,[
          'label'=>'title',
          'attr'=>['placeholder' => 'Enter article title'],
        ])
        ->add('datepub',DateType::class,
        [
                            'label' => 'Publication Date',
                            'widget' => 'single_text',
                            'attr' => ['placeholder' => 'Choose publication date'],
                        ])
        ->add('description',TextareaType::class, [
              'label' => 'Description',
              'attr' => ['placeholder' => 'Enter article description'],
          ])
        ->add('image',FileType::class, [
              'label' => 'Image',
              'attr' => ['placeholder' => 'Choose article image'],
              'mapped' => false, // Don't map this field to any property on your entity
              'required' => false, // Image upload is optional
         ])
        ->add('authorname',TextType::class, [
               'label' => 'Author Name',
               'attr' => ['placeholder' => 'entrer le nom dauteur'],
          ])
        ->add('categorie',TextType::class, [
        'label' => 'Categorie',
        'attr' => ['placeholder' => 'enter le nom du categorie'],
         ])
         ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
