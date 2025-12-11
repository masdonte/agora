<?php

namespace App\Form;

use App\Entity\CatTournois;
use App\Entity\Participant;
use App\Entity\Tournoi;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TournoiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')
            ->add('date')
            ->add('dateCreation')
            ->add('categorie', EntityType::class, [
                'class' => CatTournois::class,
                'choice_label' => 'id',
            ])
            ->add('participants', EntityType::class, [
                'class' => Participant::class,
                'choice_label' => function (Participant $participant) {
                    return $participant->getPrenom() . ' ' . $participant->getNom();
                },
                'multiple' => true,
                'expanded' => false,
                'required' => false,
                'query_builder' => function ($er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.nom', 'ASC')
                        ->addOrderBy('p.prenom', 'ASC');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tournoi::class,
        ]);
    }
}
