<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Entity\Commande;
use App\Form\FactureType;
use App\Entity\Detailcommande;
use App\Form\DetailcommandeType;
use App\Repository\ClientRepository;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ConsommableRepository;
use App\Repository\DetailcommandeRepository;
use App\Repository\FactureRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/detailcommande')]
final class DetailcommandeController extends AbstractController
{
    #[Route(name: 'app_detailcommande_index', methods: ['GET'])]
    public function index(DetailcommandeRepository $detailcommandeRepository): Response
    {
        return $this->render('detailcommande/index.html.twig', [
            'detailcommandes' => $detailcommandeRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'app_detailcommande_new', methods: ['GET', 'POST'])]
    public function new(ConsommableRepository $consommableRepository, SessionInterface $session, $id, Request $request, EntityManagerInterface $em, ClientRepository $clientRepository): Response
    {

        $commande = new Commande();
        $form = $this->createForm(DetailcommandeType::class);
        $form->handleRequest($request);
        $client = $clientRepository->find($id);
        //recuperer les detail commande existant dans la session
        $details = $session->get('details_commande', []);


        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getClickedButton()->getName() == 'autre') {
                $details[] = [
                    'form' => $request->request->all()
                ];
                $session->set('details_commande', $details);
                return $this->redirectToRoute('app_detailcommande_new', ['id' => $id], Response::HTTP_SEE_OTHER);
            }
            $details[] = [
                'form' => $request->request->all()
            ];
            $session->set('details_commande', $details);
            $details = $session->get('details_commande', []);
            $commande = new Commande();
            $client = $clientRepository->find($id);

            $commande->setClient($client);
            $commande->setDescription('...');
            $commande->setStatutcommande('en cours');
            $commande->setCreated(new \DateTime());

            $prixcommande = 0;

            foreach ($details as $detail) {
                $detailcommande = new Detailcommande();

                $detailcommande->setDescription($detail['form']['detailcommande']['description']);
                $detailcommande->setPrix($detail['form']['detailcommande']['prix']);
                $detailcommande->setType($detail['form']['detailcommande']['type']);
                $detailcommande->setCommande($commande);
                $detailcommande->setQteconsommable($detail['form']['detailcommande']['qteconsommable']);
                $detailcommande->setQtecommande($detail['form']['detailcommande']['qtecommande']);
                $detailcommande->setDimension($detail['form']['detailcommande']['dimension']);
                $detailcommande->setCreateAlt(new \DateTime());

                // mise a jour de l'approvisionnement
                $consommable = $consommableRepository->find($detail['form']['detailcommande']['consommable']);
                $consommableQteRestant = $consommable->getQtedispo();
                if ($consommableQteRestant < $detail['form']['detailcommande']['qteconsommable']) {
                    $this->addFlash('warring', 'Quantite restant est insuffisant');
                }
                $consommable->setQtedispo($consommableQteRestant - $detail['form']['detailcommande']['qteconsommable']);
                $detailcommande->setConsommable($consommable);
                $prixcommande = +$detail['form']['detailcommande']['prix'] * $detail['form']['detailcommande']['qtecommande'];
                $em->persist($detailcommande);
            }

            $commande->setPrixcommande($prixcommande);
            $em->persist($commande);
            $em->flush();

            $session->remove('details_commande');
            return $this->redirectToRoute('app_detailcommande_show', ['idcommande' => $commande->getId()], Response::HTTP_SEE_OTHER);
        }


        return $this->render('detailcommande/new.html.twig', [
            'form' => $form,
            'client' => $client
        ]);
    }

    #[Route('/delete/{index}/{id}', name: 'detail_commande_delete', methods: ['POST'])]
    public function detail_commande_delete(int $index, $id, SessionInterface $session): Response
    {
        //recuperer la liste des details
        $details = $session->get('details_commande', []);
        //verifier si l'index existe
        if (isset($details[$index])) {
            unset($details[$index]);
            $session->set('details_commande', array_values($details));
            # code...
        }
        return $this->redirectToRoute('app_detailcommande_new', ['id' => $id], Response::HTTP_SEE_OTHER);
    }

    #[Route('/save/{id}', name: 'app_detailcommande_save', methods: ['GET'])]
    public function save($id, ConsommableRepository $consommableRepository, SessionInterface $session, Request $request, EntityManagerInterface $em, ClientRepository $clientRepository): Response
    {
        $details = $session->get('details_commande', []);
        $detailcommande = new Detailcommande();
        $commande = new Commande();
        $client = $clientRepository->find($id);

        $commande->setClient($client);
        $commande->setStatutcommande('en cours');
        $commande->setCreated(new \DateTime());
        $lastcommande = $em->getRepository(Commande::class)->findOneBy([], ['id' => 'DESC']);
        $numero = $lastcommande ? intval(substr($lastcommande->getDescription(), -4)) + 1 : 1;
        $desc = 'COM-' . str_pad($numero, 3, '0', STR_PAD_LEFT);
        $commande->setDescription($desc);

        $prixcommande = 0;

        foreach ($details as $detail) {
            $detailcommande = new Detailcommande();
            $detailcommande->setDescription($detail['form']['detailcommande']['description']);
            $detailcommande->setPrix($detail['form']['detailcommande']['prix']);
            $detailcommande->setType($detail['form']['detailcommande']['type']);
            $detailcommande->setCommande($commande);
            $detailcommande->setQteconsommable($detail['form']['detailcommande']['qteconsommable']);
            $detailcommande->setQtecommande($detail['form']['detailcommande']['qtecommande']);
            $detailcommande->setDimension($detail['form']['detailcommande']['dimension']);
            $detailcommande->setCreateAlt(new \DateTime());

            // mise a jour de l'approvisionnement
            $consommable = $consommableRepository->find($detail['form']['detailcommande']['consommable']);
            $consommableQteRestant = $consommable->getQtedispo();
            if ($consommableQteRestant < $detail['form']['detailcommande']['qteconsommable']) {
                $this->addFlash('warring', 'Quantite restant est insuffisant');
            }
            $consommable->setQtedispo($consommableQteRestant - $detail['form']['detailcommande']['qteconsommable']);
            $detailcommande->setConsommable($consommable);
            $prixcommandes = $detail['form']['detailcommande']['prix'] * $detail['form']['detailcommande']['qtecommande'];
            $prixcommande = $prixcommande +  $prixcommandes;
            $em->persist($detailcommande);
        }

        $commande->setPrixcommande($prixcommande);
        $em->persist($commande);
        $em->flush();
        
        $session->remove('details_commande');
        return $this->redirectToRoute('app_detailcommande_show', ['idcommande' => $commande->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/show/{idcommande}', name: 'app_detailcommande_show', methods: ['GET', 'POST'])]
    public function show(Request $request, EntityManagerInterface $em, $idcommande, CommandeRepository $commandeRepository, ClientRepository $clientRepository, DetailcommandeRepository $detailcommandeRepository, FactureRepository $factureRepository): Response
    {
        $commande = $commandeRepository->find($idcommande);
        $detailcommande = $detailcommandeRepository->findBy(['commande' => $idcommande]);
        $client = $commande->getClient();
        $factures = $factureRepository->findBy(['Commande' => $idcommande]);
        //somme des montants du facture payer pour une commande
        $totalpayer = $factureRepository->SommeMontantPayerCommande($idcommande);

        //gestion de la facture
        $facture = new Facture();
        $form = $this->createForm(FactureType::class);
        $form->handleRequest($request);
        $commande = $em->getRepository(Commande::class)->find($idcommande);
        if ($form->isSubmitted() && $form->isValid()) {
            $facture->setCommande($commande);
            $facture->setDatefacture(new \DateTime);
            $facture->setMontant($form->get('montatalfacture')->getData());
            $facture->setMoyenpaiemant($form->get('moyenpaiement')->getData());
            $payer = $totalpayer + $form->get('montatalfacture')->getData();
            $facture->setResteapayer($commande->getPrixcommande() - $payer);
            if ($payer == $commande->getPrixcommande()) {
                $facture->setStatut('payer');
            }
            if ($payer < $commande->getPrixcommande()) {
                $facture->setStatut('avance');
            }
            $annerCreationAkemarservice = "010324";
            $lastfacture = $em->getRepository(Facture::class)->findOneBy([], ['id' => 'DESC']);
            $numero = $lastfacture ? intval(substr($lastfacture->getReference(), -4)) + 1 : 1;
            $reference = 'AS/' . $annerCreationAkemarservice . '/' . str_pad($numero, 4, '0', STR_PAD_LEFT);
            $facture->setReference($reference);

            $TVAetat = $form->get('TVA')->getData();

            if ($TVAetat == true) {
                $facture->setTVA(0.18);
            } else {
                $facture->setTVA(0);
            }

            $em->persist($facture);
            $em->flush();

            return $this->redirectToRoute('app_facture_show', [
                'idcommande' => $idcommande,
                'id' => $facture->getId(),
            ]);
        }

        return $this->render('detailcommande/show.html.twig', [
            'commande' => $commande,
            'detailcommandes' => $detailcommande,
            'client' => $client,
            'form' => $form,
            'facture' => $factures,
            'totalpayer' => $totalpayer,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_detailcommande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Detailcommande $detailcommande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DetailcommandeType::class, $detailcommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_detailcommande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('detailcommande/edit.html.twig', [
            'detailcommande' => $detailcommande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_detailcommande_delete', methods: ['POST'])]
    public function delete(Request $request, Detailcommande $detailcommande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $detailcommande->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($detailcommande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_detailcommande_index', [], Response::HTTP_SEE_OTHER);
    }
}
