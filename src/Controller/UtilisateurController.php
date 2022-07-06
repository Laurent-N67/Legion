<?php

namespace App\Controller;


use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/utilisateur", name="app_utilisateur")
     */
    public function index(): Response
    {
        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }
     /**
     * @Route("/supp_compte", name="delete_account")
     */
    public function suppCompte(ManagerRegistry $doctrine): Response
    {
        $user = $this->getUser();

        $entityManager = $doctrine->getManager();
        
        // supprime la session utilisateur
        $session = new Session();
        $session->invalidate();
        
        $entityManager->remove($user);
        $entityManager->flush();
        
        $this->addFlash('deleted','Votre compte a été supprimé.');
        return $this->redirectToRoute("app_register");
    }
}
