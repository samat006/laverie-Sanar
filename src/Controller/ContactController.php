<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name:'app_contact', methods: ['GET', 'POST'])]
    public function index(Request $request, ContactRepository $contactRepository): Response
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

        return $this->renderForm('contact/index.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }
}
