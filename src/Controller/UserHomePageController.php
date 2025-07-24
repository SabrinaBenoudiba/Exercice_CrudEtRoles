<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserUpdateType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class UserHomePageController extends AbstractController
{
    #[Route('/userHomePage', name: 'app_userHomePage')]
    #[IsGranted("ROLE_USER")]
    public function userHomePage(UserRepository $userRepo): Response
    {
        
        $datas = $userRepo->findAll();
        return $this->render('user_home_page/userHomePage.html.twig', [
            'controller_name' => 'userHomePageController',
            'datas' => $datas,
        ]);
    }

    #[Route('/userHomePage/{id}', name: 'app_update')]
    #[IsGranted("ROLE_USER")] 
    public function update_form($id, Request $request, EntityManagerInterface $entityManager, UserRepository $userRepo): Response 
    {
        $crud = $entityManager->getRepository(User::class)->find($id);
        $form = $this->createForm(UserUpdateType::class, $crud); 
        $form->handleRequest($request); 
        if ( $form->isSubmitted() && $form->isValid()){ 
            $entityManager->persist($crud); 
            $entityManager->flush(); 

            $this->addFlash('notice', 'Modification réussi !!');

            return $this->redirectToRoute('app_home_page'); 
        }

        $datas = $userRepo->findAll();

         return $this->render('user_home_page/updateUserForm.html.twig', [
            'form' => $form->createView(),
            'datas' => $datas,

        ]);
    }

    #[Route('/delete/{id}', name: 'app_delete')]
    #[IsGranted("ROLE_USER")]
    public function delete($id, EntityManagerInterface $entityManager): Response 
    {
        $del = $entityManager->getRepository(User::class)->find($id);
        
            $entityManager->remove($del); 
            $entityManager->flush();

            $this->addFlash('notice', 'Suppression réussi !!');

            return $this->redirectToRoute('app_home_page'); 
      
    }
       
}