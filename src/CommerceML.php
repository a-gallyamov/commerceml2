<?php namespace A_Gallyamov\CommerceML;

use A_Gallyamov\CommerceML\Model\Category;
use A_Gallyamov\CommerceML\Model\CategoryCollection;
use A_Gallyamov\CommerceML\Model\PriceType;
use A_Gallyamov\CommerceML\Model\PriceTypeCollection;
use A_Gallyamov\CommerceML\Model\Product;
use A_Gallyamov\CommerceML\Model\ProductCollection;
use A_Gallyamov\CommerceML\Model\Property;
use A_Gallyamov\CommerceML\Model\PropertyCollection;
use A_Gallyamov\CommerceML\ORM\Collection;


class CommerceML
{

    /**
     * Data collections.
     *
     * @var array|Collection[]
     */
    protected $collections = [];
    private $file_offers;
    private $file_import;

    /**
     * Class constructor.
     *
     * @return \A_Gallyamov\CommerceML\CommerceML
     */
    public function __construct()
    {
        $this->collections = [
            'category'  => new CategoryCollection(),
            'product'   => new ProductCollection(),
            'priceType' => new PriceTypeCollection(),
            'property'  => new PropertyCollection()
        ];
    }

    /**
     * Add XML files.
     *
     * @param string|bool $importXml
     * @param string|bool $offersXml
     */
    public function addXmls($importXml = false, $offersXml = false)
    {

        if ($importXml) {
            $importXml = $this->loadXml($importXml);

            $this->parseCategories($importXml);
            $this->parseProperties($importXml);
            $this->file_import = $importXml;
        }

        if ($offersXml) {
            $offersXml = $this->loadXml($offersXml);

            $this->parsePriceTypes($offersXml);
            $this->file_offers = $offersXml;
        }

        $this->parseProducts($importXml, $offersXml);
    }

    /**
     * Parse products.
     *
     *
     * @param bool|\SimpleXMLElement $importXml
     * @param bool|\SimpleXMLElement $offersXml
     */
    public function parseProducts($importXml = false, $offersXml = false)
    {
        $buffer = [
            'products' => []
        ];

        if ($importXml) {
            if ($importXml->Каталог->Товары) {
                foreach ($importXml->Каталог->Товары->Товар as $product) {
                    $productId                                = (string)$product->Ид;
                    $buffer['products'][$productId]['import'] = $product;
                }
            }
        }

        if ($offersXml) {
            if ($offersXml->ПакетПредложений->Предложения) {
                foreach ($offersXml->ПакетПредложений->Предложения->Предложение as $offer) {
                    $productId                               = (string)$offer->Ид;
                    $buffer['products'][$productId]['offer'] = $offer;
                }
            }
        }

        foreach ($buffer['products'] as $item) {
            $import = isset($item['import']) ? $item['import'] : null;
            $offer  = isset($item['offer']) ? $item['offer'] : null;

            $product = new Product($import, $offer);
            $this->getCollection('product')->add($product);
        }
    }

    /**
     * Parse categories.
     *
     * @param \SimpleXMLElement $importXml
     * @param \SimpleXMLElement [$parent]
     *
     * @return void
     */
    public function parseCategories($importXml, $parent = null)
    {
        $xmlCategories = ($importXml->Классификатор->Группы)
            ? $importXml->Классификатор->Группы
            : $xmlCategories = $importXml;

        foreach ($xmlCategories->Группа as $xmlCategory) {
            $category = new Category($xmlCategory);

            if (!is_null($parent)) {
                $parent->addChild($category);
            }

            $this->getCollection('category')->add($category);

            if ($xmlCategory->Группы) {
                $this->parseCategories($xmlCategory->Группы, $category);
            }
        }
    }

    /**
     * Parse price types.
     *
     * @param \SimpleXMLElement $offersXml
     *
     * @return $data
     */
    public function parsePriceTypes($offersXml)
    {
        if ($offersXml->ПакетПредложений->ТипыЦен) {
            foreach ($offersXml->ПакетПредложений->ТипыЦен->ТипЦены as $xmlPriceType) {
                $priceType = new PriceType($xmlPriceType);
                $this->getCollection('priceType')->add($priceType);
                $data[] = $priceType;
            }

            return $data;
        }
    }

    /**
     * @param \SimpleXMLElement $importXml
     *
     * @return $data
     */
    public function parseProperties($importXml)
    {
        if ($importXml->Классификатор->Свойства) {
            foreach ($importXml->Классификатор->Свойства->Свойство as $xmlProperty) {
                $property = new Property($xmlProperty);
                $this->getCollection('property')->add($property);
                $data[] = $property;
            }

            return $data;
        }
    }

    /**
     * Get Properties.
     *
     * @return array
     */
    public function getProperties()
    {
        return $this->parseProperties($this->file_import);
    }

    /**
     * Get categories.
     *
     * @param array [$attach]
     *
     * @return array|Category[]
     */
    public function getCategories($attach = [])
    {
        $categories = $this->getCollection('category');

        foreach ($attach as $collection) {
            if (isset($this->collections[$collection])) {
                $categories->attach($this->collections[$collection]);
            }
        }

        return $categories->fetch();
    }

    /**
     * Get products.
     *
     * @param array $attach
     *
     * @return array|Product[]
     */
    public function getProducts($attach = [])
    {
        $products = $this->getCollection('product');

        foreach ($attach as $collection) {
            if (isset($this->collections[$collection])) {
                $products->attach($this->collections[$collection]);
            }
        }

        return $products->fetch();
    }

    /**
     * @param $name
     *
     * @return Collection
     */
    public function getCollection($name)
    {
        return $this->collections[$name];
    }

    /**
     * Get Price Type.
     *
     * @return array
     */
    public function getPriceType()
    {
        return $this->parsePriceTypes($this->file_offers);
    }


    /**
     * Load XML form file or string.
     *
     * @param string $xml
     *
     * @return \SimpleXMLElement
     */
    private function loadXml($xml)
    {
        return is_file($xml)
            ? simplexml_load_file($xml)
            : simplexml_load_string($xml);
    }

}
