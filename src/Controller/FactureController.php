<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Commandeimpression;
use App\Entity\Facture;
use App\Form\FactureType;
use App\Repository\ClientRepository;
use App\Repository\CommandeRepository;
use App\Repository\DetailcommandeRepository;
use App\Repository\FactureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/facture')]
final class FactureController extends AbstractController
{
    #[Route(name: 'app_facture_index', methods: ['GET'])]
    public function index(FactureRepository $factureRepository): Response
    {
        return $this->render('facture/index.html.twig', [
            'factures' => $factureRepository->findBy([],['datefacture'=>'DESC']),
        ]);
    }

    #[Route('/new/{idcommande}', name: 'app_facture_new', methods: ['GET', 'POST'])]
    public function new($idcommande, Request $request, EntityManagerInterface $entityManager): Response
    {
        $facture = new Facture();
        $form = $this->createForm(FactureType::class);
        $form->handleRequest($request);
        $commande=$entityManager->getRepository(Commande::class)->find($idcommande);
        if ($form->isSubmitted() && $form->isValid()) {
            $facture->setCommande($commande);
            $facture->setDatefacture(new \DateTime);
            $facture->setMontant($form->get('montatalfacture')->getData());
            $facture->setMoyenpaiemant($form->get('moyenpaiement')->getData());
            $facture->setReference('AS000'.$facture);

            $TVAetat = $form->get('TVA')->getData();
           
            if ($TVAetat == true) {
                $facture->setTVA(0.18);
            }else {
                $facture->setTVA(0);
            }
           
            $entityManager->persist($facture);
            $entityManager->flush();

            return $this->redirectToRoute('app_generate_facture', [
                'idcommande'=>$idcommande]);
        }

        return $this->render('facture/new.html.twig', [
            'facture' => $facture,
            'form' => $form,
        ]);
    }

    #[Route('/show/{id}/{idcommande}', name: 'app_facture_show', methods: ['GET'])]
    public function show($id,$idcommande,CommandeRepository $commandeRepository,ClientRepository $clientRepository,DetailcommandeRepository $detailcommandeRepository,FactureRepository $factureRepository): Response
    {
        $commande=$detailcommandeRepository->find($idcommande);
        $detailcommande=$detailcommandeRepository->findBy(['commande'=>$idcommande]);
        $facture=$factureRepository->find($id);
        $totalpayer=$factureRepository->SommeMontantPayerCommande($idcommande);
        return $this->render('facture/show.html.twig', [
            'facture' => $facture,
            'commande' => $commande,
            'totalpayer' => $totalpayer,
            'detailcommande'=>$detailcommande
        ]);
    }

    #[Route('/{id}/edit', name: 'app_facture_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Facture $facture, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_facture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('facture/edit.html.twig', [
            'facture' => $facture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_facture_delete', methods: ['POST'])]
    public function delete(Request $request, Facture $facture, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $facture->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($facture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_facture_index', [], Response::HTTP_SEE_OTHER);
    }

   
}
