<?php

namespace App\Controller;

use App\Service\XtreamApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowSeriesCategoryController extends AbstractController
{
    private XtreamApiService $vodApiService;

    public function __construct(XtreamApiService $vodApiService)
    {
        $this->vodApiService = $vodApiService;
    }

    #[Route('/series/category/{category_id}', name: 'app_show_series_category')]
    
    public function index(int $category_id): Response
    {
        session_start();
        $this->vodApiService->setUsername($_SESSION['username']);
        $this->vodApiService->setPassword($_SESSION['password']);
        $this->vodApiService->setApiUrl($_SESSION['server_url']);
        $this->vodApiService->setAction('get_series');
        $series = $this->getSeriesByCategory($category_id);

        $toSend = $series->getContent();
        $toSend = json_decode($toSend, true);

        return $this->render('show_series_category/index.html.twig', [
            'controller_name' => 'ShowSeriesCategoryController',
            'series' => $toSend,
        ]);
    }

    public function getSeriesByCategory(int $category_id): JsonResponse
    {

        if($category_id == 1){
            $this->vodApiService->setAction('get_series');
            $series = $this->vodApiService->getAllSeries();
            return $this->json($series);
        } else {
            $series = $this->vodApiService->getWithCategoryId($category_id);
            return $this->json($series);
        }

        
    }
}
