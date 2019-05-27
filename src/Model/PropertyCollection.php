<?php namespace A_Gallyamov\CommerceML\Model;

use A_Gallyamov\CommerceML\ORM\Collection;

class PropertyCollection extends Collection
{
    /**
     * @param string $propId
     * @param string $valueId
     * @return null|string
     */
    public function getValue($propId, $valueId)
    {
        if (! is_null($prop = $this->get($propId))) {
            return $prop->getValue($valueId);
        }

        return null;
    }

    /**
     * @param string $propId
     * @return null|string
     */
    public function getName($propId)
    {
        if (! is_null($prop = $this->get($propId))) {
            return $prop->name;
        }

        return null;
    }
}
