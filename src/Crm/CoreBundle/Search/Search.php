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

		$data['q'] = trim($data['q']);
		if(strlen($data['q']) > 0 ){
			if(in_array("ROLE_ADMIN", $data['roles']) || in_array("ROLE_SUPER_ADMIN", $data['roles'])){
				
				$data['User'] = "Administrateur";
				$query = $this->em->createQuery("SELECT DISTINCT t FROM CrmAdminBundle:Utilisateur t WHERE  (t.nom LIKE :nom OR t.prenom LIKE :prenom OR CONCAT(t.nom, CONCAT(' ',t.prenom)) LIKE :nomprenom OR CONCAT(t.prenom, CONCAT(' ',t.nom)) LIKE :prenomnom ) and t.id != :moi");
	            $query->setParameters(array(
	            	"nom"=>"%".$data['q']."%",
	            	"prenom"=>"%".$data['q']."%",
	            	"moi"=>$data['utilisateur']->getId(),
	            	"nomprenom"=>"%".$data['q']."%",
	            	"prenomnom"=>"%".$data['q']."%",
	            	));
	            $data['utilisateurs'] = $query->getResult();

			}elseif(in_array("ROLE_SUP", $data['roles'])){
				$data['User'] = "Superviseur";
				$query = $this->em->createQuery("SELECT DISTINCT u FROM CrmAdminBundle:Utilisateur u WHERE u.id IN (SELECT t.id FROM CrmAdminBundle:SupUtilisateur s JOIN s.utilisateur t  WHERE (t.nom LIKE :nom OR t.prenom LIKE :prenom OR CONCAT(t.nom, CONCAT(' ',t.prenom)) LIKE :nomprenom OR CONCAT(t.prenom, CONCAT(' ',t.nom)) LIKE :prenomnom ) and s.superviseur = :sup)");
	            $query->setParameters(array(
	            	"sup"=>$data['utilisateur'],
	            	"nom"=>"%".$data['q']."%",
	            	"prenom"=>"%".$data['q']."%",
	            	"nomprenom"=>"%".$data['q']."%",
	            	"prenomnom"=>"%".$data['q']."%",
	            	));
	            $data['utilisateurs'] = $query->getResult();
			}
		}

		return $data;
	}
	
}