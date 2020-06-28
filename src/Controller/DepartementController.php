<?php

namespace App\Controller;

use App\Entity\Departement;
use App\Form\DepartementType;
use App\Repository\DepartementRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DepartementController extends AbstractController
{

    /**
     * @var DepartementRepository
     */
    private $repository;


    public function __construct(DepartementRepository $repository)
    {
        $this->repository=$repository;
    
        
    }

    
    /**
     * @Route("/departement", name="departement_index")
     */
    public function index(): Response
    {
        $departement=$this->repository->findAll();
        return $this->render('departement/index.html.twig',[
            'departement'=>$departement,
           
            ]);
    }

     /**
     * @Route("/Edit/{id}", name="departement_edit")
     */
    public function Edit(Request $request,Departement $departement)
    {
        
        $form = $this->createForm(DepartementType::class, $departement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
           
            $em->flush();

            return $this->redirectToRoute('departement_index');
        }

        return $this->render('departement/edit.html.twig', [
            'departement'=> $departement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/add",name="add")
     */
    public function add(Request $request)
    {
        $departement =new Departement();
        $form = $this->createForm(DepartementType::class, $departement);
        $form ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $em->persist($departement);
            $em->flush();
             return $this->redirectToRoute('departement_index');
          
         }
         return $this->render('departement/add.html.twig', [
            'departement'=> $departement,
            'form' => $form->createView(),
        ]);

    }
}
