<?php

namespace App\Controller;

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
        // Appel de la fonction avec l'instance de service
        $json = $this->fetchVodStreams();
        dump($json);

        return $this->render('series_categories/index.html.twig', [
            'controller_name' => 'SeriesCategoriesController',
            'series_categories' => $json->getContent(), // Envoyer les données au template
        ]);
    }

    public function fetchVodStreams(): JsonResponse
    {
        try {
            $this->vodApiService->setAction('get_vod_categories');
            $this->vodApiService->setApiUrl('http://365hub.cc:2103/player_api.php');
            $this->vodApiService->setUsername('aFAChxw1');
            $this->vodApiService->setPassword('crjkQz2');
            $data = $this->vodApiService->getVodStreams();

            return $this->json($data);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }
}
