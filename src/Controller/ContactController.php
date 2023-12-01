<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $entityManager, ContactRepository $contactRepository): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $existingContact = $contactRepository->findOneBy([
                'email' => $contact->getEmail()
            ]);

            $today = new \DateTime();
            $today->setTime(0, 0);

            if ($existingContact && $existingContact->getCreatedAt() >= $today) {
                $this->addFlash('error', 'Ya has enviado un formulario hoy.');
            } else {
                $entityManager->persist($contact);
                $entityManager->flush();

                $this->addFlash('success', 'Tu formulario ha sido enviado con éxito.');
                return $this->redirectToRoute('app_contact');
            }
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
