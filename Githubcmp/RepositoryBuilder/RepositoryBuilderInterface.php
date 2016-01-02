<?php

/**
 * (c) Artem Ostretsov <artem@ostretsov.ru>
 * Created at 02.01.2016 16:28.
 */

namespace Githubcmp\RepositoryBuilder;

use Githubcmp\Model\Repository;

interface RepositoryBuilderInterface
{
    /**
     * @return Repository
     */
    public function getResult();
}
