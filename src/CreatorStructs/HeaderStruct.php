<?php

namespace Mehmetb\BLM\CreatorStructs;

class HeaderStruct
{
    private float $version;
    private string $eof;
    private string $eor;
    private int $propertyCount;
    private string $generateDate;
    private array $customData;

    public function __construct()
    {
        $this->setVersion(3);
        $this->setEof('|');
        $this->setEor('~');
        $this->setPropertyCount(0);
        $this->setGenerateDate(date('d-F-Y H:i'));
        $this->customData = [];
    }

    /**
     * @return float
     */
    public function getVersion(): float
    {
        return $this->version;
    }

    /**
     * @param float $version
     */
    public function setVersion(float $version): void
    {
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getEof(): string
    {
        return $this->eof;
    }

    /**
     * @param string $eof
     */
    public function setEof(string $eof): void
    {
        $this->eof = $eof;
    }

    /**
     * @return string
     */
    public function getEor(): string
    {
        return $this->eor;
    }

    /**
     * @param string $eor
     */
    public function setEor(string $eor): void
    {
        $this->eor = $eor;
    }

    /**
     * @return int
     */
    public function getPropertyCount(): int
    {
        return $this->propertyCount;
    }

    /**
     * @param int $propertyCount
     */
    public function setPropertyCount(int $propertyCount): void
    {
        $this->propertyCount = $propertyCount;
    }

    /**
     * @return string
     */
    public function getGenerateDate(): string
    {
        return $this->generateDate;
    }

    /**
     * @param string $generateDate
     */
    public function setGenerateDate(string $generateDate): void
    {
        $this->generateDate = $generateDate;
    }

    /**
     * @return array
     */
    public function getCustomData(): array
    {
        return $this->customData;
    }

    /**
     * @return string
     */
    public function getRaw(): string
    {
        $raw = "#HEADER#\n";
        $raw .= 'Version : ' . $this->getVersion() . "\n";
        $raw .= 'EOF : ' . $this->getEof() . "\n";
        $raw .= 'EOR : ' . $this->getEor() . "\n";
        $raw .= 'Property Count : ' . $this->getPropertyCount() . "\n";
        $raw .= 'Generated Date : ' . $this->getGenerateDate() . "\n";
        foreach ($this->getCustomData() as $key => $value) {
            $raw .= $key . ' : ' . $value . "\n";
        }

        return $raw;
    }
}