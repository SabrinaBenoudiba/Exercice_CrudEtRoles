<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserHomePageController extends AbstractController
{
    #[Route('/userHomePage', name: 'app_userHomePage')]
    public function userHomePage(): Response
    {
        return $this->render('user_home_page/userHomePage.html.twig', [
            'controller_name' => 'UserHomePageController',
        ]);
    }
}
