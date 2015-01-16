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
 * Country utils.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class Country
{
    /**
     * An array of countries.
     *
     * @var array
     */
    private $countries = [];

    /**
     * Sets a country.
     *
     * @param string $name The country english name
     * @param string $iso2 The ISO 3166-1 alpha-2 country code
     *
     * @return $this
     */
    public function set($name, $iso2)
    {
        $this->countries[$name] = $iso2;

        return $this;
    }

    /**
     * Loads YAML files countries definitions.
     *
     * @param string $filename The YAML filename
     *
     * @return $this
     */
    public static function loadFromYaml($filename)
    {
        $self = new self();

        $data = Yaml::parse(file_get_contents($filename));

        if (isset($data['countries'])) {
            foreach ($data['countries'] as $name => $iso2) {
                $self->set($name, $iso2);
            }
        }

        return $self;
    }

    /**
     * Checks if a country is set.
     *
     * @param string $name The country name
     *
     * @return bool The presence of country
     */
    public function has($name)
    {
        return array_key_exists($name, $this->countries);
    }

    /**
     * Returns the country code by its name.
     *
     * @param string $name A country name
     *
     * @return string The country code
     *
     * @throws \InvalidArgumentException if the country name is not found
     */
    public function getCodeByName($name)
    {
        if (!isset($this->countries[$name])) {
            throw new \InvalidArgumentException(sprintf('Could not find the country "%s"', $name));
        }

        return $this->countries[$name];
    }
}
