<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
            //Ajouter un formulaire pour créér un dossier
            $form = $this->createFormBuilder()
            ->add('nomDuDossier', TextType::class, [
                'label' => 'Nom du dossier',
                'attr' => [
                    'placeholder' => 'Nom du dossier',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Créer le dossier',
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ])
            ->getForm();
            

        $finder= new Finder();
        $finder->directories()->in("img");

        return $this->render('home/index.html.twig', [
            "dossiers"=>$finder,
            'formulaire' => $form->createView(),
        ]);
    }

    public function menu(): Response
    {
        $finder= new Finder();
        $finder->directories()->in("img");

        return $this->render('home/_menu.html.twig', [
            "dossiers"=>$finder,
        ]);
    }
}
