<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Commandeconception;
use App\Entity\Commandeimpression;
use App\Form\Commande1Type;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/gestcommande')]
final class GestcommandeController extends AbstractController{
    #[Route(name: 'app_gestcommande_index', methods: ['GET'])]
    public function index(CommandeRepository $commandeRepository): Response
    {
        return $this->render('gestcommande/index.html.twig', [
            'commandes' => $commandeRepository->findBy([],['created'=>'DESC']),
        ]);
    }

    #[Route('/new', name: 'app_gestcommande_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commande = new Commande();
        $form = $this->createForm(Commande1Type::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commande);
            $entityManager->flush();

            return $this->redirectToRoute('app_gestcommande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('gestcommande/new.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gestcommande_show', methods: ['GET'])]
    public function show($id,Commande $commande,EntityManagerInterface $em): Response
    {
        $commandeimpression=$em->getRepository(Commandeimpression::class)->findBy(['Commande'=>$id]);
        $commandeconception=$em->getRepository(Commandeconception::class)->findOneBy(['commande'=>$id]);
        return $this->render('gestcommande/show.html.twig', [
            'commande' => $commande,
            'impression' => $commandeimpression,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_gestcommande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Commande1Type::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_gestcommande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('gestcommande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gestcommande_delete', methods: ['POST'])]
    public function delete(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_gestcommande_index', [], Response::HTTP_SEE_OTHER);
    }
}
