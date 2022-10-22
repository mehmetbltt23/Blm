<?php

namespace Mehmetb\BLM\CreatorStructs;

class DefinitionStruct
{
    private array $keys = [];

    public function getKeys(): array
    {
        return $this->keys;
    }

    public function pushKey(string $key): void
    {
        if (!in_array($key, $this->keys)) {
            $this->keys[] = $key;
        }
    }

    public function getRaw(): string
    {
        return "#DEFINITION#\n" . implode('|', $this->keys) . "|~\n";
    }
}