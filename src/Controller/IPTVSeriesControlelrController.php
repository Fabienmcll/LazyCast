<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IPTVSeriesControlelrController extends AbstractController
{
    #[Route('/iptvseries', name: 'app_i_p_t_v_series_controlelr')]
    public function index(): Response
    {
        
        return $this->render('iptv_series_controlelr/index.html.twig', [
            'controller_name' => 'IPTVSeriesControlelrController',
        ]);
    }
}
