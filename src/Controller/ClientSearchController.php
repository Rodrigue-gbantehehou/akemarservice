<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ClientSearchController extends AbstractController{
    #[Route('/client/search', name: 'app_client_search')]
    public function index(Request $request, ClientRepository $clientRepository): Response
    {
        $query = $request->query->get('query','');
        $clients=[];
        if (!empty($query)) {
           $clients=$clientRepository->searcheClients($query);
        }
       return  $this->redirectToRoute('app_commande',[
        'clients'=>$clients
       ]);
    }
}
