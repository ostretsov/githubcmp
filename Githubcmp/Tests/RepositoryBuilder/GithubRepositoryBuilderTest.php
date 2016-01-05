<?php

/**
 * (c) Artem Ostretsov <artem@ostretsov.ru>
 * Created at 02.01.2016 16:38.
 */

namespace Githubcmp\Tests\RepositoryBuilder;

use Githubcmp\Comparator;
use Githubcmp\Model\Repository;
use Githubcmp\RepositoryBuilder\GithubRepositoryBuilder;

class GithubRepositoryBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group functional
     */
    public function testBuild()
    {
        if (!defined('API_TOKEN')) {
            throw new \RuntimeException('API_TOKEN constant must be defined in phpunit.xml file!');
        }

        $builder = new GithubRepositoryBuilder(API_TOKEN);

        $symfonyRepository = $builder->build('symfony', 'symfony')->getResult();
        $laravelRepository = $builder->build('laravel', 'laravel')->getResult();
        $yii2Repository = $builder->build('yiisoft', 'yii2')->getResult();
        $codeIgniterRepository = $builder->build('bcit-ci', 'CodeIgniter')->getResult();

        // check built repositories
        $this->checkBuiltRepository($symfonyRepository);
        $this->checkBuiltRepository($laravelRepository);
        $this->checkBuiltRepository($yii2Repository);
        $this->checkBuiltRepository($codeIgniterRepository);

        $comparator = new Comparator();
        $result = $comparator->compare([$symfonyRepository, $laravelRepository, $yii2Repository, $codeIgniterRepository]);

        // check results
        $this->assertCount(4, $result);

        foreach ($result as $repository) {
            $this->checkBuiltRepository($repository);
            $this->assertGreaterThan(0, $repository->getWeight());
            $this->assertGreaterThan(0, $repository->getRating());
        }
    }

    private function checkBuiltRepository(Repository $repository)
    {
        $this->assertGreaterThan(0, $repository->size);
        $this->assertGreaterThan(0, $repository->stargazersCount);
        $this->assertGreaterThan(0, $repository->forks);
        $this->assertGreaterThan(0, $repository->openIssues);
        $this->assertGreaterThan(0, $repository->subscribersCount);
        $this->assertGreaterThan(0, $repository->userPublicRepos);
        $this->assertGreaterThan(0, $repository->commitsCount);
        $this->assertGreaterThan(0, $repository->commitsLastMonthCount);
        $this->assertGreaterThan(0, $repository->avgCommitsPerWeek);
        $this->assertGreaterThan(0, $repository->contributorsCount);
    }
}
