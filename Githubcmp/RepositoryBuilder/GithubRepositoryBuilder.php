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
     * @var string
     */
    private $apiToken;

    /**
     * @var Repository
     */
    private $repository = null;

    /**
     * @param string $apiToken
     */
    public function __construct($apiToken = '')
    {
        $this->apiToken = $apiToken;
    }

    public function build($username, $repository)
    {
        $this->repository = new Repository($username, $repository);

        $client = new Client();
        if ($this->apiToken) {
            $client->authenticate($this->apiToken, null, Client::AUTH_HTTP_TOKEN);
        }

        // repository data
        $data = $client->api('repo')->show($this->repository->username, $this->repository->repository);
        $this->repository->size = $data['size'];
        $this->repository->stargazersCount = $data['stargazers_count'];
        $this->repository->forks = $data['forks'];
        $this->repository->openIssues = $data['open_issues'];
        $this->repository->subscribersCount = $data['subscribers_count'];

        // repository commit activity
        $activity = $client->api('repo')->activity($this->repository->username, $this->repository->repository);
        $commitsLastYear = array_map(function (array $weekCommits) { return $weekCommits['total']; }, $activity);
        $this->repository->commitsCount = array_sum($commitsLastYear);
        $this->repository->commitsLastMonthCount = array_sum(array_slice($commitsLastYear, -4));
        $this->repository->avgCommitsPerWeek = floor(array_sum($commitsLastYear) / count($commitsLastYear));

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

        return $this;
    }

    /**
     * @return Repository
     */
    public function getResult()
    {
        if (null === $this->repository) {
            throw new \RuntimeException('Repository was not built!');
        }

        return $this->repository;
    }
}
