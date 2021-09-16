<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,[
                'label'=> 'Email ',
                'label_attr'=> ['class'=> 'small'],
                'attr'=>[ 'placeholder'=>'* Votre email...','class'=>'rounded-0'],
                'required'=>true,
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => [
                    'label' => 'Mot de passe ',
                    'label_attr'=> ['class'=> 'small'],
                    'required'=>true,
                    'attr'=>['placeholder'=> '* Votre mot de passe...','class'=>'rounded-0', 'autocomplete'=>'off'],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez entrer un mot de passe',
                        ]),
                        new Regex([
                            "pattern" => "/^(?=.*[0-9])(?=.*[a-zA-Z])[^ù ]{8,}$/",
                            "match" => true,
                            "message" => "Le mot de passe doit contenir au minimum 8 caractères dont au moins 1 lettre et 1 chiffre et en excluant les accents et les espaces",

                        ]),
                       
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmer le mot de passe ',
                    'label_attr'=> ['class'=> 'small'],
                    'required'=>true,
                    'attr'=>['placeholder'=> '* Confirmez votre mot de passe...','class'=>'rounded-0', 'autocomplete'=>'off']
                ],
                'mapped' => false,
                'invalid_message' => 'Les 2 mots de passe doivent correspondre.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
            ])

            ->add('agreeTerms', CheckboxType::class, [
                'label'=> 'J\'accepte les termes et conditions',
                'label_attr'=>[ 'class'=>'small'],
                'required'=>true,
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos conditions.',
                    ]),
                ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

 // new Length([
                        //     'min' => 4,
                        //     'minMessage' => 'Votre mot de passe doit contenir au minimum {{ limit }} caractères',
                        //     // max length allowed by Symfony for security reasons
                        //     'max' => 4096,
                        // ]),