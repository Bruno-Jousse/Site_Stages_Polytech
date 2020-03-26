<?php

namespace App\Form;

use App\Entity\MotCle;
use App\Entity\Search\StageSearch;
use App\Entity\Theme;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StageSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('annee')
            ->add('duree_mois_min')
            ->add('duree_mois_max')
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
            ->add('continent')
            ->add('pays')
            ->add('ville')
            ->add('entreprise')
            ->add('motsCles', EntityType::class, [
                "class" => MotCle::class,
                "choice_label" => "motCle",
                "multiple" => true,
                "required" => false
            ])
            ->add('themes', EntityType::class, [
                "class" => Theme::class,
                "choice_label" => "theme",
                "multiple" => true,
                "required" => false
            ])
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
