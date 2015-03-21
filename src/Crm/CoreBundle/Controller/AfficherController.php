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
        return $this->render('CrmCoreBundle:Afficher:agent.html.twig', array('utilisateur' => $utilisateur));
    }
    public function superviseurAction($utilisateur)
    {
        return $this->render('CrmCoreBundle:Afficher:superviseur.html.twig', array('utilisateur' => $utilisateur));
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