<?php

namespace App\Controller;


use App\Entity\Auteur;
use App\Form\AuteurType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuteurController extends AbstractController
{
    /**
     * @Route("/auteur", name="app_auteur")
     */
    public function index(Request $request,ManagerRegistry $doctrine): Response
    {
        $auteurs = $doctrine->getRepository(Auteur::class)-> findAll();
        return $this->render('auteur/index.html.twig', [
            'auteurs' => $auteurs,
        ]);
    }
    /**
     * @Route("/auteur/add", name="add_auteur")
     * @Route("/auteur/update/{id}", name="update_auteur")
     */
    public function add(ManagerRegistry $doctrine, Auteur $auteurs = null, Request $request): Response {
        
        if(!$auteurs){
            $auteurs = new Auteur();
        }

        $entityManager = $doctrine->getManager();
        $form = $this->createForm(AuteurType::class, $auteurs);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $auteurs = $form->getData();
            $entityManager->persist($auteurs);
            $entityManager->flush();

            return $this->redirectToRoute('app_manga');
        }

        return $this->render('auteur/add.html.twig', [
            'formAuteur' =>$form->createView()
        ]);
    }
    /**
    * @Route("/auteur/{id}", name="show_auteur")
    */
    public function show(Auteur $auteurs): Response{

        return $this->render('auteur/show.html.twig',[
            'auteurs'=>$auteurs,
        ]);
    }
    /**
     * @Route("/supp_auteur/{id}", name="del_auteur")
     */
    public function suppAuteur(ManagerRegistry $doctrine, Auteur $auteurs): Response
    {
       
        $entityManager = $doctrine->getManager();
        
        $entityManager->remove($auteurs);
        $entityManager->flush();
        
        $this->addFlash('deleted',"l'auteur a été supprimé.");
        return $this->redirectToRoute("app_auteur");
    }
}
