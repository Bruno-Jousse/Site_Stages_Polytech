<?php

namespace App\Form;

use App\Entity\Adresse;
use App\Entity\Entreprise;
use App\Entity\Stage;
use phpDocumentor\Reflection\Types\Collection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdresseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adresse')
            ->add('adresse_suite')
            ->add('code_postal')
            ->add('ville')
            ->add('latitude')
            ->add('longitude')
            ->add('continent')
            ->add('pays')
            ->add('entreprise', EntityType::class, [
                "class" => Entreprise::class,
                "choice_label" => "nom",
                "multiple" => false,
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
            'data_class' => Adresse::class,
        ]);
    }
}
