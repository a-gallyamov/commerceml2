<?php namespace A_Gallyamov\CommerceML\Model;

use A_Gallyamov\CommerceML\ORM\Model;

class Property
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
     * @var array $values
     */
    public $values = array();

    /**
     * @param SimpleXMLElement|null $importXml
     * @return \A_Gallyamov\CommerceML\Model\Property
     */
    public function __construct($importXml = null)
    {
        if (! is_null($importXml)) {
            $this->loadImport($importXml);
        }
    }

    /**
     * @param SimpleXMLElement $xml
     * @return void
     */
    public function loadImport($xml)
    {
        $this->id = (string) $xml->Ид;

        $this->name = (string) $xml->Наименование;

        $valueType = (string) $xml->ТипЗначений;

        if ($valueType == 'Справочник' && $xml->ВариантыЗначений) {
            foreach ($xml->ВариантыЗначений->Справочник as $value) {
                $id = (string) $value->ИдЗначения;
                $this->values[$id] = (string) $value->Значение;
            }
        }
    }

    /**
     * @param string $valueId
     * @return null|string
     */
    public function getValue($valueId)
    {
        if (isset($this->values[$valueId])) {
            return $this->values[$valueId];
        }

        return null;
    }
}