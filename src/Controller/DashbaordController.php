<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashbaordController extends AbstractController
{
    #[Route('/', name: 'app_dashbaord')]
    public function index(EntityManagerInterface $em): Response
    {
        $commandesTotal=$em->getRepository(Commande::class)->CountCommande();
        $commandesTotalEnCours=$em->getRepository(Commande::class)->CountCommandeEnCours();
        $commanderecent=$em->getRepository(Commande::class)->findBy([],['created'=>'DESC']);
        $ClientTotal=$em->getRepository(Client::class)->CountClient();
        $clients =$em->getRepository(Client::class)->findBy([],['created'=>'DESC']);
        
        return $this->render('dashbaord/index.html.twig', [
            'controller_name' => 'DashbaordController',
            'commandesTotal'=>$commandesTotal,
            'commandesTotalEnCours'=>$commandesTotalEnCours,
            'commanderecent'=>$commanderecent,
            'ClientTotal'=>$ClientTotal,
            'clients'=>$clients,
        ]);
    }
}
