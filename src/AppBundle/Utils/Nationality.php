<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Utils;

use Symfony\Component\Yaml\Yaml;

/**
 * Nationality utils.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class Nationality
{
    /**
     * An array of nationalities.
     *
     * @var array
     */
    private $nationalities = [];

    /**
     * Sets a nationality.
     *
     * @param string $name The nationality english name
     * @param string $iso2 The ISO 3166-1 alpha-2 nationality code
     *
     * @return $this
     */
    public function set($name, $iso2)
    {
        $this->nationalities[$name] = $iso2;

        return $this;
    }

    /**
     * Loads YAML files nationalities definitions.
     *
     * @param string $filename The YAML filename
     *
     * @return $this
     */
    public static function loadFromYaml($filename)
    {
        $self = new self();

        $data = Yaml::parse(file_get_contents($filename));

        if (isset($data['nationalities'])) {
            foreach ($data['nationalities'] as $name => $iso2) {
                $self->set($name, $iso2);
            }
        }

        return $self;
    }

    /**
     * Checks if a nationality is set.
     *
     * @param string $name The nationality name
     *
     * @return bool The presence of nationality
     */
    public function has($name)
    {
        return array_key_exists($name, $this->nationalities);
    }

    /**
     * Returns the nationality code by its name.
     *
     * @param string $name A nationality name
     *
     * @return string The nationality code
     *
     * @throws \InvalidArgumentException if the nationality name is not found
     */
    public function getCodeByName($name)
    {
        if (!isset($this->nationalities[$name])) {
            throw new \InvalidArgumentException(sprintf('Could not find the nationality "%s"', $name));
        }

        return $this->nationalities[$name];
    }
}
