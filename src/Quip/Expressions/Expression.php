<?php

namespace Quip\Expressions;

class Expression
{
    const OPERATOR_LTE = '<=';
    const OPERATOR_GTE = '>=';
    const OPERATOR_NOT = '<>';
    const OPERATOR_LT = '<';
    const OPERATOR_GT = '>';
    const OPERATOR_EQ = '=';

    protected $lhs;
    protected $rhs;
    protected $operator;

    public function __construct($lhs, $operator, $rhs)
    {
        $this->lhs = $lhs;
        $this->operator = $operator;
        $this->rhs = $rhs;
    }

    /**
     * @return mixed
     */
    public function getRhs()
    {
        return $this->rhs;
    }

    /**
     * @param mixed $rhs
     */
    public function setRhs($rhs)
    {
        $this->rhs = $rhs;
    }

    /**
     * @return mixed
     */
    public function getLhs()
    {
        return $this->lhs;
    }

    /**
     * @param mixed $lhs
     */
    public function setLhs($lhs)
    {
        $this->lhs = $lhs;
    }
    /**
     * @return mixed
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @param mixed $operator
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;
    }
}
