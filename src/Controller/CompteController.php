<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompteController extends AbstractController
{
    #[Route('/compte', name: 'app_compte')]
    public function index(): Response
    {
        /** @var UserInterface $user */
        $user = $this->getUser();
        $email = $user->getEmail();
        $commandes = $user->getCommandes();
        $reparations = $user->getReparations();
        $transactions = $user->getTransactions();
        $abonnements = $user->getAbonnements();
        return $this->render('compte/index.html.twig', [
            'commandes' => $commandes, 'reparations' => $reparations ,'transactions' => $transactions, 'abonnements' => $abonnements
        ]);
    }
}
