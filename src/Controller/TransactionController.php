<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Form\TransactionType;
use DateTime;
use Symfony\Component\Security\Core\Security;
use App\Repository\CommandeRepository;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/transaction')]
class TransactionController extends AbstractController
{
    private $security;
    #[Route('/', name: 'app_transaction_index', methods: ['GET'])]
    public function index(TransactionRepository $transactionRepository): Response
    {
        return $this->render('transaction/index.html.twig', [
            'transactions' => $transactionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_transaction_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TransactionRepository $transactionRepository, Security $security, UserRepository $userRepository, CommandeRepository $commandeRepository): Response
    {
        $transaction = new Transaction();
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);
        $commandes = $commandeRepository->findAll();
        $clients = $userRepository->findAll();
        if ($form->isSubmitted() && $form->isValid()) {
            $transaction->setUserCreate($this->getUser());
            $transaction->setDate(new DateTime("now"));
            $transactionRepository->save($transaction, true);

            $this->security = $security;
            if ($this->security->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
            } elseif ($this->security->isGranted('ROLE_EMPLOYER')) {
                return $this->redirectToRoute('app_employer', [], Response::HTTP_SEE_OTHER);
            } else {
                return $this->redirectToRoute('app_compte', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('transaction/new.html.twig', [
            'form' => $form,
            'clients' => $clients,
            'commandes' => $commandes,
            'transaction' => $transaction,
        ]);
    }

    #[Route('/{id}', name: 'app_transaction_show', methods: ['GET'])]
    public function show(Transaction $transaction): Response
    {
        return $this->render('transaction/show.html.twig', [
            'transaction' => $transaction,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_transaction_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Transaction $transaction, CommandeRepository $commandeRepository, UserRepository $userRepository, TransactionRepository $transactionRepository, Security $security): Response
    {
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);
        $commandes = $commandeRepository->findAll();
        $clients = $userRepository->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            $transactionRepository->save($transaction, true);

            $this->security = $security;
            if ($this->security->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
            } elseif ($this->security->isGranted('ROLE_EMPLOYER')) {
                return $this->redirectToRoute('app_employer', [], Response::HTTP_SEE_OTHER);
            } else {
                return $this->redirectToRoute('app_compte', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('transaction/edit.html.twig', [
            'transaction' => $transaction,
            'form' => $form,
            'commandes' => $commandes,
            'clients' => $clients
        ]);
    }

    #[Route('/{id}', name: 'app_transaction_delete', methods: ['POST'])]
    public function delete(Request $request, Transaction $transaction, TransactionRepository$transactionRepository, Security $security): Response
    {
        if ($this->isCsrfTokenValid('delete'.$transaction->getId(), $request->request->get('_token'))) {
            $transactionRepository->remove($transaction, true);
        }
        $this->security = $security;
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
        } elseif ($this->security->isGranted('ROLE_EMPLOYER')) {
            return $this->redirectToRoute('app_employer', [], Response::HTTP_SEE_OTHER);
        } else {
            return $this->redirectToRoute('app_compte', [], Response::HTTP_SEE_OTHER);
        }
    }
}
