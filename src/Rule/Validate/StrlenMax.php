<?php
/**
 *
 * This file is part of the Aura project for PHP.
 *
 * @package Aura.Filter
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 *
 */
namespace Aura\Filter\Rule\Validate;

/**
 *
 * Validates that a value is no longer than a certain length.
 *
 * @package Aura.Filter
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 *
 */
class StrlenMax
{
    /**
     *
     * Validates that a string is no longer than a certain length.
     *
     * @param mixed $max The value must have no more than this many
     *                   characters.
     *
     * @return bool True if valid, false if not.
     *
     */
    public function __invoke($subject, $field, $max)
    {
        $value = $subject->$field;
        if (! is_scalar($value)) {
            return false;
        }

        return strlen($value) <= $max;
    }
}
