<?php

namespace App\Controller;

use App\Service\GlobalVariableService;
use PhpParser\Node\Stmt\Global_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $username = $request->request->get('username');
            $password = $request->request->get('password');
            $serverUrl = $request->request->get('server_url');

            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            $_SESSION['server_url'] = $serverUrl . '/player_api.php';

            return $this->redirectToRoute('app_series_categories');
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            "username" => 'not set',
        ]);
    }
}
