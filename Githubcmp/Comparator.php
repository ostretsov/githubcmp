<?php

/**
 * (c) Artem Ostretsov <artem@ostretsov.ru>
 * Created at 01.01.2016 11:52.
 */

namespace Githubcmp;

use Doctrine\Common\Annotations\AnnotationReader;
use Githubcmp\Annotation\Weight;
use Githubcmp\Model\Repository;

class Comparator
{
    /**
     * @param Repository[] $repositories
     */
    public function compare(array $repositories)
    {
        $reflectedClass = new \ReflectionClass(Repository::class);
        $reader = new AnnotationReader();

        foreach ($reflectedClass->getProperties() as $property) {
            foreach ($reader->getPropertyAnnotations($property) as $annotation) {
                if ($annotation instanceof Weight) {
                }
            }
        }

        return [];
    }
}
