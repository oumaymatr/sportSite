<?php

namespace App\Form;

use App\Entity\Search;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sport', ChoiceType::class, [
                'choices' => $options['sportChoices'],
                'placeholder' => '--Sélectionner--',
                'label' => 'Sport:',
            ])
            ->add('niveau', ChoiceType::class, [
                'choices' => [
                    'Débutant' => 'debutant',
                    'Confirmé' => 'confirme',
                    'Pro' => 'pro',
                    'Supporter' => 'supporter',
                ],
                'placeholder' => '--Sélectionner--',
                'label' => 'Niveau:',
            ])
            ->add('departement', ChoiceType::class, [
                'choices' => $options['departementChoices'],
                'label' => 'Département:',
                'placeholder' => '--Sélectionner--',
            ]);
            }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'sportChoices' => [],
            'departementChoices' => [],
        ]);
    }
}
