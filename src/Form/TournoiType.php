<?php

namespace App\Form;

use App\Entity\CatTournois;
use App\Entity\Tournoi;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Participant;

class TournoiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')
            ->add('date')
            ->add('dateCreation')
            ->add('categorie')
            ->add('participants', EntityType::class, [
                'class' => Participant::class,
                'choice_label' => fn(Participant $p) => $p->getNom().' '.$p->getPrenom(),
                'multiple' => true,
                'expanded' => false,
                'by_reference' => false,
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
