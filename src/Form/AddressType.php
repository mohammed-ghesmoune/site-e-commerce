<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('civility',ChoiceType::class,[
                'choices'=>['Homme'=>'Male','Femme'=>'Female'],
                'expanded'=> true,
                'multiple'=> false,
                'label'=> 'Civilité *'
                
            ])
            ->add('firstname',TextType::class,[
                'label'=> 'Prénom *'
            ])
            ->add('lastname',TextType::class,[
                'label'=> 'Nom *'
            ])
            ->add('line1',TextType::class,[
                'label'=> 'Adresse *'
            ])
            ->add('line2',TextType::class,[
                'label'=> 'Complément d\'adresse',
                'required'=> false,
            ])
            ->add('postalcode',TextType::class,[
                'label'=> 'Code postal *'
            ])
            ->add('city',TextType::class,[
                'label'=> 'Ville *'
            ])
            ->add('state',TextType::class,[
                'label'=> 'Département',
                'required'=> false,
            ])
            ->add('country',CountryType::class,[
                'label'=> 'Pays *',
            ])
            ->add('phone',TelType::class,[
                'label'=> 'Téléphone *'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }

    

}
