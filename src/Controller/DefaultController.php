<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name:'app_main', methods: ['GET', 'POST'])]
    public function main(Request $request, ContactRepository $contactRepository): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact->setDate(new \DateTime("now"));
            $contact->setDateCreate(new \DateTime("now"));
            $contactRepository->save($contact, true);

            return $this->redirectToRoute('app_contacts_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('default/index.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }
    #[Route('/default', name: 'app_default')]
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
