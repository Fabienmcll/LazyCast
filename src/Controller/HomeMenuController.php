<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeMenuController extends AbstractController
{
    #[Route('/home/menu', name: 'app_home_menu')]
    public function index(): Response
    {
        return $this->render('home_menu/index.html.twig', [
            'controller_name' => 'HomeMenuController',
        ]);
    }
}
