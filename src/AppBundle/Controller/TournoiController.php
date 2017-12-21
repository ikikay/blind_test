<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TournoiController extends Controller
{
     /**
     * @Route("/tournoi", name="tournoi")
     */
    public function indexAction()
    {
         return new Response(
            '<html><body>On va lister les tournois</body></html>'
        );
    }

}
