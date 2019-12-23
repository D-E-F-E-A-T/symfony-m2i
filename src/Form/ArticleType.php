<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Author;
use App\Form\DataTransformer\TagCollectionToStringDataTranformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    /**
     * @var TagCollectionToStringDataTranformer
     */
    private $tagTransformer;

    /**
     * ArticleType constructor.
     * @param TagCollectionToStringDataTranformer $tagTransformer
     */
    public function __construct(TagCollectionToStringDataTranformer $tagTransformer)
    {
        $this->tagTransformer = $tagTransformer;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'titre'])
            ->add('createdAt', DateType::class, [
                'label' => 'Date de création',
                'widget' => 'single_text'
            ])
            ->add('text', TextareaType::class,
                ['label' => 'Texte',
                    'attr' => ['rows' => '15']
                ])
            /* ->add('author', EntityType::class, [
                 'class'=> Author::class,
                 'choice_label'=> 'fullName',
                 'multiple' => false,
                 'expanded' => true
             ])*/
            ->add('tags', TextType::class, ['label' => 'Liste des tages'])
            ->add('photo', FileType::class, [
                'label' => 'Télécharger le photo',
                'required' => false,
                'mapped' => false
            ])
            ->add('submit', SubmitType::class,
                ["label" => "Valider", "attr" => ["class" => "btn btn-danger"]]);
        $builder->get('tags')->addModelTransformer($this->tagTransformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
