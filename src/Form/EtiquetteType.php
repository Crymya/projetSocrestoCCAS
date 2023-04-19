<?php

namespace App\Form;

use App\Entity\Editeur;
use App\Entity\Etiquette;
use App\Repository\EditeurRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtiquetteType extends AbstractType
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
            ->add('nomProduit', TextType::class, [
                'label' => 'Nom du produit',
                'required' => true
            ])
            ->add('temperature', NumberType::class, [
                'label' => 'Température du produit',
                'required' => true
            ])
            ->add('jourUtilise', DateType::class, [
                'html5' => true,
                'widget' => 'single_text',
                'required' => true,
                'label' => 'Date d\'ouverture'
            ])
            ->add('dlc', DateType::class, [
                'html5' => true,
                'widget' => 'single_text',
                'required' => true,
                'label' => 'Date limite de consommation'
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
            'data_class' => Etiquette::class,
            'allow_extra_fields' => true
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
