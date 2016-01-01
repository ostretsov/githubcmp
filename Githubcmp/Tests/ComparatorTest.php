<?php

/**
 * (c) Artem Ostretsov <artem@ostretsov.ru>
 * Created at 01.01.2016 11:52
 */
class ComparatorTest extends \PHPUnit_Framework_TestCase
{
    public function testCompare()
    {
        $client = new \Github\Client();
        $repo = $client->api('repo')->show('symfony', 'symfony');
        $ownerRepos = $client->api('user')->setPerPage(50)->repositories('symfony');
    }
}