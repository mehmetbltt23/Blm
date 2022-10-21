<?php

namespace Mehmetb\BLM\Tests;

use Mehmetb\BLM\Creator;
use Mehmetb\BLM\structs\DataStruct;
use PHPUnit\Framework\TestCase;

class CreatorTest extends TestCase
{
    public function testA()
    {
        //1 ev için
        $data = new DataStruct();
        $data->setDetail(DataStruct::ADDRESS_1, '1234');
        $data->setDetail(DataStruct::ADDRESS_2, 'aaa');
        $data->setDetail(DataStruct::TOWN, 'bbb');
        $data->setImage('/path', 'title');
        $data->setImage('/path2', 'title2');


        $class = new Creator();
        $class->creator($data);
    }
}