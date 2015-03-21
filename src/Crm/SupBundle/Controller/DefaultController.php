<?php

namespace Crm\SupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
/**
* @Security("has_role('ROLE_SUP')")
*/
class DefaultController extends Controller
{
    public function indexAction()
    {
        $utilisateur = $this->getDoctrine()->getManager()
        ->getRepository('CrmAdminBundle:Utilisateur')
        ->findOneByCompte($this->getUser());
        return $this->render('CrmSupBundle:Default:index.html.twig', array(
            'utilisateur' => $utilisateur));
    }
    public function utilisateursAction(Request $request){

        $nombreUtilisateur = 5;

        //Doctrine manager
        $em =$this->getDoctrine()->getManager();


        // Repositories
        $repoProfil = $em->getRepository('CrmAdminBundle:Profil');
        $repo = $em->getRepository('CrmAdminBundle:Utilisateur');
        $reposp = $em->getRepository('CrmAdminBundle:SupUtilisateur');

        //les profils
        $lesProfils = $repoProfil->findAll();

        // Profil request
        $profil = "Tous les profils";

        $criteres = array(
                    "trash"=>false,
                    "active"=>true,
                    );

        $utilisateurs = array();
        $page = 1;
        $pagination =array();
        
        if($request->query->get('page')!==null && !empty($request->query->get('page'))){
            $page = $request->query->get('page');
        }


        if($request->query->get('profil')!==null && !empty($request->query->get('profil'))){
            $profil = $request->query->get('profil');

            $profilDB = $repoProfil->findOneByNom($profil);
            if($profilDB != null){
                $criteres = array(
                    "trash"=>false,
                    "active"=>true,
                    "profil"=>$profilDB
                    );
            }

        }
        
        
        
        $url = $this->generateUrl('crm_sup_utilisateurs',array("profil"=>$profil));
        $paginationS = $this->get('crm_core.pagination');
        

    	if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {

            $total = count($repo->findBy(
                $criteres,
                array(),null,0
                ));
            $last = round($total/$nombreUtilisateur);
            if(round($total/$nombreUtilisateur) < ($total/$nombreUtilisateur))
                $last+=1;
            if ($page > $total) {
                $page = $last;
            }
            $pagination = array(
                "page"=>$page,
                "total"=>$total,
                "last"=>$last);
            $id = ($page-1)*$nombreUtilisateur;
            if($id < 0)
                $id = 0;
    		$utilisateurs = $repo->findBy(
                $criteres,
                array("nom"=>"asc","prenom"=>"asc","id"=>"desc"),
                $nombreUtilisateur,
                $id
                );
    	}elseif ($this->get('security.context')->isGranted('ROLE_SUP')){
            $lesProfils = array();
            $lesProfils[] = $repoProfil->findOneByCode('ROLE_AGENT');
            $lesProfils[] = $repoProfil->findOneByCode('ROLE_CONF');

            $me = $repo->findOneByCompte($this->getUser());

            $criteres["superviseur"] = $me;
            $total = count($reposp->findBy(
                $criteres,
                array(),null,0
                ));
            $last = round($total/$nombreUtilisateur);
            if(round($total/$nombreUtilisateur) < ($total/$nombreUtilisateur))
                $last+=1;
            if ($page > $total) {
                $page = $last;
            }
            $pagination = array(
                "page"=>$page,
                "total"=>$total,
                "last"=>$last);
            $id = ($page-1)*$nombreUtilisateur;
            if($id < 0)
                $id = 0;
            $temp = $reposp->findBy(
                $criteres,
                array("utilisateur"=>"desc"),
                $nombreUtilisateur,
                $id
                );
            $utilisateurs = array();
            foreach ($temp as $key => $sp) {
                $utilisateurs[] = $sp->getUtilisateur();
            }

        }

    	return $this->render('CrmSupBundle:Default:utilisateurs.html.twig', 
    		array(
    			'utilisateurs' => $utilisateurs,
    			"classe"=>"utilisateur",
                "pagination"=>$paginationS->paginer($pagination,$url),
                "profils"=>$lesProfils,
                "profil"=>$profil,
    			));
    }
    public function utilisateursvoirAction(Request $request,$id){
        $utilisateur = $this->getDoctrine()->getManager()->getRepository('CrmAdminBundle:Utilisateur')->find($id);
        if($utilisateur === null){
            throw new NotFoundHttpException("Erreur id : [".$id."]");
            
        }
        return $this->render('CrmSupBundle:Default:utilisateursvoir.html.twig', 
            array(
                'utilisateur' => $utilisateur,
                "classe"=>"utilisateur"
                ));
    }
}
