<?php


namespace Mollie\Gambio\APIProcessor;

/**
 * Class Result
 *
 * @package Mollie\Gambio\APIProcessor
 */
class Result
{
    /**
     * @var bool
     */
    private $success;
    /**
     * @var string
     */
    private $redirectUrl;
    /**
     * @var string
     */
    private $errorMessage;

    /**
     * Result constructor.
     *
     * @param bool   $success
     * @param string $redirectUrl
     */
    public function __construct($success, $redirectUrl = null)
    {
        $this->success     = $success;
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @param string $errorMessage
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }
}