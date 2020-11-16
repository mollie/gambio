<?php

namespace Mollie\Infrastructure\ORM;

/**
 * Class IntermediateObject
 * @package Mollie\Infrastructure\ORM
 */
class IntermediateObject
{
    /**
     * @var string
     */
    private $index1;
    /**
     * @var string
     */
    private $index2;
    /**
     * @var string
     */
    private $index3;
    /**
     * @var string
     */
    private $index4;
    /**
     * @var string
     */
    private $index5;
    /**
     * @var string
     */
    private $index6;
    /**
     * @var string
     */
    private $data;
    /**
     * @var array
     */
    private $otherIndexes = array();

    /**
     * @return string
     */
    public function getIndex1()
    {
        return $this->index1;
    }

    /**
     * @param string $index1
     */
    public function setIndex1($index1)
    {
        $this->index1 = $index1;
    }

    /**
     * @return string
     */
    public function getIndex2()
    {
        return $this->index2;
    }

    /**
     * @param string $index2
     */
    public function setIndex2($index2)
    {
        $this->index2 = $index2;
    }

    /**
     * @return string
     */
    public function getIndex3()
    {
        return $this->index3;
    }

    /**
     * @param string $index3
     */
    public function setIndex3($index3)
    {
        $this->index3 = $index3;
    }

    /**
     * @return string
     */
    public function getIndex4()
    {
        return $this->index4;
    }

    /**
     * @param string $index4
     */
    public function setIndex4($index4)
    {
        $this->index4 = $index4;
    }

    /**
     * @return string
     */
    public function getIndex5()
    {
        return $this->index5;
    }

    /**
     * @param string $index5
     */
    public function setIndex5($index5)
    {
        $this->index5 = $index5;
    }

    /**
     * @return string
     */
    public function getIndex6()
    {
        return $this->index6;
    }

    /**
     * @param string $index6
     */
    public function setIndex6($index6)
    {
        $this->index6 = $index6;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Sets index value
     *
     * @param int $index
     * @param string $value
     */
    public function setIndexValue($index, $value)
    {
        if (!is_int($index) || $index < 1 || !is_string($value)) {
            return;
        }

        if ($index >= 1 && $index <= 6) {
            $methodName = 'setIndex' . $index;
            $this->$methodName($value);
        } else {
            $this->otherIndexes['index_' . $index] = $value;
        }
    }

    /**
     * Returns index value
     *
     * @param int $index
     *
     * @return string|null
     */
    public function getIndexValue($index)
    {
        $value = null;
        if (!is_int($index) || $index < 1) {
            return $value;
        }

        if ($index >= 1 && $index <= 6) {
            $methodName = 'getIndex' . $index;
            $value = $this->$methodName();
        } elseif (array_key_exists('index_' . $index, $this->otherIndexes)) {
            $value = $this->otherIndexes['index_' . $index];
        }

        return $value;
    }
}
