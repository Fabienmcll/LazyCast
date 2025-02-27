<?php

namespace App\Controller;

use App\Service\XtreamApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

        $this->vodApiService->setAction('get_series_categories');
        $this->vodApiService->setApiUrl($_SESSION['server_url']);
        $this->vodApiService->setUsername($_SESSION['username']);
        $this->vodApiService->setPassword($_SESSION['password']);
        $categories = $this->vodApiService->getVodStreams();

        $category_name = "Toutes les séries";
        foreach ($categories as $category) {
            if ($category['category_id'] == $category_id) {
                $category_name = $category['category_name'];
                break;
            }
        }

        $toSend = $this->json($series);

        $toSend = $toSend->getContent();
        $toSend = json_decode($toSend, true);

        return $this->render('show_series_category/index.html.twig', [
            'controller_name' => 'ShowSeriesCategoryController',
            'series' => $toSend,
            'category_id' => $category_id,
            'category_name' => $category_name,
        ]);
    }

    public function getSeriesByCategory(int $category_id): array
    {

        if ($category_id == 1) {
            $this->vodApiService->setAction('get_series');
            $series = $this->vodApiService->getAllSeries();
            return $series;
        } else {
            $series = $this->vodApiService->getWithCategoryId($category_id);
            return $series;
        }
    }

    #[Route('/series/{category_id}/search', name: 'app_search_series', methods: ['GET'])]
    public function searchSeries(Request $request, int $category_id): Response
    {
        $query = $request->query->get('q', '');
        if (empty($query)) {
            return $this->redirectToRoute('app_show_series_category', ['category_id' => 1]);
        }

        session_start();

        $this->vodApiService->setUsername($_SESSION['username']);
        $this->vodApiService->setPassword($_SESSION['password']);
        $this->vodApiService->setApiUrl($_SESSION['server_url']);
        $this->vodApiService->setAction('get_series');
        $series = $this->getSeriesByCategory($category_id);

        $this->vodApiService->setAction('get_series_categories');
        $this->vodApiService->setApiUrl($_SESSION['server_url']);
        $this->vodApiService->setUsername($_SESSION['username']);
        $this->vodApiService->setPassword($_SESSION['password']);
        $categories = $this->vodApiService->getVodStreams();

        $category_name = "Toutes les séries";
        foreach ($categories as $category) {
            if ($category['category_id'] == $category_id) {
                $category_name = $category['category_name'];
                break;
            }
        }

        // Filtrer les résultats en fonction de la recherche (nom, genre, casting, etc.)
        $filteredSeries = array_filter($series, function ($serie) use ($query) {
            return stripos($serie['name'], $query) !== false;
        });

        return $this->render('show_series_category/index.html.twig', [
            'controller_name' => 'ShowSeriesCategoryController',
            'series' => $filteredSeries,
            'category_id' => $category_id,
            'category_name' => $category_name,
        ]);
    }
}