<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Form\ResetPasswordRequestFormType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login", methods={"GET", "POST"})
     */
    public function login(AuthenticationUtils $authenticationUtils):Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $requestForm = $this->createForm(ResetPasswordRequestFormType::class);

        return $this->render('security/se-connecter.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
            'registerForm' => $form->createView(),
            'requestForm' => $requestForm->createView(),
            'register'      => false,
            'login'         => true,
            'showForgotPasswordModal' => false,

        ]);
    }

   
    /**
     * @Route("/logout", name="logout" , methods={"GET"})
     */
    public function logout()
    {
    }
}


 /**
     * @Route("/register", name="register" , methods={"GET","POST"})
     */
 /*   public function register(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();

        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();
            $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }
        return $this->render('security/register.html.twig', [
            'registerForm' => $form->createView()
        ]);
    }
    */