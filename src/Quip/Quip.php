<?php

namespace Quip;

use Quip\Entities\EmbedChain;
use Quip\Entities\Query;
use Quip\Entities\Sort;
use Quip\Exceptions\NoSuchSortException;
use Quip\Expressions\Expression;
use Quip\Expressions\ExpressionParser;

/**
 * Class Quip
 *
 * Main class for the Quip library. Constructed with a raw query string
 * or input array, with methods to parse into a Query object.
 *
 * @package Quip
 */
class Quip
{
    /**
     * @var Query
     */
    protected $query;

    /**
     * @var string|array
     */
    protected $queryString;

    public function __construct($queryString)
    {
        $this->queryString = $queryString;
    }

    /**
     * Parse a raw query into something more meaningful
     *
     * @return Query
     */
    public function parse()
    {
        $input = [];

        // Parse string if it's not already parsed into an array
        if (is_string($this->queryString)) {
            $input = [];
            parse_str($this->queryString, $input);
        }

        $this->query = new Query($input);

        $this->parseQ();
        $this->parseEmbeds();
        $this->parseIncludes();
        $this->parseExcludes();
        $this->parseSorts();

        return $this->query;
    }

    /**
     * Parse the SQL queries (filters) from the query string
     */
    protected function parseQ()
    {
        if ($this->query->has('q')) {
            $exprs = explode(',', $this->query->getRaw('q'));

            foreach ($exprs as $expr) {
                $this->query->addExpression($this->parseExpression($expr));
            }
        }
    }


    /**
     * Parse the embeds from the query string
     */
    protected function parseEmbeds()
    {
        if ($this->query->has('embeds')) {
            $embeds = explode(',', $this->query->getRaw('embeds'));

            foreach ($embeds as $embed) {
                $this->query->addEmbed($this->parseEmbed($embed));
            }
        }
    }

    /**
     * Parse the includees from the query string
     */
    protected function parseIncludes()
    {
        if ($this->query->has('includes')) {
            $this->query->setIncludes(
                explode(',', $this->query->getRaw('includes'))
            );
        }
    }

    /**
     * Parse the excludes from the query string
     */
    protected function parseExcludes()
    {
        if ($this->query->has('excludes')) {
            $this->query->setExcludes(
                explode(',', $this->query->getRaw('excludes'))
            );
        }
    }

    /**
     * Parse the sorts from the query string
     *
     * @throws NoSuchSortException
     */
    protected function parseSorts()
    {
        if ($this->query->has('sort')) {
            $sorts = explode(',', $this->query->getRaw('sort'));

            foreach($sorts as $sort) {
                $this->query->addSort($this->parseSort($sort));
            }
        }
    }

    /**
     * Parse a single sort from a raw query string
     *
     * @param $sort
     *
     * @return Sort
     *
     * @throws NoSuchSortException
     */
    protected function parseSort($sort)
    {
        $type = substr($sort, 0, 1);
        $key = substr($sort, 1);

        switch ($type) {
            case '+': $type = Sort::TYPE_ASC; break;
            case '-': $type = Sort::TYPE_DESC; break;
            default:
                throw new NoSuchSortException();
        }

        return new Sort($type, $key);
    }

    /**
     * Parse a raw embed into a meaningful chain
     *
     * @param $embed
     *
     * @return EmbedChain
     */
    protected function parseEmbed($embed)
    {
        return new EmbedChain(explode('.', $embed));
    }

    /**
     * Parse a raw expression into an Expression
     *
     * @param $expr
     *
     * @return Expression
     *
     * @throws Expressions\Exceptions\InvalidExpressionException
     */
    protected function parseExpression($expr)
    {
        return (new ExpressionParser($expr))->parse();
    }
}
