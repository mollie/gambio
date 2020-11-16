<?php

namespace Mollie\BusinessLogic\Http\Exceptions;

use Mollie\Infrastructure\Http\Exceptions\HttpRequestException;
use Throwable;

/**
 * Class UnprocessableEntityRequestException
 *
 * @package Mollie\BusinessLogic\Http\Exceptions
 */
class UnprocessableEntityRequestException extends HttpRequestException
{
    /**
     * @var string
     */
    private $field;

    /**
     * Exception that is thrown in case of unprocessable entity error on Mollie API
     *
     * @param string $field Validation error field from returned by Mollie API
     * @param string $message [optional] The Exception message to throw.
     * @param int $code [optional] The Exception code.
     * @param Throwable $previous [optional] The previous throwable used for the exception chaining.
     * @since 5.1.0
     */
    public function __construct($field, $message = '', $code = 0, $previous = null)
    {
        $this->field = $field;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }
}
