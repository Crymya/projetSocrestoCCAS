<?php

namespace App\Form;

use App\Data\SearchData;
use App\Entity\Materiel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchTemperatureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut', DateType::class, [
                'html5' => true,
                'widget' => 'single_text',
                'label' => 'Date de début',
                'required' => false,
                'by_reference' => false,
                'empty_data' => ''
            ])
            ->add('dateFin', DateType::class, [
                'html5' => true,
                'widget' => 'single_text',
                'label' => 'Date de début',
                'required' => false,
                'by_reference' => false,
                'empty_data' => ''
            ])
            ->add('materiels', EntityType::class, [
                'class' => Materiel::class,
                'choice_label' => 'nom',
                'label' => false,
                'required' => false,
                'expanded' => true,
                'multiple' => true,
                'by_reference' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
