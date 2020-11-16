<?php

namespace Mollie\BusinessLogic\Http\DTO;

/**
 * Class Image
 *
 * @package Mollie\BusinessLogic\Http\DTO
 */
class Image extends BaseDto
{
    /**
     * @var string
     */
    protected $size1x;
    /**
     * @var string
     */
    protected $size2x;
    /**
     * @var string
     */
    protected $svg;

    /**
     * @inheritDoc
     */
    public static function fromArray(array $raw)
    {
        $result = new static();

        $result->size1x = static::getValue($raw, 'size1x');
        $result->size2x = static::getValue($raw, 'size2x');
        $result->svg = static::getValue($raw, 'svg');

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return array(
            'size1x' => $this->size1x,
            'size2x' => $this->size2x,
            'svg' => $this->svg,
        );
    }

    /**
     * @return string
     */
    public function getSize1x()
    {
        return $this->size1x;
    }

    /**
     * @param string $size1x
     */
    public function setSize1x($size1x)
    {
        $this->size1x = $size1x;
    }

    /**
     * @return string
     */
    public function getSize2x()
    {
        return $this->size2x;
    }

    /**
     * @param string $size2x
     */
    public function setSize2x($size2x)
    {
        $this->size2x = $size2x;
    }

    /**
     * @return string
     */
    public function getSvg()
    {
        return $this->svg;
    }

    /**
     * @param string $svg
     */
    public function setSvg($svg)
    {
        $this->svg = $svg;
    }
}
