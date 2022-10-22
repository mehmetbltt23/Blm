<?php

namespace Mehmetb\BLM\Tests;

use http\Exception\InvalidArgumentException;
use Mehmetb\BLM\Creator;
use Mehmetb\BLM\CreatorStructs\DataStruct;
use Mehmetb\BLM\CreatorStructs\DefinitionStruct;
use Mehmetb\BLM\CreatorStructs\HeaderStruct;
use Mehmetb\BLM\Exceptions\BLMException;
use PHPUnit\Framework\TestCase;

class CreatorTest extends TestCase
{
    public function testDataStruct()
    {
        $struct = new DataStruct();
        $data_test = (new Data())->dataTest();
        $all_data = [];
        foreach ($data_test as $key => $items) {
            switch ($key) {
                case 'details':
                    foreach ($items as $detail_key => $detail) {
                        $struct->setDetail($detail_key, $detail);
                        $all_data[$detail_key] = $detail;
                    }
                    break;

                case 'features':
                    foreach ($items as $feature) {
                        $k = $struct->setFeature($feature);
                        $all_data[$k] = $feature;
                    }
                    break;

                case 'images':
                    foreach ($items as $image) {
                        $k = $struct->setImage($image['path'], $image['text']);
                        $all_data[$k['path_key']] = $image['path'];
                        $all_data[$k['title_key']] = $image['text'];
                    }
                    break;

                case 'floor_plans':
                    foreach ($items as $floor_plan) {
                        $k = $struct->setFloorPlan($floor_plan['path'], $floor_plan['text']);
                        $all_data[$k['path_key']] = $floor_plan['path'];
                        $all_data[$k['title_key']] = $floor_plan['text'];
                    }
                    break;

                case 'documents':
                    foreach ($items as $document) {
                        $k = $struct->setDocument($document['path'], $document['text']);
                        $all_data[$k['path_key']] = $document['path'];
                        $all_data[$k['title_key']] = $document['text'];
                    }
                    break;

                case 'virtual_tours':
                    foreach ($items as $virtual_tour) {
                        $k = $struct->setVirtualTour($virtual_tour['path'], $virtual_tour['text']);
                        $all_data[$k['path_key']] = $virtual_tour['path'];
                        $all_data[$k['title_key']] = $virtual_tour['text'];
                    }
                    break;

                default:
                    $this->fail('invalid type ' . $key);

            }
        }

        $get_data = $struct->getData();
        $this->assertNotEmpty($get_data);

        foreach ($all_data as $key => $value) {
            $val = $get_data[$key] ?? '--';
            $this->assertArrayHasKey($key, $get_data);
            $this->assertEquals($value, $val, $value . ' not equal to ' . $val);
        }

        $this->assertNotEmpty($struct->getRaw(array_keys($all_data)));
    }

    public function testDefinitionStruct()
    {
        $definition = new DefinitionStruct();
        $definition->pushKey(DataStruct::ADDRESS_1);
        $definition->pushKey(DataStruct::ADDRESS_2);
        $definition->pushKey(DataStruct::TOWN);
        $definition->pushKey(DataStruct::POSTCODE1);
        $definition->pushKey(DataStruct::POSTCODE2);

        $this->assertCount(5, $definition->getKeys());
        $this->assertNotEmpty($definition->getRaw());
        $this->assertEquals($definition->getRaw(), "#DEFINITION#\n" . implode('|', $definition->getKeys()) . "|~\n");
    }

    public function testHeaderStruct()
    {
        $header = new HeaderStruct();
        $this->assertNotEmpty($header->getRaw());
        $this->assertEquals(0, $header->getPropertyCount());
        $this->assertNotNull($header->getGenerateDate());
        $this->assertEquals(3, $header->getVersion());
        $this->assertEquals('|', $header->getEof());
        $this->assertEquals('~', $header->getEor());

        $header->setPropertyCount(12);
        $date = date('Y-m-d H:i');
        $header->setGenerateDate($date);
        $header->setVersion(2);
        $header->setEof('||');
        $header->setEor('~~');

        $this->assertNotEmpty($header->getRaw());
        $this->assertEquals(12, $header->getPropertyCount());
        $this->assertEquals($date, $header->getGenerateDate());
        $this->assertEquals(2, $header->getVersion());
        $this->assertEquals('||', $header->getEof());
        $this->assertEquals('~~', $header->getEor());

    }

    public function testCreator()
    {
        $test_data[] = (new Data())->dataTest();
        $test_data[] = (new Data())->dataTest();
        $test_data[] = (new Data())->dataTest();
        $test_data[] = (new Data())->dataTest();
        $test_data[] = (new Data())->dataTest();
        $test_data[] = (new Data())->dataTest();

        $creator = new Creator();
        foreach ($test_data as $t) {
            $struct = new DataStruct();
            foreach ($t as $key => $items) {
                switch ($key) {
                    case 'details':
                        foreach ($items as $detail_key => $detail) {
                            $struct->setDetail($detail_key, $detail);
                        }
                        break;

                    case 'features':
                        foreach ($items as $feature) {
                            $struct->setFeature($feature);
                        }
                        break;

                    case 'images':
                        foreach ($items as $image) {
                            $struct->setImage($image['path'], $image['text']);
                        }
                        break;

                    case 'floor_plans':
                        foreach ($items as $floor_plan) {
                            $struct->setFloorPlan($floor_plan['path'], $floor_plan['text']);
                        }
                        break;

                    case 'documents':
                        foreach ($items as $document) {
                            $struct->setDocument($document['path'], $document['text']);
                        }
                        break;

                    case 'virtual_tours':
                        foreach ($items as $virtual_tour) {
                            $struct->setVirtualTour($virtual_tour['path'], $virtual_tour['text']);
                        }
                        break;

                    default:
                        $this->fail('invalid type ' . $key);

                }
            }

            $this->assertNotEmpty($struct->getData());
            $creator->push($struct);
        }

        $creator->getContent();
        $this->addToAssertionCount(1);
        $file = $creator->save('data');
        $this->fileExists($file);
        unlink($file);
    }
}