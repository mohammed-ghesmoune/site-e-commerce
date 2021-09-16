<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use App\Entity\Profile\ContactInformations;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class ContactInformationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
        ->add('line1',TextType::class,[
            'label'=> 'Adresse',
        ])
        ->add('line2',TextType::class,[
            'label'=> 'Complément d\'adresse',
        ])
        ->add('postalcode',TextType::class,[
            'label'=> 'Code postal',
        ])
        ->add('city',TextType::class,[
            'label'=> 'Ville',
        ])
        ->add('state',TextType::class,[
            'label'=> 'Département',
        ])
        ->add('country',CountryType::class,[
            'label'=> 'Pays',
            'attr'=>['placeholder'=>'Pays'],
        ])
        ->add('phone',TelType::class,[
            'label'=> 'Téléphone',
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactInformations::class,
        ]);
    }
}
