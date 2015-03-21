<?php 
namespace Crm\CoreBundle\Search;
use Crm\CoreBundle\Pagination\Pagination;
use Doctrine\Common\Persistence\ObjectManager;
class Data{


	protected $em;
	protected $pagination;

	public function __contruct(Pagination $pagination, ObjectManager $em){
	   $this->pagination = $pagination;
	   $this->em = $em;
	}
	/**
	*	Pour recuperer les agents d'un superviseur
	*/
	public function mesAgents($utilisateur){
		$agents = array();

		foreach ($utilisateur->getSupUtilisateurs() as $key => $supagent) {

			if(!$supagent->getTrash() && $supagent->getActive() 
				&& $supagent->getProfil()->getCode() == 'ROLE_AGENT'
				)
				$agents[] = $supagent->getUtilisateur();
		}
		return $agents;
	}
	/**
	*	Pour recuperer les confirmateurs d'un superviseur
	*/
	public function mesConfirmateurs($utilisateur){
		$agents = array();

		foreach ($utilisateur->getSupUtilisateurs() as $key => $supagent) {

			if(!$supagent->getTrash() && $supagent->getActive() 
				&& $supagent->getProfil()->getCode() == 'ROLE_CONF'
				)
				$agents[] = $supagent->getUtilisateur();
		}
		return $agents;
	}

	/**
	*	Pour recuperer les agents affectable d'un superviseur
	*/
	public function affectableAgents($utilisateur,$p,$em,$pagination,$inf,$url){
		$limit = 12;
		$uAgents = $this->mesAgents($utilisateur);
		if(count($uAgents) == 0) $uAgents = array(0);

		$profil = $em->getRepository('CrmAdminBundle:Profil')->findOneByCode($p);
		$query = $em->createQuery('SELECT u FROM CrmAdminBundle:Utilisateur u WHERE u.profil = :profil and u NOT IN (:array)');
		$query->setParameters(array(
			"profil"=>$profil,
			"array"=>$uAgents));
		$id = ($inf-1)*$limit;
            if($id < 0)
                $id = 0;
		$query->setFirstResult($id)->setMaxResults($limit);

		$agents = $query->getResult();

		return array(
			"agents"=>$agents,
			"pagination"=>$this->affectableAgentsPagination($utilisateur,$em,$pagination,$inf,$url)
			);
	}
	private function affectableAgentsPagination($utilisateur,$em,$pagination,$page,$url){
		
		$limit = 12;
		$uAgents = $this->mesAgents($utilisateur);
		if(count($uAgents) == 0) $uAgents = array(0);
		$profil = $em->getRepository('CrmAdminBundle:Profil')->findOneByCode('ROLE_AGENT');
		$query = $em->createQuery('SELECT u FROM CrmAdminBundle:Utilisateur u WHERE u.profil = :profil and u NOT IN (:array)');
		$query->setParameters(array(
			"profil"=>$profil,
			"array"=>$uAgents));
		$total = count($query->getResult());
		$last = round($total/$limit);
            if(round($total/$limit) < ($total/$limit))
                $last+=1;
        $paginations = array(
                "page"=>$page,
                "total"=>$total,
                "last"=>$last);
        return $pagination->paginer($paginations,$url);
	}
}