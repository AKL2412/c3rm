<?php

namespace Crm\UserBundle\Authentication;

use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Crm\AdminBundle\Entity\Log;
use Doctrine\Common\Persistence\ObjectManager;

class LogoutSuccessHandler implements LogoutSuccessHandlerInterface
{
	
	protected $router;
	protected $em;
	protected $repo;
	public function __construct(ObjectManager $em,Router $router)
	{
		$this->router = $router;
		$this->em = $em;
		$this->repo = $em->getRepository('CrmAdminBundle:Log');
	}
	
	public function onLogoutSuccess(Request $request)
	{
		// redirect the user to where they were before the login process begun.
		$referer_url = $request->headers->get('referer');

		$user = $_SESSION['authen'];

		$logs = $this->repo->findBy(
				array("user"=>$user,
					"deconnectedat"=>null),array(),null,0
				);
			foreach ($logs as $key => $log) {
				$log->setDeconnectedat(new \DateTime());
				$log->setConnected(false);

			}

		$this->em->flush();

		$response = new RedirectResponse($referer_url);		
		return $response;
	}
	
}