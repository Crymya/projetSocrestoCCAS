<?php

namespace App\Form;

use App\Entity\Controle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ControleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom du document',
                'required' => true
            ])
            ->add('dateControle', DateType::class, [
                'html5' => true,
                'widget' => 'single_text',
                'required' => true,
                'label' => 'Date du contrôle'
            ])
            ->add('documents', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Controle::class,
            'allow_extra_fields' => true
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
