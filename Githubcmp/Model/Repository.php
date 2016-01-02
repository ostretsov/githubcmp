<?php

/**
 * (c) Artem Ostretsov <artem@ostretsov.ru>
 * Created at 01.01.2016 12:53.
 */

namespace Githubcmp\Model;

use Githubcmp\Annotation\Weight;

class Repository
{
    public $username;

    public $repository;

    /**
     * @var int
     *
     * @Weight(0.1)
     */
    public $size;

    /**
     * @var int
     *
     * @Weight(1)
     */
    public $stargazersCount;

    /**
     * @var int
     *
     * @Weight(0.5)
     */
    public $forks;

    /**
     * @var int
     *
     * @Weight(0.1)
     */
    public $openIssues;

    /**
     * @var float
     */
    private $weight;

    public function __construct()
    {
        $this->weight = 0.0;
    }

    /**
     * @param $delta float
     */
    public function addWeight($delta)
    {
        $this->weight += $delta;
    }

    /**
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }
}
