<?php

namespace App\Service;

use App\Entity\Address;
use App\Form\AddressType;
use App\Form\ChangeEmailType;
use App\Form\ChangePasswordType;
use App\Repository\UserRepository;
use App\Entity\Profile\ChangeEmail;
use App\Form\ContactInformationsType;
use Symfony\Component\Form\FormError;
use App\Entity\Profile\ChangePassword;
use App\Form\PersonalInformationsType;
use Symfony\Component\Form\FormFactory;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Profile\ContactInformations;
use App\Entity\Profile\PersonalInformations;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfileHelper
{
    private $user;
    private $request;
    private $session;
    private $formFactory;
    private $entityManager;
    private $passwordEncoder;
    public function __construct(RequestStack $requestStack, UserRepository $userRepository, FormFactoryInterface $formFactory, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->session = $this->request->getSession();
        $userId =  $this->session->get('user')->getId();
        $this->user = $userRepository->find($userId);
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->passwordEncoder=$passwordEncoder;
    }

    public function getPersonalInformationsForm()
    {
        $personalInformations = (new PersonalInformations())
            ->setCivility($this->user->getCivility())
            ->setFirstname($this->user->getFirstname())
            ->setLastname($this->user->getLastname())
            ->setBirthday($this->user->getBirthday())
            ->setProfession($this->user->getProfession());

        $personalInformationsForm = $this->formFactory->create(PersonalInformationsType::class, $personalInformations);

        if (null !== $this->request->request->get('change_personal_informations')) {
            $personalInformationsForm->handleRequest($this->request);
            if ($personalInformationsForm->isSubmitted() && $personalInformationsForm->isValid()) {
                $this->user->setCivility($personalInformations->getCivility())
                    ->setFirstname($personalInformations->getFirstname())
                    ->setLastname($personalInformations->getLastname())
                    ->setBirthday($personalInformations->getBirthday())
                    ->setProfession($personalInformations->getProfession());
                $this->entityManager->persist($this->user);
                $this->entityManager->flush();

                $this->session->getFlashBag()->add(
                    'success',
                    ' Vos informations personnelles ont bien été modifiées'
                );
            }
        }

        return $personalInformationsForm;
    }

    public function getContactInformationsForm()
    {

        $ContactInformations = (new ContactInformations())
            ->setLine1($this->user->getLine1())
            ->setLine2($this->user->getLine2())
            ->setPostalcode($this->user->getPostalcode())
            ->setCity($this->user->getCity())
            ->setState($this->user->getState())
            ->setCountry($this->user->getCountry())
            ->setPhone($this->user->getPhone());

        $contactInformationsForm = $this->formFactory->create(ContactInformationsType::class, $ContactInformations);

        if (null !== $this->request->request->get('change_contact_informations')) {
            $contactInformationsForm->handleRequest($this->request);
            if ($contactInformationsForm->isSubmitted() && $contactInformationsForm->isValid()) {
                $this->user->setLine1($ContactInformations->getLine1())
                    ->setLine2($ContactInformations->getLine2())
                    ->setPostalcode($ContactInformations->getPostalcode())
                    ->setCity($ContactInformations->getCity())
                    ->setState($ContactInformations->getState())
                    ->setCountry($ContactInformations->getCountry())
                    ->setPhone($ContactInformations->getPhone());
                $this->entityManager->persist($this->user);
                $this->entityManager->flush();

                $this->session->getFlashBag()->add(
                    'success',
                    ' Vos coordonnées ont bien été modifiées'
                );
            }
        }
        return $contactInformationsForm;
    }

    public function getChangeEmailForm(){
        
        $changeEmail = (new ChangeEmail());
        $changeEmailForm = $this->formFactory->create(ChangeEmailType::class, $changeEmail);

        if (null !== $this->request->request->get('update_email')) {
            $changeEmailForm->handleRequest($this->request);
            if ($changeEmailForm->isSubmitted() && $changeEmailForm->isValid()) {
                $this->user->setEmail($changeEmail->getEmail());
                $this->entityManager->persist($this->user);
                $this->entityManager->flush();
                $this->session->getFlashBag()->add(
                    'success',
                    ' Votre email a bien été modifié'
                );
            }
        }
        return $changeEmailForm;
    }

    public function getChangePasswordForm(){
        $logout= false;
        $changePassword = new ChangePassword();
        $changePasswordForm = $this->formFactory->create(ChangePasswordType::class, $changePassword);
        if (null !== $this->request->request->get('update_password')) {
            $changePasswordForm->handleRequest($this->request);
            if ($changePasswordForm->isSubmitted() && $changePasswordForm->isValid()) {
                $checkPassword = $this->passwordEncoder->isPasswordValid($this->user, $changePassword->getOldPassword());
                if ($checkPassword === true) {
                    $newPassword = $this->passwordEncoder->encodePassword($this->user, $changePassword->getPassword());
                    $this->user->setPassword($newPassword);
                    $this->entityManager->persist($this->user);
                    $this->entityManager->flush();

                    $this->session->getFlashBag()->add(
                        'success',
                        ' Votre mot de passe a bien été modifié'
                    );

                    $logout=true;
                } else {
                    $changePasswordForm->get('oldPassword')->addError(new FormError("Mot de passe incorrect"));
                }
            }
        }
        return compact('changePasswordForm','logout');
    }

    public function getAdresses(){

        $addresses = $addressesForms = [];
        $addresses = $this->entityManager->getRepository(Address::class)->findBy(['user' => $this->user]);
        foreach ($addresses as $k => $address) {
            ++$k;
            ${'addressForm' . $k} = $this->formFactory->createNamed('address' . $k, AddressType::class, $address);
            if (null !== $this->request->request->get('update_address') && $k == $this->request->request->get('update_address')) {
                ${'addressForm' . $k}->handleRequest($this->request);

                if (${'addressForm' . $k}->isSubmitted() && ${'addressForm' . $k}->isValid()) {
                    $this->entityManager->persist($address);
                    $this->entityManager->flush();

                    $this->session->getFlashBag()->add(
                        'success',
                        " Votre  <strong>\" Adresse $k \" </strong> a bien été modifiée"
                    );
                }
            }
            if (null !== $this->request->request->get('delete_address') &&  $k == $this->request->request->get('delete_address')) {

                $this->entityManager->remove($address);
                $this->entityManager->flush();

                $this->session->getFlashBag()->add(
                    'success',
                    " Votre  <strong>\" Adresse $k \" </strong> a bien été supprimée"
                );
                continue;
            }

            $addressesForms['addressForm' . $k] = ${'addressForm' . $k}->createView();
        }
        return compact('addresses','addressesForms');
    }

   
}
