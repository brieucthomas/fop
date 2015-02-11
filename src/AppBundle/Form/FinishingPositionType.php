<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Form;

use AppBundle\Repository\TeamRepositoryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * The prediction item type.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class FinishingPositionType extends AbstractType
{
    /**
     * @var int
     */
    private $year;

    /**
     * Constructor.
     *
     * @param int $year
     */
    public function __construct($year)
    {
        $this->year = $year;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('team', 'entity', [
                'class' => 'AppBundle:Team',
                'query_builder' => function (TeamRepositoryInterface $repository) {
                    return $repository->findByYear($this->year);
                },
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\FinishingPosition',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'finishing_position';
    }
}
