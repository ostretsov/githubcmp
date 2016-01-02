<?php

/**
 * (c) Artem Ostretsov <artem@ostretsov.ru>
 * Created at 01.01.2016 11:52.
 */

namespace Githubcmp\Tests;

use Githubcmp\Comparator;
use Githubcmp\Model\Repository;

class ComparatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Comparator
     */
    private $comparator;

    protected function setUp()
    {
        $this->comparator = new Comparator();
    }

    /**
     * @group unit
     */
    public function testCompare()
    {
        $repo1 = new Repository();
        $repo1->size = 85000;
        $repo1->stargazersCount = 15000;
        $repo1->forks = 450;
        $repo1->openIssues = 300;

        $repo2 = new Repository();
        $repo2->size = 5000;
        $repo2->stargazersCount = 1000;
        $repo2->forks = 40;
        $repo2->openIssues = 30;

        $result = $this->comparator->compare([$repo1, $repo2]);
    }
}
