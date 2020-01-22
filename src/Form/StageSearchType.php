<?php

namespace App\Form;

use App\Entity\Search\StageSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StageSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('annee')
            ->add('duree_jours_min')
            ->add('duree_jours_max')
            ->add('est_gratifie', CheckboxType::class, [
                'label'    => 'Stage rémunéré uniquement',
                'required' => false,
            ])
            ->add('contratPro' , CheckboxType::class, [
                'label'    => 'Contrat Pro uniquement',
                'required' => false,
            ])
            ->add('embauche', CheckboxType::class, [
                'label'    => 'Entreprise recrutant uniquement',
                'required' => false,
            ])
            ->add('promo')
            ->add('annee_form')
            ->add('departement')
            ->add('localisation')
            ->add('entreprise')
            ->add('motsCle')
            ->add('themes')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StageSearch::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return "";
    }
}
