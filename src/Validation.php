<?php

namespace Rv\InputValidation;

/**
 * Class Validation
 * @package Rv\InputValidation
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Validation implements ValidationInterface
{
    /**
     * Class package of the rule
     */
    const RULES_PACKAGE = 'Respect\Validation\Rules';

    /**
     * @param string $input
     * @param array $rules
     * @return bool
     */
    public function validate($input, array $rules)
    {
        $isValid = true;
        foreach ($rules as $rule) {
            $class  = $this->resolveClass($rule);
            $ruleInstance = $this->getRuleInstance($class, $rule);
            $isValid &= $ruleInstance->validate($input);
        }

        return (bool) $isValid;
    }

    /**
     * @param array $rule
     * @return string
     * @throws InputValidationMethodException
     */
    protected function resolveClass(array $rule)
    {
        if (!array_key_exists('class', $rule)) {
            throw new InputValidationMethodException('Validation rule class must be provided.');
        }

        $ruleClass = $rule['class'];
        $fullClass = self::RULES_PACKAGE . '\\' . $rule['class'];

        if (!class_exists($fullClass)) {
            throw new InputValidationMethodException(
                sprintf('%s class is not found', $ruleClass)
            );
        }

        return $fullClass;
    }

    /**
     * @param $ruleClass
     * @param $rule
     * @return null|object
     */
    protected function getRuleInstance($ruleClass, $rule)
    {
        $instance = null;
        if (array_key_exists('args', $rule) && is_array($rule['args'])) {
            $ref = new \ReflectionClass($ruleClass);
            $instance = $ref->newInstanceArgs($rule['args']);
        } else {
            $instance = new $ruleClass();
        }

        return $instance;
    }
}
