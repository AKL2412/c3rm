<?php

namespace Crm\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function updateAction()
    {
    	$repo = $this->getDoctrine()->getManager()
    	->getRepository('CrmAdminBundle:Utilisateur');
    	$user = $this->getUser();
    	$provider = $this->container->get('fos_message.provider');
        $messages = array();
        
        foreach ($provider->getInboxThreads()as $key => $thread) {
            
            if(!$thread->isReadByParticipant($user)){

                foreach ($thread->getMessages() as $key => $mess) {
                            
                    if(!$mess->isReadByParticipant($user)){
                        
                        $um = $repo->findOneByCompte($mess->getSender());
                        
                        $p = $repo->findOneByCompte($thread->getCreatedBy());
                                
                            $messages[]= array(
                                'thread'=>$thread,
                                'person'=>$p,
                                'message'=>$mess,
                                'sender'=>$um
                            );
                    }
                }
                       
            }
        }
        return $this->render('CrmCoreBundle:Default:index.html.twig', array('messages' => $messages
        	));
    }
    public function contactAction(){

    	$user = $this->getUser();
    	$em = $this->getDoctrine()->getManager();
    	$repo = $em->getRepository('CrmAdminBundle:Utilisateur');
    	$utilisateur = $repo->findOneByCompte($user);
    	$contacts = array();

    	if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
			
			$query = $em->createQuery('SELECT u FROM CrmAdminBundle:Utilisateur u WHERE u.compte is NOT NULL');
			$contacts = $query->getResult();
    	}elseif ($this->get('security.context')->isGranted('ROLE_SUP')){
            $query = $em->createQuery(' SELECT t FROM CrmAdminBundle:Utilisateur t WHERE t.id IN (SELECT u.id FROM CrmAdminBundle:SupUtilisateur s JOIN s.utilisateur u  WHERE u.compte is NOT NULL and s.superviseur = :sup)');
            $query->setParameter("sup",$utilisateur);
            $contacts = $query->getResult();
             // echo "<pre>";
             // print_r($contacts);
             // echo "</pre>";
             // die('');
        }
    	return $this->render('CrmCoreBundle:Default:contacts.html.twig', array('contacts' => $contacts
        	));
    }
}
