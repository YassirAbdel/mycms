<?php

namespace App\Form;

use App\Entity\Souscollectioncnd;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\UX\Dropzone\Form\DropzoneType;

class SouscollectioncndType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'attr' => ['class' => 'input-default', 'class' => 'form-control'],
                'label' => 'Titre'
            ])
            ->add('soustitre', TextType::class, [
                'attr' => ['class' => 'input-default', 'class' => 'form-control'],
                'label' => 'Sous-titre'
            ])
            ->add('presentation', CKEditorType::class, [
                'attr' => ['class' => 'input-default', 'class' => 'form-control'],
                'label' => 'Présentation',
                'label_attr' => ['class' => 'margin-label']
            ])
            ->add('imageFile', DropzoneType::class, [
                'required' => false,
                'label' => 'Illustration'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Souscollectioncnd::class,
        ]);
    }
}
