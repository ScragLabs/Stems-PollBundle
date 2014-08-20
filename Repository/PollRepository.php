<?php

namespace Stems\PollBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PollRepository extends EntityRepository
{
	/**
	 * Check if the given IP address has already voted on this poll
	 *
	 * @param  string 	$ip 		The IP address of the requesting user
	 * @param  Poll 	$poll 		The poll entity that we need to check against
	 * @return bool 				Whether the IP has already voted
	 */
	public function checkIpAlreadyVoted($ip, $poll)
	{
		// Start the query builder
		$qb = $this->getEntityManager()->createQueryBuilder();
		$qb->addSelect('vote');
		$qb->from('StemsPollBundle:Vote', 'vote');
		$qb->leftJoin('vote.choice', 'choice');
		$qb->leftJoin('choice.poll', 'poll');	
		
		// Check for the IP in the votes for the poll
		$qb->where('poll.id = :id');
		$qb->setParameter('id', $poll);
		$qb->andWhere('vote.ip = :ip');
		$qb->setParameter('ip', $ip);

		// True if there's one or more results
		if (count($qb->getQuery()->getResult()) > 0) {
			return true;
		} else {
			return false;
		}
	}
}