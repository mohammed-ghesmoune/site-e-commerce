<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Repository\CartRepository;
use App\Repository\SizeRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class InvoiceController extends AbstractController
{
  /**
   * @Route("/invoice", name="invoice")
   */
  public function index(OrderRepository $orderRepository, CartRepository $cartRepository, EntityManagerInterface $entityManager)
  {
    $session = $this->get('session');
    if (!$session->get('cart') || !$session->get('cart')->getAmount()) {
      $this->addFlash(
          'danger',
          'Votre panier est vide'
      );
      return $this->redirectToRoute('cart');
  }
    $user = $this->getUser();
    $cart =$cartRepository->find($session->get('cart')->getId());

    $stripe = new \Stripe\StripeClient($_SERVER['STRIPE_KEY']);

    if (!$session->get('invoice')) {
      return $this->redirectToRoute('cart');
    }
    $invoice = $stripe->invoices->retrieve(
      $session->get('invoice'),
      []
    );

    if ($invoice['status'] !== 'paid') {
      return $this->redirectToRoute('cart');
    }

    $orders = $orderRepository->findOrderProducts($session->get('cart'));
    foreach ($orders as $order) {
      $orderQuantity = $order->getQuantity();
      $size = $order->getSize();
      $stock = $size->getStock();
      $size->setStock($stock - $orderQuantity);
    }

    $invoiceName = $invoice['number'];
    $invoicePdf = $invoice['invoice_pdf'];

    $invoice =(new Invoice())
            ->setUser($user)
            ->setCart($cart)
            ->setName($invoiceName)
            ->setUrl($invoicePdf);

         
    $entityManager->persist($invoice);
    $entityManager->flush(); 
    //clear session
    $session->clear();
    $session->set('user', $user);
    /*
    $session->remove('cart');
    $session->remove('invoice');
    $session->remove('articles');
    $session->remove('billing_address');
    $session->remove('shipping_address');
    */

   

   // $session->set('invoiceName', $invoiceName);
    $session->set('invoicePdf', $invoicePdf);

    $this->addFlash(
      'success',
      'Votre paiement a bien été effectué.'
    );
    return $this->redirectToRoute('facture');
  }

  /**
   *@Route("/facture", name="facture")
   */
  public function facture()
  {
    if(!$this->get('session')->get('invoicePdf')){
      return $this->redirectToRoute('home');
    }
    return $this->render('payment/invoice.html.twig',[]);
  }
}
