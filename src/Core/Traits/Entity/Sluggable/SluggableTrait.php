<?php

namespace App\Core\Traits\Entity\Sluggable;

use Knp\DoctrineBehaviors\Model\Sluggable\SluggablePropertiesTrait;

trait SluggableTrait
{
    use SluggablePropertiesTrait;
    use SluggableMethodsTrait;
}
