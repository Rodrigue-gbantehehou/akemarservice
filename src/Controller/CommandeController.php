<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Commande;
use App\Form\ClientType;
use App\Form\CommandeType;
use App\Entity\Consommable;
use App\Form\ImpConcepType;
use App\Entity\Commandeconception;
use App\Entity\Commandeimpression;
use App\Form\CommandeconceptionType;
use App\Form\CommandeImpressionType;
use App\Repository\ClientRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{

    #[Route('/commande', name: 'app_commande', methods: ['GET', 'POST'])]
    public function index(Request $request, ClientRepository $clientRepository, EntityManagerInterface $em, SessionInterface $session): Response
    {

        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client->setCreated(new \DateTimeImmutable());
            $em->persist($client);
            $em->flush();

            return $this->redirectToRoute('app_commande', [], Response::HTTP_SEE_OTHER);
        }
        $seachform = $this->createForm(CommandeType::class);
        $seachform->handleRequest($request);
        if ($seachform->isSubmitted() && $seachform->isValid()) {
            //recuperation du numero du client saisir
            $seachformclient = $seachform->get('Numclient')->getData();
            //recuperation de la description de la commande
            $descriptioncommande = $seachform->get('description')->getData();
            //recuperation du type de la commande
            $Typecommande = $seachform->get('Typecommande')->getData();
            //recuperation du prix de la commande
            $PrixCommande = $seachform->get('Prix')->getData();

            //recherche du client ayant le numero recuperer
           
            //stocke de la commande dans la session
            $session->set('commande', [
                'client' => $seachformclient,
                'date' => new \DateTime(),
                'Typecommande' => $Typecommande,
                'PrixCommande' => $PrixCommande,
                'description' => $descriptioncommande
            ]);


            if ($Typecommande == 'impression') {
                return $this->redirectToRoute('app_detail_impression', []);
            } elseif ($Typecommande == 'conception') {
                return $this->redirectToRoute('app_detail_conception', []);
            } elseif ('impression et conception') {
                return $this->redirectToRoute('app_detail_ImpCon', []);
            }
        }

        $query = $request->query->get('query','');
        $clients=[];
        if (!empty($query)) {
           $clients=$clientRepository->searcheClients($query);
        }else {
            $clients=$clientRepository->findAll();
        }
        
        return $this->render('commande/listeclients.html.twig', [
            'clients' => $clients,
            'controller_name' => 'Commande',
            'form' => $form->createView()
        ]);
    }
    #[Route('/detail/impression/', name: 'app_detail_impression', methods: ['GET', 'POST'])]
    public function detail(Request $request, ClientRepository $clientRepository, EntityManagerInterface $em, SessionInterface $session): Response
    {
        //commande impression

        $commande = new Commande();
       $Commandeimpressionform = $this->createForm(CommandeImpressionType::class, $Commandeimpression);
        $Commandeimpressionform->handleRequest($request);

        if ($Commandeimpressionform->isSubmitted() && $Commandeimpressionform->isValid()) {
            $buttonsumited = $Commandeimpressionform->getClickedButton()->getName();
            
            
            $commandeData = $session->get('commande');
            $nouvelleclient = $clientRepository->findOneBy(['telephoneClient' => $commandeData['client']]);

            //verification de l'existqnce du client
            if (!$nouvelleclient) {
                $nouvelleclient = new Client();
                $nouvelleclient->setTelephoneClient($commandeData['client']);
                $em->persist($nouvelleclient);
            }

            //enregister la commande
            $commande->setClient($nouvelleclient);
            $commande->setCreated(new \DateTime());
            $commande->setTypecommande($commandeData['Typecommande']);
            $commande->setPrixcommande($commandeData['PrixCommande']);
            $commande->setStatutcommande('en cours');
            $commande->setDescription($commandeData['description']);

            // mise a jour de l'approvisionnement
            $consommableformId = $Commandeimpressionform->get('consommable')->getData();
            $consommableformQte = $Commandeimpressionform->get('nombrepapier')->getData();

            $consommableid = $consommableformId->getId();
            $consommable = $em->getRepository(Consommable::class)->findOneBy(['id' => $consommableid]);
            $consommableQteRestant = $consommable->getQtedispo();
            

           

            if ($consommableQteRestant < $consommableformQte) {
                $this->addFlash('warring', 'Quantite restant es insuffisant');
                return $this->redirectToRoute('app_detail_impression', []);
            }

            $consommable->setQtedispo($consommableQteRestant - $consommableformQte);


            $client = $commandeData['client'];

            for ($i=0; $i < 10; $i++) { 
                $Commandeimpression->setydimension($i);
           $Commandeimpression->setCommande($commande);
            $em->persist($Commandeimpression);
            }
           
            
            $em->persist($commande);
            $em->flush();
            $comid = $commande->getId();
            if ($buttonsumited == 'Payement') {
                $this->addFlash('success', 'commande en register avec success, payement enclanché!');
                return $this->redirectToRoute('app_facture_new', [
                    'comid'=>$comid]);
                
            }
            $this->addFlash('success', 'commande en register avec success');
            return $this->redirectToRoute('app_gestcommande_index');
        }
        return $this->render('commande/detailImpression.html.twig', [
            'client' => $clientRepository->findAll(),
            'controller_name' => 'Commande Impression',
            'Commandeimpressionform' => $Commandeimpressionform->createView(),
        ]);
    }
    #[Route('/detail/conception/{comid}', name: 'app_detail_conception', methods: ['GET', 'POST'])]
    public function detailconception($comid, Request $request, ClientRepository $clientRepository, EntityManagerInterface $em): Response
    {
        $commande = $em->getRepository(Commande::class)->find($comid);

        //commande conception
        $Commandeconception = new Commandeconception();
        $Commandeconceptionform = $this->createForm(CommandeconceptionType::class, $Commandeconception);
        $Commandeconceptionform->handleRequest($request);
        if ($Commandeconceptionform->isSubmitted() && $Commandeconceptionform->isValid()) {

            $Commandeconception->setCommande($commande);
            $em->persist($Commandeconception);
            $em->flush();
            return $this->redirectToRoute('app_gestcommande_index');
        }

        return $this->render('commande/detailconception.html.twig', [
            'client' => $clientRepository->findAll(),
            'controller_name' => 'Commande conception',
            'commande' => $commande,
            'Commandeconception' => $Commandeconceptionform->createView()
        ]);
    }
    #[Route('/detail/detailImpConp/{comid}', name: 'app_detail_ImpCon', methods: ['GET', 'POST'])]
    public function detailImpConp($comid, Request $request, ClientRepository $clientRepository, EntityManagerInterface $em): Response
    {
        $commande = $em->getRepository(Commande::class)->find($comid);


        //commande conception
        $Commandeconception = new Commandeconception();
        $Commandeconception = new Commandeconception();
        $form = $this->createForm(ImpConcepType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $Commandeconception->setCommande($commande);
            $em->persist($Commandeconception);
            $em->flush();

            return $this->redirectToRoute('app_gestcommande_index');
        }

        return $this->render('commande/detailImpConp.html.twig', [
            'client' => $clientRepository->findAll(),
            'controller_name' => 'Commande conception',
            'commande' => $commande,
            'form' => $form->createView()
        ]);
    }
}
