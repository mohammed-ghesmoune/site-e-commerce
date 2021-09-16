<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Address;
use App\Entity\Invoice;
use App\Form\PersoType;
use App\Form\AddressType;
use App\Form\ChangeEmailType;
use App\Service\ProfileHelper;
use App\Form\ChangePasswordType;
use App\Entity\Profile\ChangeEmail;
use App\Form\ContactInformationsType;
use Symfony\Component\Form\FormError;
use App\Entity\Profile\ChangePassword;
use App\Form\PersonalInformationsType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Profile\ContactInformations;
use App\Entity\Profile\PersonalInformations;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * @IsGranted("ROLE_USER")
 */

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     * 
     */
    public function profile(ProfileHelper $pofileHelper, ValidatorInterface $validator, Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder)
    {
        $personalInformationsForm = $pofileHelper->getPersonalInformationsForm();
        $contactInformationsForm = $pofileHelper->getContactInformationsForm();
        $changeEmailForm = $pofileHelper->getChangeEmailForm();
        extract($pofileHelper->getChangePasswordForm());
        extract($pofileHelper->getAdresses());
        $invoices =  $this->getDoctrine()->getManager()->getRepository(Invoice::class)->findBy(['user' => $this->getUser()],['createdAt'=>'DESC']);

        if ($request->isXmlHttpRequest()) {
            if ($request->request->get('change_personal_informations')) {
                $view = $this->renderView('profile/_personal_informations.html.twig', [
                    'personalInformationsForm' => $personalInformationsForm->createView(),
                ]);
            }
            if ($request->request->get('change_contact_informations')) {
               // dd('ok');
                $view = $this->renderView('profile/_contact_informations.html.twig', [
                    'contactInformationsForm' => $contactInformationsForm->createView(),
                ]);
            }
            if ($request->request->get('update_email')) {
                $view = $this->renderView('profile/_change_email.html.twig', [
                    'changeEmailForm' => $changeEmailForm->createView(),
                ]);
            }

            if ($request->request->get('update_password')) {
                $view = $this->renderView('profile/_change_password.html.twig', [
                    'changePasswordForm' => $changePasswordForm->createView(),
                ]);
            }

            if ($request->request->get('update_address') || $request->request->get('delete_address')) {
                $view = $this->renderView('profile/_address.html.twig', [
                    'addresses' => $addresses,
                    'addressesForms' => $addressesForms,
                ]);
            }

            return $this->json(['content' => $view]);
            die();
        }


        return $this->render('profile/profile.html.twig', [
            'personalInformationsForm' => $personalInformationsForm->createView(),
            'contactInformationsForm' => $contactInformationsForm->createView(),
            'changeEmailForm' => $changeEmailForm->createView(),
            'changePasswordForm' => $changePasswordForm->createView(),
            'addresses' => $addresses,
            'addressesForms' => $addressesForms,
            'invoices' => $invoices
        ]);
    }
}

