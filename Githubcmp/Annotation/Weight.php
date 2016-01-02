<?php

/**
 * (c) Artem Ostretsov <artem@ostretsov.ru>
 * Created at 02.01.2016 09:00.
 */

namespace Githubcmp\Annotation;

use Doctrine\Common\Annotations\Annotation\Attribute;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class Weight
{
    /**
     * @Attribute(required=true, type="float")
     */
    public $value;
}
