<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Tests\Fixtures;

use AppBundle\Entity\User;

class UserFixture extends User
{
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
