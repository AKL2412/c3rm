<?php 
namespace  Crm\CoreBundle\Connected;
use Crm\AdminBundle\Entity\Log;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;
class Connected{

	protected $em;
	protected $repo;
	public function setEntityManager(ObjectManager $em){
	   $this->em = $em;
	   $this->repo = $em->getRepository('CrmAdminBundle:Log');
	}

	public function onKernelLogOk(AuthenticationEvent $event){
		$request = $event->getAuthenticationToken();
		$user = $request->getUser();
		if(gettype($user) != 'string'){
			$logs = $this->repo->findBy(
				array("user"=>$user,
					"deconnectedat"=>null),array(),null,0
				);
			foreach ($logs as $key => $log) {
				$log->setDeconnectedat(new \DateTime());
				$log->setConnected(false);
			}
			$af = new Log();
			$af->setUser($user);
			$this->em->persist($af);
			$this->em->flush();
			$_SESSION['authen'] = $user;
			$_SESSION['position'] = array();
		}else{
			$_SESSION['authen']= null;
		}
	}
}