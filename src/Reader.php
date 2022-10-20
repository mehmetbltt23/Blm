<?php

namespace Mehmetb\BLM;

class Reader
{
    protected $file;

    protected $headers;

    protected $definitions;

    public function __construct($file)
    {
        $fileNameParts = explode('.', $file);
        $ext = end($fileNameParts);
        $ext = strtoupper($ext);
        if ($file == '' || $ext != 'BLM') {
            throw new \Exception("Given file is not a .BLM");
        }

        // read file
        $this->file = file_get_contents($file);

        // Fix encoding issue when non ascii charcters are there.
        $this->file = mb_convert_encoding($this->file, 'UTF-8',
            mb_detect_encoding($this->file, 'UTF-8, ISO-8859-1', true));
    }

    public function toArray()
    {
        $this->headers = $this->getHeaders();
        $this->definitions = $this->getDefinitions();
        return $this->getData();
    }

    protected function getHeaders()
    {
        if (!preg_match('/#HEADER#(.*?)#/sm', $this->file, $match)) {
            throw new \Exception("No #HEADER# provided");
        }
        $params = array();
        $lines = explode("\n", $match[1]);
        foreach ($lines as $line) {
            if (trim($line) != '') {
                $parts = explode(' : ', $line);
                $value = preg_replace('/(^[\'"]|[\'"]$)/', '', trim($parts[1]));
                $params[trim($parts[0])] = $value;
            }
        }
        return $params;
    }

    protected function getDefinitions()
    {
        if (empty($this->headers)) {
            throw new \Exception("Please set headers first.");
        }

        if (!preg_match('/#DEFINITION#(.*?)\#/sm', $this->file, $match)) {
            throw new \Exception("No #DEFINITION# provided");
        }

        $fields = array_map('trim', explode($this->headers['EOF'], $match[1]));

        $fieldsEnd = end($fields);
        if ($fieldsEnd == $this->headers['EOR']) {
            $fieldKeys = array_keys($fields);
            unset($fields[array_pop($fieldKeys)]);
        }
        return $fields;
    }

    protected function getData()
    {
        if (empty($this->definitions)) {
            throw new \Exception("Please set definitions first.");
        }

        if (!preg_match('/#DATA#(.*)#END#/sm', $this->file, $match)) {
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
        return $data;
    }
}