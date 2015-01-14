<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Translation;

use JMS\TranslationBundle\Model\Message;
use JMS\TranslationBundle\Model\MessageCatalogue;
use JMS\TranslationBundle\Translation\Extractor\FileVisitorInterface;
use PHPParser_Node;

/**
 * Extracts translation keys from menu builders.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class MenuTranslationExtractor implements FileVisitorInterface, \PHPParser_NodeVisitor
{
    /**
     * @var \PHPParser_NodeTraverser
     */
    private $traverser;

    /**
     * @var \SplFileInfo
     */
    private $file;

    /**
     * @var MessageCatalogue
     */
    private $catalogue;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->traverser = new \PHPParser_NodeTraverser();
        $this->traverser->addVisitor($this);
    }

    /**
     * {@inheritdoc}
     */
    public function visitPhpFile(\SplFileInfo $file, MessageCatalogue $catalogue, array $ast)
    {
        $this->file = $file;
        $this->catalogue = $catalogue;
        $this->traverser->traverse($ast);
    }

    /**
     * {@inheritdoc}
     */
    public function enterNode(\PHPParser_Node $node)
    {
        if (!$node instanceof \PHPParser_Node_Expr_MethodCall) {
            return;
        }

        if ($node->name != 'addChild') {
            return;
        }

        if (empty($node->args)) {
            return;
        }

        /* @var $value \PHPParser_Node_Expr_Variable */
        $value = $node->args[0]->value;

        if (empty($value->value)) {
            return;
        }

        $this->catalogue->add(new Message($value->value, 'navigation'));
    }

    /**
     * {@inheritdoc}
     */
    public function visitFile(\SplFileInfo $file, MessageCatalogue $catalogue)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function visitTwigFile(\SplFileInfo $file, MessageCatalogue $catalogue, \Twig_Node $node)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function beforeTraverse(array $nodes)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function leaveNode(PHPParser_Node $node)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function afterTraverse(array $nodes)
    {
    }
}
