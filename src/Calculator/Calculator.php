<?php

namespace App\Calculator;

class Calculator
{
    private $equation;

    private $result;

    public function __construct()
    {
        $this->result = null;
        $this->equation = '';
    }

    /**
     * @param null $result
     * @return Calculator
     */
    public function setResult($result) : Calculator
    {
        $this->result = $result;
        return $this;
    }

    /**
     * @return int
     */
    public function getResult() : ?int
    {
        // Some security checks. Check for integers and math operators
        if(!preg_match('([ -+\/*]\d+(\.\d+)?)', $this->equation )) {
            return 0;
        }

        return eval("return " . $this->equation . ";");
    }

    /**
     * @param null|string $equation
     *
     * @return Calculator
     */
    public function setEquation($equation) : Calculator
    {
        $this->equation = (string) $equation;

        return $this;
    }

    /**
     * @return string
     */
    public function getEquation() : string
    {
        return (string) $this->equation;
    }

}