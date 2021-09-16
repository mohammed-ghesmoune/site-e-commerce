<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Merci de renseigner un mot de passe',
                        ]),
                        new Regex([
                            "pattern" => "/^(?=.*[0-9])(?=.*[a-zA-Z])[^ù ]{8,}$/",
                            "match" => true,
                            "message" => "Le mot de passe doit contenir au minimum 8 caractères dont au moins 1 lettre et 1 chiffre et en excluant les accents et les espaces",

                        ]),

                    ],
                    'label' => 'Nouveau mot de passe',
                    'label_attr' => ['class' => 'small'],
                    'attr' => ['placeholder' => '* Nouveau mot de passe...', 'class' => 'rounded-0', 'autocomplete' => 'off'],
                ],
                'second_options' => [
                    'label' => 'Confirmer le mot de passe ',
                    'label_attr' => ['class' => 'small'],
                    'attr' => ['placeholder' => '* Confirmez le mot de passe...', 'class' => 'rounded-0', 'autocomplete' => 'off'],
                ],
                'invalid_message' => 'Les 2 mots de passe doivent correspondre.',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}

/*new Length([
'min' => 4,
'minMessage' => 'Votre mot de passe doit contenir au minimum {{ limit }} caractères',
// max length allowed by Symfony for security reasons
'max' => 4096,
]),*/
