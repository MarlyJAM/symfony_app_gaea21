<?php

namespace App\Controller\API;

use App\DTO\PaginationDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class UserApiController extends AbstractController
{
    #[Route('/api/list_users',name:'app_list_users',methods: ['GET'])]
    public function list_users(
        UserRepository $userRepository ,
        #[MapQueryString()]
        ?PaginationDTO $paginationDTO = null
        ) 
    {

        $users= $userRepository->paginateUser($paginationDTO?->page);

        return $this->json($users , 200 ,[],[
           'groups' =>['users.index']
        ]);
    }

    #[Route('/api/show_user/{id}',name:'app_show_user',methods: ['GET'],requirements:['id' => Requirement::DIGITS])]
    public function show_user(User $user) {
        
        return $this->json($user , 200 ,[],[
           'groups' =>['users.index','user.show']
        ]);
    }

    #[Route('/api/create_users',name:'app_create_users',methods: ['POST'])]
    public function create_user(
        Request $request,
        #[MapRequestPayload(
            serializationContext:[
                'groups' =>['user.create']
            ]
        )]

        User $user,
        EntityManagerInterface $em
    )
    {
        $em->persist($user);
        $em->flush();
        return $this->json($user , 200 ,[],[
            'groups' =>['users.index','user.show']
         ]);
    }

    #[Route('/api/delete_user/{id}',name:'app_delete_user',methods: ['DELETE'],requirements:['id' => Requirement::DIGITS])]
    public function delete_user(User $user,EntityManagerInterface $em) {
        
       $em->remove($user);
       $em->flush();

       return "Utilisateur supprimé";
    }

}