<?php

namespace App\Form;

use App\Entity\Signaux;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SignauxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('date_placement')
            ->add('evenement')
            ->add('placement')
            ->add('gain')
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'En cours' => 0,
                    'Terminé' => 1,
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Signaux::class,
        ]);
    }
}
