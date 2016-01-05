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
     * @dataProvider getRepositories
     */
    public function testCompare($repo1, $repo2)
    {
        $result = $this->comparator->compare([$repo2, $repo1]);
        $this->assertEquals('first', $result[0]->username);
        $this->assertEquals('second', $result[1]->username);
    }

    /**
     * @group unit
     * @dataProvider getRepositories
     */
    public function testCompareWithOptions($repo1, $repo2)
    {
        $result = $this->comparator->compare(
            [
                $repo1,
                $repo2,
            ],
            [
                'open_issues' => 1000,
            ]
        );
        $this->assertEquals('second', $result[0]->username);
        $this->assertEquals('first', $result[1]->username);
    }

    public function getRepositories()
    {
        $repo1 = new Repository('first', 'repo1');
        $repo1->size = 85000;
        $repo1->stargazersCount = 15000;
        $repo1->forks = 450;
        $repo1->openIssues = 300;

        $repo2 = new Repository('second', 'repo1');
        $repo2->size = 5000;
        $repo2->stargazersCount = 1000;
        $repo2->forks = 40;
        $repo2->openIssues = 30000;

        return [
            [$repo1, $repo2],
        ];
    }
}
