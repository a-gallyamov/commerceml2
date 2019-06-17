<?php namespace A_Gallyamov\CommerceML\Model;

use A_Gallyamov\CommerceML\ORM\Model;

class Category extends Model
{
    /**
     * @var string $id
     */
    public $id;

    /**
     * @var string $name
     */
    public $name;

    /**
     * @var string $parent
     */
    public $parent;

    /**
     * @var string $status
     */
    public $status;

    /**
     * Create instance from file.
     *
     * @param null $importXml
     * @return \A_Gallyamov\CommerceML\Model\Category
     */
    public function __construct($importXml = null)
    {
        if (! is_null($importXml)) {
            $this->loadImport($importXml);
        }
    }

    /**
     * Load category data from import.xml.
     *
     * @param SimpleXMLElement $xml
     * @return void
     */
    public function loadImport($xml)
    {
        $this->id = (string) $xml->Ид;

        $this->name = (string) $xml->Наименование;

        $this->status = ($xml->Статус) ? trim($xml->Статус) : '';
    }

    /**
     * Add children category.
     *
     * @param Category $category
     * @return void
     */
    public function addChild($category)
    {
        $category->parent = $this->id;
    }

    /**
     * Add products to category.
     *
     * @param Collection $products
     * @return void
     */
    public function attachProducts($products)
    {
        $this->products = array();
        foreach ($products->fetch() as $product) {
            if (array_key_exists($this->id, $product->categories)) {
                $this->products[$product->id] = $product;
            }
        }
    }
}
