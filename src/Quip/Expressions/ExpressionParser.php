<?php

namespace Quip\Expressions;

use Quip\Expressions\Exceptions\InvalidExpressionException;

class ExpressionParser
{
    /**
     * @var string
     */
    protected $rawExpression;
    protected $expression;

    public function __construct($rawExpression) {
        $this->rawExpression = $rawExpression;
    }

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