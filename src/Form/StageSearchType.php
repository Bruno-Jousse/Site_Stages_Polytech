<?php

namespace App\Form;

use App\Entity\Search\StageSearch;
use Symfony\Component\Form\AbstractType;
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
            ->add('est_gratifie')
            ->add('gratification')
            ->add('contratPro')
            ->add('embauche')
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
