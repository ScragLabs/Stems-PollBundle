<?php

namespace Stems\PollBundle\Controller;

use Stems\CoreBundle\Controller\BaseRestController,
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
		// Get the associated choice
		$em     = $this->getDoctrine()->getManager();
		$choice = $em->getRepository('StemsPollBundle:Poll')->find($id);

		// Check that the choice exists and the poll it belongs to is active
		if (!$choice || !$choice->getPoll()->getActive()) {
			return $this->error('Invalid voting choice.', true)->sendResponse();
		}

		// See if this IP has already votes on the poll
		$ip = $request->getClientIp();

		// Add the vote
		$vote = new Vote($choice, $ip);
		$em->persist($vote);
		$em->flush();

		return $this->success('Your vote has been registered!')->sendResponse();
	}
}
