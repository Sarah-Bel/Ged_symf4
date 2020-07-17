<?php

namespace App\Controller;

use App\Entity\Document;
use App\Form\DocumentType;
use App\Repository\DocumentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DocumentController extends AbstractController
{

    /**
    *  @var TypeDocumentRepository
    */
    private $repository;

  public function __construct(DocumentRepository $repository)
  {
      $this->repository=$repository;
  }

    /**
     * @Route("/", name="document_index")
     */
    public function index(): Response
    {
        $document=$this->repository->findAll();
        return $this->render('document/index.html.twig',compact('document'));
    }

    /**
     * @Route("document/add",name="document_add")
     */

     public function add(Request $request)
     {
         $Document =new Document();
         $form=$this->createForm(DocumentType::class,$Document);
         $form->handleRequest($request);
         if($form->isSubmitted() && $form->isValid())
         {
            
            $em=$this->getDoctrine()->getManager();
            $em->persist($Document);
            $em->flush();
            $this->addFlash('success','Bien ajoutè avec succès ');
             return $this->redirectToRoute('document_index');
          
         }
         return $this->render('document/add.html.twig', [
            'Document'=> $Document,
            'form' => $form->createView(),
        ]);

     }
    
     /**
     * @Route("document/edit/{id}" , name="document_edite")
     */

    public function edit(Document $document,Request $request)
    {
      
       $form =$this->createForm(DocumentType::class,$document);
       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
               
           $em=$this->getDoctrine()->getManager();
          
           $em->flush();
           $this->addFlash('success','Bien modifié avec succès ');
           return $this->redirectToRoute('document_index');
       }
       
       return $this->render('document/edit.html.twig', [
           'document'=> $document,
           'form' => $form->createView(),
       ]);
    }

    /**
     *
     * @Route("/{id}", name="document_delete", methods="DELETE")
     */
    public function Delete(Document $document,Request $request)
    {
        if($this->isCsrfTokenValid('delete'.$document->getId(), $request->get('_token')))
        {
            $em=$this->getDoctrine()->getManager();

            $em->remove($document);
            $em->flush();
            $this->addFlash('success','Bien supprimé avec succès ');
        }
        return $this->redirectToRoute('document_index');

    } 
 
 
}
