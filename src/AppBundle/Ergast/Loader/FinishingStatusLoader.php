<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Ergast\Loader;

use AppBundle\Entity as AppEntity;
use AppBundle\Service\FinishingStatusServiceInterface;
use BrieucThomas\ErgastClient\Entity as ErgastEntity;
use BrieucThomas\ErgastClient\Url\Builder\StatusUrlBuilder;

/**
 * Finishing status loader.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class FinishingStatusLoader extends AbstractLoader
{
    /**
     * @var FinishingStatusServiceInterface
     */
    private $finishingStatusService;

    /**
     * @var bool
     */
    private $loaded = false;

    /**
     * Constructor.
     *
     * @param FinishingStatusServiceInterface $finishingStatusService
     */
    public function __construct(FinishingStatusServiceInterface $finishingStatusService)
    {
        $this->finishingStatusService = $finishingStatusService;
    }

    /**
     * {@inheritdoc}
     */
    public function load(AppEntity\Season $season)
    {
        if ($this->loaded) {
            return;
        }

        $urlBuilder = new StatusUrlBuilder('f1');
        $response = $this->client->execute($urlBuilder->build());

        $finishingStatues = $this->finishingStatusService->findAll();

        foreach ($response->getFinishingStatues() as $ergastFinishingStatus) {
            /* @var $ergastFinishingStatus ErgastEntity\FinishingStatus */
            $label = $ergastFinishingStatus->getName();

            if (!$finishingStatues->get($label)) {
                $finishingStatus = new AppEntity\FinishingStatus($label);
                $this->finishingStatusService->save($finishingStatus);
            }
        }

        $this->loaded = true;
    }
}
