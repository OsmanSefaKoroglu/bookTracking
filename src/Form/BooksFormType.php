<?php

namespace App\Form;

use App\Entity\Books;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;




class BooksFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr'=>array(
                    'class'=>'bg-transparent block border-b-2 w-full h-15 text-2xl  
                    outline-style:solid ;
                    outline-color: red;','placeholder'=>' Enter The Title...'
                ),
                'label'=>false
            ])
            ->add('releaseYear', IntegerType::class, [
                'attr'=>array(
                    'class'=>'bg-transparent block mt-8 border-b-2 w-full h-15 text-2xl  
                    outline-style:solid ;
                    outline-color: red;','placeholder'=>' Enter The Release...'
                ),
                'label'=>false
            ])
            ->add('description', TextareaType::class, [
                'attr'=>array(
                    'class'=>'bg-transparent block mt-8 border-b-2 w-full h-25 text-2xl  
                    outline-style:solid ;
                    outline-color: red;','placeholder'=>' Enter Description...'
                ),
                'label'=>false
            ])
            ->add('imagePath',FileType::class, array(
             'required'=>false,
             'mapped'=>false
            ))
            //->add('writer')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Books::class,
        ]);
    }
}
