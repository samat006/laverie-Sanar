<?php

namespace App\Controller;

use App\Entity\Reparation;
use App\Form\ReparationType;
use App\Repository\CommandeRepository;
use DateTime;
use Symfony\Component\Security\Core\Security;
use App\Repository\ReparationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reparations')]
class ReparationsController extends AbstractController
{
    private $security;
    #[Route('/', name: 'app_reparations_index', methods: ['GET'])]
    public function index(ReparationRepository $reparationRepository): Response
    {
        return $this->render('reparations/index.html.twig', [
            'reparations' => $reparationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_reparations_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReparationRepository $reparationRepository, CommandeRepository $commandeRepository, Security $security): Response
    {
        $reparation = new Reparation();
        $commandes = $commandeRepository->findByUser($this->getUser());
        $form = $this->createForm(ReparationType::class, $reparation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $reparation->setUserId($this->getUser());
            $reparation->setDatecreate(new DateTime("now"));
            $reparationRepository->save($reparation, true);

            $this->security = $security;
            if ($this->security->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
            } elseif ($this->security->isGranted('ROLE_EMPLOYER')) {
                return $this->redirectToRoute('app_employer', [], Response::HTTP_SEE_OTHER);
            } else {
                return $this->redirectToRoute('app_compte', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('reparations/new.html.twig', [
            'reparation' => $reparation,
            'form' => $form,
            'commandes' => $commandes
        ]);
    }

    #[Route('/{id}', name: 'app_reparations_show', methods: ['GET'])]
    public function show(Reparation $reparation): Response
    {
        return $this->render('reparations/show.html.twig', [
            'reparation' => $reparation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reparations_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reparation $reparation, ReparationRepository $reparationRepository, CommandeRepository $commandeRepository, Security $security): Response
    {
        $commandes = $commandeRepository->findByUser($reparation->getUserId());
        $form = $this->createForm(ReparationType::class, $reparation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reparation->setDateUpdate(new DateTime("now"));
            $reparationRepository->save($reparation, true);

            $this->security = $security;
            if ($this->security->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
            } elseif ($this->security->isGranted('ROLE_EMPLOYER')) {
                return $this->redirectToRoute('app_employer', [], Response::HTTP_SEE_OTHER);
            } else {
                return $this->redirectToRoute('app_compte', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('reparations/edit.html.twig', [
            'reparation' => $reparation,
            'form' => $form,
            'commandes' => $commandes
        ]);
    }

    #[Route('/{id}', name: 'app_reparations_delete', methods: ['POST'])]
    public function delete(Request $request, Reparation $reparation, ReparationRepository$reparationRepository, Security $security): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reparation->getId(), $request->request->get('_token'))) {
            $reparationRepository->remove($reparation, true);
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
