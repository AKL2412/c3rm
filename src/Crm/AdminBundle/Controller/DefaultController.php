<?php

namespace Crm\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Crm\AdminBundle\Entity\Utilisateur;
use Crm\AdminBundle\Entity\SupUtilisateur;
use Crm\AdminBundle\Form\UtilisateurType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
/**
* @Security("has_role('ROLE_ADMIN')")
*/
class DefaultController extends Controller
{
    public function indexAction()
    {
    	$session = new Session();
    	/*
    	echo "<h1>Name :".$session->get('name')."</h1>";
    	echo "<h1>Id [migrate]:".$session->migrate()."</h1>";
    	echo "<h1>Id [getId]:".$session->getId()."</h1>";
    	echo "<h1>name session:".$session->getName()."</h1>";
    	echo "<pre>";
    	print_r($session->all());
    	echo "</pre>";
    	//$session->invalidate();
    	die('Ok admin');
    	//*/
        
        //die('');
        // $this->getUser()->setRoles(array("ROLE_SUPER_ADMIN"));
        // $this->getDoctrine()->getManager()->flush();
        return $this->render('CrmAdminBundle:Default:index.html.twig', array("classe"=>"home","name"=>""));
    }

    public function ajouterutilisateurAction(Request $request){
    	$em = $this->getDoctrine()->getmanager();
    	$utilisateur = new Utilisateur();
        $file = new File("images/".$utilisateur->getImage());
        $utilisateur->setImage($file);
    	$form = $this->get('form.factory')->create(new UtilisateurType(),$utilisateur);
    	if($form->handleRequest($request)->isValid()){

            if($utilisateur->getImage() == null)  $utilisateur->setImage($file);
            else{
                $file = $form['image']->getData();
                if($file != null){
                    $extension = $file->guessExtension();
                    if (!$extension) {
                        $extension = 'jpg';
                    }
                    $nomImage = date('dmYHis').''.rand(1, 99999).'.'.$extension;
                    $file->move("images/", $nomImage);
                     $utilisateur->setImage(new File("images/".$nomImage));
                }
            }
    		$em->persist($utilisateur);
    		$em->flush();
             return $this->redirect($this->generateUrl('crm_sup_utilisateurs_voir_un',array("id"=>$utilisateur->getId())));
    	}
    	return $this->render('CrmAdminBundle:Default:ajouterutilisateur.html.twig', array("classe"=>"utilisateur","form"=>$form->createView(),"titre"=>'<i class="fa-plus-square fa"></i> Ajouter un nouvel utilisateur'));
    }

    public function modifierutilisateurAction(Request $request,$id){
        $em = $this->getDoctrine()->getmanager();

        $utilisateur = $this->getDoctrine()->getManager()->getRepository('CrmAdminBundle:Utilisateur')->find($id);
        if($utilisateur === null){
            throw new NotFoundHttpException("Erreur id : [".$id."]");
            
        }
        $file = new File($utilisateur->getImage());
        $utilisateur->setImage($file);
        $form = $this->get('form.factory')->create(new UtilisateurType(),$utilisateur);
        if($form->handleRequest($request)->isValid()){

            if($utilisateur->getImage() == null)  $utilisateur->setImage($file);
            else{
                $file = $form['image']->getData();
                if($file != null){
                    $extension = $file->guessExtension();
                    if (!$extension) {
                        $extension = 'jpg';
                    }
                    $nomImage = date('dmYHis').''.rand(1, 99999).'.'.$extension;
                    $file->move("images/", $nomImage);
                     $utilisateur->setImage(new File("images/".$nomImage));
                }
            }
            $em->flush();
            return $this->redirect($this->generateUrl('crm_sup_utilisateurs_voir_un',array("id"=>$utilisateur->getId())));
        }
        return $this->render('CrmAdminBundle:Default:ajouterutilisateur.html.twig', 
            array(
                "classe"=>"utilisateur",
                "form"=>$form->createView(),
                "titre"=>'<i class="fa-edit fa"></i> Modifier utilisateur [ '.$utilisateur->getNom()." ]"
                )
            );
    }

    public function creercompteutilisateurAction($id){

        $em = $this->getDoctrine()->getmanager();

        $utilisateur = $this->getDoctrine()->getManager()->getRepository('CrmAdminBundle:Utilisateur')->find($id);
        if($utilisateur === null){
            throw new NotFoundHttpException("Erreur id : [".$id."]");
            
        }
        $serviceUser = $this->get('crm_core.create.username');
        $username = $serviceUser->generateUsername($utilisateur);
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $user->setUsername($username);
        $user->setPlainPassword($username);
        $user->setEmail($utilisateur->getEmail());
        $user->setRoles(array($utilisateur->getProfil()->getCode()));
        $userManager->updateUser($user);

        $utilisateur->setCompte($user);
        $utilisateur->setMotpasse($username);
        $em->flush();
         return $this->redirect($this->generateUrl('crm_sup_utilisateurs_voir_un',array("id"=>$utilisateur->getId())));
        
    }
    public function activerDesactiverCompteAction($id){


        $em = $this->getDoctrine()->getmanager();

        $utilisateur = $this->getDoctrine()->getManager()->getRepository('CrmAdminBundle:Utilisateur')->find($id);
        if($utilisateur === null){
            throw new NotFoundHttpException("Erreur id : [".$id."]");
            
        }
        $user  = $utilisateur->getCompte();

        if($user->isEnabled())
            $user->setEnabled(false);
        else
            $user->setEnabled(true);
        $em->flush();
         return $this->redirect($this->generateUrl('crm_sup_utilisateurs_voir_un',array("id"=>$utilisateur->getId())));
    }

    public function affecterAgentUtilisateurAction($id,Request $request){
        $em = $this->getDoctrine()->getmanager();

        $repo =$em->getRepository('CrmAdminBundle:SupUtilisateur');
        $repoa =$em->getRepository('CrmAdminBundle:Utilisateur');
        $utilisateur = $repoa->find($id);
        if($utilisateur === null){
            throw new NotFoundHttpException("Erreur id : [".$id."]");
            
        }
        $url = $this->generateUrl('crm_admin_utilisateur_affecter_des_agents',array("id"=>$id,"profil"=>"agent"));

        if(!empty($request->request->all())){
            foreach ($request->request->all() as $key => $id) {
                $agent =$repoa->find($id);
                $supagent = $repo->findOneBy(
                array("superviseur"=>$utilisateur,
                    "utilisateur"=>$agent),
                array(),
                null,0);
               if($supagent !== null){
                    $supagent->setTrash(false);
                    $supagent->setActive(true);
               }else{
                 $supagent = new SupUtilisateur();
                 $supagent->setUtilisateur($agent);
                 $supagent->setSuperviseur($utilisateur);
                 $supagent->setProfil($agent->getProfil());
                 $em->persist($supagent);
               }
            }
            $em->flush();
            return $this->redirect($this->generateUrl('crm_admin_utilisateur_affecter_des_agents',array("id"=>$utilisateur->getId())));
        }
        $page = 1;
        if(!empty($request->query->get('page'))){
            $page = $request->query->get('page');
        }
        $data = $this->get('crm_core.search.utilisateur.data');
        $paginationS = $this->get('crm_core.pagination');
        $datas = $data->affectableAgents($utilisateur,"ROLE_AGENT",$em,$paginationS,$page,$url);
        return $this->render('CrmAdminBundle:Default:affecterAgentUtilisateur.html.twig', 
            array(
                "classe"=>"utilisateur",
                "utilisateur"=>$utilisateur,
                "agents"=>$datas['agents'],
                "pagination"=>$datas['pagination'],
                )
            );
    }
    public function affecterConfirmateurUtilisateurAction($id,Request $request){
        
         $em = $this->getDoctrine()->getmanager();

        $repo =$em->getRepository('CrmAdminBundle:SupUtilisateur');
        $repoa =$em->getRepository('CrmAdminBundle:Utilisateur');
        $utilisateur = $repoa->find($id);
        if($utilisateur === null){
            throw new NotFoundHttpException("Erreur id : [".$id."]");
        }
        $url = $this->generateUrl('crm_admin_utilisateur_affecter_des_confirmateurs',array("id"=>$id,"profil"=>"confirmateur"));

        if(!empty($request->request->all())){
            foreach ($request->request->all() as $key => $id) {
                $agent =$repoa->find($id);
                $supagent = $repo->findOneBy(
                array("superviseur"=>$utilisateur,
                    "utilisateur"=>$agent),
                array(),
                null,0);
               if($supagent !== null){
                    $supagent->setTrash(false);
                    $supagent->setActive(true);
               }else{
                 $supagent = new SupUtilisateur();
                 $supagent->setUtilisateur($agent);
                 $supagent->setSuperviseur($utilisateur);
                 $supagent->setProfil($agent->getProfil());
                 $em->persist($supagent);
               }
            }
            $em->flush();
            return $this->redirect($this->generateUrl('crm_admin_utilisateur_affecter_des_confirmateurs',array("id"=>$utilisateur->getId())));
        }
        $page = 1;
        if(!empty($request->query->get('page'))){
            $page = $request->query->get('page');
        }
        $data = $this->get('crm_core.search.utilisateur.data');
        $paginationS = $this->get('crm_core.pagination');
        $datas = $data->affectableAgents($utilisateur,"ROLE_CONF",$em,$paginationS,$page,$url);
        return $this->render('CrmAdminBundle:Default:affecterConfirmateurUtilisateur.html.twig', 
            array(
                "classe"=>"utilisateur",
                "utilisateur"=>$utilisateur,
                "agents"=>$datas['agents'],
                "pagination"=>$datas['pagination'],
                )
            );
    }
}
