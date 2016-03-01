<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Twig;

use Symfony\Bundle\FrameworkBundle\Templating\Helper\AssetsHelper;

/**
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class ConditionalAssetExtension extends \Twig_Extension
{
    private $rootDir;
    private $assetsHelper;

    public function __construct(string $rootDir, AssetsHelper $assetsHelper)
    {
        $this->rootDir = $rootDir;
        $this->assetsHelper = $assetsHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            'asset_if' => new \Twig_Function_Method($this, 'assetIf'),
        ];
    }

    /**
     * Get the path to an asset. If it does not exist, return the path to the
     * fallback path.
     *
     * @param string $path         the path to the asset to display
     * @param string $fallbackPath the path to the asset to return in case asset $path does not exist
     *
     * @return string path
     */
    public function assetIf($path, $fallbackPath)
    {
        // define the path to look for
        $pathToCheck = realpath($this->rootDir.'/../web/').'/'.$path;

        // if the path does not exist, return the fallback image
        if (!file_exists($pathToCheck)) {
            return $this->assetsHelper->getUrl($fallbackPath);
        }

        // return the original image
        return $this->assetsHelper->getUrl($path);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'asset_if';
    }
}
