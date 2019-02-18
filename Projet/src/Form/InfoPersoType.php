<?php

namespace App\Form;

use App\Entity\InfoUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class InfoPersoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom')
            ->add('Prenom')
            ->add('Sexe', ChoiceType::class, [
                'choices' => [
                    'Homme' => 'homme',
                    'Femme' => 'femme',
                ],
                'expanded' => true,
                'label_attr' => [
                    'class' => 'radio-inline'
                ],
            ])
            ->add('Age', TextType::class)
            ->add('Poids', TextType::class)
            ->add('Taille', TextType::class)
            ->add('tour_taille', TextType::class)
            ->add('tour_hanche', TextType::class)
            ->add('temps_activite_physique', TextType::class)
            ->add('intolerance')
            ->add('type_regime', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InfoUser::class,
        ]);
    }
}
