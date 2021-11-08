<?php

namespace Mollie\BusinessLogic\Connect\DTO;

use Mollie\BusinessLogic\Http\DTO\BaseDto;

/**
 * Class TokenRequest
 * @package Mollie\BusinessLogic\Connect\DTO
 */
class TokenRequest extends BaseDto
{
    /**
     * @var string
     */
    private $grantType;
    /**
     * @var string
     */
    private $code;
    /**
     * @var string
     */
    private $refreshToken;
    /**
     * @var string
     */
    private $redirectUrl;

    /**
     * TokenRequest constructor.
     * @param string $grantType
     * @param string $code
     * @param string $refreshToken
     * @param string $redirectUrl
     */
    public function __construct($grantType, $code = '', $refreshToken = '', $redirectUrl = '')
    {
        $this->grantType = $grantType;
        $this->code = $code;
        $this->refreshToken = $refreshToken;
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * @return string
     */
    public function getGrantType()
    {
        return $this->grantType;
    }

    /**
     * @param string $grantType
     */
    public function setGrantType($grantType)
    {
        $this->grantType = $grantType;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * @param string $refreshToken
     */
    public function setRefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;
    }

    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    /**
     * @param string $redirectUrl
     */
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * @inheritDoc
     *
     * @return array
     */
    public function toArray()
    {
        $array = array();
        $array['grant_type'] = $this->getGrantType();
        if ($this->getGrantType() === 'authorization_code') {
            $array['code'] = $this->getCode();
        } else {
            $array['refresh_token'] = $this->getRefreshToken();
        }

        if ($this->getRedirectUrl() !== '') {
            $array['redirect_uri'] = $this->getRedirectUrl();
        }

        return $array;
    }
}