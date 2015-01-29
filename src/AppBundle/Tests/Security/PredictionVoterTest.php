<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Tests\Security;

use AppBundle\Security\PredictionVoter;

class PredictionVoterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PredictionVoter
     */
    private $voter;

    protected function setUp()
    {
        $this->voter = new PredictionVoter();
    }

    protected function tearDown()
    {
        $this->voter = null;
    }

    public function testShowPrediction()
    {

        //$this->assertTrue($this->voter->vote());
    }
}
