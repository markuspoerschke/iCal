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
 * The Property Class represents a property as defined in RFC 2445
 *
 * The content of a line (unfolded) will be rendered in this class
 */
class Property
{
    /**
     * The value of the Property
     *
     * @var mixed
     */
    protected $value;

    /**
     * The params of the Property
     *
     * @var array
     */
    protected $params;

    /**
     * @var string
     */
    protected $name;

    function __construct($name, $value, $params = array())
    {
        $this->name   = $name;
        $this->value  = $value;
        $this->params = $params;
    }

    /**
     * Renders an unfolded line
     *
     * @return string
     */
    public function toLine()
    {
        // Property-name
        $line = $this->getName();
        $value = $this->value;
        if (false !== strpos($value, "\n")) {
            $this->params['ENCODING'] = 'QUOTED-PRINTABLE';
            $value = quoted_printable_encode($value);
            $value = strtr($value, array ("\r" => "", "\n" => ""));
        }

        // Adding params
        foreach ($this->params as $param => $paramValues) {
            if (!is_array($paramValues)) {
                $paramValues = array($paramValues);
            }
            foreach ($paramValues as $k => $v) {
                $paramValues[$k] = $this->escapeParamValue($v);
            }
            $line .= ';' . $param . '=' . implode(',', $paramValues);
        }

        // Property value
        $line .= ':' . $value;

        return $line;
    }

    /**
     * Returns an escaped string
     *
     * @param $value
     */
    public function escapeParamValue($value)
    {
        $count = 0;
        $value = str_replace('"', '\"', $value, $count);
        if (false !== strpos($value, ';') || false !== strpos($value, ',') || $count) {
            $value = '"' . $value . '"';
        }
        return $value;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function setParam($name, $value)
    {
        $this->params[$name] = $value;
    }

    /**
     * @param $name
     * @return null
     */
    public function getParam($name)
    {
        if (array_key_exists($name, $this->params)) {
            return $this->params[$name];
        }

        return null;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
