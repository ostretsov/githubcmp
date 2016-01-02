<?php

/**
 * (c) Artem Ostretsov <artem@ostretsov.ru>
 * Created at 02.01.2016 16:28.
 */

namespace Githubcmp\RepositoryBuilder;

use Github\Client;
use Github\ResultPager;
use Githubcmp\Model\Repository;

class GithubRepositoryBuilder implements RepositoryBuilderInterface
{
    /**
     * @var Repository
     */
    private $repository;

    public function __construct($username, $repository)
    {
        $this->repository = new Repository($username, $repository);
        $this->build();
    }

    public function build()
    {
        $client = new Client();

        // repository data
        $data = $client->api('repo')->show($this->repository->username, $this->repository->repository);
        $this->repository->size = $data['size'];
        $this->repository->stargazersCount = $data['stargazers_count'];
        $this->repository->forks = $data['forks'];
        $this->repository->openIssues = $data['open_issues'];
        $this->repository->subscribersCount = $data['subscribers_count'];

        // repository commit activity
        $activity = $client->api('repo')->activity($this->repository->username, $this->repository->repository);
        $this->repository->commitsCount = array_sum(array_map(function (array $weekCommits) { return $weekCommits['total']; }, $activity));

        // repository contributors
        $paginator = new ResultPager($client);
        $contributors = $paginator->fetchAll(
            $client->api('repo'),
            'contributors',
            [
                $this->repository->username,
                $this->repository->repository,
                true,
            ]
        );
        $this->repository->contributorsCount = count($contributors);

        // user data
        $user = $client->api('user')->show($this->repository->username);
        $this->repository->userPublicRepos = $user['public_repos'];
    }

    /**
     * @return Repository
     */
    public function getResult()
    {
        return $this->repository;
    }
}
