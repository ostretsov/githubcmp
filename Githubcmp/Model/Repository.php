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
     * @Weight(0.2)
     */
    public $size;

    /**
     * @var int
     *
     * @Weight(0.7)
     */
    public $stargazersCount;

    /**
     * @var int
     *
     * @Weight(1)
     */
    public $forks;

    /**
     * @var int
     *
     * @Weight(0.2)
     */
    public $openIssues;

    /**
     * @var int
     *
     * @Weight(1)
     */
    public $subscribersCount;

    /**
     * @var int
     *
     * @Weight(0.2)
     */
    public $userPublicRepos;

    /**
     * @var int
     *
     * @Weight(0.5)
     */
    public $commitsCount;

    /**
     * @var int
     *
     * @Weight(0.8)
     */
    public $commitsLastMonthCount;

    /**
     * @var int
     *
     * @Weight(2)
     */
    public $avgCommitsPerWeek;

    /**
     * @var int
     *
     * @Weight(1)
     */
    public $contributorsCount;

    /**
     * @var float
     */
    private $weight;

    /**
     * @var int Rating in percentage
     */
    private $rating;

    public function __construct($username, $repository)
    {
        $this->username = $username;
        $this->repository = $repository;
        $this->weight = 0.0;
        $this->rating = 0;
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

    /**
     * @return int
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param int $rating
     */
    public function setRating($rating)
    {
        if ($rating > 100) {
            throw new \InvalidArgumentException('Rating can\'t be greater than 100!');
        }

        $this->rating = $rating;
    }

    /**
     * @param int $delta
     */
    public function addRating($delta)
    {
        if ($this->rating + $delta > 100) {
            throw new \InvalidArgumentException('Rating can\'t be greater than 100!');
        }

        $this->rating += $delta;
    }
}
