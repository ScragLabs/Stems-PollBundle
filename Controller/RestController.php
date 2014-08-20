<?php

namespace Stems\PollBundle\Controller;

use Stems\CoreBundle\Controller\BaseRestController,
	Symfony\Component\HttpFoundation\RedirectResponse,
	Symfony\Component\HttpFoundation\JsonResponse,
	Symfony\Component\HttpFoundation\Request,
	Stems\PollBundle\Entity\Vote;

class RestController extends BaseRestController
{
	/**
	 * Vote for a specific option
	 *
	 * @param  integer 	$id 		The ID of the choice to voted for
	 * @param  Request  $request
	 */
	public function voteAction(Request $request, $id)
	{		
		// Get the associated choice and the voter's IP
		$em     = $this->getDoctrine()->getManager();
		$choice = $em->getRepository('StemsPollBundle:Choice')->find($id);
		$ip     = $request->getClientIp();

		// Check that the choice exists
		if (!$choice) {
			return $this->error('Invalid voting choice.', true)->sendResponse();
		}

		// Render the results html
		$html = $this->renderView('StemsPollBundle:Rest:results.html.twig', array(
			'poll' 	=> $choice->getPoll(),
		));

		// Check if voting is still allowed on the poll
		if (!$choice->getPoll()->getActive()) {
			return $this->addHtml($html)->error('Voting is closed for this poll.')->setCallback('votingComplete')->sendResponse();
		}

		// See if this IP has already voted on the poll
		if ($em->getRepository('StemsPollBundle:Poll')->checkIpAlreadyVoted($ip, $choice->getPoll())) {
			return $this->addHtml($html)->error('You\'ve already voted on this poll.')->setCallback('votingComplete')->sendResponse();
		}

		// Add the vote, ensuring we add it to the choice so the new totals add up
		$vote = new Vote($choice, $ip);
		$choice->addVote($vote);

		$em->persist($vote);
		$em->persist($choice);
		$em->flush();

		// Re-render the results html now that a vote has been added
		$html = $this->renderView('StemsPollBundle:Rest:results.html.twig', array(
			'poll' 	=> $choice->getPoll(),
		));	

		return $this->addHtml($html)->success('Thanks for voting!')->setCallback('votingComplete')->sendResponse();
	}
}
