<?php

namespace App\Services;

use App\Data\CityData;
use App\Data\CityDetailData;
use App\Data\DistrictData;
use App\Exceptions\ParseException;
use HungCP\PhpSimpleHtmlDom\HtmlDomParser;
use Throwable;

class ParseDataService
{
    /**
     * @return DistrictData[]
     * @throws ParseException
     */
    public function getDistricts(): array
    {
        $districts = [];
        try {
            $baseUrl = 'https://www.e-obce.sk/kraj/NR.html';
            $dom = HtmlDomParser::file_get_html($baseUrl);
            $bTags = $dom->find('b');
            foreach ($bTags as $bTag) {
                if (trim($bTag->text()) === 'OKRES:') {
                    $districtsRow = $bTag->parent();
                    $districtAs = $districtsRow->find('a');
                    foreach ($districtAs as $districtA) {
                        $district = new DistrictData();
                        $district->name = trim($districtA->text());
                        $district->url = trim($districtA->getAttribute('href'));
                        $districts[] = $district;
                    }
                    break;
                }
            }
        } catch (Throwable) {
            throw new ParseException('Could not get information about districts.');
        }

        if (empty($districts)) {
            throw new ParseException('Could not get information about districts.');
        }

        return $districts;
    }

    /**
     * @param DistrictData $district
     * @return CityData[]
     * @throws ParseException
     */
    public function getCities(DistrictData $district): array
    {
        $cities = [];
        try {
            $dom = HtmlDomParser::file_get_html($district->url);
            $bTags = $dom->find('b');
            $searchBText = "Vyberte si obec alebo mesto z okresu {$district->name}:";
            foreach ($bTags as $bTag) {
                if ($bTag->text() === $searchBText) {
                    $citiesTable = $bTag->nextSibling();
                    $cityTds = $citiesTable->find('td[align="left"]');
                    foreach ($cityTds as $cityTd) {
                        $cityA = $cityTd->firstChild();
                        $city = new CityData();
                        $city->name = trim($cityA->text());
                        $city->url = trim($cityA->getAttribute('href'));
                        $cities[] = $city;
                    }
                    break;
                }
            }
        } catch (Throwable) {
            throw new ParseException("Could not get information about cities of district {$district->name}.");
        }

        if (empty($cities)) {
            throw new ParseException("Could not get information about cities of district {$district->name}.");
        }

        return $cities;
    }

    /**
     * @param CityData $city
     * @return CityDetailData
     * @throws ParseException
     */
    public function getCityDetail(CityData $city): CityDetailData
    {
        $cityDetail = new CityDetailData();
        $cityDetail->name = $city->name;
        try {
            $dom = HtmlDomParser::file_get_html($city->url);
            $h1 = $dom->find('h1', 0);
            $addressTable = $h1->parent();
            while ($addressTable->tag !== 'table') {
                $addressTable = $addressTable->parent();
            }
            $tds = $addressTable->find('td');
            foreach ($tds as $td) {
                $tdText = trim($td->text());
                if ($tdText === 'Tel:') {
                    $cityDetail->phone = trim($td->nextSibling()->text());
                }
                if ($tdText === 'Fax:') {
                    $cityDetail->fax = trim($td->nextSibling()->text());
                }
                if ($tdText === 'Email:') {
                    $cityDetail->email = trim($td->nextSibling()->text());
                }
                if ($tdText === 'Web:') {
                    $cityDetail->web = trim($td->nextSibling()->text());
                }
                if ($tdText === 'Obecný úrad') {
                    $streetTr = $td->parent()->nextSibling()->nextSibling();
                    $streetText = trim($streetTr->firstChild()->text());
                    $cityText = trim($streetTr->nextSibling()->firstChild()->text());
                    $cityDetail->address = "{$streetText}, {$cityText}";
                }
            }
            $majorTds = $addressTable->nextSibling()->nextSibling()->find('td');
            foreach ($majorTds as $majorTd) {
                if (trim($majorTd->text()) === 'Starosta:') {
                    $cityDetail->mayorName = trim($majorTd->nextSibling()->text());
                    break;
                }
            }
            return $cityDetail;
        } catch (Throwable) {}
        throw new ParseException("Could not get information about city {$city->name}.");
    }
}
