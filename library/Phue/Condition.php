<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue;

/**
 * Condition object
 */
class Condition
{
    /**
     * Operator: Equals
     */
    const OPERATOR_EQUALS = 'eq';

    /**
     * Operator: Greater than
     */
    const OPERATOR_GREATER_THAN = 'gt';

    /**
     * Operator: Less than
     */
    const OPERATOR_LESS_THAN = 'lt';

    /**
     * Operator: Changed
     */
    const OPERATOR_CHANGED = 'dx';

    /**
     * Sensor Id
     *
     * @var string
     */
    protected $sensorId;

    /**
     * Attribute to target condition
     *
     * @var string
     */
    protected $attribute;

    /**
     * Operator
     *
     * @var string Operator
     */
    protected $operator;

    /**
     * Value to match
     *
     * @var string
     */
    protected $value;

    /**
     * Construct a condition object
     *
     * @param \stdClass $condition Condition attributes
     */
    public function __construct(\stdClass $condition = null)
    {
        $condition !== null && $this->import($condition);
    }

    /**
     * Get sensor Id
     *
     * @return string Sensor Id
     */
    public function getSensorId()
    {
        return $this->sensorId;
    }

    /**
     * Set sensor Id
     *
     * @param mixed $sensorId Sensor Id or Sensor object
     *
     * @return self This object
     */
    public function setSensorId($sensorId)
    {
        $this->sensorId = (string) $sensorId;

        return $this;
    }

    /**
     * Get attribute
     *
     * @return string Attribute
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * Set attribute to target condition
     *
     * @param string $attribute Attribute
     *
     * @return self This object
     */
    public function setAttribute($attribute)
    {
        $this->attribute = (string) $attribute;

        return $this;
    }

    /**
     * Get operator
     *
     * @return string Operator
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * Set operator
     *
     * @param string $operator Operator
     *
     * @return self This object
     */
    public function setOperator($operator)
    {
        $this->operator = (string) $operator;

        return $this;
    }

    /**
     * Get value
     *
     * @return string Value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set value to match
     *
     * @param string $value Value
     *
     * @return self This object
     */
    public function setValue($value)
    {
        $this->value = (string) $value;

        return $this;
    }

    /**
     * Import from API response
     *
     * @param \stdClass $condition Condition values
     *
     * @return self This object
     */
    public function import(\stdClass $condition)
    {
        $this->setSensorId(explode('/', $condition->address)[2]);
        $this->setAttribute(explode('/', $condition->address)[4]);
        $this->setOperator((string) $condition->operator);
        isset($condition->value) && $this->setValue((string) $condition->value);

        return $this;
    }

    /**
     * Export for API request
     *
     * @return \stdClass Result object
     */
    public function export()
    {
        $result = [
            'address'  => "/sensors/{$this->getSensorId()}/state/{$this->getAttribute()}",
            'operator' => $this->getOperator(),
        ];

        if ($this->value !== null) {
            $result['value'] = $this->getValue();
        }

        return (object) $result;
    }


    /**
     * Set operator to equals
     *
     * @return self This object
     */
    public function equals()
    {
        $this->operator = self::OPERATOR_EQUALS;

        return $this;
    }

    /**
     * Set operator to greater than
     *
     * @return self This object
     */
    public function greaterThan()
    {
        $this->operator = self::OPERATOR_GREATER_THAN;

        return $this;
    }

    /**
     * Set operator to less than
     *
     * @return self This object
     */
    public function lessThan()
    {
        $this->operator = self::OPERATOR_LESS_THAN;

        return $this;
    }

    /**
     * Set operator to changed
     *
     * @return self This object
     */
    public function changed()
    {
        $this->operator = self::OPERATOR_CHANGED;

        return $this;
    }
}
