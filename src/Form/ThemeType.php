<?php

namespace App\Form;

use App\Entity\Stage;
use App\Entity\Theme;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ThemeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('theme')
            ->add('pere', EntityType::class, [
                "class" => Theme::class,
                "choice_label" => "theme",
                "multiple" => false,
                "required" => false
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
            'data_class' => Theme::class,
        ]);
    }
}
