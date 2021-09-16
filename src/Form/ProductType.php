<?php

namespace App\Form;

use App\Entity\Product;
use App\Form\ColorType;
use App\Entity\Category;
use App\Form\CouleurType;
use App\Entity\SubCategory;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',null,[
                'label'=> 'Nom produit'
            ])
            ->add('nouveautes',null,[
                'label'=> 'Nouveauté'
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label'=> 'Categorie',
                "placeholder"=> "Choisir une catégorie",
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de renseigner une catégorie',
                    ]),
                ]
            ])
            ->add('subCategory', EntityType::class, [
                'class' => SubCategory::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('sc')
                        ->groupBy('sc.name')
                        ->orderBy('sc.name', 'ASC');
                },
                'choice_label' => 'name',
                'label'=> 'Sous categorie',
                "placeholder"=> "Choisir une sous catégorie",
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de renseigner une sous catégorie',
                    ]),
                ]

            ])
            ->add('colors', CollectionType::class, [
                "label"=> "Couleurs",
                'entry_type' => CouleurType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
