<?php


namespace Mollie\BusinessLogic\Authorization\Interfaces;

/**
 * Interface AuthorizationService
 *
 * @package Mollie\BusinessLogic\Authorization\Interfaces
 */
interface AuthorizationService
{
    const CLASS_NAME = __CLASS__;

    /**
     * @param TokenInterface $token
     */
    public function connect(TokenInterface $token);

    /**
     * Validates access token
     *
     * @param TokenInterface $token
     *
     * @return bool Validation result
     */
    public function validateToken(TokenInterface $token);

    /**
     * Resets account
     */
    public function reset();
}
