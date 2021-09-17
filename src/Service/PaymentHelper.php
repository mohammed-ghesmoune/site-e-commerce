<?php

namespace App\Service;

use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\UserRepository;
use App\Repository\OrderRepository;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;

class PaymentHelper
{

    private $stripe;
    private $session;
    private $request;
    private $user;
    private $entityManager;
    private $addressRepository;
    private $formFactory;
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository, RequestStack $requestStack, EntityManagerInterface $entityManager, FormFactoryInterface $formFactory, UserRepository $userRepository, AddressRepository $addressRepository, $stripeKey)
    {

        $this->stripe =  new \Stripe\StripeClient($stripeKey);
        $this->entityManager = $entityManager;
        $this->request = $requestStack->getCurrentRequest();
        $this->session = $this->request->getSession();
        $this->user = $userRepository->find($this->session->get('user')->getId());
        $this->addressRepository = $addressRepository;
        $this->formFactory = $formFactory;
        $this->orderRepository = $orderRepository;
    }

    public function handlePayment()
    {

        $step = $this->request->request->get('payment_step') ?? "billing";
        $clientSecret = null;

        //$addresses = $this->addressRepository->findByUser($this->user);


        $newAddress = new Address();
        $form = $this->formFactory->create(AddressType::class, $newAddress);

        if (null !== $this->request->request->get('choose_address')) {
            if (null !== $this->request->request->get('id_address')) {
                $address = $this->addressRepository->find($this->request->request->get('id_address'));
                if ($address) {
                    if ('billing' == $step) {
                        $this->setBillingAddress($address);
                        $step = 'shipping';
                        $this->session->set('billing_address', true);
                    } elseif ('shipping' == $step) {
                        $this->setShippingAddress($address);
                        $step = 'card';
                        $this->session->set('shipping_address', true);
                    }
                }
            } else {
                $this->session->getFlashBag()->add(
                    'danger',
                    ' Veuillez sélectioner une adresse '
                );
            }
        } elseif (null !== $this->request->request->get('new_address')) {
            $form->handleRequest($this->request);

            if ($form->isSubmitted() && $form->isValid()) {
                $newAddress->setUser($this->user);

                $this->entityManager->persist($newAddress);
                $this->entityManager->flush();

                if ('billing' === $step) {
                    $this->setBillingAddress($newAddress);
                    $step = 'shipping';
                    $this->session->set('billing_address', true);
                } elseif ('shipping' === $step) {
                    $this->setShippingAddress($newAddress);
                    $step = 'card';
                    $this->session->set('shipping_address', true);
                }
                $this->session->getFlashBag()->add(
                    'success',
                    'Votre nouvelle adresse a bien été enregistrée'
                );
            } else {
                $this->session->getFlashBag()->add(
                    'danger',
                    ' Veuillez vérifier vos coordonnées !'
                );
            }
        }

        return compact('form', 'step');
    }

    public function setBillingAddress($billingAddress)
    {

        $address = [
            'line1' => $billingAddress->getLine1(),
            'line2' => $billingAddress->getLine2(),
            'postal_code' => $billingAddress->getPostalcode(),
            'city' => $billingAddress->getCity(),
            'state' => $billingAddress->getState(),
            'country' => $billingAddress->getCountry(),
        ];
        if (!$this->user->getIdCustomer()) {
            $customer = $this->stripe->customers->create([
                'name' => $billingAddress->getFirstname() . " " . $billingAddress->getLastname(),
                'description' => "Client N° : {$this->user->getId()}",
                'metadata' => ["id_user" => $this->user->getId()],
                "preferred_locales" => ['fr', 'en'],
                'email' => $this->user->getEmail(),
                'phone' => $billingAddress->getPhone(),
                'address' => $address
            ]);

            $this->user->setIdCustomer($customer['id']);
            $this->entityManager->flush();
            //dd($this->user);
            $this->session->set('user', $this->user);
        } else {
            $customer = $this->stripe->customers->update(
                $this->user->getIdCustomer(),
                [
                    'name' => $billingAddress->getFirstname() . " " . $billingAddress->getLastname(),
                    'phone' => $billingAddress->getPhone(),
                    'address' => $address
                ]
            );
        }
    }

    public function setShippingAddress($shippingAddress)
    {
        $address = [
            'line1' => $shippingAddress->getLine1(),
            'line2' => $shippingAddress->getLine2(),
            'postal_code' => $shippingAddress->getPostalcode(),
            'city' => $shippingAddress->getCity(),
            'state' => $shippingAddress->getState(),
            'country' => $shippingAddress->getCountry(),
        ];

        $customer = $this->stripe->customers->update(
            $this->user->getIdCustomer(),
            [
                'shipping' => [
                    'name' => $shippingAddress->getFirstname() . " " . $shippingAddress->getLastname(),
                    'phone' => $shippingAddress->getPhone(),
                    'address' => $address
                ]
            ]
        );
    }

    public function paymentIntent()
    {
        $cart = $this->session->get('cart');
        $orders = $this->orderRepository->findOrderProducts($cart);

        foreach ($orders as $order) {
            $invoice_item = $this->stripe->invoiceItems->create([
                'customer' => $this->user->getIdCustomer(),
                'description' => $order->getSize()->getProduct()->getName(),
                'unit_amount' => $order->getSize()->getPrice() * 100,
                'currency' => 'eur',
                'quantity' => $order->getQuantity(),
                'tax_rates' => ['txr_1JaKhXAux3gYDg7UDQikb6xn'],
            ]);
        }
        $invoice = $this->stripe->invoices->create([
            'customer' => $this->user->getIdCustomer(),
        ]);
        $this->stripe->invoices->finalizeInvoice($invoice['id'], []);
        $invoice = $this->stripe->invoices->retrieve(
            $invoice['id'],
            []
        );
        $paymentIntentId = $invoice['payment_intent'];
        $paymentIntent = $this->stripe->paymentIntents->update(
            $paymentIntentId,
            [
                'receipt_email' => 'med.ghesmoune@gmail.com',
                'setup_future_usage' => 'off_session',
            ]
        );
        $this->session->set('invoice', $invoice['id']);
        return $paymentIntent;
    }
}
