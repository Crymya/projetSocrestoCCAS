<?php

namespace App\Form;

use App\Entity\Editeur;
use App\Repository\EditeurRepository;
use App\Tools\Modele;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Type;

class TemperatureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('editeur', EntityType::class, [
                'label' => 'Utilisateur',
                'class' => Editeur::class,
                'placeholder' => '-- Saisir un utilisateur --',
                'query_builder' => function (EditeurRepository $editeurRepository) {
                    return $editeurRepository->createQueryBuilder('er')
                        ->where('er.actif = :actif')
                        ->setParameter('actif', true);
                }
            ])
            ->add('temp1', IntegerType::class, [
                'label' => 'Température',
                'required' => true,
                'constraints' => new Type(['type' => 'numeric'])
            ])
            ->add('temp2', IntegerType::class, [
                'label' => 'Température',
                'required' => true
            ])
            ->add('temp3', IntegerType::class, [
                'label' => 'Température',
                'required' => true
            ])
            ->add('temp4', IntegerType::class, [
                'label' => 'Température',
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Modele::class,
            'allow_extra_fields' => true
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
