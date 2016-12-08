<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\AppBundle\Security;

use AppBundle\Entity\Prediction;
use AppBundle\Entity\Race;
use AppBundle\Entity\User;
use AppBundle\Security\PredictionVoter;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Tests\WebTestCase;

class PredictionVoterTest extends WebTestCase
{
    /**
     * @var PredictionVoter
     */
    private $voter;

    protected function setUp()
    {
        $this->voter = new PredictionVoter(
            $this->get('security.access.decision_manager')
        );
    }

    protected function tearDown()
    {
        $this->voter = null;
    }

    public function testAdminCanShowOtherPredictionWhenTheRaceIsNotFinished()
    {
        $token = $this->getMockedToken($this->getUser(1), [new Role('ROLE_ADMIN')]);
        $prediction = new Prediction($this->getNextRace(), $this->getUser(2));

        $this->assertSame(VoterInterface::ACCESS_GRANTED, $this->voter->vote($token, $prediction, ['show']));
    }

    public function testUserCanShowHisPredictionWhenTheRaceIsNotFinished()
    {
        $token = $this->getMockedToken($this->getUser(1), [new Role('ROLE_USER')]);
        $prediction = new Prediction($this->getNextRace(), $token->getUser());

        $this->assertSame(VoterInterface::ACCESS_GRANTED, $this->voter->vote($token, $prediction, ['show']));
    }

    public function testAnonymousCannotShowPredictionWhenTheRaceIsNotFinished()
    {
        $token = new AnonymousToken('foo', 'bar');
        $prediction = new Prediction($this->getNextRace(), $this->getUser(2));

        $this->assertSame(VoterInterface::ACCESS_DENIED, $this->voter->vote($token, $prediction, ['show']));
    }

    public function testAnonymousCanShowPredictionWhenTheRaceIsFinished()
    {
        $token = new AnonymousToken('foo', 'bar');
        $prediction = new Prediction($this->getFinishedRace(), $this->getUser(2));

        $this->assertSame(VoterInterface::ACCESS_GRANTED, $this->voter->vote($token, $prediction, ['show']));
    }

    public function testUserCanShowOtherPredictionWhenTheRaceInFinished()
    {
        $token = $this->getMockedToken($this->getUser(1), [new Role('ROLE_USER')]);
        $prediction = new Prediction($this->getFinishedRace(), $this->getUser(2));

        $this->assertSame(VoterInterface::ACCESS_GRANTED, $this->voter->vote($token, $prediction, ['show']));
    }

    public function testUserCannotShowOtherPredictionWhenTheRaceInNotFinished()
    {
        $token = $this->getMockedToken($this->getUser(1), [new Role('ROLE_USER')]);
        $prediction = new Prediction($this->getNextRace(), $this->getUser(2));

        $this->assertSame(VoterInterface::ACCESS_DENIED, $this->voter->vote($token, $prediction, ['show']));
    }

    public function testAdminCanEditOtherPredictionWhenTheRaceInNotFinished()
    {
        $token = $this->getMockedToken($this->getUser(1), [new Role('ROLE_ADMIN')]);
        $prediction = new Prediction($this->getNextRace(), $this->getUser(2));

        $this->assertSame(VoterInterface::ACCESS_GRANTED, $this->voter->vote($token, $prediction, ['edit']));
    }

    public function testAdminCanEditOtherPredictionWhenTheRaceInFinished()
    {
        $token = $this->getMockedToken($this->getUser(1), [new Role('ROLE_ADMIN')]);
        $prediction = new Prediction($this->getFinishedRace(), $this->getUser(2));

        $this->assertSame(VoterInterface::ACCESS_GRANTED, $this->voter->vote($token, $prediction, ['edit']));
    }

    public function testUserCanEditAPredictionWhenTheRaceInNotFinished()
    {
        $token = $this->getMockedToken($this->getUser(1), [new Role('ROLE_USER')]);
        $prediction = new Prediction($this->getNextRace(), $token->getUser());

        $this->assertSame(VoterInterface::ACCESS_GRANTED, $this->voter->vote($token, $prediction, ['edit']));
    }

    public function testUserCannotEditHisPredictionWhenTheRaceIsFinished()
    {
        $token = $this->getMockedToken($this->getUser(1), [new Role('ROLE_USER')]);
        $prediction = new Prediction($this->getFinishedRace(), $token->getUser());

        $this->assertSame(VoterInterface::ACCESS_DENIED, $this->voter->vote($token, $prediction, ['edit']));
    }

    public function testUserCannotEditOtherPredictions()
    {
        $token = $this->getMockedToken($this->getUser(1), [new Role('ROLE_USER')]);
        $prediction = new Prediction($this->getNextRace(), $this->getUser(2));

        $this->assertSame(VoterInterface::ACCESS_DENIED, $this->voter->vote($token, $prediction, ['edit']));
    }

    /**
     * @return TokenInterface
     */
    private function getMockedToken(UserInterface $user = null, array $roles)
    {
        $token = $this->getMockBuilder(TokenInterface::class)->getMock();
        $token->expects($this->any())->method('getUser')->willReturn($user);
        $token->expects($this->any())->method('getRoles')->willReturn($roles);

        return $token;
    }

    /**
     * @return Race
     */
    private function getNextRace()
    {
        return $this->getRace('Tomorrow');
    }

    /**
     * @return Race
     */
    private function getFinishedRace()
    {
        return $this->getRace('Yesterday');
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
    private function getUser($id)
    {
        $user = $this->getMockBuilder(User::class)->getMock();
        $user->expects($this->any())->method('getId')->willReturn($id);

        return $user;
    }
}
