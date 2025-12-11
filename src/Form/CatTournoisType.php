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
                'choice_label' => function (Tournoi $tournoi) {
                    return $tournoi->getLibelle() . ' (' . ($tournoi->getDate() ? $tournoi->getDate()->format('d/m/Y') : 'N/A') . ')';
                },
                'multiple' => true,
                'expanded' => false,
                'required' => false,
                'query_builder' => function ($er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.libelle', 'ASC');
                },
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
