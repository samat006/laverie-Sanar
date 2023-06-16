<?php

namespace App\Controller;

use App\Repository\AbonnementRepository;
use App\Repository\CommandeRepository;
use App\Repository\ContactRepository;
use App\Repository\ReparationRepository;
use App\Repository\TransactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployerController extends AbstractController
{
    #[Route('/employer', name: 'app_employer')]
    public function index(ContactRepository $contactRepository ,CommandeRepository $commandeRepository, ReparationRepository $reparationRepository, AbonnementRepository $abonnementRepository, TransactionRepository $transactionRepository): Response
    {
        /** @var UserInterface $user */
        $user = $this->getUser();
        $email = $user->getEmail();
        $commandesClients = $commandeRepository->findAll();
        $reparationsClients = $reparationRepository->findAll();
        $abonnementsClients = $abonnementRepository->findAll();
        $transactionsClients = $transactionRepository->findAll();
        $contacts = $contactRepository->findAll();
        $commandes = $user->getCommandes();
        $reparations = $user->getReparations();
        $transactions = $user->getTransactions();
        $abonnements = $user->getAbonnements();
        return $this->render('employer/index.html.twig', [
            'commandes' => $commandes, 
            'reparations' => $reparations, 
            'transactions' => $transactions, 
            'abonnements' => $abonnements,
            'contacts' => $contacts,
            'commandesClients' => $commandesClients,
            'reparationsClients' => $reparationsClients,
            'abonnementsClients' => $abonnementsClients,
            'transactionsClients' => $transactionsClients,
        ]);
    }
}
