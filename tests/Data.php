<?php

namespace Mehmetb\BLM\Tests;

use Mehmetb\BLM\CreatorStructs\DataStruct;

class Data
{
    public function dataTest(): array
    {
        return [
            'details' => [
                DataStruct::AGENT_REF => uniqid(),
                DataStruct::ADDRESS_1 => '18',
                DataStruct::ADDRESS_2 => 'Estates',
                DataStruct::TOWN => 'Roud',
                DataStruct::POSTCODE1 => 'CM3',
                DataStruct::POSTCODE2 => '8EQ',
                DataStruct::SUMMARY => uniqid(),
                DataStruct::DESCRIPTION => uniqid(),
                DataStruct::BRANCH_ID => uniqid(),
                DataStruct::STATUS_ID => uniqid(),
                DataStruct::BEDROOMS => uniqid(),
                DataStruct::BATHROOMS => uniqid(),
                DataStruct::LIVING_ROOMS => uniqid(),
                DataStruct::PRICE => uniqid(),
                DataStruct::PRICE_QUALIFIER => uniqid(),
                DataStruct::PROP_SUB_ID => uniqid(),
                DataStruct::CREATE_DATE => uniqid(),
                DataStruct::UPDATE_DATE => uniqid(),
                DataStruct::DISPLAY_ADDRESS => uniqid(),
                DataStruct::PUBLISHED_FLAG => uniqid(),
                DataStruct::LET_DATE_AVAILABLE => uniqid(),
                DataStruct::LET_BOND => uniqid(),
                DataStruct::LET_TYPE_ID => uniqid(),
                DataStruct::LET_FURN_ID => uniqid(),
                DataStruct::LET_RENT_FREQUENCY => uniqid(),
                DataStruct::TRANS_TYPE_ID => uniqid(),
                DataStruct::NEW_HOME_FLAG => uniqid(),
                DataStruct::ADMINISTRATION_FEE => uniqid(),
            ],
            'features' => ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j'],
            'images' => [
                [
                    'path' => '/path/' . uniqid() . 'file.jpeg',
                    'text' => 'test path ' . uniqid()
                ],
                [
                    'path' => '/path/' . uniqid() . 'file.jpeg',
                    'text' => 'test path ' . uniqid()
                ],
                [
                    'path' => '/path/' . uniqid() . 'file.jpeg',
                    'text' => 'test path ' . uniqid()
                ],
                [
                    'path' => '/path/' . uniqid() . 'file.jpeg',
                    'text' => 'test path ' . uniqid()
                ],
                [
                    'path' => '/path/' . uniqid() . 'file.jpeg',
                    'text' => 'test path ' . uniqid()
                ],
                [
                    'path' => '/path/' . uniqid() . 'file.jpeg',
                    'text' => 'test path ' . uniqid()
                ],
                [
                    'path' => '/path/' . uniqid() . 'file.jpeg',
                    'text' => 'test path ' . uniqid()
                ],
                [
                    'path' => '/path/' . uniqid() . 'file.jpeg',
                    'text' => 'test path ' . uniqid()
                ],
                [
                    'path' => '/path/' . uniqid() . 'file.jpeg',
                    'text' => 'test path ' . uniqid()
                ],
                [
                    'path' => '/path/' . uniqid() . 'file.jpeg',
                    'text' => 'test path ' . uniqid()
                ],
                [
                    'path' => '/path/' . uniqid() . 'file.jpeg',
                    'text' => 'test path ' . uniqid()
                ],
            ],
            'floor_plans' => [
                [
                    'path' => '/path/' . uniqid() . 'floor-plan.jpeg',
                    'text' => 'test floor plan ' . uniqid()
                ],
                [
                    'path' => '/path/' . uniqid() . 'floor-plan.jpeg',
                    'text' => 'test floor plan ' . uniqid()
                ]
            ],
            'documents' => [
                [
                    'path' => '/path/' . uniqid() . 'file.doc',
                    'text' => 'test doc ' . uniqid()
                ],
                [
                    'path' => '/path/' . uniqid() . 'file.xls',
                    'text' => 'test xls ' . uniqid()
                ]
            ],
            'virtual_tours' => [
                [
                    'path' => 'https://google.com',
                    'text' => 'virtual tour'
                ]
            ]
        ];
    }
}