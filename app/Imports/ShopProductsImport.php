<?php

namespace App\Imports;

use App\Product;
use App\ShopProduct;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ShopProductsImport implements ToModel , WithHeadingRow, WithCustomCsvSettings
{
    use Importable;
    var $shop_id;
    public function __construct($shop_id = 0)
    {
        $this->shop_id = $shop_id;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (!empty($row['key']) &&!empty($row['stock'])) {
            $product = Product::all()->where("unique_key", "=",$row['key'])->first();
            if (!empty($product) && $product) {
                $shop_product = ShopProduct::all()->where("shop_id","=",$this->shop_id)->where("product_id","=",$product->id)->first();
                if (!empty($shop_product)){
                    ShopProduct::all()->find($shop_product->id)->update([
                        'stocks'=>$row['stock'],
                    ]);
                } else {
                    return new ShopProduct([
                        'shop_id'=>$this->shop_id,
                        'product_id'=>$product->id,
                        'stocks'=>$row['stock'],
                    ]);
                }
            }
            return null;
        }
    }
    public function headingRow(): int
    {
        return 1;
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }
    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => 'ISO-8859-1',
            'delimiter'=>';'
        ];
    }

}
