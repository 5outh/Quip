<?php

namespace Quip;

use Quip\Entities\EmbedChain;
use Quip\Entities\Query;
use Quip\Entities\Sort;
use Quip\Exceptions\NoSuchSortException;
use Quip\Expressions\Expression;
use Quip\Expressions\ExpressionParser;

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

    private function parseQ()
    {
        if ($this->query->has('q')) {
            $exprs = explode(',', $this->query->getRaw('q'));

            foreach ($exprs as $expr) {
                $this->query->addExpression($this->parseExpression($expr));
            }
        }
    }

    private function parseEmbeds()
    {
        if ($this->query->has('embeds')) {
            $embeds = explode(',', $this->query->getRaw('embeds'));

            foreach ($embeds as $embed) {
                $this->query->addEmbed($this->parseEmbed($embed));
            }
        }
    }

    private function parseIncludes()
    {
        if ($this->query->has('includes')) {
            $this->query->setIncludes(
                explode(',', $this->query->getRaw('includes'))
            );
        }
    }

    private function parseExcludes()
    {
        if ($this->query->has('excludes')) {
            $this->query->setExcludes(
                explode(',', $this->query->getRaw('excludes'))
            );
        }
    }

    private function parseSorts()
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
    private function parseExpression($expr)
    {
        return (new ExpressionParser($expr))->parse();
    }
}
