<?php

namespace App\Form;

use App\Entity\Color;
use App\Form\SizeType;
use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class CouleurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', ColorType::class, [
                'label' => 'Couleur',
                     'attr' => ['style' => 'width:50px']
            ])
            // ->add('name', TextType::class, [
            //     'label' => 'Couleur',
            //     'attr' => ['placeholder' => 'Couleur']
            // ])
            ->add('images', CollectionType::class, [
                "label"=>"Images",
                'entry_type' => ImageType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('sizes', CollectionType::class, [
                "label"=> "Tailles",
                'entry_type' => SizeType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Color::class,
        ]);
    }
}
