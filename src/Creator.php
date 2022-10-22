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

    public function save(string $name = ''): string
    {
        $default_name = 'ISSL' . date('YmdHis');
        $ext = 'BLM';

        if ($name == '') {
            $name = $default_name . '.' . $ext;
        } else if (strpos(strtolower($name), '.blm') === false) {
            $name .= '.' . $ext;
        }

        $content = $this->createBlmContents();
        if (!file_put_contents($name, $content)) {
            throw new CreatorException('Unable to create output file: ' . $name);
        }

        return $name;
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

    private function setDefinitionKeys(): self
    {
        $definition = $this->getDefinition();
        foreach ($this->getData() as $item) {
            if ($item instanceof DataStruct) {
                foreach ($item->getData() as $key => $value) {
                    $definition->pushKey($key);
                }
            }
        }

        return $this;
    }

    private function createBlmContents(): string
    {
        $content = "";
        $data = $this->getData();
        $count = count($data);
        foreach ($this->getData() as $data_struct) {
            if ($data_struct instanceof DataStruct) {
                $content .= $data_struct->getRaw($this->getDefinition()->getKeys());
            }
        }

        $header = $this->getHeader();
        $header->setPropertyCount($count);

        $raw = "";
        $raw .= $header->getRaw();
        $raw .= $this->setDefinitionKeys()->getDefinition()->getRaw();

        return $raw;
    }
}