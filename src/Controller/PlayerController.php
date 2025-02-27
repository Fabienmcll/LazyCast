<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlayerController extends AbstractController
{
    #[Route('/player/{type}/{id}', name: 'app_player')]
    public function index(string $type, int $id): Response
    {
        session_start();
        $base_url = $_SESSION['server_url'];
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
        return $this->render('player/index.html.twig', [
            'controller_name' => 'PlayerController',
            'type' => $type,
            'id' => $id,
            'password' => $password,
            'username' => $username,
            'base_url' => $base_url,
        ]);
    }
}
