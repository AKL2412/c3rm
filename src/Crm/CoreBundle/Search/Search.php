<?php 
namespace  Crm\CoreBundle\Search;
use Crm\AdminBundle\Entity\AuthFail;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;
class Search{

	protected $em;

	public function setEntityManager(ObjectManager $em){
	   $this->em = $em;
	}

	public function search(array $data){
		if(in_array("ROLE_ADMIN", $data['roles'])){
			$data['User'] = "Administrateur";
		}elseif(in_array("ROLE_SUP", $data['roles'])){
			$data['User'] = "SUperviseur";
		}

		return $data;
	}
	
}