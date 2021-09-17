<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Form\ResetPasswordRequestFormType;
use App\Security\EmailVerifier;
use App\Security\LoginAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginAuthenticator $authenticator, $emailSender)
    {
        $requestForm = $this->createForm(ResetPasswordRequestFormType::class);

        $user = new User();
        $user->setPassword('abcd1234');
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )

            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address($emailSender, 'Boutique En Ligne'))
                    ->to($user->getEmail())
                    ->subject('Veuillez confirmer votre email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );

            // do anything else you need here, like send an email

            $this->addFlash('success', "Vérifiez votre adresse email <span class='font-weight-bold'> {$user->getEmail()} </span> - Vous allez recevoir un email de validation.");

            /* return $guardHandler->authenticateUserAndHandleSuccess(
            $user,
            $request,
            $authenticator,
            'main' // firewall name in security.yaml
            );
             */

            return $this->render('security/se-connecter.html.twig', [
                'registerForm' => $form->createView(),
                'requestForm' => $requestForm->createView(),
                'last_username' => '',
                'error' => '',
                'register' => false,
                'login' => true,
                'showForgotPasswordModal' => false,
            ]);
        }

        return $this->render('security/se-connecter.html.twig', [
            'registerForm' => $form->createView(),
            'requestForm' => $requestForm->createView(),
            'last_username' => '',
            'error' => '',
            'register' => true,
            'login' => false,
            'showForgotPasswordModal' => false,
        ]);
    }

    /**
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());

        } catch (VerifyEmailExceptionInterface $exception) {

            if (get_class($exception) === "SymfonyCasts\Bundle\VerifyEmail\Exception\ExpiredSignatureException") {

                if (!$this->getUser()->isVerified()) {

                    $em->remove($this->getUser());
                    $em->flush();
                    $this->get('security.token_storage')->setToken(null);
                    $request->getSession()->invalidate(0);
                    $this->addFlash('danger', 'Le lien pour valider l\'adresse e-mail associée à votre compte a expiré. Veuillez vous réinscrire.');
                    return $this->redirectToRoute('register');
                } else {
                    $this->addFlash('success', 'L\'adresse e-mail associée à votre compte a déja été validée.');
                    return $this->redirectToRoute('home');
                }
            }
            $this->get('security.token_storage')->setToken(null);
            $request->getSession()->invalidate(0);
            $this->addFlash('danger', $exception->getReason());

            return $this->redirectToRoute('login');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Félicitations! votre adresse e-mail a été validée.');

        return $this->redirectToRoute('home');
    }
}
