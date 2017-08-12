<?php

namespace Liliom\Firebase\Exceptions;

class InvalidConfiguration extends \Exception
{
	/**
     * Thrown when configuration key not set.
     *
     * @return static
     */
    public static function configurationNotSet()
    {
        return new static('In order to send notification via Firebase you need to add credentials in the `firebase` key of `config.services`.');
    }
}