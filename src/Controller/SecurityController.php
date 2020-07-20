<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    /**
     *  @var UserRepository
     */
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 
     * @Route("/login" , name="login")
     */

    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render(
            'security/login.html.twig',
            [
                'last_username' => $lastUsername,
                'error' => $error
            ]

        );
    }

    /**
     * @Route("login/add",name="login_add")
     */

    public function add(Request $request,UserPasswordEncoderInterface $encoder)
    {
        $user =new User();
        $form=$this->createForm(UserType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
           
           $em=$this->getDoctrine()->getManager();
           $em->persist($user);
           $em->flush();
           $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);
            $em->flush();
           $this->addFlash('success','Bien ajoutè avec succès ');
            return $this->redirectToRoute('listeUtilisateur');
         
        }
        return $this->render('security/add.html.twig', [
           'user'=> $user,
           'form' => $form->createView(),
       ]);

    }

    /**
     * @Route("user\list" , name="listeUtilisateur")
     */

     public function liste()
     {
        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository('App:user')->findAll();
        return $this->render('security/list.html.twig', array(
            'user'=>$user
             ));

        

     }


    /**
     * @Route("user/Update/{id}",name="Modifuser")
     */
    public function UpdateAction(Request $request, User $user)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Bien Modifier');
            return $this->redirectToRoute('listeUtilisateur');
        }

        return $this->render('security/edit.html.twig', array(
            'user'=>$user,
            "form"=>$form->createView()
        ));
    }


    /**
     * @Route("user/list/{id}",name="deleteuser")
     */
    public function Delete(Request $request, User $user)
    {
        if($this->isCsrfTokenValid('delete'.$user->getId(), $request->get('_token')))
        {
            $em=$this->getDoctrine()->getManager();

            $em->remove($user);
            $em->flush();
            $this->addFlash('success','Bien supprimè avec succès ');
        }

        return $this->redirectToRoute('listeUtilisateur');
       

        
    }

}
