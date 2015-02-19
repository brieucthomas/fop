<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Listener;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;

/**
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class SequencePrefixListener
{
    protected $prefix;

    public function __construct($prefix)
    {
        $this->prefix = (string) $prefix;
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $args)
    {
        $classMetadata = $args->getClassMetadata();
        if ($classMetadata->isInheritanceTypeSingleTable() && !$classMetadata->isRootEntity()) {
            return;
        }

        if ($classMetadata->isIdGeneratorSequence()) {
            $newDefinition = $classMetadata->sequenceGeneratorDefinition;
            $newDefinition['sequenceName'] = $this->prefix . $newDefinition['sequenceName'];

            $classMetadata->setSequenceGeneratorDefinition($newDefinition);
            $em = $args->getEntityManager();
            if (isset($classMetadata->idGenerator)) {
                $sequenceGenerator = new \Doctrine\ORM\Id\SequenceGenerator(
                    $em->getConfiguration()->getQuoteStrategy()->getSequenceName(
                        $newDefinition,
                        $classMetadata,
                        $em->getConnection()->getDatabasePlatform()
                    ),
                    $newDefinition['allocationSize']
                );
                $classMetadata->setIdGenerator($sequenceGenerator);
            }
        }
    }
}