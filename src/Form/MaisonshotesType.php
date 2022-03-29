<?php

namespace App\Form;

use App\Entity\Maisonhoteimage;
use App\Entity\Maisonshotes;
use App\Entity\TypeMaison;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaisonshotesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('libelle')
            ->add('capacite')
            ->add('localisation')
            ->add('proprietaire')
            ->add('prix')
            ->add('nbrChambres')

            ->add('type_maison',EntityType::class,
                [
                    'class' => TypeMaison::class,
                    'choice_label'=>'libelle',
                    'required' => true,
                ])
            ->add(
                'maisonhotesimages',
                CollectionType::class,
                array(
                    'entry_type' => MaisonhoteimageType::class,
                    'by_reference' => false,
                    'allow_add'    => true,
                    'allow_delete' => true,
                    'label' => 'Image(s) :',
                    'prototype' => true,

                )
            )
        ;


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Maisonshotes::class,
            'required' => false,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_maisonshotes';
    }
}
