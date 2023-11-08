<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChatonsController extends AbstractController
{
    #[Route('/chatons', name: 'app_chatons')]
    public function index(): Response
    {
        return $this->render('chatons/index.html.twig', [
            'controller_name' => 'ChatonsController',
        ]);
    }
}
