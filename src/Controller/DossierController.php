<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DossierController extends AbstractController
{
    #[Route('/img/{nomDuDossier}', name: 'app_dossier')]
    public function index($nomDuDossier, Request $request): Response
    {
        $chemin="img/$nomDuDossier";

        //on vérifie que le dossier existe
        $fs= new Filesystem();
        if (!$fs->exists($chemin)) {
            //je renvoie une erreur 404
            throw $this->createNotFoundException("Ce dossier n'existe pas");
        }

         //Ajouter une image avec choix du dossier
         $formulaireImageAdd = $this->createFormBuilder()
         //Ajout de l'url de l'image
         ->add('imageFile', FileType::class, [
             'label' => 'Image à partir des documents',
             'required' => true,
         ])
         
         ->add('submit', SubmitType::class, [
             'label' => 'Ajouter l\'image',
             'attr' => [
                 'class' => 'btn btn-primary',
             ],
         ])
         ->getForm();
     
         $formulaireImageAdd->handleRequest($request);
         if ($formulaireImageAdd->isSubmitted() && $formulaireImageAdd->isValid()) {
             $data = $formulaireImageAdd->getData();
             $fs = new Filesystem();
             //comment faire pour l'ajoute dans le dossier 
                $data['imageFile']->move($chemin, $data['imageFile']->getClientOriginalName());
             return $this->redirectToRoute('app_home');
         }

        //je vais constituer le modèle à envoyer à la vue
        $finder= new Finder();
        $finder->files()->in($chemin);

        return $this->render('dossier/index.html.twig', [
            'nomDuDossier' => $nomDuDossier,
            'fichiers' => $finder,
            'formulaireImageAdd' => $formulaireImageAdd->createView(),
        ]);
    }
}
