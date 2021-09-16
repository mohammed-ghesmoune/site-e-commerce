<?php

namespace App\Form;

use App\Entity\SaleForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class SaleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'label'=>'Nom du produit',
                'disabled'=>true
            ])
            ->add('color',TextType::class,[
                'label'=>'Couleur',
                'disabled'=>true
            ])
            ->add('size',TextType::class,[
                'label'=>'Taille',
                'disabled'=>true
            ])
            ->add('price', MoneyType::class,[
                'label'=>'Prix',
                'disabled'=>true
            ])
            ->add('stock',IntegerType::class,[
                'label'=>'Stock',
                'disabled'=>true
            ])
            ->add('startDate',DateType::class,[
                'label'=>'Début de la promo',
                'widget'=>'single_text',

            ])
            ->add('endDate',DateType::class,[
                'label'=>'Fin de la promo',
                'widget'=>'single_text',

            ])
            ->add('minItems',IntegerType::class,[
                'label'=>'Nombre Min d\'articles',
            ])
            ->add('rate',IntegerType::class,[
                'label'=>'Remise en % ',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SaleForm::class,
        ]);
    }
}
