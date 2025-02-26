<?php

namespace App\Controller;

use App\Service\GlobalVariableService;
use App\Service\XtreamApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SeriesCategoriesController extends AbstractController
{
    private XtreamApiService $vodApiService;

    public function __construct(XtreamApiService $vodApiService)
    {
        $this->vodApiService = $vodApiService;
    }

    #[Route('/series/categories', name: 'app_series_categories')]
    public function index(): Response
    {
        $json = $this->fetchVodStreams();
        dump($json);
        $toSend = $json->getContent();
        $toSend = json_decode($toSend, true);

        return $this->render('series_categories/index.html.twig', [
            'controller_name' => 'SeriesCategoriesController',
            'series_categories' => $toSend, 
        ]);
    }

    public function fetchVodStreams(): JsonResponse
    {
        try {
            session_start();
            $serverUrl = $_SESSION['server_url'];
            $username = $_SESSION['username'];
            $password = $_SESSION['password'];
            $this->vodApiService->setAction('get_vod_categories');
            $this->vodApiService->setApiUrl($serverUrl);
            $this->vodApiService->setUsername($username);
            $this->vodApiService->setPassword($password);
            $data = $this->vodApiService->getVodStreams();

            return $this->json($data);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }
}
