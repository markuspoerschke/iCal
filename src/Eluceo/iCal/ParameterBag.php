<?php

namespace Eluceo\iCal;

class ParameterBag
{
    /**
     * The params
     *
     * @var array
     */
    protected $params;

    public function __construct($parms = array())
    {
        $this->params = $parms;
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
     * Checks if there are any params
     *
     * @return bool
     */
    public function hasParams()
    {
        return count($this->params) > 0;
    }

    /**
     * @return string
     */
    public function toString()
    {
        $line = '';
        foreach ($this->params as $param => $paramValues) {
            if (!is_array($paramValues)) {
                $paramValues = array($paramValues);
            }
            foreach ($paramValues as $k => $v) {
                $paramValues[$k] = $this->escapeParamValue($v);
            }

            if ('' != $line) {
                $line .= ';';
            }

            $line .= $param . '=' . implode(',', $paramValues);
        }

        return $line;
    }

    /**
     * Returns an escaped string for a param value
     *
     * @param   string  $value
     * @return  string
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
     * @return string
     */
    function __toString()
    {
        return $this->toString();
    }
}
