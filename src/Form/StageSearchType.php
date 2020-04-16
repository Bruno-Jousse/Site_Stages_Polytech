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
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
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
            //TODO: gérer les droits d'accès aux  stages
            ->add('promo')
            ->add('annee_form')
            ->add('departement')

            //TODO: Transformer ces champs en EntityType
            ->add('continent')
            ->add('pays')
            ->add('ville')
            ->add('entreprise')
            ->add('motsCles', EntityType::class, [
                "class" => MotCle::class,
                "choice_label" => "motCle",
                'attr' => [
                    'title' => 'Veuillez faire un choix',
                    'class' => 'selectpicker w-100',
                    'style' => 'width:200px;'
                ],
                "multiple" => true,
                "required" => false
            ])
            ->add('themes', EntityType::class, [
                "class" => Theme::class,
                "choice_label" => "theme",
                'attr' => [
                    'title' => 'Veuillez faire un choix',
                    'class' => 'selectpicker w-100',
                    'style' => 'width:200px;'
                ],
                "multiple" => true,
                "required" => false
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StageSearch::class,
        ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return "";
    }
}
