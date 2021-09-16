<?php

namespace App\Controller;


use App\Entity\Order;
use App\Service\CartHelper;
use App\Form\OrderType;
use App\Repository\CartRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ShippingFeeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{

    /**
     * @Route("/cart", name="cart")
     */
    public function show(CartHelper $cartHelper)
    {
        return $this->render('cart/cart.html.twig', $cartHelper->Summary());
    }

    /**
     * @Route("/cart/{id<\d+>}/delete", name="cart_delete")
     * @Route("/cart/{id<\d+>}/update", name="cart_update")
     * 
     */

    public function delete(CartHelper $cartHelper, Request $request, Session $session, OrderRepository $orderRepo, $id, EntityManagerInterface $em, CartRepository $cartRepo): Response
    {
        $order = $orderRepo->find($id);
        $product = $this->findProduct($order);
        $em->remove($order);
        $em->flush();


        if ($request->attributes->get('_route') === "cart_update") {
            $cartHelper->Summary();
            return $this->redirectToRoute('product_show', $product);
        }

        return $this->redirectToRoute('cart');
    }

    private function findProduct(Order $order)
    {
        $size = $order->getSize();
        $color = $size->getColor();
        $product = $color->getProduct();
        $colors = $product->getColors();
        $sizes = $color->getSizes();
        $colorIndex = $colors->indexOf($color);
        $sizeIndex =  $sizes->indexOf($size);
        $id = $product->getId();
        $slug = $product->getSlug();
        $quantity_form = $this->createForm(OrderType::class, $order)->createView();

        return compact('colorIndex', 'sizeIndex', 'id', 'slug', 'quantity_form');
    }
}
