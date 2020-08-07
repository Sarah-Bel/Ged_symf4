<?php

namespace App\Controller;

use App\Entity\Document;
use App\Entity\User;
use App\Form\DocumentType;
use App\Repository\DocumentRepository;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class DocumentController extends AbstractController
{

    /**
     *  @var DocumentRepository
     */
    private $repository;

    public function __construct(DocumentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/doc", name="document_index")
     */
    public function index(): Response
    {
        
        $document = $this->repository->findAll();
       
        return $this->render('document/index.html.twig', [
            'document' => $document,
           
        ]);
        

      
    }

    /**
     * @Route("document/add",name="document_add")
     */

    public function add(Request $request)
    {
        $Document = new Document();
        $form = $this->createForm(DocumentType::class, $Document);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
       
        $user = $this->getUser();
         
            /** @var UploadedFile $ImageFile */
            $ImageFile = $form->get('ImageFile')->getData();            
            if ($ImageFile) {
              
                $newFilename = md5(uniqid()) . '.' . $ImageFile->guessExtension();  
                try {
                    $ImageFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) { }

                $Document->setImageFile($newFilename);
            }

            $em = $this->getDoctrine()->getManager();
            
            $Document->setCreatedby($user);
             
            $em->persist($Document);
            $em->flush();
            $this->addFlash('success', 'Bien ajoutè avec succès ');
            return $this->redirectToRoute('document_index');
        }
        return $this->render('document/add.html.twig', [
            'Document' => $Document,
                
            'form' => $form->createView(),
           
            
        ]);
    }

    /**
     * @Route("document/edit/{id}" , name="document_edite")
     */

    public function edit(Document $document, Request $request, CacheManager $cacheManager, UploaderHelper $helper)
    {

        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
             /** @var UploadedFile $ImageFile */
             $ImageFile = $form->get('ImageFile')->getData();
             $document->setUpdatedAt(new \DateTime());
            
             if ($ImageFile) {
               
                 $newFilename = md5(uniqid()) . '.' . $ImageFile->guessExtension();  
                 try {
                     $ImageFile->move(
                         $this->getParameter('brochures_directory'),
                         $newFilename
                     );
                 } catch (FileException $e) { }
 
 
                 $document->setImageFile($newFilename);
             }




            $em = $this->getDoctrine()->getManager();
             
            $document->setEditby($user);
            
            
            
            $em->flush();
            $this->addFlash('success', 'Bien modifié avec succès ');
            return $this->redirectToRoute('document_index');
        }

        return $this->render('document/edit.html.twig', [
            'document' => $document,
            'form' => $form->createView(),
        ]);
    }

    /**
     *
     * @Route("/{id}", name="document_delete", methods="DELETE")
     */
    public function Delete(Document $document, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $document->getId(), $request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($document);
            $em->flush();
            $this->addFlash('success', 'Bien supprimé avec succès ');
        }
        return $this->redirectToRoute('document_index');
    }

  /**
     * @Route("/", name="totalDoc")
     */
    public function total() :Response
    {   if ($this->isGranted('ROLE_ADMIN')){
        $total = $this->repository->findTotatldoc();    
        $totalparjrs = $this->repository->findDocJrs(new \DateTime);
        $totalEtude = $this->repository->findDocTypeEtude();
        $totalRC = $this->repository->findDocTypeRC();
        $totalPV = $this->repository->findDocTypePV();
        $totalFacture = $this->repository->findDocTypeFacture();
        $totalparmois = $this->repository->findDocparMois();
        $totalparannees = $this->repository->findDocparAnnees();
        
        return $this->render('document/stati.html.twig',[
        'total'=>$total,
        'totalparjrs' =>$totalparjrs,
        'totalEtude' =>$totalEtude,
        'totalRC' =>$totalRC,
        'totalPV' =>$totalPV,
        'totalFacture' =>$totalFacture,
        'totalparmois'=>$totalparmois,
        'totalparannees' =>$totalparannees,
         ] );
        }

        else
        {
            return $this->redirectToRoute('document_index');
        }
    }


}