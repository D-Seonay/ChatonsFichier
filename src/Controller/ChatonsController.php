<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChatonsController extends AbstractController
{
    #[Route('/', name: 'app_chatons')]
    public function index(): Response
    {
        $cards = [
            [
                'image' => './img/cat1.jpg',
                'altText' => 'Chat 1',
                'title' => 'Chat 1',
                'text' => 'Texte 1',
                'link' => '#',
            ],
            [
                'image' => './img/cat2.jpg',
                'altText' => 'Chat 2    ',
                'title' => 'Chat 2',
                'text' => 'Texte 2',
                'link' => '#',
            ],
            [
                'image' => './img/cat3.jpg',
                'altText' => 'Chat 3',
                'title' => 'Chat 3',
                'text' => 'Texte 3',
                'link' => '#',
            ],
        ];
    
        return $this->render('chatons/index.html.twig', ['cards' => $cards]);
    }
}