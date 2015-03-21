<?php 

namespace  Crm\CoreBundle\User;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Doctrine\UserManager;
class Username{

	protected $em;
	protected $repo;
	protected $fos;

	public function __construct(ObjectManager $em,UserManager $usermanager){
	   $this->em = $em;
	   $this->repo = $em->getRepository('CrmAdminBundle:Utilisateur');
	   $this->fos=$usermanager;
	}

	public function repoUtilisateur(){
		return $this->repo;
	}
	public function utilisateurByUser($username){
		//$userManager = $this->container->get('fos_user.user_manager');

		$user = $this->fos->findUserByUsername($username);
		$utili = $this->repo->findOneByCompte($user);
		if($utili != null){
			return $utili->getPrenom().' <span class="nom">'.$utili->getNom().'</span>';
		}else{
			return $username;
		}
		
	}
	public function generateUsername($utilisateur){
		$username = "inconnu";
		$profil = $utilisateur->getProfil();
		$nombre =0;
		foreach ($this->repo->findBy(array("profil"=>$profil),array(),null,0) as $key => $uti) {
			if($uti->getCompte() !== null)
				$nombre += 1;
		}
		$nombre += 1;
		$extension = $nombre;
		if($nombre < 10 )
			$extension = "000".$nombre;
		elseif($nombre < 100 )
			$extension = "00".$nombre;
		elseif($nombre < 1000 )
			$extension = "0".$nombre;
		$username = $profil->getAbrv().$extension;

		return $username;
	}
}