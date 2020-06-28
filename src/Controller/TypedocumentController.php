<?php

namespace App\Controller;

use App\Entity\TypeDocument;
use App\Form\TypedocumentType;
use App\Repository\TypeDocumentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TypedocumentController extends AbstractController
{
  /**
   * * @var DepartementRepository
   */
    private $repository;


    public function __construct(TypeDocumentRepository $repository)
    {
        $this->repository=$repository;
    
        
    }
    
    /**
     * @Route("/Tdocument", name="Tdocument_index")
     */
    public function index(): Response
    {
        $tdocument=$this->repository->findAll();
        return $this->render('typedocument/index.html.twig',compact('tdocument'));
    }

     /**
     * @Route("Tdocument/add",name="td_add")
     */
    public function add(Request $request)
    {
        $typedocument =new TypeDocument();
        $form = $this->createForm(TypedocumentType::class, $typedocument);
        $form ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $em->persist($typedocument);
            $em->flush();
             return $this->redirectToRoute('Tdocument_index');
          
         }
         return $this->render('typedocument/add.html.twig', [
            'typedocument'=> $typedocument,
            'form' => $form->createView(),
        ]);

    }
}
