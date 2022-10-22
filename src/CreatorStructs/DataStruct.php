<?php

namespace Mehmetb\BLM\CreatorStructs;

use Mehmetb\BLM\Exceptions\CreatorException;

class DataStruct
{
    const AGENT_REF = 'AGENT_REF';
    const ADDRESS_1 = 'ADDRESS_1';
    const ADDRESS_2 = 'ADDRESS_2';
    const TOWN = 'TOWN';
    const POSTCODE1 = 'POSTCODE1';
    const POSTCODE2 = 'POSTCODE2';
    const SUMMARY = 'SUMMARY';
    const DESCRIPTION = 'DESCRIPTION';
    const BRANCH_ID = 'BRANCH_ID';
    const STATUS_ID = 'STATUS_ID';
    const BEDROOMS = 'BEDROOMS';
    const BATHROOMS = 'BATHROOMS';
    const LIVING_ROOMS = 'LIVING_ROOMS';
    const PRICE = 'PRICE';
    const PRICE_QUALIFIER = 'PRICE_QUALIFIER';
    const PROP_SUB_ID = 'PROP_SUB_ID';
    const CREATE_DATE = 'CREATE_DATE';
    const UPDATE_DATE = 'UPDATE_DATE';
    const DISPLAY_ADDRESS = 'DISPLAY_ADDRESS';
    const PUBLISHED_FLAG = 'PUBLISHED_FLAG';
    const LET_DATE_AVAILABLE = 'LET_DATE_AVAILABLE';
    const LET_BOND = 'LET_BOND';
    const LET_TYPE_ID = 'LET_TYPE_ID';
    const LET_FURN_ID = 'LET_FURN_ID';
    const LET_RENT_FREQUENCY = 'LET_RENT_FREQUENCY';
    const TRANS_TYPE_ID = 'TRANS_TYPE_ID';
    const NEW_HOME_FLAG = 'NEW_HOME_FLAG';
    const ADMINISTRATION_FEE = 'ADMINISTRATION_FEE';
    const FEATURE = 'FEATURE%s';
    const MEDIA_IMAGE = 'MEDIA_IMAGE_%s';
    const MEDIA_IMAGE_TEXT = 'MEDIA_IMAGE_TEXT_%s';
    const MEDIA_FLOOR_PLAN = 'MEDIA_FLOOR_PLAN_%s';
    const MEDIA_FLOOR_PLAN_TEXT = 'MEDIA_FLOOR_PLAN_TEXT_%s';
    const MEDIA_DOCUMENT = 'MEDIA_DOCUMENT_%s';
    const MEDIA_DOCUMENT_TEXT = 'MEDIA_DOCUMENT_TEXT_%s';
    const MEDIA_VIRTUAL_TOUR = 'MEDIA_VIRTUAL_TOUR_%s';
    const MEDIA_VIRTUAL_TOUR_TEXT = 'MEDIA_VIRTUAL_TOUR_TEXT_%s';

    private array $data;

    public function __construct()
    {
        $this->data = [
            $this->getDetailKey() => [],
            $this->getFeatureKey() => [],
            $this->getImageKey() => [],
            $this->getFloorPlanKey() => [],
            $this->getDocumentKey() => [],
            $this->getVirtualTourKey() => [],
        ];
    }

    private function setData(string $index, string $key, string $value): void
    {
        $this->data[$index][$key] = $value;
    }

    private function getDetailKey(): string
    {
        return 'details';
    }

    private function getFeatureKey(): string
    {
        return 'features';
    }

    private function getImageKey(): string
    {
        return 'images';
    }

    private function getFloorPlanKey(): string
    {
        return 'floor_plans';
    }

    private function getDocumentKey(): string
    {
        return 'documents';
    }

    private function getVirtualTourKey(): string
    {
        return 'virtual_tours';
    }

    public function setDetail(string $key, string $value): string
    {
        $this->setData($this->getDetailKey(), $key, $value);
        return $key;
    }

    public function setFeature(string $value): string
    {
        $key = $this->getFeatureKey();
        $count = count($this->data[$key]) + 1;
        $this->setData($key, sprintf(self::FEATURE, $count), $value);

        return "FEATURE$count";
    }

    public function setImage(string $path, string $title): array
    {
        return $this->setMedia($this->getImageKey(), $path, $title);
    }

    public function setFloorPlan(string $path, string $title): array
    {
        return $this->setMedia($this->getFloorPlanKey(), $path, $title);
    }

    public function setDocument(string $path, string $title): array
    {
        return $this->setMedia($this->getDocumentKey(), $path, $title);
    }

    public function setVirtualTour(string $path, string $title): array
    {
        return $this->setMedia($this->getVirtualTourKey(), $path, $title);
    }

    private function setMedia(string $key, string $path, string $title): array
    {
        $count_str = count($this->data[$key]);
        if ($count_str > 0) {
            $count_str /=2;
        }

        if ($count_str <= 9) {
            $count_str = "0$count_str";
        }

        $fn = function (string $text) use ($count_str) {
            return sprintf($text, $count_str);
        };

        switch ($key) {
            case $this->getImageKey():
                $path_key = $fn(self::MEDIA_IMAGE);
                $title_key = $fn(self::MEDIA_IMAGE_TEXT);
                break;

            case $this->getFloorPlanKey():
                $path_key = $fn(self::MEDIA_FLOOR_PLAN);
                $title_key = $fn(self::MEDIA_FLOOR_PLAN_TEXT);
                break;

            case $this->getDocumentKey():
                $path_key = $fn(self::MEDIA_DOCUMENT);
                $title_key = $fn(self::MEDIA_DOCUMENT_TEXT);
                break;

            case $this->getVirtualTourKey():
                $path_key = $fn(self::MEDIA_VIRTUAL_TOUR);
                $title_key = $fn(self::MEDIA_VIRTUAL_TOUR_TEXT);
                break;

            default:
                throw new CreatorException('Invalid key');
        }

        $this->setData($key, $path_key, $path);
        $this->setData($key, $title_key, $title);

        return ['path_key' => $path_key, 'title_key' => $title_key];
    }

    public function getData(): array
    {
        $data = [];
        foreach ($this->data as $items) {
            foreach ($items as $key => $value) {
                if (!is_string($value)) {
                    throw new CreatorException('Invalid item');
                }

                $data[$key] = $value;
            }
        }

        return $data;
    }

    public function getRaw(array $all_keys): string
    {
        if (empty($all_keys)) {
            throw new CreatorException('Empty keys');
        }

        $raw_data = "";
        $data = $this->getData();
        foreach ($all_keys as $key) {
            $value = $data[$key] ?? '';
            $raw_data .= $value . '|';
        }

        $raw_data .= "~\n";

        return $raw_data;
    }
}