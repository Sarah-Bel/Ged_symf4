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
            $departement->setUpdatedAt(new \DateTime());
            $user = $this->getUser();
            $em=$this->getDoctrine()->getManager();
            $departement->setEditby($user);
           
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
            $user = $this->getUser();
            $em=$this->getDoctrine()->getManager();
            $departement->setCreatedby($user);
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
     * @Route("departement/{id}", name="departement_delete")
     */
    public function Delete(Departement $departement,Request $request)
    {
        if($this->isCsrfTokenValid('delete'.$departement->getId(), $request->get('_token')))
        {
            $typdoc=$departement->getTypeDocuments();
        
            foreach($typdoc as $key => $value)
            {
                if($value!==null)
                {
                $this->addFlash('supp','Vous ne pouvez pas le supprimer ce departement déja utilisé');
                return $this->redirectToRoute('departement_index');
                }
                
            }
            $em=$this->getDoctrine()->getManager();
        

            $em->remove($departement);
            $em->flush();
            $this->addFlash('success','Bien supprimè avec succès ');
        }
        return $this->redirectToRoute('departement_index');

    } 
}
