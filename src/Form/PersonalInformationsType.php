<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use App\Entity\Profile\PersonalInformations;

class PersonalInformationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('civility',ChoiceType::class,[
                'choices'=>['M. '=>'Male',' Mme.'=>'Female'],
                'expanded'=> true,
                'multiple'=> false,
                'label'=> 'Civilité'
                
            ])
            ->add('firstname',TextType::class,[
                'label'=> 'Prénom'
            ])
            ->add('lastname',TextType::class,[
                'label'=> 'Nom'
            ])
            ->add('birthday',BirthdayType::class,[
                'label'=> 'Date de naissance'
            ])
            ->add('profession',TextType::class,[
                'label'=> 'Profession'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PersonalInformations::class,
        ]);
    }
}
