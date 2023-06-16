<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Repository\AbonnementRepository;
use App\Repository\CommandeRepository;
use App\Repository\ContactRepository;
use App\Repository\ReparationRepository;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(UserRepository $userRepository, CommandeRepository $commandeRepository, ReparationRepository $reparationRepository, TransactionRepository $transactionRepository, AbonnementRepository $abonnementRepository, ContactRepository $contactRepository): Response
    {
        $users = $userRepository->findAll();
       // $commandes = $commandeRepository->findAll();
        //$reparations = $reparationRepository->findAll();
        //$transactions = $transactionRepository->findAll();
       // $abonnements = $abonnementRepository->findAll();
       // $contacts = $contactRepository->findBy($limit= 10);
       // $userslimit = $userRepository->findBy($limit=10);
        return $this->render('admin/admin.html.twig', [
            'lusers'=> count($users),
          //  'lcommandes'=>count($commandes),
         //   'lreparations'=>count($reparations),
           // 'ltrans'=>count($transactions) + count($abonnements),
            //'userslimit' => $userslimit
        ]);
    }
    #[Route('/list', name: 'list')]
    public function list(UserRepository $userRepository, CommandeRepository $commandeRepository, ReparationRepository $reparationRepository, TransactionRepository $transactionRepository, AbonnementRepository $abonnementRepository, ContactRepository $contactRepository): Response
    {
        $users = $userRepository->findAll();
     
        return $this->render('user/index.html.twig', [
            'users'=> count($users),
    
        ]);
    }

    #[Route('/delete', name: 'delete')]
    public function delete(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
     
        return $this->redirectToRoute('app_user_delete', [], Response::HTTP_SEE_OTHER);
         
    
    }
    #[Route('/editcom', name: 'editcom')]
    public function editcom(CommandeRepository $commandeRepository): Response
    {
           $commandes = $commandeRepository->findAll();
        return $this->redirectToRoute('app_commandes_edit', [], Response::HTTP_SEE_OTHER);
       
    }
    
    #[Route('/edituses', name: 'edituser')]
    public function edituser(): Response
    {
        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
       
    }
}
