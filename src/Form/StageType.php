<?php

namespace App\Form;

use App\Entity\MotCle;
use App\Entity\Stage;
use App\Entity\Theme;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sujet', TextareaType::class)
            ->add('intitule', TextareaType::class)
            ->add('annee')
            ->add('duree_jours')
            ->add('est_gratifie')
            ->add('gratification')
            ->add('nom_etud')
            ->add('prenom_etud')
            ->add('contratPro')
            ->add('nom_tuteur_ent')
            ->add('prenom_tuteur_ent')
            ->add('tel_tuteur_ent')
            ->add('mail_visible')
            ->add('mail_tuteur_ent')
            ->add('commentaire', TextareaType::class)
            ->add('recap')
            ->add('embauche')
            ->add('promo')
            ->add('annee_form')
            ->add('departement')
            ->add('themes', EntityType::class, [
                "class" => Theme::class,
                "choice_label" => "theme",
                "multiple" => true,
                "required" => false
            ])
            ->add('adresse', AdresseType::class)
            ->add('motsCles', EntityType::class, [
                "class" => MotCle::class,
                "choice_label" => "motCle",
                "multiple" => true,
                "required" => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
