<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Profile\ChangeEmail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangeEmailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('email', RepeatedType::class, [
                'type' => EmailType::class,
                'invalid_message' => 'Les champs de l\'adressse mail doivent correspondre.',
                'options' => ['attr' => ['class' => 'email-field']],
                'required' => true,
                'first_options'  => ['label' => false, 'attr' => [ 'placeholder' => '* Votre nouvel email...','required'=>true]],
                'second_options' => ['label' => false, 'attr' => [ 'placeholder' => '* Confirmez votre nouvel email...', 'required'=>true]],
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ChangeEmail::class,
        ]);
    }
}
