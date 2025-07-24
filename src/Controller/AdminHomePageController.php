<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AdminUpdateType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// #[Route('/admin')]
final class AdminHomePageController extends AbstractController
{
    #[Route('/adminHomePage', name: 'app_adminHomePage')]
    #[IsGranted("ROLE_ADMIN")]
    public function HomePage(UserRepository $userRepo): Response
    {
        
        $datas = $userRepo->findall();
        return $this->render('admin_home_page/adminHomePage.html.twig', [
            'controller_name' => 'adminHomePageController',
            'datas' => $datas,
        ]);
    }

    #[Route('/adminHomePage/{id}', name: 'app_update_admin')]
    #[IsGranted("ROLE_ADMIN")]
    public function update_form($id, Request $request, EntityManagerInterface $entityManager,UserRepository $userRepo ): Response 
    {
        $crud = $entityManager->getRepository(User::class)->find($id);
        $form = $this->createForm(AdminUpdateType::class, $crud); 
        $form->handleRequest($request); 
        if ( $form->isSubmitted() && $form->isValid()){ 
            $entityManager->persist($crud); 
            $entityManager->flush(); 

            $this->addFlash('notice', 'Modification réussi !!');

            return $this->redirectToRoute('app_adminHomePage'); 
        }
         $datas = $userRepo->findall();

         return $this->render('admin_home_page/updateAdminForm.html.twig', [
            'form' => $form->createView(),
            'datas' => $datas,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_delete_admin')]
    #[IsGranted("ROLE_ADMIN")]
    public function delete($id, EntityManagerInterface $entityManager): Response 
    {
        $del = $entityManager->getRepository(User::class)->find($id);
        
            $entityManager->remove($del); 
            $entityManager->flush();

            $this->addFlash('notice', 'Suppression réussi !!');

            return $this->redirectToRoute('app_home_page'); 
      
    }
}
