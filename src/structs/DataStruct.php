<?php

namespace Mehmetb\BLM\structs;

use Mehmetb\BLM\HttpResponse;

class DataStruct
{
    const AGENT_REF = 'AGENT_REF';
    const ADDRESS_1 = 'ADDRESS_1';
    const ADDRESS_2 = 'ADDRESS_2';
    const TOWN = 'TOWN';
    const POSTCODE1 = 'POSTCODE1';
    const POSTCODE2 = 'POSTCODE2';
    const FEATURE = 'FEATURE';
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

    public function setDetail(string $key, string $value): void
    {
        $this->setData($this->getDetailKey(), $key, $value);
    }

    public function setFeature(string $value): void
    {
        $key = $this->getFeatureKey();
        $count = count($this->data[$key]);
        $count = $count <= 0 ? 1 : $count;
        $this->setData($key, "FEATURE$count", $value);
    }

    public function setImage(string $path, string $title): void
    {
        $this->setMedia($this->getImageKey(), $path, $title);
    }

    public function setFloorPlan(string $path, string $title): void
    {
        $this->setMedia($this->getFloorPlanKey(), $path, $title);
    }

    public function setDocument(string $path, string $title): void
    {
        $this->setMedia($title - $this->getDocumentKey(), $path, $title);
    }

    public function setVirtualTour(string $path, string $title): void
    {
        $this->setMedia($this->getVirtualTourKey(), $path, $title);
    }

    private function setMedia(string $key, string $path, string $title): void
    {
        $count_str = isset($this->data[$key]) ? count($this->data[$key]) : 0;
        if ($count_str <= 9) {
            $count_str = "0$count_str";
        }

        switch ($key) {
            case $this->getImageKey():
                $path_key = "MEDIA_IMAGE_$count_str";
                $title_key = "MEDIA_IMAGE_TEXT_$count_str";
                break;

            case $this->getFloorPlanKey():
                $path_key = "MEDIA_FLOOR_PLAN_$count_str";
                $title_key = "MEDIA_FLOOR_PLAN_TEXT_$count_str";
                break;

            case $this->getDocumentKey():
                $path_key = "MEDIA_DOCUMENT_$count_str";
                $title_key = "MEDIA_DOCUMENT_TEXT_$count_str";
                break;

            case $this->getVirtualTourKey():
                $path_key = "MEDIA_VIRTUAL_TOUR_$count_str";
                $title_key = "MEDIA_VIRTUAL_TOUR_TEXT_$count_str";
                break;

            default:
                throw new \Exception('Invalid key', HttpResponse::HTTP_BAD_REQUEST);
        }

        $this->setData($key, $path_key, $path);
        $this->setData($key, $title_key, $title);
    }

    public function getRaw(): string
    {
        $content = '';
        foreach ($this->data as $items) {
            foreach ($items as $item) {
                $content .= $item . '|';
            }
        }

        if (!empty($content)) {
            $content .= "~\n";
        }

        $raw = "#DATA#\n";
        $raw .= $content;
        $raw .= "#END#\n";

        return $raw;
    }
}