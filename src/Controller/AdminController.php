<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Entity\User;
use App\Form\UserType;

#[Route('/admin')]
class AdminController extends AbstractController
{

    private function getMenuList()
    {
        $menu_list = [['User', $this->generateUrl('app_admin_user')], ['Settings', 'user']];
        return $menu_list;
    }

    #[Route('/', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'menu' => $this->getMenuList(),
        ]);
    }

    #[Route('/user', name: 'app_admin_user')]
    public function adminUser(UserRepository $userRepository): Response
    {
        return $this->render('admin/user/list.html.twig', [
            'controller_name' => 'AdminController',
            'menu' => $this->getMenuList(),
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/user/new', name: 'app_admin_user_new')]
    public function adminUserNew(): Response
    {

        $user = new User();

        $form = $this->createForm(UserType::class, $user, [
            'action' => $this->generateURL('app_user_new'),
        ]);

        return $this->renderForm('admin/user/new.html.twig', [
            'controller_name' => 'AdminController',
            'menu' => $this->getMenuList(),
            'form' => $form,
        ]);
    }

    #[Route('/user/edit/{id}', name: 'app_admin_user_edit')]
    public function adminUserEdit(User $user, int $id): Response
    {
        $form = $this->createForm(UserType::class, $user, [
            'action' => $this->generateURL('app_user_edit', ['id' => $id]),
        ]);

        return $this->renderForm('admin/user/edit.html.twig', [
            'controller_name' => 'AdminController',
            'menu' => $this->getMenuList(),
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/user/show/{id}', name: 'app_admin_user_show')]
    public function adminUserShow(UserRepository $userRepositor, int $id): Response
    {
        $user = $userRepositor->find($id);

        return $this->render('admin/user/show.html.twig', [
            'controller_name' => 'AdminController',
            'menu' => $this->getMenuList(),
            'user' => $user,
        ]);
    }
}
