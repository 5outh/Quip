<?php

namespace Quip\Entities;

/**
 * Class Query
 *
 * Represents a parsed query string
 *
 * @package Quip\Entities
 */
class Query
{
    // Embedded objects
    protected $embeds = [];

    // Sorts (primary first)
    protected $sorts = [];

    // Filters to apply
    protected $expressions = [];

    // Fields to explicitly include
    protected $includes = [];

    // Fields to explicitly exclude
    protected $excludes = [];

    // Raw input from Laravel's parse
    protected $rawInput;

    /**
     * Construct a query
     *
     * @param $input
     */
    public function __construct($input)
    {
        $this->rawInput = $input;
    }

    /**
     * Check if the query contains a certain key
     *
     * @param $key
     *
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $this->rawInput);
    }

    /**
     * Get the raw input for query key
     *
     * @param $key
     *
     * @return mixed
     */
    public function getRaw($key)
    {
        return $this->rawInput[$key];
    }

    /**
     * Alias for `getRaw`
     *
     * @param $key
     *
     * @return mixed
     */
    public function getExtra($key)
    {
        return $this->getRaw($key);
    }

    /**
     * Get the included fields
     *
     * @return array
     */
    public function getIncludes()
    {
        return $this->includes;
    }

    /**
     * Set included fields
     *
     * @param array $includes
     */
    public function setIncludes($includes)
    {
        $this->includes = $includes;
    }

    /**
     * Add a field
     *
     * @param $include
     */
    public function addInclude($include)
    {
        $this->includes[] = $include;
    }

    /**
     * Get the excluded fields
     *
     * @return array
     */
    public function getExcludes()
    {
        return $this->excludes;
    }

    /**
     * Set the excluded fields
     *
     * @param array $excludes
     */
    public function setExcludes($excludes)
    {
        $this->excludes = $excludes;
    }

    /**
     * Add an excluded field
     *
     * @param $exclude
     */
    public function addExclude($exclude)
    {
        $this->excludes[] = $exclude;
    }

    /**
     * Get the embeds
     *
     * @return array
     */
    public function getEmbeds()
    {
        return $this->embeds;
    }

    /**
     * Set the embeds
     *
     * @param array $embeds
     */
    public function setEmbeds($embeds)
    {
        $this->embeds = $embeds;
    }

    /**
     * Add an embed
     *
     * @param $embed
     */
    public function addEmbed($embed)
    {
        $this->embeds[] = $embed;
    }

    /**
     * Get all sorting functions
     *
     * @return array
     */
    public function getSorts()
    {
        return $this->sorts;
    }

    /**
     * Set the sorting functions
     *
     * @param array $sorts
     */
    public function setSorts($sorts)
    {
        $this->sorts = $sorts;
    }

    /**
     * Add a sorting function
     *
     * @param $sort
     */
    public function addSort($sort)
    {
        $this->sorts[] = $sort;
    }

    /**
     * Get the expressions array
     *
     * @return array
     */
    public function getExpressions()
    {
        return $this->expressions;
    }

    /**
     * Set the expressions array
     *
     * @param array $expressions
     */
    public function setExpressions($expressions)
    {
        $this->expressions = $expressions;
    }

    /**
     * Add an expression
     *
     * @param $expression
     */
    public function addExpression($expression)
    {
        $this->expressions[] = $expression;
    }
}
