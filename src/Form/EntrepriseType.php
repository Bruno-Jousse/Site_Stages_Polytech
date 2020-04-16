<?php

namespace App\Form;

use App\Entity\Adresse;
use App\Entity\Entreprise;
use App\Entity\Stage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntrepriseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('est_privee')
            ->add('adresses', EntityType::class, [
                "class" => Adresse::class,
                "choice_label" => function(Adresse $adr){
                    return $adr->getAdresse() . " " . $adr->getVille() . " " . $adr->getPays();
                },
                "multiple" => true,
                "required" => true
            ])
            ->add('stages', EntityType::class, [
                "class" => Stage::class,
                "choice_label" => function(Stage $s){
                    return $s->getId() . " - " . $s->getIntitule();
                },
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
            'data_class' => Entreprise::class,
        ]);
    }
}
