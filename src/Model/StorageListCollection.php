<?php namespace A_Gallyamov\CommerceML\Model;

use A_Gallyamov\CommerceML\ORM\Collection;

class StorageListCollection extends Collection
{
    /**
     * Get price type by id.
     *
     * @param $name
     * @return string
     */
    public function getType($name)
    {
        return $this->get($name)->name;
    }
}
