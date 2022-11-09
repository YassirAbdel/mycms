<?php

namespace App\Form;

use App\Entity\Sousrubrique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class SousrubriqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                    //'placeHolder' => 'Titre'
                ],
                'label' => 'Titre'
            ])
            ->add('soustitre', TextType::class, [
                'label' => 'Sous-titre',
                'required' => false
            ])
            ->add('resume', CKEditorType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Introduction',
                'label_attr' => ['class' => 'margin-label']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sousrubrique::class,
        ]);
    }
}
