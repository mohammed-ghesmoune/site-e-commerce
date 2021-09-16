<?php

namespace App\Controller;

use App\Entity\Size;
use App\Entity\User;
use App\Entity\Product;
use App\Form\RegisterType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {       
        return $this->render('home/index.html.twig', [
        ]);
    }
    /**
     * @Route("/se-connecter", name="se_connecter")
     */
    public function seConnecter()
    {   
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);    
        return $this->render('Security/se-connecter.html.twig', [
            'registerForm' => $form->createView(),
            'last_username' => '',
            'error'         => '',
            'register'      => false,
            'login'         => true
        ]);
    }

    public function nouveaute(): Response
    {
        $nouveautes = $this->getDoctrine()->getRepository(Product::class)->findBy(['nouveautes'=> 1 ],[],3);
        $response = $this->render('home/_nouveautes.html.twig', compact('nouveautes'));
        $response->setPublic();
        $response->setMaxAge(600);

        return $response;
    }

    public function promotion(): Response
    {
        $promotions = $this->getDoctrine()->getRepository(Size::class)->findSaleProduct();
        $response = $this->render('home/_promotion.html.twig', compact('promotions'));
        $response->setPublic();
        $response->setMaxAge(600);

        return $response;
    }
}
