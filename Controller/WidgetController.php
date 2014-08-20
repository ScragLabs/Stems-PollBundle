<?php

namespace Stems\PollBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\HttpFoundation\RedirectResponse,
	Symfony\Component\HttpFoundation\Response,
	Symfony\Component\HttpFoundation\Request;

class WidgetController extends Controller
{
	/**
	 * Renders a poll in a widget
	 *
	 * @param  integer 	$id 	The ID of the poll to render
	 * @param  string 	$ip 	The IP of the user
	 */
	public function renderPollAction($ip, $id)
	{

		// Get the requested poll
		$em   = $this->getDoctrine()->getEntityManager();
		$poll = $em->getRepository('StemsPollBundle:Poll')->find($id);

		// Check if the user has already voted from their IP
		$voted = $em->getRepository('StemsPollBundle:Poll')->checkIpAlreadyVoted($ip, $poll);

		return $this->render('StemsPollBundle:Widget:renderPoll.html.twig', array(
			'voted' => $voted,
			'poll' 	=> $poll,
		));
	}
}
