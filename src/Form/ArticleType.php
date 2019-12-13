<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Author;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'titre'])
            ->add('createdAt', DateType::class, [
                'label' => 'Date de création',
                'widget' => 'single_text'
            ])
            ->add('text', TextareaType::class,
                ['label'=>'Texte',
                    'attr'=>['rows'=>'15']
                ])
            ->add('author', EntityType::class, [
                'class'=> Author::class,
                'choice_label'=> 'fullName',
                'multiple' => false,
                'expanded' => true
            ])
            ->add('tags', TextType::class, ['label'=> 'Liste des tages'])
            ->add('submit', SubmitType::class,
                ["label" => "Valider", "attr" => ["class" => "btn btn-danger" ]]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
