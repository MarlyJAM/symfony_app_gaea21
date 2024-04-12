<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/users', name: 'app_user')]
    public function index(UserRepository $u_repository): Response
    {
        $users= $u_repository->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }
}
