<?php

namespace Mehmetb\BLM\Tests;

use Mehmetb\BLM\Creator;
use Mehmetb\BLM\CreatorStructs\DataStruct;
use Mehmetb\BLM\CreatorStructs\DefinitionStruct;
use PHPUnit\Framework\TestCase;

class CreatorTest extends TestCase
{
    public function testA()
    {
        var_dump(strtoupper('mehmEt'));die;
        $dt = fopen('export/files/veri.txt', 'w');
        fwrite($dt, '1');
        fwrite($dt, '23');
        fclose($dt);

        die;
        $file_name = '/aaa.BLM.BLM';
        $path = '/pp/bbb/';
        var_dump(pathinfo($path . $file_name));
        die;
        var_dump(implode('|', ['a']));
        die;
        //1 ev için

        $creator = new Creator();
        for ($i = 0; $i < 10; $i++) {
            $data = new DataStruct();
            $data->setDetail(DataStruct::ADDRESS_1, '1234');
            $data->setDetail(DataStruct::ADDRESS_2, 'aaa');
            $data->setDetail(DataStruct::TOWN, 'bbb');
            $data->setImage('/path', 'title');
            $data->setImage('/path2', 'title2');

            $creator->push($data);
        }


        $class = new Creator();
        $class->output($data);
    }
}