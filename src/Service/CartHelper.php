<?php

namespace App\Service;

use App\Entity\Cart;
use App\Entity\Size;
use App\Entity\Order;
use App\Repository\CartRepository;
use App\Repository\UserRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ShippingFeeRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartHelper
{

    private $session;
    private $orderRepository;
    private $shippingFeeRepository;
    private $cartRepository;
    private $entityManager;
    private $userRepository;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager, UserRepository $userRepository, OrderRepository $orderRepository, ShippingFeeRepository $shippingFeeRepository, CartRepository $cartRepository)
    {
        $this->session = $requestStack->getCurrentRequest()->getSession();
        $this->orderRepository = $orderRepository;
        $this->shippingFeeRepository = $shippingFeeRepository;
        $this->cartRepository = $cartRepository;
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    public function Summary()
    {
        $orders = $discount = $articles = $realAmount = $fee = null;
        if(!$this->session->get('cart')){
            return compact('orders', 'realAmount', 'fee', 'discount', 'articles');
        }
        $cartId = $this->session->get('cart')->getId();
        $cart = $this->cartRepository->find($cartId);

        if ($cart) {
            $orders = $this->orderRepository->findOrderProducts($cart);
            if ($orders) {
                $now =  new \DateTime();
                foreach ($orders as $order) {
                    $articles += $order->getQuantity();
                    $sales = $order->getSize()->getsales();
                    foreach ($sales as $sale) {
                        if ($now > $sale->getstartDate() && $now < $sale->getEndDate()) {
                            if ($order->getQuantity() >= $sale->getMinItems()) {
                                $discount += $order->getQuantity() * $order->getSize()->getPrice() * $sale->getRate() / 100;
                            }
                        }
                    }
                }

                $cartAmount = $this->orderRepository->cartAmount($cart) ?? 0;
                $cart->setAmount($cartAmount);

                $realAmount = $cartAmount - $discount;
                $shippingFee = $this->shippingFeeRepository->find(1);
                $minAmountShippingFee = $shippingFee->getMinAmount();

                $fee = $realAmount > $minAmountShippingFee ? 0 : $shippingFee->getFee();
                $realAmount += $fee;
                $cart->setRealAmount($realAmount);
            } else {
                $cart->setAmount(0);
                $cart->setRealAmount(0);
            }
            $this->entityManager->flush();
        }
        $this->session->set('articles', $articles);
        $this->session->set('cart', $cart);
        return compact('orders', 'realAmount', 'fee', 'discount', 'articles');
    }

    public function addOrder(Order $order, Size $size)
    {
        $quantity =  $order->getQuantity();
        $price = $size->getPrice();

        if (!$this->session->get('cart')) {
            $cart = (new Cart())
                ->setAmount($price * $quantity);
            if ($this->session->get('user')) {
                $user = $this->userRepository->find($this->session->get('user')->getId());
                $cart->setUser($user);
            } else {
                $cart->setTimestamp(time());
            }
            $this->entityManager->persist($cart);

            $order = (new Order())
                ->setQuantity($quantity)
                ->setSize($size)
                ->setCart($cart);

            $this->entityManager->persist($order);
            $this->entityManager->flush();
            $this->session->set('cart', $cart);
        } else {
            $order = $this->orderRepository->findOneBy(['size' => $size, 'cart' => $this->session->get('cart')]);
            $cartId = $this->session->get('cart')->getId();
            $cart = $this->cartRepository->find($cartId);
            if ($order) {
                $order->setQuantity($quantity);
                $cartAmount = $this->orderRepository->cartAmount($cart);
                $cart->setAmount($cartAmount);
                $this->entityManager->flush();
            } else {
                $order = (new Order())
                    ->setQuantity($quantity)
                    ->setSize($size)
                    ->setCart($cart);
                $this->entityManager->persist($order);
                $this->entityManager->flush();
                $cartAmount = $this->orderRepository->cartAmount($cart);
                $cart->setAmount($cartAmount);
                $this->entityManager->flush();
            }
            $this->session->set('cart', $cart);
        }
    }
}
