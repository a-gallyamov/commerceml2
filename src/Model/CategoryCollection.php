<?php namespace A_Gallyamov\CommerceML\Model;

use A_Gallyamov\CommerceML\ORM\Collection;

class CategoryCollection extends Collection
{
    /**
     * Attach products to categories.
     *
     * @param ProductCollection $productCollection
     * @return void
     */
    public function attachProductCollection($productCollection)
    {
        foreach ($this->fetch() as $category) {
            $category->attachProducts($productCollection);
        }
    }
}
