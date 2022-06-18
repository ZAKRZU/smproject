<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
        $error = $authenticationUtils->getLastAuthenticationError();
        $user = new User();
        
        $form = $this->createFormBuilder($user)
            ->add('email', TextType::class, [
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

        // $form->handleRequest($request);
        // if ($form->isSubmitted() && $form->isValid()) {

        // }

        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
            'form' => $form->createView(),
            'error' => $error,
        ]);
    }
}
