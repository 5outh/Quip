<?php

namespace Quip\Entities;

use Quip\Exceptions\NoSuchSortException;

class Sort
{
    const TYPE_ASC = 'TYPE_ASC';
    const TYPE_DESC = 'TYPE_DESC';

    protected $field;
    protected $type;

    /**
     * Construct a new Sort, throws an error if type doesn't match ASC or DESC.
     *
     * @param $type
     * @param $field
     *
     * @throws NoSuchSortException
     */
    public function __construct($type, $field)
    {
        if ($type !== static::TYPE_ASC && $type !== static::TYPE_DESC) {
            throw new NoSuchSortException();
        }

        $this->type = $type;
        $this->field = $field;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
    /**
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param mixed $field
     */
    public function setField($field)
    {
        $this->field = $field;
    }
}