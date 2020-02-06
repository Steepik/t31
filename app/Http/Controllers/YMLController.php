<?php

namespace App\Http\Controllers;

use App\Tire;
use App\Wheel;
use Illuminate\Http\Request;

class YMLController extends Controller
{
    // Category Tire
    const CATEGORY_TIRE = 1;
    const CATEGORY_SUMMER_TIRE = 2;
    const CATEGORY_WINTER_TIRE = 3;
    const CATEGORY_SPIKE_TIRE = 4;

    // Category Wheel
    const CATEGORY_WHEEL = 5;
    const CATEGORY_LITOY_WHEEL = 6;
    const CATEGORY_SHTAMP_WHEEL = 7;


    public function index()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<yml_catalog date="' . date('Y-m-d H:i') . '">';
        $xml .= '<shop>';
        $xml .= '<name>Tyre31</name>
                <company>Каретный двор</company>
                <url>https://tyre31.ru</url>
                <currencies>
                    <currency id="RUR" rate="1"/>
                </currencies>
                <categories>
                    <category id="' . self::CATEGORY_TIRE . '">Шины</category>
                    <category id="' . self::CATEGORY_SUMMER_TIRE . '" parentId="' . self::CATEGORY_TIRE . '">Летние шины</category>
                    <category id="' . self::CATEGORY_WINTER_TIRE . '" parentId="' . self::CATEGORY_TIRE . '">Зимние шины</category>
                    <category id="' . self::CATEGORY_SPIKE_TIRE . '" parentId="' . self::CATEGORY_TIRE . '">Шипованные шины</category>
                    
                    <category id="' . self::CATEGORY_WHEEL . '">Диски</category>
                    <category id="' . self::CATEGORY_LITOY_WHEEL . '" parentId="' . self::CATEGORY_WHEEL . '">Литые диски</category>
                    <category id="' . self::CATEGORY_SHTAMP_WHEEL . '" parentId="' . self::CATEGORY_WHEEL . '">Штампованные диски</category>
                </categories>';
        $xml .= "<offers>";

        // Tires
        $tireList = Tire::all();
        foreach ($tireList as $tire) {
            if ($tire->price_roz <= 0) continue;

            $typeCategory = $tire->tseason == 'Летняя' ? self::CATEGORY_SUMMER_TIRE : self::CATEGORY_WINTER_TIRE;
            $type = $tire->spike == 1 ? 'Шипованная' : $tire->tseason;

            if ($tire->tseason == 'Зимняя' && $tire->spike == 1) {
                $typeCategory = self::CATEGORY_SPIKE_TIRE;
            }

            $xml .= '
                 <offer id="' . $tire->id . '">
                    <name>' . $tire->name . '</name>
                    <min-quantity>1</min-quantity> 
                    <vendor>' . $tire->brand->name . '</vendor>
                    <vendorCode>' . $tire->tcae . '</vendorCode>
                    <url/>
                    <price>' . $tire->price_roz . '</price>
                    <currencyId>RUR</currencyId>
                    <categoryId>' . $typeCategory  . '</categoryId>
                    <delivery>true</delivery>
                    <pickup>true</pickup>
                    <store>true</store>
                    <delivery-options>
                        <option cost="0" days="1"/>
                    </delivery-options>
                    <param name="Ширина">' . (int)$tire->twidth . '</param>
                    <param name="Профиль">' . (int)$tire->tprofile . '</param>
                    <param name="Диаметр">' . (int)$tire->tdiameter . '</param>
                    <param name="Индекс нагрузки">' . $tire->load_index . '</param>
                    <param name="Индекс скорости">' . $tire->speed_index . '</param>
                    <param name="Тип">' . $type . '</param>
                    <param name="Модель">' . $tire->model . '</param>
                </offer>';
        }

        // Wheels
        $wheelList = Wheel::all();
        $iteration = 0;
        foreach ($wheelList as $wheel) {
            if ($wheel->price_roz <= 0) continue;

            $iteration++;

            $wheelId = count($tireList) + $iteration;
            $wheelCategory = $wheel->type == 'Литой' ? self::CATEGORY_LITOY_WHEEL : self::CATEGORY_SHTAMP_WHEEL;
            $xml .= '
                 <offer id="' . $wheelId . '">
                    <name>' . $wheel->name . '</name>
                    <min-quantity>1</min-quantity> 
                    <vendor>' . htmlspecialchars($wheel->brand->name) . '</vendor>
                    <vendorCode>1</vendorCode>
                    <url/>
                    <price>' . $wheel->price_roz . '</price>
                    <currencyId>RUR</currencyId>
                    <categoryId>' . $wheelCategory  . '</categoryId>
                    <delivery>true</delivery>
                    <pickup>true</pickup>
                    <store>true</store>
                    <delivery-options>
                        <option cost="0" days="1"/>
                    </delivery-options>
                    <param name="Ширина">' . $wheel->twidth . '</param>
                    <param name="Диаметр">' . $wheel->tdiameter . '</param>
                    <param name="Кол-во отверстий">' . (int)$wheel->hole_count . '</param>
                    <param name="PCD">' . $wheel->pcd . '</param>
                    <param name="ET">' . $wheel->et . '</param>
                    <param name="DIA">' . $wheel->dia . '</param>
                    <param name="Модель">' . $wheel->model . '</param>
                </offer>';
        }

        $xml .= '</offers></shop></yml_catalog>';

        return response($xml)
            ->header('Content-Type', 'text/xml');
    }
}
