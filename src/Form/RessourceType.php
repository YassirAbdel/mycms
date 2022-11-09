<?php

namespace App\Form;

use App\Entity\Ressource;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RessourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type')
            ->add('titre')
            ->add('langue')
            ->add('commentaire')
            ->add('personne')
            ->add('oeuvre')
            ->add('organisme')
            ->add('lieu')
            ->add('descripteur')
            ->add('analyse')
            ->add('droits')
            ->add('created_at')
            ->add('auteur')
            ->add('responsable')
            ->add('editeur')
            ->add('lieuedition')
            ->add('annee_edition')
            ->add('isbn')
            ->add('pagination')
            ->add('collection')
            ->add('auteur_secondaire')
            ->add('anneeStat')
            ->add('perHisto')
            ->add('origDoc')
            ->add('copyRight')
            ->add('support')
            ->add('couleur')
            ->add('format')
            ->add('formatFile')
            ->add('duree')
            ->add('nbFiles')
            ->add('cote')
            ->add('supNum')
            ->add('locaSupnum')
            ->add('coteNum')
            ->add('urlImag')
            ->add('urlPdf')
            ->add('urlAudio')
            ->add('numVideo')
            ->add('urlDoc')
            ->add('resEdit')
            ->add('lecteur')
            ->add('folderFront')
            //->add('textes')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ressource::class,
        ]);
    }
}
