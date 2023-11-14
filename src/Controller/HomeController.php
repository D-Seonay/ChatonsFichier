<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;


class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
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
            
            //Gestion de la soumission du formulaire
            //1. récupérer les données du formulaire
            $form->handleRequest($request);
            //2. vérifier que le formulaire est soumis et valide
            if ($form->isSubmitted() && $form->isValid()) {
                //3. récupérer les données du formulaire
                $data = $form->getData();
                //4. créer le dossier
                $fs = new Filesystem();
                $fs->mkdir("img/".$data['nomDuDossier']);
                //5. rediriger vers la page d'accueil
                return $this->redirectToRoute('app_dossier', ['nomDuDossier' => $data['nomDuDossier']]);
            }

            //Ajouter une image
            $formImage = $this->createFormBuilder()
                ->add('imageFile', FileType::class, [
                    'label' => 'Image à partir des documents',
                    'required' => false,
                ])
                ->add('submit', SubmitType::class, [
                    'label' => 'Ajouter l\'image',
                    'attr' => [
                        'class' => 'btn btn-primary',
                    ],
                ])
                ->getForm();
                $formImage->handleRequest($request);
                if ($formImage->isSubmitted() && $formImage->isValid()) {
                    $data = $formImage->getData();
                    $fs = new Filesystem();
                    $fs->copy($data['imageFile']->getPathname(), "img/".$data['imageFile']->getClientOriginalName());
                    return $this->redirectToRoute('app_home');
                }

            //Gestion de la soumission du formulaire

            


        $finder= new Finder();
        $finder->directories()->in("img");

        return $this->render('home/index.html.twig', [
            "dossiers"=>$finder,
            'formulaire' => $form->createView(),
            'formulaireImage' => $formImage->createView(),
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
