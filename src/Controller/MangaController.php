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
        $mangas = $doctrine->getRepository(Manga::class)-> findAll();
        

        // $mangas = $paginator->paginate(
        //     $mangas,
        //     $request->query->getInt(key: 'page', default:1),
        //     limit: 10
        // );
        return $this->render('manga/index.html.twig', [
            'mangas' => $mangas,
        ]);
    }

    /**
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
        $form = $this->createForm(UserMangaType::class, $userManga);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $userManga = new UserManga();
            $user = $this -> getUser();
            $userManga -> setUser($user)
                        -> setManga($manga)
                        -> setNote($form->get('note')->getData());
            $entityManager->persist($userManga);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_manga');

        }

        return $this->render('manga/show.html.twig',[
            'manga'=>$manga,
            'formManga' =>$form->createView(),
            'userManga'=>$userManga
        ]);
    }
}
