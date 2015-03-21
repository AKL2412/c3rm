<?php 
namespace  Crm\CoreBundle\Echecconnexion;
use Crm\AdminBundle\Entity\AuthFail;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;
class Echecconnexion{

	protected $em;

	public function setEntityManager(ObjectManager $em){
	   $this->em = $em;
	}

	public function onKernelLogFail(AuthenticationFailureEvent $event){
		$request = $event->getAuthenticationToken();
		$af = new AuthFail();
		$af->setLogin("aby");
		$af->setPass('aby');
		$this->em->persist($af);
		print_r($request);
	}
}