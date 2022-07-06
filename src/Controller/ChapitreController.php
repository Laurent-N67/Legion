<?php

namespace App\Controller;

use App\Entity\Chapitre;
use App\Form\ChapitreType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChapitreController extends AbstractController
{
    /**
     * @Route("/chapitre", name="app_chapitre")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $chapitres = $doctrine->getRepository(Chapitre::class)->findAll();

        return $this->render('chapitre/index.html.twig', [
            'chapitres' => $chapitres,
        ]);
    }
    /**
     * @Route("/chapitre/add", name="add_chapitre")
     * @Route("/chapitre/update/{id}", name="update_chapitre")
     */
    public function add(ManagerRegistry $doctrine, Chapitre $chapitres = null, Request $request): Response {
        
        if(!$chapitres){
            $chapitres = new Chapitre();
        }

        $entityManager = $doctrine->getManager();
        $form = $this->createForm(ChapitreType::class, $chapitres);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $chapitres = $form->getData();
            $entityManager->persist($chapitres);
            $entityManager->flush();

            return $this->redirectToRoute('app_manga');
        }

        return $this->render('chapitre/add.html.twig', [
            'formChapitre' =>$form->createView()
        ]);
    }
    /**
    * @Route("/chapitre/{id}", name="show_chapitre")
    */
    public function show(Chapitre $chapitre): Response{

        return $this->render('chapitre/show.html.twig',[
            'chapitre'=>$chapitre,
        ]);
    }
}
