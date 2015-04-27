<?php

namespace Quip\Entities;

class EmbedChain
{
    protected $chain = [];

    /**
     * Construct a new EmbedChain
     *
     * @param $chain
     */
    public function __construct($chain)
    {
        $this->chain = $chain;
    }

    /**
     * Get the embed chain
     *
     * @return array
     */
    public function getChain()
    {
        return $this->chain;
    }

    /**
     * Set the embed chain
     *
     * @param array $chain
     */
    public function setChain($chain)
    {
        $this->chain = $chain;
    }
}
