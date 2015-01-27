<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Form;

use AppBundle\Entity\Race;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * The prediction type.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class PredictionType extends AbstractType
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
            ->add('finishingPositions', 'collection', [
                'type' => new FinishingPositionType($this->year),
                'allow_add' => true
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Prediction'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'prediction';
    }
}
