<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\CartRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\PasswordUpgradeBadge;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\HttpFoundation\Session\Session;




class UserAuthenticator extends AbstractAuthenticator
{
    private $userRepository;
    private $cartRepository;
    private $urlGenerator;
    private $user;
    private $session;



    public function __construct(UserRepository $userRepository, CartRepository $cartRepository, EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator)
    {
        $this->userRepository = $userRepository;
        $this->cartRepository = $cartRepository;
        $this->urlGenerator = $urlGenerator;
        $this->em = $em;
        $this->session = new Session;
    }

    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning `false` will cause this authenticator
     * to be skipped.
     */
    public function supports(Request $request): ?bool
    {
        return $request->attributes->get("_route") === "login" && $request->isMethod("POST");
    }

    public function authenticate(Request $request): PassportInterface
    {

        $this->user = $this->userRepository->findOneBy(['email' => $request->get('_username')]);

        if (null === $this->user) {
            throw new UsernameNotFoundException();
        }

        return new Passport($this->user, new PasswordCredentials($request->get('_password')), [
            // and CSRF protection using a "csrf_token" field
            new CsrfTokenBadge('login_form', $request->get('csrf_token')),

            // and add support for upgrading the password hash
            //new PasswordUpgradeBadge($request->get('_password'), $this->userRepository),
            new RememberMeBadge()

        ]);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $this->session->set('user', $this->user);
        $this->session->getFlashBag()->add('success', 'Vous avez été connecté avec succes');

        if ($this->session->get('cart')) {
            $cart = $this->cartRepository->find($this->session->get('cart')->getId())
                ->setUser($this->user)
                ->setTimestamp(null);
            $this->em->persist($cart);
            $this->em->flush();
            $this->session->set('cart',$cart);
        }
        return new RedirectResponse($this->urlGenerator->generate("home"));
        // on success, let the request continue
       // return null;

    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $this->session->getFlashBag()->add('danger', 'Identifiants incorrects');
        
        return new RedirectResponse($this->urlGenerator->generate("login"));
    }
}
