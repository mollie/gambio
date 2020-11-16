<?php


namespace Mollie\BusinessLogic\Authorization\Interfaces;

/**
 * Interface TokenInterface
 *
 * @package Mollie\BusinessLogic\Authorization\Interfaces
 */
interface TokenInterface
{
    /**
     * Returns api token
     *
     * @return string
     */
    public function getToken();

    /**
     * Returns flag that indicates whether is test mode or not
     *
     * @return bool
     */
    public function isTest();
}