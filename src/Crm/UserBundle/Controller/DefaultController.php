<?php

namespace Crm\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Exception\Exception;

class DefaultController extends Controller
{
    public function indexAction()
    {
    	$name = "Junior Aby";
    	$session = new Session();
		$session->set('name', 'Drak');
		if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
		
        	return $this->redirect($this->generateUrl('crm_admin_homepage'));

    	}elseif ($this->get('security.context')->isGranted('ROLE_SUP')) {
		
        	return $this->redirect($this->generateUrl('crm_sup_homepage'));

    	}else{

    	}
        return $this->redirect($this->generateUrl("fos_user_security_login"));
        //return $this->render('CrmUserBundle:Default:index.html.twig', array('name' => $name));
    }

    public function rechercheAction(Request $request){
        $q = $request->query->get('q');
        $serviceSearch = $this->get('crm_core.search');
        $user = $this->getUser();
       
        $utilisateur = $this->getDoctrine()->getManager()
            ->getRepository('CrmAdminBundle:Utilisateur')
            ->findOneByCompte($user);

         $data = array(
            "q"=>$q,
            "roles"=>$user->getRoles(),
            "utilisateur"=>$utilisateur,
            "utilisateurs"=>array(),
            "campagnes"=>array(),
            "clients"=>array(),
            "groupes"=>array(),
            "user"=>null
         );
         //
        return $this->render('CrmUserBundle:Default:search.html.twig',
        array(
        'data' => $serviceSearch->search($data)
        ));
    }

    public function traductionAction($name){
        return $this->render('CrmUserBundle:Default:traduction.html.twig',
        array(
        'name' => $name
        ));
    }

    public function positionAction(){

        if(array_key_exists('HTTP_REFERER', $_SERVER)){

            $urlPrevious = $_SERVER['HTTP_REFERER'];

            if (array_key_exists('position', $_SESSION)) {
               $positions = $_SESSION['position'];
               
            }else{
                $positions = array();
                
            }
            $positions[] = $urlPrevious;
            
            $_SESSION['position'] = $positions;

            // echo "<pre>";
            // print_r($positions);
            // echo "</pre>";

        }
         $msg= "";
        return new Response($msg);
    }
}
