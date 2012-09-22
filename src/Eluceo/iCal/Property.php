<?php

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
     * @todo: Values containing ";", "=", ":" will not be escaped yet
     *
     * @return string
     */
    public function toLine()
    {
        // Property-name
        $line = $this->getName();

        // Adding params
        foreach ($this->params as $param => $paramValue) {
            $line .= ';' . $param . '=' . $paramValue;
        }

        // Property value
        $line .= ':' . $this->value;

        return $line;
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