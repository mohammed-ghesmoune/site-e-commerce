<?php

namespace App\Service;

use App\Entity\Product;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;

class ProductHelper
{
    private $entityManager;
    private $session;
    private $fileUploader;

    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack, FileUploader $fileUploader)
    {
        $this->entityManager = $entityManager;
        $this->request = $requestStack->getCurrentRequest();
        $this->session = $this->request->getSession();
        $this->fileUploader = $fileUploader;
    }

    public function handle($product)
    {

        $route = $this->request->attributes->get("_route");

        extract($this->checkEmptyColorOrImageOrSize($product));

        if ($emptyColor === false && $emptySize === false && $emptyImage == false) {

            if (!$this->save($product)) {
                return false;
            }

            if ($route === "product_new") {
                $this->session->getFlashBag()->add(
                    'success',
                    "Le produit <strong>{$product->getName()}</strong> a bien été enregistré "
                );
            } else {
                $this->session->getFlashBag()->add(
                    'success',
                    " Les modifications du produit <strong>{$product->getName()}</strong> ont bien été enregistrées "
                );
            }
            return true;
        }
        return false;
    }

    public function save(Product $product)
    {
        /*
        if ($this->EmptyUploadImage($product)) {
            return false;
        }
        */

        foreach ($product->getColors() as $keyColor => $color) {
            foreach ($color->getImages() as $keyImage => $image) {
                $uploadImage = array_values($this->request->files->get('product')['colors'][$keyColor]['images'])[$keyImage]['imageURL'];
                if ($uploadImage !== null) {
                    $url = $this->fileUploader->upload($uploadImage);
                    $image->setUrl($url);
                }
                
                $image->setColor($color);
                $this->entityManager->persist($image);
            }
            foreach ($color->getSizes() as $size) {
                $size->setColor($color)
                     ->setProduct($product);

                $this->entityManager->persist($size);
            }
            $color->setProduct($product);
            $this->entityManager->persist($color);
        }
        $this->entityManager->persist($product);
        $this->entityManager->flush();
        return true;
    }

    public function checkEmptyColorOrImageOrSize(Product $product)
    {
        $emptyColor = $emptySize = $emptyImage =  false;
        if ($product->getColors()->isEmpty()) {
            $this->session->getFlashBag()->add(
                'danger',
                " Merci d'ajouter une <strong> couleur </strong> a ce produit"
            );
            $emptyColor = true;
        } else {

            foreach ($product->getColors() as $color) {
                if ($color->getSizes()->isEmpty()) {
                    $this->session->getFlashBag()->add(
                        'danger',
                        " Merci d'ajouter une <strong> taille </strong> a la couleur <strong>{$color->getName()}</strong>"
                    );
                    $emptySize = true;
                }
                if ($color->getImages()->isEmpty()) {
                    $this->session->getFlashBag()->add(
                        'danger',
                        " Merci d'ajouter une <strong> Image </strong> a la couleur <strong>{$color->getName()}</strong>"
                    );
                    $emptyImage = true;
                }
            }
        }
        return compact('emptyColor', 'emptySize', 'emptyImage');
    }
    /*
    public function EmptyUploadImage($product)
    {
        $EmptyUploadImage = false;
        foreach ($product->getColors() as $keyColor => $color) {
            foreach ($color->getImages() as $keyImage => $image) {
                $uploadImage = array_values($this->request->files->get('product')['colors'][$keyColor]['images'])[$keyImage]['imageURL'];
                if ($uploadImage === null) {
                    $this->session->getFlashBag()->add(
                        'danger',
                        " Le champs <strong> image Url N° " . ($keyImage + 1) . "</strong> pour la couleur <strong>{$color->getName()}</strong> est vide"
                    );
                    $EmptyUploadImage = true;
                }
            }
        }
        return $EmptyUploadImage;
    }
    */
}
