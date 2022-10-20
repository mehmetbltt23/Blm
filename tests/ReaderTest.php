<?php

namespace Mehmetb\BLM\Tests;

use Mehmetb\BLM\Reader;
use PHPUnit\Framework\TestCase;

class ReaderTest extends TestCase
{
    private string $testDataPath = __DIR__.'/../data/test.BLM';

    public function testGetData()
    {
        $reader = new Reader($this->testDataPath);
        $result = $reader->getData();
        $this->assertIsArray($result);
        if ($this->count($result) <= 0) {
            $this->fail(['Result empty']);
        }
    }

    public function testGetHeader()
    {
        $reader = new Reader($this->testDataPath);
        $result = $reader->getHeaders();
        $this->assertIsArray($result);
        if ($this->count($result) <= 0) {
            $this->fail(['Result empty']);
        }
    }

    public function testGetDefinitions()
    {
        $reader = new Reader($this->testDataPath);
        $result = $reader->getDefinitions();
        $this->assertIsArray($result);
        if ($this->count($result) <= 0) {
            $this->fail(['Result empty']);
        }
    }

    public function testGetPathInfo()
    {
        $reader = new Reader($this->testDataPath);
        $result = $reader->getDefinitions();
        $this->assertIsArray($result);
        if ($this->count($result) <= 0) {
            $this->fail(['Result empty']);
        }
    }
}