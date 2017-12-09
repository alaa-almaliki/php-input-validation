<?php

namespace Rv\InputValidation;

/**
 * Interface ValidationInterface
 * @package Rv\InputValidation
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
interface ValidationInterface
{
    /**
     * @param string $input
     * @param array $rules
     * @return bool
     */
    public function validate($input, array $rules) : bool;
}