<?php

namespace App\Entity;


class Calculation
{
    private $inputA, $inputB, $operator, $result;


    public function __construct($inputA, $inputB, $operator)
    {
        $this->inputA = $inputA;
        $this->inputB = $inputB;
        $this->operator = $operator;
    }

    /**
     * @param mixed $inputA
     * @return Calculation
     */
    public function setInputA($inputA)
    {
        $this->inputA = $inputA;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInputA()
    {
        return $this->inputA;
    }

    /**
     * @param mixed $inputB
     * @return Calculation
     */
    public function setInputB($inputB)
    {
        $this->inputB = $inputB;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInputB()
    {
        return $this->inputB;
    }

    /**
     * @param mixed $operator
     * @return Calculation
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @param mixed $result
     * @return Calculation
     */
    public function setResult($result)
    {
        $this->result = $result;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    public function __toString()
    {
        return $this->inputA . $this->operator . $this->inputB;
    }

    public function calculateResult()
    {
        return eval("return ". $this . ";");
    }
}