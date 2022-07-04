<?php

namespace App\Controller;

use App\Entity\Manga;
use App\Form\MangaType;
use App\Entity\UserManga;
use App\Form\UserMangaType;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MangaController extends AbstractController
{
    
    /**
     * @Route("/", name="app_manga")
     */
    public function index(Request $request,ManagerRegistry $doctrine,  PaginatorInterface $paginator): Response
    {
        $mangas = $doctrine->getRepository(Manga::class)-> findall();
        


        return $this->render('manga/index.html.twig', [
            'mangas' => $mangas,
        ]);
    }
    /**
     * @Route("/manga/tri/A-Z", name="alphabet_manga")
     */
    public function alphabet(Request $request,ManagerRegistry $doctrine): Response
    {
        $mangas = $doctrine->getRepository(Manga::class)-> findManga();
        
        return $this->render('manga/alphabet.html.twig', [
            'mangas' => $mangas,
        ]);
    }
    /**      
     * @Route("/manga/tri/note", name="note_manga")
     */
    public function note(Request $request,ManagerRegistry $doctrine){

        $mangas = $doctrine->getRepository(Manga::class)-> findall();
        


        return $this->render('manga/note.html.twig', [
            'mangas' => $mangas,
        ]);
    }

    /**
     * 
     * @Route("/manga/add", name="add_manga")
     * @Route("/manga/update/{id}", name="update_manga")
     */
    public function add(ManagerRegistry $doctrine, Manga $mangas = null, Request $request): Response {
        
        if(!$mangas){
            $mangas = new Manga();
        }

        $entityManager = $doctrine->getManager();
        $form = $this->createForm(MangaType::class, $mangas);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $mangas = $form->getData();
            $entityManager->persist($mangas);
            $entityManager->flush();

            return $this->redirectToRoute('app_manga');
        }

        return $this->render('manga/add.html.twig', [
            'formManga' =>$form->createView()
        ]);
    }
    /**
     * @Route("/manga/{id}", name="show_manga")
     */
    public function show(Manga $manga,UserManga $userManga = null, ManagerRegistry $doctrine, Request $request): Response{

        $entityManager = $doctrine->getManager();

        // permet de préparer le form pour la note
        $form = $this->createForm(UserMangaType::class, $userManga);

        $form->handleRequest($request);

        // moyen de mettre 1 note et la faire rentrer en base de donnée
        if($form->isSubmitted() && $form->isValid()) {
            $userManga = new UserManga();
            $user = $this -> getUser();
            $userManga -> setUser($user)
                        -> setManga($manga)
                        -> setNote($form->get('note')->getData());
            $entityManager->persist($userManga);
            $entityManager->flush();
            
            //regirige vers la page avec les manga
            return $this->redirectToRoute('show_manga',[
                'id' => $manga ->getId()
            ]);
        }

        return $this->render('manga/show.html.twig',[
            'manga'=>$manga,
            'formManga' =>$form->createView(),
            'userManga'=>$userManga
        ]);
    }
    /**
     * @Route("/mentions", name="app_mentions")
     */
    public function mentions(){

        return $this->render('mentions.html.twig');
    }
       /**
     * @Route("/supp_manga/{id}", name="del_manga")
     */
    public function suppManga(ManagerRegistry $doctrine, Manga $manga): Response
    {
       
        $entityManager = $doctrine->getManager();
        
        $entityManager->remove($manga);
        $entityManager->flush();
        
        $this->addFlash('deleted','Votre Manga a été supprimé.');
        return $this->redirectToRoute("app_manga");
    }
}
