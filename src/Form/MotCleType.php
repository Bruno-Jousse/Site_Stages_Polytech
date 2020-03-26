<?php

namespace App\Form;

use App\Entity\MotCle;
use App\Entity\Stage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MotCleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('motCle')
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
            'data_class' => MotCle::class,
        ]);
    }
}
