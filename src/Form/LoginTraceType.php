<?php

namespace App\Form;

use App\Entity\LoginTrace;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginTraceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('ipAddress')
            ->add('message')
            ->add('logged_at', null, [
                'widget' => 'single_text',
            ])
            ->add('success')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LoginTrace::class,
        ]);
    }
}
