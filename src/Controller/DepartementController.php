<?php

namespace App\Controller;

use App\Entity\Departement;
use App\Form\DepartementType;
use App\Repository\DepartementRepository;
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
            $departement->setCreatedAt(new \DateTime());
            $em=$this->getDoctrine()->getManager();
           
            $em->flush();
             $this->addFlash('success','Bien modifiè avec succès ');

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
            $this->addFlash('success','Bien ajoutè avec succès ');
             return $this->redirectToRoute('departement_index');
          
         }
         return $this->render('departement/add.html.twig', [
            'departement'=> $departement,
            'form' => $form->createView(),
        ]);

    }

      /**
     *
     * @Route("departement/{id}", name="departement_delete", methods="DELETE")
     */
    public function Delete(Departement $departement,Request $request)
    {
        if($this->isCsrfTokenValid('delete'.$departement->getId(), $request->get('_token')))
        {
            $em=$this->getDoctrine()->getManager();

            $em->remove($departement);
            $em->flush();
            $this->addFlash('success','Bien supprimè avec succès ');
        }
        return $this->redirectToRoute('departement_index');

    } 
}
