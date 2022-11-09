<?php

namespace App\Form;

use App\Classe\Search;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('string', TextType::class, [
            'label' => false,
            'required' => true,
            'attr' => [
                'id' => 'search-input',
                'placeholder' => 'Rechercher...',
                'class' => 'form-control py-2 border-right-1',
                'data-suggest' => '',
                'autocomplete' => 'off',
                
                //'width' => '3000',

            ]
        ])
        ->add('id_rubrique', HiddenType::class)
        ->add('id_texte', HiddenType::class)
        ->add('id_collection', HiddenType::class)
        ->add('id_sous_collection', HiddenType::class)
        ->add('id_article', HiddenType::class)
        
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'GET',
            'crsf_protection' => false,
        ]);
    }
    
    public function getBlockPrefix()
    {
       return '';
    }
}