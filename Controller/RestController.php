<?php

namespace Stems\PollBundle\Controller;

use Stems\CoreBundle\Controller\BaseRestController;

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
		$ip = $request->getClientIp();
		
		// See if a vote has already been for this poll from the requesting IP
		$em     = $this->getDoctrine()->getManager();
		$choice = $em->getRepository('StemsPollBundle:Poll')->find($id);

		// Check that the choice exists and the poll it belongs to is active
		if (!$choice || !$choice->getPoll()->getActive()) {
			return $this->error('Invalid voting choice.', true)->sendResponse();
		}

		// favourites can be null if none exist already
		$favourites = $profile->getSocialFeeds() ? $profile->getSocialFeeds() : array();

		// add the feed to the user's favourites if it doesn't already exist
		if (!in_array($id, $favourites)) {

			// save the feed as a favourite
			$favourites[] = $id;
			$profile->setSocialFeeds($favourites);
			$em->persist($profile);
			$em->flush();

			return $this->success($feed->getName().' has been added to your social circle.', true)->sendResponse();

		} else {

			// notify that it's already a favourite
			return $this->error($feed->getName().' is already in your social circle!', true)->sendResponse();
		}	
	}
}
