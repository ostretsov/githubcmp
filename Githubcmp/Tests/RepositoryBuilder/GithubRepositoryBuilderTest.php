<?php

/**
 * (c) Artem Ostretsov <artem@ostretsov.ru>
 * Created at 02.01.2016 16:38.
 */

namespace Githubcmp\Tests\RepositoryBuilder;

use Githubcmp\Comparator;
use Githubcmp\RepositoryBuilder\GithubRepositoryBuilder;

class GithubRepositoryBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $builder = new GithubRepositoryBuilder('symfony', 'symfony');
        $symfonyRepository = $builder->getResult();

        $builder = new GithubRepositoryBuilder('laravel', 'laravel');
        $laravelRepository = $builder->getResult();

        $comparator = new Comparator();
        $result = $comparator->compare([$symfonyRepository, $laravelRepository]);
    }
}
