<?php

namespace App\Form;

use App\Entity\Other\FichierCSV;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class FichierCSVType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("file", FileType::class, array(
                "label" => false,
                "required" => false,
                "mapped" => false,
                "constraints" => [
                    new File([
                        "maxSize" => "5000k",
                        "mimeTypes" => [
                            "text/csv",
                            "application/vnd.ms-excel"
                        ],
                        "mimeTypesMessage" => "Please upload a valid CSV file"
                    ])
                ]
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FichierCSV::class,
        ]);
    }
}
