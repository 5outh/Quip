<?php

namespace Quip\Expressions;

use Quip\Expressions\Exceptions\InvalidExpressionException;

/**
 * Class ExpressionParser
 *
 * Handles parsing strings into expressions
 *
 * @package Quip\Expressions
 */
class ExpressionParser
{
    /**
     * @var string
     */
    protected $rawExpression;

    /**
     * @var Expression
     */
    protected $expression;

    /**
     * Construct an ExpressionParser from a raw, string expression
     *
     * @param $rawExpression
     */
    public function __construct($rawExpression) {
        $this->rawExpression = $rawExpression;
    }

    /**
     * Parse a raw expression into a valid expression
     *
     * @return Expression
     *
     * @throws InvalidExpressionException
     */
    public function parse()
    {
        // Note: Order is very important here!
        $operators = [
            Expression::OPERATOR_GTE,
            Expression::OPERATOR_LTE,
            Expression::OPERATOR_NOT,
            Expression::OPERATOR_EQ,
            Expression::OPERATOR_GT,
            Expression::OPERATOR_LT
        ];

        foreach ($operators as $operator) {
            $pos = strpos($this->rawExpression, $operator);

            if ($pos) {

                return new Expression(
                    substr($this->rawExpression, 0, $pos),
                    $operator,
                    substr($this->rawExpression, $pos + strlen($operator))
                );
            }
        }

        // Throw an exception if an operator can't be found
        throw new InvalidExpressionException();
    }
}