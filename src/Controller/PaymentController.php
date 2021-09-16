<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use App\Service\CartHelper;
use App\Service\PaymentHelper;
use App\Repository\OrderRepository;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class PaymentController extends AbstractController
{

    /**
     * @Route("/payment", name="payment")
     */

    public function index(CartHelper $cartHelper, PaymentHelper $paymentHelper, Request $request, Session $session, AddressRepository $addressRepository,  EntityManagerInterface $em)
    {

        if (!$session->get('cart') || !$session->get('cart')->getAmount()) {
            $this->addFlash(
                'danger',
                'Votre panier est vide'
            );
            return $this->redirectToRoute('cart');
        }

        $clientSecret = null;
        extract($paymentHelper->handlePayment()); // returns $step , $form

        $addresses = $addressRepository->findByUser($this->getUser());

        if ($request->isXmlHttpRequest()) {
            if ($step !== 'card') {
                $view = $this->renderView('payment/_payment_addresses.html.twig', [
                    'addresses' => $addresses,
                    'form' => $form->createView(),
                    'step' => $step,
                ]);
            } else {

                $view = $this->renderView('payment/_payment_addresses.html.twig', [
                    'addresses' => $addresses,
                    'form' => $form->createView(),
                    'step' => $step,
                    'client_secret' => $paymentHelper->paymentIntent()['client_secret'],
                ]);
            }

            return $this->json(['content' => $view]);
            die();
        }
        return $this->render('payment/payment.html.twig', array_merge($cartHelper->Summary(), [
            'addresses' => $addresses,
            'form' => $form->createView(),
            'step' => $step,
            'client_secret' => $clientSecret,

        ]));
    }
}

