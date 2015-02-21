<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) Markus Poerschke <markus@eluceo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eluceo\iCal;

/**
 * Abstract Calender Component.
 */
abstract class Component
{
    /**
     * The PropertyBag.
     *
     * @var PropertyBag
     */
    protected $properties;

    /**
     * Array of Components.
     *
     * @var array
     */
    protected $components = array();

    /**
     * The type of the concrete Component.
     *
     * @abstract
     *
     * @return string
     */
    abstract public function getType();

    /**
     * Adds a Component.
     *
     * If $key is given, the component at $key will be replaced else the component will be append.
     *
     * @param Component $component The Component that will be added
     * @param null      $key       The key of the Component
     */
    public function addComponent(Component $component, $key = null)
    {
        if (null == $key) {
            $this->components[] = $component;
        } else {
            $this->components[$key] = $component;
        }
    }

    /**
     * Renders an array containing the lines of the iCal file.
     *
     * @return array
     */
    public function build()
    {
        $this->buildPropertyBag();

        $lines = array();

        $lines[] = sprintf('BEGIN:%s', $this->getType());

        /** @var $property Property */
        foreach ($this->properties as $property) {
            $lines = array_merge($lines, $property->toLines());
        }

        /** @var $component Component */
        foreach ($this->components as $component) {
            foreach ($component->build() as $l) {
                $lines[] = $l;
            }
        }

        $lines[] = sprintf('END:%s', $this->getType());

        $ret = array();

        foreach ($lines as $line) {
            foreach ($this->fold($line) as $l) {
                $ret[] = $l;
            }
        }

        return $ret;
    }

    /**
     * Folds a single line.
     *
     * According to RFC 2445, all lines longer than 75 characters will be folded
     *
     * @link http://www.ietf.org/rfc/rfc2445.txt
     *
     * @param $string
     *
     * @return array
     */
    public function fold($string)
    {
        $lines = array();
        $array = preg_split('/(?<!^)(?!$)/u', $string);

        $line   = '';
        $lineNo = 0;
        foreach ($array as $char) {
            $charLen = strlen($char);
            $lineLen = strlen($line);
            if ($lineLen + $charLen > 75) {
                $line = ' ' . $char;
                ++$lineNo;
            } else {
                $line .= $char;
            }
            $lines[$lineNo] = $line;
        }

        return $lines;
    }

    /**
     * Renders the output.
     *
     * @return string
     */
    public function render()
    {
        $lines = array();
        foreach ($this->build() as $l) {
            $lines[] = $l;
        }

        return implode("\r\n", $lines);
    }

    /**
     * Renders the output when treating the class as a string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Building the PropertyBag.
     *
     * @abstract
     */
    abstract public function buildPropertyBag();
}
