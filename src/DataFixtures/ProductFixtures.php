<?php

namespace App\DataFixtures;

use App\Entity\Size;
use App\Entity\Color;
use App\Entity\Image;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\SubCategory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories=['homme','femme','enfant'];
        $sousCategories=['vêtements','chaussures','accessoires'];
        $faker = \Faker\Factory::create('fr_FR');

        foreach($categories as $categorie) {
            $category = (new Category())->setName($categorie);
            $manager->persist($category);
            foreach ($sousCategories as $sousCategorie) {
                $subCategory = (new SubCategory())
                    ->setName($sousCategorie)
                    ->setCategory($category);
                $manager->persist($subCategory);
            }
        }

        $manager->flush();
    }
    /*
    public function load(ObjectManager $manager)
    {
        $categorie=['homme','femme','enfant'];
        $sousCategorie=[];
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 3; $i++) {
            $category = (new Category())->setName($faker->word);
            $manager->persist($category);
            for ($j = 0; $j < 3; $j++) {
                $subCategory = (new SubCategory())
                    ->setName($faker->word)
                    ->setCategory($category);
                $manager->persist($subCategory);
                for ($k = 0; $k < mt_rand(4, 6); $k++) {
                    $product = (new Product())
                        ->setName($faker->words($nb = mt_rand(3, 5), $asText = true))
                        ->setCategory($category)
                        ->setSubCategory($subCategory);
                    $manager->persist($product);

                    for ($l = 0; $l < mt_rand(2, 4); $l++) {
                        $color = (new Color())
                            ->setName($faker->safeColorName())
                            ->setProduct($product);
                        $manager->persist($color);
                        $image = (new Image())
                            ->setUrl($faker->imageUrl($width = 450, $height = 450))
                            ->setColor($color);
                        $manager->persist($image);

                        for ($m = 0; $m < mt_rand(2, 4); $m++) {
                            $size = (new Size())
                                ->setName(mt_rand(38, 45))
                                ->setPrice(mt_rand(50, 100))
                                ->setColor($color)
                                ->setProduct($product)
                                ->setStock(mt_rand(0, 10));
                            $manager->persist($size);
                        }
                    }
                }
            }
        }

        $manager->flush();
    }
    */
}
