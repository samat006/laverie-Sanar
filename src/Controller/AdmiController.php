<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdmiController extends AbstractController
{
    #[Route('/admi', name: 'app_admi')]
    public function index(): Response
    {
        return $this->render('admi/index.html.twig', [
            'controller_name' => 'AdmiController',
        ]);
    }
}
