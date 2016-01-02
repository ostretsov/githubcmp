<?php

/**
 * (c) Artem Ostretsov <artem@ostretsov.ru>
 * Created at 01.01.2016 11:52.
 */

namespace Githubcmp;

use Doctrine\Common\Annotations\AnnotationReader;
use Githubcmp\Annotation\Weight;
use Githubcmp\Model\Repository;
use Symfony\Component\PropertyAccess\PropertyAccess;

class Comparator
{
    /**
     * @param Repository[] $repositories
     *
     * @return Repository[]
     */
    public function compare(array $repositories)
    {
        if (count($repositories) < 2) {
            throw new \InvalidArgumentException('At least two Repositories must be specified!');
        }

        $reflectedClass = new \ReflectionClass(Repository::class);
        $reader = new AnnotationReader();

        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $totalWeight = 0.0;
        foreach ($repositories as $repository) {
            /* @var Repository $repository */
            foreach ($reflectedClass->getProperties() as $property) {
                foreach ($reader->getPropertyAnnotations($property) as $annotation) {
                    if ($annotation instanceof Weight) {
                        $repository->addWeight($propertyAccessor->getValue($repository, $property->name) * $annotation->value);
                    }
                }
            }
            $totalWeight += $repository->getWeight();
        }

        // Sort in ascending order according to repository's weight
        usort($repositories, function (Repository $a, Repository $b) {
            return $b->getWeight() - $a->getWeight();
        });

        // Calculate rating
        $left = 100;
        foreach ($repositories as $repository) {
            /* @var Repository $repository */
            $rating = floor(100 * $repository->getWeight() / $totalWeight);
            $repository->setRating($rating);
            $left -= $rating;
        }

        // The leader is rated better than others
        $repositories[0]->addRating($left);

        return $repositories;
    }
}
