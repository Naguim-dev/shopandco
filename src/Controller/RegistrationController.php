<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\UserAuthenticator;
use App\Services\EmailService;
use App\Services\JwtService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        UserAuthenticatorInterface $userAuthenticator,
        UserAuthenticator $authenticator,
        EntityManagerInterface $entityManager,
        EmailService $emailService,
        JwtService $jwt
    ): Response {
        $user = new User();
        $registerForm = $this->createForm(RegistrationFormType::class, $user);
        $registerForm->handleRequest($request);

        if ($registerForm->isSubmitted() && $registerForm->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $registerForm->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            // On génère le JWT de l'utilisateur
            // On crée le Header
            $header = [
                'typ' => 'JWT',
                'alg' => 'HS256',
            ];

            // On crée le Payload
            $payload = [
                'user_id' => $user->getId(),
            ];

            // On génère le token
            $token = $jwt->generate(
                $header,
                $payload,
                $this->getParameter('app.jwtsecret')
            );

            // On envoie un email
            $emailService->send(
                'no-reply@shopandco.com',
                $user->getEmail(),
                'Activation de votre compte ShopandCo',
                'account_activate',
                [
                    'user' => $user,
                    'token' => $token,
                ]
            );
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registerForm' => $registerForm->createView(),
        ]);
    }

    /**
     * @Route("/verif/{token}", name="verify_user")
     */
    public function verifyUser(
        $token,
        JwtService $jwt,
        UserRepository $userRepository,
        EntityManagerInterface $em
    ): Response {
        //On vérifie si le token est valide, n'a pas expiré et n'a pas été modifié
        if (
            $jwt->isValid($token) &&
            !$jwt->isExpired($token) &&
            $jwt->check($token, $this->getParameter('app.jwtsecret'))
        ) {
            // On récupère le payload
            $payload = $jwt->getPayload($token);

            // On récupère le user du token
            $user = $userRepository->find($payload['user_id']);

            //On vérifie que l'utilisateur existe et n'a pas encore activé son compte
            if ($user && !$user->getIsVerified()) {
                $user->setIsVerified(true);
                $em->flush($user);
                $this->addFlash(
                    'success',
                    'Merci d\'avoir activé votre compte.'
                );
                return $this->redirectToRoute('home');
            }
        }
        // Ici un problème se pose dans le token
        $this->addFlash('danger', 'Le token est invalide ou a expiré');
        return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/resendverif", name="resend_verif")
     */
    public function resendVerif(
        JwtService $jwt,
        EmailService $emailService,
        UserRepository $userRepository
    ): Response {
        $user = $this->getUser();

        if (!$user) {
            $this->addFlash(
                'danger',
                'Vous devez être connecté pour accéder à cette page'
            );
            return $this->redirectToRoute('app_login');
        }

        if ($user->getIsVerified()) {
            $this->addFlash('warning', 'Cet utilisateur est déjà activé');
            return $this->redirectToRoute('profile_index');
        }

        // On génère le JWT de l'utilisateur
        // On crée le Header
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256',
        ];

        // On crée le Payload
        $payload = [
            'user_id' => $user->getId(),
        ];

        // On génère le token
        $token = $jwt->generate(
            $header,
            $payload,
            $this->getParameter('app.jwtsecret')
        );

        // On envoie un mail
        $emailService->send(
            'no-reply@shopandco.com',
            $user->getEmail(),
            'Activation de votre compte sur le site ShopandCo',
            'account_activate',
            compact('user', 'token')
        );
        $this->addFlash('success', 'Email de vérification envoyé');
        return $this->redirectToRoute('home');
    }
}
