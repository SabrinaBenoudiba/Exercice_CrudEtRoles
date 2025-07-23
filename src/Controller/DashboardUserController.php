<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/user')]
final class DashboardUserController extends AbstractController
{
    #[Route('/dashboardUser', name: 'app_dashboard_user')]
    #[IsGranted("ROLE_USER")]
    public function dashboardUser(): Response
    {
        return $this->render('dashboard_user/dashboardUser.html.twig', [
            'controller_name' => 'DashboardUserController',
        ]);
    }
}
