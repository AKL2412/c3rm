<?php 
namespace Crm\CoreBundle\Role;
class Granted{

	public function isGranted($utilsateur,$role){

		//if($utilsateur->getCompte()!= null && in_array($role, $utilsateur->getCompte()->getRoles()))
		if($utilsateur->getProfil()->getCode() == trim($role))
			return true;
		return false;
	}
}