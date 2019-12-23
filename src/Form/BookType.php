<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Publisher;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ["label" => "Titre", "required" => true, "help" => "Le Titre du Livre "])
            ->add('authors', CollectionType::class, [
                "label" => "Liste des auteurs",
                "entry_type" => AuthorType::class,
                "allow_add" => true

                ])
            ->add('price', NumberType::class,
                ["label" => "Prix", "html5" => true, "attr" => ["min" => "1", "max" => "999.99", "step" => ".5"]])
            ->add('publisher', EntityType::class, [
                'class' => Publisher::class,
                'choice_label' => 'name'
            ])
            ->add('submit', SubmitType::class,
                ["label" => "Valider", "attr" => ["class" => "btn btn-danger" ]]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
