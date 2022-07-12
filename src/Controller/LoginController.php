<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        // If authenticated redirect to dashboard
        if ($this->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            return $this->redirectToRoute('app_dashboard');
        }

        // If authentication failed get error
        $error = $authenticationUtils->getLastAuthenticationError();

        // Create base for user
        $user = new User();
        
        // Create login form
        $form = $this->createFormBuilder($user)
            ->add('email', EmailType::class, [
                'attr' => [
                    'name' => '_username'
                ]
                ])
            ->add('password', PasswordType::class, [
                'attr' => [
                    'name' => '_password'
                ]
                ])
            ->add('login', SubmitType::class)
            ->getForm();

        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
            'form' => $form->createView(),
            'error' => $error,
        ]);
    }
}
