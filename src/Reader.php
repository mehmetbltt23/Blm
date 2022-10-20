<?php

namespace Mehmetb\BLM;

class Reader
{
    private string $file;
    private array $pathInfo;
    private string $content;
    private array $headers;
    protected array $definitions;
    protected array $data;

    public function __construct(string $file)
    {
        $this->setFile($file);
        $this->setPathInfo();
        $this->setContent();
        $this->setHeader();
        $this->setDefinitions();
        $this->setData();
    }

    public function getPathInfo(): array
    {
        return $this->pathInfo;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getDefinitions(): array
    {
        return $this->definitions;
    }

    public function getData(): array
    {
        return $this->data;
    }

    private function setFile(string $file): void
    {
        if (!file_exists($file)) {
            throw new \Exception('File not found', HttpResponse::HTTP_NOT_FOUND);
        }

        $this->file = $file;

        $this->setPathInfo();
    }

    private function setContent(): void
    {
        $content = file_get_contents($this->file);
        if (empty($content)) {
            throw new \Exception('BLM file empty');
        }

        $this->content = mb_convert_encoding($content, 'UTF-8', mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
    }

    private function setPathInfo(): void
    {
        $this->pathInfo = pathinfo($this->file);

        if (strtolower($this->getPathInfo()['extension']) != 'blm') {
            throw new \Exception("Given file is not a .BLM");
        }
    }

    private function setHeader(): void
    {
        if (!preg_match('/#HEADER#(.*?)#/sm', $this->content, $match)) {
            throw new \Exception("No #HEADER# provided");
        }
        $params = [];
        $lines = explode("\n", $match[1]);
        foreach ($lines as $line) {
            if (trim($line) != '') {
                $parts = explode(' : ', $line);
                $value = preg_replace('/(^[\'"]|[\'"]$)/', '', trim($parts[1]));
                $params[trim($parts[0])] = $value;
            }
        }

        $this->headers = $params;
    }

    private function setDefinitions(): void
    {
        if (empty($this->headers)) {
            throw new \Exception("Please set headers first.", HttpResponse::HTTP_BAD_REQUEST);
        }

        if (!preg_match('/#DEFINITION#(.*?)\#/sm', $this->content, $match)) {
            throw new \Exception("No #DEFINITION# provided", HttpResponse::HTTP_BAD_REQUEST);
        }

        $fields = array_map('trim', explode($this->headers['EOF'], $match[1]));

        $fieldsEnd = end($fields);
        if ($fieldsEnd == $this->headers['EOR']) {
            $fieldKeys = array_keys($fields);
            unset($fields[array_pop($fieldKeys)]);
        }

        $this->definitions = $fields;
    }

    private function setData(): void
    {
        if (empty($this->definitions)) {
            throw new \Exception("Please set definitions first.");
        }

        if (!preg_match('/#DATA#(.*)#END#/sm', $this->content, $match)) {
            throw new \Exception("No #DATA# provided (or no #END# defined)");
        }

        $data = array();

        $rows = array_map('trim', explode($this->headers['EOR'], $match[1]));

        foreach ($rows as $i => $row) {
            $fields = array_map('trim', explode($this->headers['EOF'], $row));
            if (count($fields) > 1) {
                $data[$i] = array();
                foreach ($fields as $k => $field) {
                    if (isset($this->definitions[$k])) {
                        $data[$i][$this->definitions[$k]] = $field;
                    }
                }
            }
        }

        $this->data = $data;
    }
}