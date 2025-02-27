<?php

namespace App\Controller;

use App\Service\XtreamApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowSerieDetailsController extends AbstractController
{
    private XtreamApiService $vodApiService;

    public function __construct(XtreamApiService $vodApiService)
    {
        $this->vodApiService = $vodApiService;
    }

    private function getSerieDetails()
    {
        $serieDetail = $this->vodApiService->getSerieDetails();
        return $this->json($serieDetail);
    }

    #[Route('/serie/{idSerie}/{seasonNumber}', name: 'app_show_season_episodes')]
    public function indexSeason($idSerie, $seasonNumber): Response
    {
        session_start();
        $this->vodApiService->setApiUrl($_SESSION['server_url']);
        $this->vodApiService->setUsername($_SESSION['username']);
        $this->vodApiService->setPassword($_SESSION['password']);
        $this->vodApiService->setAction('get_series_info');
        $this->vodApiService->setSerieId($idSerie);
        $serieDetails = $this->getSerieDetails();
        $toSend = $serieDetails->getContent();
        $toSend = json_decode($toSend, true);

        $episodes = $this->vodApiService->getEpisodesBySeason($toSend, $seasonNumber);

        return $this->render('show_serie_details/index.html.twig', [
            'controller_name' => 'ShowSerieDetailsController',
            'episodes' => $episodes,
            'serieDetails' => $toSend,
        ]);
    }
}