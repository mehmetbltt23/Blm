<?php

namespace Mehmetb\BLM;

use Mehmetb\BLM\Exceptions\CreatorException;
use Mehmetb\BLM\CreatorStructs\DataStruct;
use Mehmetb\BLM\CreatorStructs\DefinitionStruct;
use Mehmetb\BLM\CreatorStructs\HeaderStruct;

class Creator
{
    private array $data;
    private HeaderStruct $header;
    private DefinitionStruct $definition;

    public function save(string $path, string $name = ''): string
    {
        $default_name = 'ISSL' . date('YmdHis');
        $ext = 'BLM';

        if ($name == '') {
            $name = $default_name . '.' . $ext;
        } else {
            $name = pathinfo($name)['filename'].'.'.$ext;
        }

        $path = pathinfo($path)['basename'].'/'.$name;

        $content = $this->createBlmContents();
        if (!file_put_contents($path, $content)) {
            throw new CreatorException('Unable to create output file: ' . $name);
        }

        return $path;
    }

    public function getContent(): string
    {
        return $this->createBlmContents();
    }

    private function getData(): array
    {
        if (!isset($this->data)) {
            throw new CreatorException('Data empty');
        }

        return $this->data;
    }

    public function push(DataStruct $data): void
    {
        $this->data[] = $data;
    }

    private function getDefinition(): DefinitionStruct
    {
        if (!isset($this->definition)) {
            $this->setDefinition(new DefinitionStruct());
        }

        return $this->definition;
    }

    private function setDefinition(DefinitionStruct $definition): void
    {
        $this->definition = $definition;
    }

    private function getHeader(): HeaderStruct
    {
        if (!isset($this->header)) {
            $this->setHeader(new HeaderStruct());
        }

        return $this->header;
    }

    public function setHeader(HeaderStruct $header): void
    {
        $this->header = $header;
    }

    private function setDefinitionKeys(): DefinitionStruct
    {
        $definition = $this->getDefinition();
        foreach ($this->getData() as $item) {
            if ($item instanceof DataStruct) {
                foreach ($item->getData() as $key => $value) {
                    $definition->pushKey($key);
                }
            }
        }

        return $definition;
    }

    private function createBlmContents(): string
    {
        $data = $this->getData();
        $count = count($data);
        $header = $this->getHeader();
        $header->setPropertyCount($count);
        $definition_keys = $this->setDefinitionKeys();

        $content = "";
        foreach ($data as $data_struct) {
            if ($data_struct instanceof DataStruct) {
                $content .= $data_struct->getRaw($this->getDefinition()->getKeys());
            }
        }

        $raw = "";
        $raw .= $header->getRaw();
        $raw .= $definition_keys->getRaw();
        $raw .= "#DATA#\n$content#END#\n";

        return $raw;
    }
}