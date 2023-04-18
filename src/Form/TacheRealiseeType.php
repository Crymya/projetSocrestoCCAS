<?php

namespace App\Form;

use App\Entity\Editeur;
use App\Entity\Tache;
use App\Entity\TacheRealisee;
use App\Repository\EditeurRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TacheRealiseeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tache', EntityType::class, [
                'class' => Tache::class,
                'choice_label' => 'libelle',
                'label' => false,
                'attr' => ['style' => 'display:none;']
            ])
            ->add('editeur', EntityType::class, [
                'class' => Editeur::class,
                'label' => false,
                'placeholder' => '-- Saisir un utilisateur --',
                'required' => false,
                'query_builder' => function (EditeurRepository $editeurRepository) {
                    return $editeurRepository->createQueryBuilder('er')
                        ->where('er.actif = :actif')
                        ->setParameter('actif', true);
                }
            ])
            ->add('realisee', CheckboxType::class, [
                'required' => false,
                'label' => 'Réalisée'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TacheRealisee::class,
        ]);
    }
}
