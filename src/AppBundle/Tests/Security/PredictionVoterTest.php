<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Tests\Security;

use AppBundle\Entity\Prediction;
use AppBundle\Entity\Race;
use AppBundle\Entity\User;
use AppBundle\Security\PredictionVoter;
use AppBundle\Tests\Fixtures\UserFixture;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\User\UserInterface;

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

    public function testAdminCanShowOtherPredictionWhenTheRaceIsNotFinished()
    {
        $token = $this->getMockedToken($this->getUserLoggedAsAdmin(1));
        $prediction = new Prediction($this->getRace('Yesterday'), $this->getUserLoggedAsUser(2));

        $this->assertSame(VoterInterface::ACCESS_GRANTED, $this->voter->vote($token, $prediction, ['show']));
    }

    public function testUserCanShowHisPredictionWhenTheRaceIsNotFinished()
    {
        $user = $this->getUserLoggedAsUser(1);
        $token = $this->getMockedToken($user);
        $prediction = new Prediction($this->getRace('Yesterday'), $user);

        $this->assertSame(VoterInterface::ACCESS_GRANTED, $this->voter->vote($token, $prediction, ['show']));
    }

    public function testUserCanShowOtherPredictionWhenTheRaceInFinished()
    {
        $token = $this->getMockedToken($this->getUserLoggedAsUser(1));
        $prediction = new Prediction($this->getRace('Yesterday'), $this->getUserLoggedAsUser(2));

        $this->assertSame(VoterInterface::ACCESS_GRANTED, $this->voter->vote($token, $prediction, ['show']));
    }

    public function testUserCannotShowOtherPredictionWhenTheRaceInNotFinished()
    {
        $token = $this->getMockedToken($this->getUserLoggedAsUser(1));
        $prediction = new Prediction($this->getRace('Tomorrow'), $this->getUserLoggedAsUser(2));

        $this->assertSame(VoterInterface::ACCESS_DENIED, $this->voter->vote($token, $prediction, ['show']));
    }

    public function testAdminCanEditOtherPredictionWhenTheRaceInNotFinished()
    {
        $token = $this->getMockedToken($this->getUserLoggedAsAdmin(1));
        $prediction = new Prediction($this->getRace('Tomorrow'), $this->getUserLoggedAsUser(2));

        $this->assertSame(VoterInterface::ACCESS_GRANTED, $this->voter->vote($token, $prediction, ['edit']));
    }

    public function testAdminCanEditOtherPredictionWhenTheRaceInFinished()
    {
        $token = $this->getMockedToken($this->getUserLoggedAsAdmin(1));
        $prediction = new Prediction($this->getRace('Yesterday'), $this->getUserLoggedAsUser(2));

        $this->assertSame(VoterInterface::ACCESS_GRANTED, $this->voter->vote($token, $prediction, ['edit']));
    }

    public function testUserCanEditAPredictionWhenTheRaceInNotFinished()
    {
        $user = $this->getUserLoggedAsUser(1);
        $token = $this->getMockedToken($user);
        $prediction = new Prediction($this->getRace('Tomorrow'), $user);

        $this->assertSame(VoterInterface::ACCESS_GRANTED, $this->voter->vote($token, $prediction, ['edit']));
    }

    public function testUserCannotEditHisPredictionWhenTheRaceIsFinished()
    {
        $user = $this->getUserLoggedAsUser(1);
        $token = $this->getMockedToken($user);
        $prediction = new Prediction($this->getRace('Yesterday'), $user);

        $this->assertSame(VoterInterface::ACCESS_DENIED, $this->voter->vote($token, $prediction, ['edit']));
    }

    public function testUserCannotEditOtherPredictions()
    {
        $token = $this->getMockedToken($this->getUserLoggedAsUser(1));
        $prediction = new Prediction($this->getRace('Tomorrow'), $this->getUserLoggedAsUser(2));

        $this->assertSame(VoterInterface::ACCESS_DENIED, $this->voter->vote($token, $prediction, ['edit']));
    }

    /**
     * @return TokenInterface
     */
    private function getMockedToken(UserInterface $user = null)
    {
        $token = $this->getMock('Symfony\Component\Security\Core\Authentication\Token\TokenInterface');
        $token
            ->expects($this->any())
            ->method('getUser')
            ->willReturn($user)
        ;

        return $token;
    }

    /**
     * @return Race
     */
    private function getRace($time)
    {
        $race = new Race();
        $race->setDate(new \DateTime($time));

        return $race;
    }

    /**
     * @return User
     */
    private function getUserLoggedAsUser($id)
    {
        return $this->getUser($id, ['ROLE_USER']);
    }

    /**
     * @return User
     */
    private function getUserLoggedAsAdmin($id)
    {
        return $this->getUser($id, ['ROLE_ADMIN']);
    }

    /**
     * @return User
     */
    private function getUser($id, $roles = [])
    {
        $user = new UserFixture();
        $user->setId($id);

        foreach ($roles as $role) {
            $user->addRole($role);
        }

        return $user;
    }
}
