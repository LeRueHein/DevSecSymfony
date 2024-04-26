<?php

namespace App\Controller;

use App\Entity\User;
use App\Fonction\Fonction;
use App\Form\MessageType;
use App\Form\VerifPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use function App\Fonction\generateToken;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();


        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/forgot', name: 'app_forgot')]
    public function forgot(Request $request, EntityManagerInterface $entityManager, RouterInterface $router): Response
    {
        $form = $this->createForm(VerifPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

            if ($user) {
                $a = new Fonction();
                $token = $a->generateToken(20);
                $user->setToken($token);
                $user->setdateExpirationToken(new \DateTime('+1 hour'));
                $entityManager->flush();

                // Redirection avec le token dans l'URL
                $resetUrl = $this->generateUrl('app_reset_password', ['token' => $token], RouterInterface::ABSOLUTE_URL);
                return $this->redirect($resetUrl);
            }

            $this->addFlash('error', 'Aucun utilisateur trouvé pour cette email');
        }

        return $this->render('security/forgot.html.twig', [
            'form' => $form
        ]);
    }


    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('');
    }
}

