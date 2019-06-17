<?php namespace A_Gallyamov\CommerceML\Model;

use A_Gallyamov\CommerceML\ORM\Model;

class StorageList extends Model
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /*
     * @param SimpleXMLElement [$xmlPriceType]
     * @return \A_Gallyamov\CommerceML\Model\StorageList
     */
    public function __construct($xmlStorageList = null)
    {
        if (! is_null($xmlStorageList)) {
            $this->loadImport($xmlStorageList);
        }
    }

    /**
     * @param SimpleXMLElement [$xmlPriceType]
     * @return void
     */
    private function loadImport($xmlStorageList)
    {
        $this->id = (string) $xmlStorageList->Ид;

        $this->name = (string) $xmlStorageList->Наименование;
    }
}
