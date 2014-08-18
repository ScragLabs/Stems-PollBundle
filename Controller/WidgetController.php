<?php

namespace Stems\PollBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\HttpFoundation\RedirectResponse,
	Symfony\Component\HttpFoundation\Response,
	Symfony\Component\HttpFoundation\Request;

class WidgetController extends Controller
{
	/**
	 * Renders a poll widget
	 *
	 * @param  integer 	$id 	The ID of the poll to render
	 */
	public function renderPollAction($id)
	{
		// get the latest blog post
		$em   = $this->getDoctrine()->getEntityManager();
		$poll = $em->getRepository('StemsPollBundle:Post')->find($id);

		return $this->render('StemsPollBundle:Widget:renderPoll.html.twig', array(
			'poll' 	=> $poll,
		));
	}
}
