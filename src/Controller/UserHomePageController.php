<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class UserHomePageController extends AbstractController
{
    #[Route('/userHomePage', name: 'app_userHomePage')]
    public function userHomePage(UserRepository $userRepo): Response
    {
        $datas = $userRepo->findall();
        return $this->render('user_home_page/userHomePage.html.twig', [
            'controller_name' => 'UserHomePageController',
            'datas' => $datas,
        ]);
    }

    #[Route('/userHomePage/{id}', name: 'update')] # création d'un formulaire 
    public function update_form($id, Request $request, EntityManagerInterface $entityManager): Response 
    {
        $crud = $entityManager->getRepository(User::class)->find($id);
        $form = $this->createForm(RegistrationFormType::class, $crud); 
        $form->handleRequest($request); 
        if ( $form->isSubmitted() && $form->isValid()){ 
            $entityManager->persist($crud); 
            $entityManager->flush(); 

            $this->addFlash('notice', 'Modification réussi !!');

            return $this->redirectToRoute('app_home_page'); 
        }

         return $this->render('user_home_page/userHomePage.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete($id, EntityManagerInterface $entityManager): Response 
    {
        $del = $entityManager->getRepository(User::class)->find($id);
        
            $entityManager->remove($del); 
            $entityManager->flush();

            $this->addFlash('notice', 'Suppression réussi !!');

            return $this->redirectToRoute('app_home_page'); 
      
    }


    // #[Route('/create', name: 'app_create_form')]   
    // public function create_form(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $user = new User(); 
    //     $form = $this->createForm(UserType::class, $user); 
    //     if ( $form->isSubmitted() && $form->isValid()){
        
    //         $entityManager->persist($crud); 
    //         $entityManager->flush(); 

    //         $this->addFlash('notice', 'Soumission réussi !!');

    //         return $this->redirectToRoute('app_home_page');

    //     }
    //     return $this->render('form/createForm.html.twig', [
    //         'form' => $form->createView() 
    //     ]);

    // }
       
}