<?php

namespace App\Controller;

use App\Form\ChangePasswordFormType;
use App\Form\ResetPasswordRequestFormType;
use App\Repository\UserRepository;
use App\Services\EmailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException(
            'This method can be blank - it will be intercepted by the logout key on your firewall.'
        );
    }

    /**
     * @Route("/forgot-pass", name="forgotten_password")
     */
    public function forgottenPassword(
        Request $request,
        UserRepository $userRepository,
        TokenGeneratorInterface $tokenGenerator,
        EntityManagerInterface $entityManager,
        EmailService $emailService
    ): Response {
        $form = $this->createForm(ResetPasswordRequestFormType::class);

        $form->handleRequest($request);
        //dd($form);
        if ($form->isSubmitted() && $form->isValid()) {
            // On r??cup??re l'utilisateur par son email
            $user = $userRepository->findOneByEmail(
                $form->get('email')->getData()
            );
            // On v??rifie si on a un utilisateur avec cet email
            if ($user) {
                // On g??n??re un token de r??initialisation
                $token = $tokenGenerator->generateToken();
                $user->setResetToken($token);
                $entityManager->persist($user);
                $entityManager->flush();

                // On g??n??re un lien de r??initialisation de mot de passe
                $url = $this->generateUrl(
                    'reset_password',
                    ['token' => $token],
                    UrlGeneratorInterface::ABSOLUTE_URL
                );

                // On cr??e les donn??es du mail
                $context = compact('url', 'user');

                // On envoie l'email
                $emailService->send(
                    'no-reply@shopandco.com',
                    $user->getEmail(),
                    'R??initialisation de mot de passe',
                    'email',
                    $context
                );

                $this->addFlash('success', 'Email envoy?? avec succ??s');
                return $this->redirectToRoute('app_login');
            }
            // $user est null
            $this->addFlash(
                'success',
                'Si votre email est reconnu par notre syst??me, vous recevrez l\'email pour r??initialiser votre mot de passe'
            );
            return $this->redirectToRoute('app_login');
        }
        return $this->render('reset_password/request.html.twig', [
            'requestPassForm' => $form->createView(),
        ]);
    }

    /**
     * Validates and process the reset URL that the user clicked in their email.
     *
     * @Route("/reset/{token}", name="reset_password")
     */
    public function reset(
        string $token,
        Request $request,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        // On v??rifie si l'utilisateur a un token (bdd : user->reset_token)
        $user = $userRepository->findOneByResetToken($token);

        if ($user) {
            $resetForm = $this->createForm(ChangePasswordFormType::class);
            $resetForm->handleRequest($request);

            if ($resetForm->isSubmitted() && $resetForm->isValid()) {
                // On d??truit le token
                $user->setResetToken('');
                $user->setPassword(
                    $passwordHasher->hashPassword(
                        $user,
                        $resetForm->get('password')->getData()
                    )
                );
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash(
                    'success',
                    'Votre mot de passe a ??t?? r??initialis?? avec succ??s'
                );
                return $this->redirectToRoute('app_login');
            }

            return $this->render('reset_password/reset.html.twig', [
                'resetForm' => $resetForm->createView(),
            ]);
        }

        $this->addFlash('danger', 'Token invalid');
        return $this->redirectToRoute('app_login');
    }
}
