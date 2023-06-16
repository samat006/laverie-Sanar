<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\ArticleRepository;
use App\Repository\CommandeRepository;
use DateTime;
use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commandes')]
class CommandesController extends AbstractController
{
    private $security;
    #[Route('/', name: 'app_commandes_index', methods: ['GET'])]
    public function index(CommandeRepository $commandeRepository): Response
    {
        return $this->render('commandes/index.html.twig', [
            'commandes' => $commandeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_commandes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CommandeRepository $commandeRepository, ArticleRepository $articleRepository, Security $security): Response
    {
        $commande = new Commande();
        $articles = $articleRepository->findAll();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $commande->setClientId($this->getUser());
            $commande->setDatecreate(new DateTime("now"));
            $commandeRepository->save($commande, true);

            $this->security = $security;
            if ($this->security->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
            } elseif ($this->security->isGranted('ROLE_EMPLOYER')) {
                return $this->redirectToRoute('app_employer', [], Response::HTTP_SEE_OTHER);
            } else {
                return $this->redirectToRoute('app_compte', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('commandes/new.html.twig', [
            'commande' => $commande,
            'form' => $form,
            'articles' => $articles
        ]);
    }

    #[Route('/{id}', name: 'app_commandes_show', methods: ['GET'])]
    public function show(Commande $commande): Response
    {
        return $this->render('commandes/show.html.twig', [
            'commande' => $commande,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_commandes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commande $commande, CommandeRepository $commandeRepository, Security $security, ArticleRepository $articleRepository): Response
    {

        $articles = $articleRepository->findAll();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commande->setDateUpdate(new \DateTime("now"));
            $commandeRepository->save($commande, true);

            $this->security = $security;
            if ($this->security->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
            } elseif ($this->security->isGranted('ROLE_EMPLOYER')) {
                return $this->redirectToRoute('app_employer', [], Response::HTTP_SEE_OTHER);
            } else {
                return $this->redirectToRoute('app_compte', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('commandes/edit.html.twig', [
            'commande' => $commande,
            'form' => $form,
            'articles'=> $articles
        ]);
    }

    #[Route('/{id}', name: 'app_commandes_delete', methods: ['POST'])]
    public function delete(Request $request, Commande $commande, CommandeRepository $commandeRepository, Security $security): Response
    {
        if ($this->isCsrfTokenValid('delete' . $commande->getId(), $request->request->get('_token'))) {
            $commandeRepository->remove($commande, true);
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
