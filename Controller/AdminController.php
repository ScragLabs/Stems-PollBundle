<?php

namespace Stems\PollBundle\Controller;

use Stems\CoreBundle\Controller\BaseAdminController,
	Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter,
	Symfony\Component\HttpFoundation\RedirectResponse,
	Symfony\Component\HttpFoundation\Response,
	Symfony\Component\HttpFoundation\Request;

class AdminController extends BaseAdminController
{
	protected $home = 'stems_admin_poll_overview';

	/**
	 * Render the dialogue for the module's dashboard entry in the admin panel
	 */
	public function dashboardAction()
	{
		return $this->render('StemsPollBundle:Admin:dashboard.html.twig', array());
	}

	/**
	 * Polls overview page showing all polls
	 */
	public function indexAction()
	{		
		// Get all polls
		$em     = $this->getDoctrine()->getEntityManager();
		$polls = $em->getRepository('StemsPollBundle:Poll')->findByDeleted(false);

		return $this->render('StemsPollBundle:Admin:index.html.twig', array(
			'polls' 	=> $polls,
		));
	}
}