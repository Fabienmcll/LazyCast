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

    #[Route('/serie/{idSerie}', name: 'app_show_serie_details')]
    public function index(int $idSerie): Response
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

        dump($toSend);

        return $this->render('show_serie_details/index.html.twig', [
            'controller_name' => 'ShowSerieDetailsController',
            'serieDetails' => $toSend,
        ]);
    }
    private function getSerieDetails()
    {
        $serieDetail = $this->vodApiService->getSerieDetails();
        return $this->json($serieDetail);
    }
}