<?php

namespace Crm\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AfficherController extends Controller
{
    public function indexAction($name)
    {

        return $this->render('CrmCoreBundle:Afficher:index.html.twig', array('name' => $name));
    }
    public function agentAction($utilisateur)
    {
         $logs = $this->getDoctrine()->getManager()
            ->getRepository('CrmAdminBundle:Log')
            ->findBy(array("user"=>$utilisateur->getCompte()),array("connectedat"=>"DESC"),null,0);
        return $this->render('CrmCoreBundle:Afficher:agent.html.twig', array('utilisateur' => $utilisateur,"logs"=>$logs));
    }
    public function superviseurAction($utilisateur)
    {
        $logs = $this->getDoctrine()->getManager()
            ->getRepository('CrmAdminBundle:Log')
            ->findBy(array("user"=>$utilisateur->getCompte()),array("connectedat"=>"DESC"),null,0);

        return $this->render('CrmCoreBundle:Afficher:superviseur.html.twig', array('utilisateur' => $utilisateur,"logs"=>$logs));
    }
    public function confirmateurAction($utilisateur)
    {
        return $this->render('CrmCoreBundle:Afficher:confirmateur.html.twig', array('utilisateur' => $utilisateur));
    }
    public function administrateurAction($utilisateur)
    {
        return $this->render('CrmCoreBundle:Afficher:administrateur.html.twig', array('utilisateur' => $utilisateur));
    }
}