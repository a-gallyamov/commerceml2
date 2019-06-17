PHP CommerceML2
==============

Библиотека с небольшими правками для универсального парсинга CommerceML2 файлов. <br />
Автор оригинальной сборки: [Zenwalker](https://github.com/zenwalker/php-commerceml)

```composer log
composer require a-gallyamov/commerceml2
```

==============


```php
$comm = new CommerceML();
$comm->addXmls('import.xml', 'offers.xml');


//Типы цен
$comm->getPriceType();
Array
(
    [0] => PriceType Object
        (
            [id] => 60823afe-7f09-11d6-6e95-00s081b7a3xz
            [type] => Опт
            [currency] => RUB
        )

    [1] => PriceType Object
        (
            [id] => f4bccefe-ccfd-11d6-b489-00s081b7a3xz
            [type] => Розница
            [currency] => RUB
        )

    [2] => PriceType Object
        (
            [id] => 61300ccc-9126-11d6-0e9d-00s081b7a3xz
            [type] => Дилер
            [currency] => RUB
        )
)


//Категории
$comm->getCategories();
Array
(
    [b7f51e7a-65c8-11e9-938c-000c29be8ff7] => Category Object
        (
            [id] => b7f51e7a-65c8-11e9-938c-000c29be8ff7
            [name] => Товары
            [parent] => 
            [status] => 
        )

    [8a3557f2-4c00-11de-9f89-001d605cb50d] => Category Object
        (
            [id] => 8a3557f2-4c00-11de-9f89-001d605cb50d
            [name] => Оборудование
            [parent] => b7f51e7a-65c8-11e9-938c-000c29be8ff7
            [status] => 
        )
)


//Скипок складов
$comm->getStorageList();
Array
(
    [0] => SimpleXMLElement Object
        (
            [Ид] => 973117ad-a01a-11d6-0f82-00e081b7a3cf
            [Наименование] => Склад 1
        )

    [1] => SimpleXMLElement Object
        (
            [Ид] => a41bfa6d-e933-11d6-2c88-00e081b7a3cf
            [Наименование] => Склад 2
        )

    [2] => SimpleXMLElement Object
        (
            [Ид] => 5ba00e29-9525-11d6-5580-00e081b7a3cf
            [Наименование] => Склад 3
        )
)


//Продукция
$comm->getProducts();
Array
(
    [9c2c8c15-79c4-11e8-a8ba-20cf306f1f25] => Product Object
        (
            [id] => 9c2c8c15-79c4-11e8-a8ba-20cf306f1f25
            [name] => Тормозная площадка НР 1022/3050/3052/3055 (CET3843)
            [sku] => CET3843
            [unit] => шт
            [description] => Тормозная площадка
            [status] => 
            [quantity] => 10
            [price] => Array
                (
                    [61300ccc-9126-11d6-0e9d-00s081b7a3xz] => Array
                        (
                            [type] => 61300ccc-9126-11d6-0e9d-00s081b7a3xz
                            [currency] => USD
                            [value] => 2.5
                        )

                    [60823afe-7f09-11d6-6e95-00s081b7a3xz] => Array
                        (
                            [type] => 60823afe-7f09-11d6-6e95-00s081b7a3xz
                            [currency] => руб
                            [value] => 169
                        )

                    [f4bccefe-ccfd-11d6-b489-00s081b7a3xz] => Array
                        (
                            [type] => f4bccefe-ccfd-11d6-b489-00s081b7a3xz
                            [currency] => руб
                            [value] => 183
                        )

                )

            [categories] => Array
                (
                    [0] => 8a3557f2-4c00-11de-9f89-001d605cb50d
                )

            [requisites] => Array
                (
                    [ВидНоменклатуры] => Товар
                    [ТипНоменклатуры] => Товар
                    [Полное наименование] => Тормозная площадка НР 1022/3050/3052/3055
                    [Вес] => 0
                )

            [properties] => Array
                (
                    [c8f57c26-5ecd-11e6-a19e-00e081b7a3df] => HP: LaserJet 1022
                    [6d09526e-7a7c-11e6-a792-00e081b7a3df] => 3d9e5484-44b2-11e9-e481-000c29be8ff7
                )

            [storage] => Array
                (
                    [973117ad-a01a-11d6-0f82-00e081b7a3cf] => 0
                    [a41bfa6d-e933-11d6-2c88-00e081b7a3cf] => 40
                    [5ba00e29-9525-11d6-5580-00e081b7a3cf] => 112
                )
        )
)


//Свойства
$comm->getProperties();
Array
(
    [0] => Property Object
        (
            [id] => c8f57c26-5ecd-11e6-a19e-00e081b7a3df
            [name] => Наименование
            [values] => Array
                (
                )

        )

    [1] => Property Object
        (
            [id] => 6d09526e-7a7c-11e6-a792-00e081b7a3df
            [name] => Цвет
            [values] => Array
                (
                    [3d9e5484-44b2-11e9-e481-000c29be8ff7] => черный
                )

        )
)
```