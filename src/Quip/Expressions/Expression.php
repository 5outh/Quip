<?php

namespace Quip\Expressions;

/**
 * Class Expression
 *
 * Represents a SQL filter that can be parsed out of a REST query
 *
 * @package Quip\Expressions
 */
class Expression
{
    const OPERATOR_LTE = '<=';
    const OPERATOR_GTE = '>=';
    const OPERATOR_NOT = '<>';
    const OPERATOR_LT = '<';
    const OPERATOR_GT = '>';
    const OPERATOR_EQ = '=';

    /**
     * @var string
     */
    protected $lhs;

    /**
     * @var string
     */
    protected $rhs;

    /**
     * @var string
     */
    protected $operator;

    /**
     * Construct a new Expression from lhs, operator and rhs
     *
     * @param $lhs
     * @param $operator
     * @param $rhs
     */
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
