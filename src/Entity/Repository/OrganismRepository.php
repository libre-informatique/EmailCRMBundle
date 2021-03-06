<?php

/*
 * This file is part of the Blast Project package.
 *
 * Copyright (C) 2015-2017 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Librinfo\EmailCRMBundle\Entity\Repository;

use Librinfo\CRMBundle\Entity\Repository\OrganismRepository as BaseOrganismRepository;

class OrganismRepository extends BaseOrganismRepository
{
    /**
     * @param string $id the Organism id
     */
    public function getEmailMessagesQueryBuilder($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder('e');
        $qb->select('e')
            ->from('LibrinfoEmailBundle:Email', 'e')
            ->leftJoin('e.organizations', 'org')
            ->leftJoin('e.individuals', 'pos')
            ->where('org.id = :id')
            ->orWhere($qb->expr()->andX(
                $qb->expr()->eq('pos.individual', ':id'),
                $qb->expr()->isNotNull('pos.id')))
            ->setParameter('id', $id)
        ;

        return $qb;
    }
}
