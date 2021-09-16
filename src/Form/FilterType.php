<?php

namespace App\Form;

use App\Entity\Size;
use App\Entity\Color;
use App\Entity\Category;
use App\Entity\SubCategory;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'required' => false,
                'label' => false,
                //'label_attr' => ['for' => 'font-weight-bold text-uppercase'],
                //"placeholder"=> "Categorie",
                'multiple' => true,
                'expanded' => true,

            ])
            ->add('SubCategory', EntityType::class, [
                'class' => SubCategory::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('sc')
                        ->distinct('sc.name')
                        //->groupBy('sc.name')
                        ->orderBy('sc.name', 'ASC');
                },
                'choice_label' => 'name',
                'required' => false,
                'label' => false,
                //"placeholder"=> "Sous categorie",
                'multiple' => true,
                'expanded' => true,

            ])
            ->add('Color', EntityType::class, [
                'class' => Color::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('co')
                        ->distinct('co.name')
                        //->groupBy('co.name')
                        ->orderBy('co.name', 'ASC');
                },
                'choice_label' => 'name',
                'required' => false,
                'label' => false,
                // "placeholder"=> "Couleur",
                'multiple' => true,
                'expanded' => true,

            ])
            ->add('SizeMin', EntityType::class, [
                'class' => Size::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('si')
                        ->distinct('si.name')
                      //  ->groupBy('si.name')
                        ->orderBy('si.name', 'ASC');
                },
                'choice_label' => 'name',
                'required' => false,
                'label' => "Taille Min",
                //"placeholder"=> false,
                'expanded' => true,

            ])
            ->add('SizeMax', EntityType::class, [
                'class' => Size::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('si')
                        ->distinct('si.name')
                      //  ->groupBy('si.name')
                        ->orderBy('si.name', 'ASC');
                },
                'choice_label' => 'name',
                'required' => false,
                'label' => "Taille Max",
                //"placeholder"=> false,
                'expanded' => true,
            ])
            ->add('PriceMin', MoneyType::class, ['label' => false, 'required' => false, "attr" => ['placeholder' => 'Min']])
            ->add('PriceMax', MoneyType::class, ['label' => false, 'required' => false, "attr" => ['placeholder' => 'Max']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }
}
