<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/users', name: 'app_user',methods: ['GET'])]
    public function index(UserRepository $u_repository): Response
    {
        $users= $u_repository->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }


    #[Route('/add_users', name: 'app_add_user')]
    public function add_user(Request $request,ManagerRegistry $doctrine): Response
    {
        $user=new User();
        $form = $this->createForm(UserType::class,$user);

        $form->handleRequest($request);
        $em = $doctrine->getManager();

        if ($form->isSubmitted() && $form->isValid()) {
            
            $user = $form->getData();
            $em ->persist($user);
            $em -> flush();

            return $this->redirectToRoute('app_user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/add_user.html.twig', [
            'form' => $form,
        ]);

    }

    #[Route('/{id}/profile_user', name: 'app_profile_user')]
    public function profile_user(User $user): Response
    {
        $birthdate = $user->getBirthDate();
        $currentDate = new \DateTime();
        $age = $currentDate->diff($birthdate)->y;

        return $this->render('user/profile_user.html.twig', [
            'user'=>$user,
            'age'=>$age,
            
        ]);

    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['GET'])]
    public function delete(EntityManagerInterface $manager, User $user): Response
    {
        $manager->remove($user);
        $manager ->flush();

        return $this-> redirectToRoute('app_user', [], Response::HTTP_SEE_OTHER);
    }
}
