<?php

namespace App\Form;

use App\Entity\Allergie;
use App\Entity\InfoUser;
use App\Entity\Intolerance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

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
                    'class' => 'radio-inline',
                ],
            ])
            ->add('Age', TextType::class, [
                'required' => false,
            ])
            ->add('Poids', TextType::class, [
                'required' => false,
            ])
            ->add('Taille', TextType::class, [
                'required' => false,
            ])
            ->add('tour_taille', TextType::class, [
                'required' => false,
            ])
            ->add('tour_hanche', TextType::class, [
                'required' => false,
            ])
            ->add('temps_activite_physique', TextType::class, [
                'required' => false,
            ])
            ->add('intolerance', EntityType::class, [
                'class' => Intolerance::class,
                'choice_label' => 'Nom',
                'label_attr' => [
                    'class' => 'checkbox-inline',
                ],
                'expanded' => true,
                'multiple' => true

            ])
            ->add('allergie', EntityType::class, [
                'class' => Allergie::class,
                'choice_label' => 'Nom',
                'label_attr' => [
                    'class' => 'checkbox-inline',
                ],
                'expanded' => true,
                'multiple' => true

            ])
            ->add('enregistrer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InfoUser::class,
        ]);
    }
}
