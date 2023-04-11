<?php

namespace App\Form;

use App\Entity\Editeur;
use App\Tools\ModeleTache;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TacheRealiseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('editeur1', EntityType::class, [
                'class' => Editeur::class,
                'label' => false,
                'placeholder' => '-- Saisir un utilisateur --'
            ])
            ->add('editeur2', EntityType::class, [
                'class' => Editeur::class,
                'label' => false,
                'placeholder' => '-- Saisir un utilisateur --'
            ])/*
            ->add('editeur3', EntityType::class, [
                'class' => Editeur::class,
                'label' => false,
                'placeholder' => '-- Saisir un utilisateur --'
            ])
            ->add('editeur4', EntityType::class, [
                'class' => Editeur::class,
                'label' => false,
                'placeholder' => '-- Saisir un utilisateur --'
            ])
            ->add('editeur5', EntityType::class, [
                'class' => Editeur::class,
                'label' => false,
                'placeholder' => '-- Saisir un utilisateur --'
            ])
            ->add('editeur6', EntityType::class, [
                'class' => Editeur::class,
                'label' => false,
                'placeholder' => '-- Saisir un utilisateur --'
            ])
            ->add('editeur7', EntityType::class, [
                'class' => Editeur::class,
                'label' => false,
                'placeholder' => '-- Saisir un utilisateur --'
            ])
            ->add('editeur8', EntityType::class, [
                'class' => Editeur::class,
                'label' => false,
                'placeholder' => '-- Saisir un utilisateur --'
            ])
            ->add('editeur9', EntityType::class, [
                'class' => Editeur::class,
                'label' => false,
                'placeholder' => '-- Saisir un utilisateur --'
            ])
            ->add('editeur10', EntityType::class, [
                'class' => Editeur::class,
                'label' => false,
                'placeholder' => '-- Saisir un utilisateur --'
            ])
            ->add('editeur11', EntityType::class, [
                'class' => Editeur::class,
                'label' => false,
                'placeholder' => '-- Saisir un utilisateur --'
            ])
            ->add('editeur12', EntityType::class, [
                'class' => Editeur::class,
                'label' => false,
                'placeholder' => '-- Saisir un utilisateur --'
            ])
            ->add('editeur13', EntityType::class, [
                'class' => Editeur::class,
                'label' => false,
                'placeholder' => '-- Saisir un utilisateur --'
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ModeleTache::class,
            'allow_extra_fields' => true
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
