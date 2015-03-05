<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Prediction;
use AppBundle\Entity\Race;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

/**
 * The prediction repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class PredictionRepository extends EntityRepository implements PredictionRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findByRaceAndUser(Race $race, User $user)
    {
        return $this->findOneBy(['race' => $race, 'user' => $user]);
    }

    /**
     * {@inheritdoc}
     */
    public function remove(Prediction $prediction)
    {
        $this->_em->remove($prediction);
        $this->_em->flush();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function save(Prediction $prediction)
    {
        $this->_em->persist($prediction);
        $this->_em->flush();

        return $this;
    }
}
