<?php

namespace App;

use Excel;
use Illuminate\Support\Str;

class ImportExcelToDb
{
    public $once = false;
    public $onceTruck = false;
    public $street;
    protected $currentQuantityTire;
    protected $currentQuantityTruck;
    protected $currentQuantityWheel;

    const RED_ARMY_STREET = 1;
    const CHECHERINA_STREET = 2;

    public function import($filename, $street) {
            $this->street = (int)$street;
            $this->initCurrentQuantityForStreets($this->street);

            Excel::selectSheetsByIndex(0)->load($filename, function($reader) {
            $brands = new Brand();
            //$reader->ignoreEmpty();
            
            $reader = $reader->each(function($sheet){
            	/*$sheet['dia'] = number_format($sheet->dia, 1, '.', '');
            	if(str_contains($sheet['polnoe_naimenovanie'], '9999999999999')) {
            		$str = preg_replace('/([0-9]{2}|[0-9]{3})\.([0-9])9999999999999/', $sheet['dia'], $sheet['polnoe_naimenovanie']);
                    $sheet['polnoe_naimenovanie'] = $str;
            	}
            	if(str_contains($sheet['cai'], '9999999999999')) {
            		$str = preg_replace_callback('/([0-9])9999999999999/', function($matches) {
    					return $matches[1] + 1;
					}, $sheet['cai']);
					$sheet['cai'] = $str;
            	}*/
            });

            $result = $reader->all();
            foreach($result as $item) {
                $brand_name = Str::ucfirst(Str::lower(trim($item->brend)));
                $brands_check = $brands->where('name' , $brand_name);

                if(isset($item['brend']) and $item['brend'] != null and !isset($item['tip_diska'])) {
                    if (!$brands_check->first()) { // if brand's name doesn't exist in DB then add new brand name
                        $new_brand = $brands->create([
                            'name' => $brand_name,
                            'image' => ''
                        ]);
                    } else {
                        $new_brand = $brands_check->first();
                    }

                    if(str_contains($item['shirina'], ',')) {
                        $item['shirina'] = str_replace(',', '.', $item['shirina']);
                    }

                    $item['opt'] = str_replace(' ', '', $item['opt']);
                    $item['roznitsa'] = str_replace(' ', '', $item['roznitsa']);

                    $this->addDataTire(
                        $new_brand->id, $item['polnoe_naimenovanie'], $item['imya_fayla'], '',
                        $item['shirina'], $item['profil'], $item['diametr'], $item['indeks_nagruzki'], $item['indeks_skorosti'],
                        $item['sezonnost'], $item['model'], $item['cai'], $item['ship'], '', $item['opt'], $item['roznitsa'],
                        $item['obshchee_kolichestvo'], $item['tip_shiny']
                    );

                    //truncate data
                    $t_tire = ($item['tip_shiny'] == 'Легковая' ? new Tire() : new Truck());

                    if ($t_tire instanceof Tire) {
                        if ($this->once == false) {
                            $t_tire->truncate();
                            $this->once = true;
                        }
                    } elseif ($t_tire instanceof Truck) {
                        if ($this->onceTruck == false) {
                            $t_tire->truncate();
                            $this->onceTruck = true;
                        }
                    }
                } elseif(isset($item['brend']) and $item['brend'] != null and isset($item['tip_diska'])) {
                    //dd($item);
                    if (!$brands_check->first()) { // if brand's name doesn't exist in DB then add new brand name
                        $new_brand = $brands->create([
                            'name' => $brand_name,
                            'image' => ''
                        ]);
                    } else {
                        $new_brand = $brands_check->first();
                    }

                    if (str_contains($item['shirina_oboda'], ',')) {
                        $item['shirina_oboda'] = str_replace(',', '.', $item['shirina_oboda']);
                    }

                    if (str_contains($item['dia'], ',')) {
                        $item['dia'] = str_replace(',', '.', $item['dia']);
                    }

                    $this->addDataWheel(
                        $new_brand->id, $item['polnoe_naimenovanie'], $item['imya_fayla'], '', $item['model'],
                        $item['shirina_oboda'], $item['posadochnyy_diametr'], $item['kolichestvo_otverstiy'], $item['pcd'], $item['vylet_et'],
                        $item['dia'], $item['cai'], $item['tip_diska'], $item['opt'], $item['roznitsa'], $item['obshchee_kolichestvo']
                    );

                    //truncate data
                    if ($this->once == false) {
                        $tire = new Wheel();
                        $tire->truncate();
                        $this->once = true;
                    }
                }
            }
        }, 'UTF-8');

        $this->setCurrentQuantityForStreets($this->street);
    }

    /**
     * Create new record in DB with data from excel
     *
     * @param $brand_id
     * @param $name
     * @param $image
     * @param $code
     * @param $twidth
     * @param $tprofile
     * @param $tdiameter
     * @param $load_index
     * @param $speed_index
     * @param $tseason
     * @param $model
     * @param $tcae
     * @param $spike
     * @param $model_class
     * @param $price_opt
     * @param $price_roz
     * @param $quantity
     * @param $t_type | type of tires: Легковая | Грузовая | Спец
     *
     * return void
     */
    private function addDataTire($brand_id, $name, $image, $code, $twidth, $tprofile, $tdiameter, $load_index, $speed_index,
                            $tseason, $model, $tcae, $spike, $model_class, $price_opt, $price_roz, $quantity, $t_type) {

        $data = [
            'brand_id' => $brand_id,
            'name' => $name,
            'image' => $image,
            'code' => $code,
            'twidth' => isset($twidth) ? $twidth : 0,
            'tprofile' => isset($tprofile) ? $tprofile : 0,
            'tdiameter' => isset($tdiameter) ? $tdiameter : 0,
            'load_index' => $load_index,
            'speed_index' => $speed_index,
            'tseason' => $tseason,
            'model' => $model,
            'tcae' => trim($tcae),
            'spike' => ($spike == 'Да') ? 1 : 0,
            'model_class' => $model_class,
            'price_opt' => ($price_opt != 0) ? intval($price_opt) : 0,
            'price_roz' => ($price_roz != 0) ? intval($price_roz) : 0,
        ];

        $quantity = $quantity == null ? 0 : $quantity;

        if ($this->street === self::RED_ARMY_STREET) {
            $data['quantity'] = $quantity;
        } elseif ($this->street === self::CHECHERINA_STREET) {
            $data['quantity_b'] = $quantity;
        }

        $t_tire = ($t_type == 'Легковая' ? new Tire() : new Truck());

        $t_tire->create($data);
    }

    private function addDataWheel($brand_id, $name, $image, $code, $model, $twidth, $tdiameter, $hole_count, $pcd, $et, $dia, $tcae,
                                    $type, $price_opt, $price_roz, $quantity) {

        $data = [
            'brand_id' => $brand_id,
            'name' => $name,
            'image' => $image,
            'code' => $code,
            'twidth' => isset($twidth) ? $twidth : 0,
            'tdiameter' => isset($tdiameter) ? $tdiameter : 0,
            'hole_count' => $hole_count,
            'pcd' => $pcd,
            'et' => $et,
            'model' => isset($model) ? $model : '',
            'et' => $et,
            'dia' => floatval($dia),
            'tcae' => trim($tcae),
            'type' => $type,
            'price_opt' => ($price_opt != 0) ? $price_opt : 0,
            'price_roz' => ($price_roz != 0) ? $price_roz : 0,
        ];

        $quantity = $quantity == null ? 0 : $quantity;

        if ($this->street === self::RED_ARMY_STREET) {
            $data['quantity'] = $quantity;
        } elseif ($this->street === self::CHECHERINA_STREET) {
            $data['quantity_b'] = $quantity;
        }

        $wheels = new Wheel();

        $wheels->create($data);
    }

    /**
     * Remember quantity for another shops except which we're updating
     *
     * @param $street
     */
    private function initCurrentQuantityForStreets($street)
    {
        if ($street === self::RED_ARMY_STREET) {
            $this->currentQuantityTire = Tire::select('quantity_b', 'tcae')->get();
            $this->currentQuantityTruck = Truck::select('quantity_b', 'tcae')->get();
            $this->currentQuantityWheel = Wheel::select('quantity_b', 'tcae')->get();
        } elseif ($street === self::CHECHERINA_STREET) {
            $this->currentQuantityTire = Tire::select('quantity', 'tcae')->get();
            $this->currentQuantityTruck = Truck::select('quantity', 'tcae')->get();
            $this->currentQuantityWheel = Wheel::select('quantity', 'tcae')->get();
        }
    }

    /**
     * Set quantity for another shops except which we're updating
     *
     * @param $street
     */
    private function setCurrentQuantityForStreets($street)
    {
        if ($street === self::RED_ARMY_STREET) {
            if (!empty($this->currentQuantityTire)) {
                foreach ($this->currentQuantityTire as $tire) {
                    Tire::where('tcae', $tire->tcae)->update([
                        'quantity_b' => $tire->quantity_b
                    ]);
                }
            }

            if (!empty($this->currentQuantityTruck)) {
                foreach ($this->currentQuantityTruck as $truck) {
                    Truck::where('tcae', $truck->tcae)->update([
                        'quantity_b' => $truck->quantity_b
                    ]);
                }
            }

            if (!empty($this->currentQuantityWheel)) {
                foreach ($this->currentQuantityWheel as $wheel) {
                    Wheel::where('tcae', $wheel->tcae)->update([
                        'quantity_b' => $wheel->quantity_b
                    ]);
                }
            }

        } elseif ($street === self::CHECHERINA_STREET) {
            if (!empty($this->currentQuantityTire)) {
                foreach ($this->currentQuantityTire as $tire) {
                    Tire::where('tcae', $tire->tcae)->update([
                        'quantity' => $tire->quantity
                    ]);
                }
            }

            if (!empty($this->currentQuantityTruck)) {
                foreach ($this->currentQuantityTruck as $truck) {
                    Truck::where('tcae', $truck->tcae)->update([
                        'quantity' => $truck->quantity
                    ]);
                }
            }

            if (!empty($this->currentQuantityWheel)) {
                foreach ($this->currentQuantityWheel as $wheel) {
                    Wheel::where('tcae', $wheel->tcae)->update([
                        'quantity' => $wheel->quantity
                    ]);
                }
            }
        }
    }
}
