<?php

namespace App\Form;

use App\Entity\Size;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class SizeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',null, [
                'label' => 'Taille',
                'attr'=> ['placeholder' =>' Taille']
                
            ]
           )
            ->add('price', MoneyType::class,[
                'label' => 'Prix',
                'attr'=> ['placeholder' =>' Prix']
            ])
            ->add('stock',null,[
                'attr'=> ['placeholder' =>' Stock']
            ])
            ->add('deleted',null,[
                'label'=> 'Non disponible'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Size::class,           
        ]);
    }
}
