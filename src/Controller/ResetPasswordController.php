<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ResetPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ResetPasswordController extends AbstractController
{
    #[Route('/reset_password/{token}', name: 'app_reset_password')]
    public function reset(Request $request, EntityManagerInterface $entityManager, string $token): Response
    {
        $user = $entityManager->getRepository(User::class)->findOneBy(['token' => $token]);

        if (!$user) {
            throw $this->createNotFoundException('Mauvais token');
        }

        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if($user->getDateExpirationToken() > new \DateTime() ){

                $newPassword = $form->get('password')->getData();
                $user->setPassword(password_hash($newPassword, PASSWORD_BCRYPT));
                $user->setToken(null);
                $user->setDateExpirationToken(null);
                $entityManager->flush();

            }





            $this->addFlash('success', 'Votre mot de passe à bien été changé');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('reset_password/index.html.twig', [
            'form' => $form,
        ]);
    }
}
