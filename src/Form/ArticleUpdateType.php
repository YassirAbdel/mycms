<?php

namespace App\Form;

use App\Entity\Article;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\UX\Dropzone\Form\DropzoneType;

class ArticleUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Titre'
            ])
            ->add('soustitre', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Sous-titre',
                'required'   => false
            ])
            ->add('resume', CKEditorType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Introduction',
                'label_attr' => ['class' => 'margin-label']
            ])
            ->add('folderFront', CheckboxType::class, [
                'label' => 'A la une (o/n)',
                'required'   => false,
                'attr' => [
                    'class' => 'box'
                ]
            ])
            ->add('published', CheckboxType::class, [
                'label' => 'Publié (o/n)',
                'required'   => false,
                'attr' => [
                    'class' => 'box'
                ]
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
            'data_class' => Article::class,
        ]);
    }
}
