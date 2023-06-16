<?php

namespace App\Controller;

use App\Entity\Abonnement;
use App\Form\AbonnementType;
use DateTime;
use Symfony\Component\Security\Core\Security;
use App\Repository\AbonnementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/abonnements')]
class AbonnementsController extends AbstractController
{
    private $security;
    #[Route('/', name: 'app_abonnements_index', methods: ['GET'])]
    public function index(AbonnementRepository $abonnementRepository): Response
    {
        return $this->render('abonnements/index.html.twig', [
            'abonnements' => $abonnementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_abonnements_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AbonnementRepository $abonnementRepository, Security $security): Response
    {
        $abonnement = new Abonnement();
        $form = $this->createForm(AbonnementType::class, $abonnement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $abonnement->setClientId($this->getUser());
            $abonnement->setDatecreate(new DateTime("now"));
            $abonnementRepository->save($abonnement, true);

            $this->security = $security;
            if ($this->security->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
            } elseif ($this->security->isGranted('ROLE_EMPLOYER')) {
                return $this->redirectToRoute('app_employer', [], Response::HTTP_SEE_OTHER);
            } else {
                return $this->redirectToRoute('app_compte', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('abonnements/new.html.twig', [
            'abonnement' => $abonnement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_abonnements_show', methods: ['GET'])]
    public function show(Abonnement $abonnement): Response
    {
        return $this->render('abonnements/show.html.twig', [
            'abonnement' => $abonnement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_abonnements_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Abonnement $abonnement, AbonnementRepository $abonnementRepository, Security $security): Response
    {
        $form = $this->createForm(AbonnementType::class, $abonnement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $abonnement->setDateUpdate(new \DateTime("now"));
            $abonnementRepository->save($abonnement, true);

            $this->security = $security;
            if ($this->security->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
            } elseif ($this->security->isGranted('ROLE_EMPLOYER')) {
                return $this->redirectToRoute('app_employer', [], Response::HTTP_SEE_OTHER);
            } else {
                return $this->redirectToRoute('app_compte', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('abonnements/edit.html.twig', [
            'abonnement' => $abonnement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_abonnements_delete', methods: ['POST'])]
    public function delete(Request $request, Abonnement $abonnement, AbonnementRepository$abonnementRepository, Security $security): Response
    {
        if ($this->isCsrfTokenValid('delete'.$abonnement->getId(), $request->request->get('_token'))) {
            $abonnementRepository->remove($abonnement, true);
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
