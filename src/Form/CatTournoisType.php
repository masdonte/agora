<?php

namespace App\Form;

use App\Entity\CatTournois;
use App\Entity\Tournoi;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CatTournoisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')
            ->add('tournois', EntityType::class, [
                'class' => Tournoi::class,
                'choice_label' => 'libelle',
                'multiple' => true,
                'expanded' => false,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CatTournois::class,
        ]);
    }
}
