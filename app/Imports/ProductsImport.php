<?php

namespace App\Imports;

use App\Product;
use App\User;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel , WithHeadingRow, WithCustomCsvSettings
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (!empty($row['key']) && !empty($row['name']) &&!empty($row['price'])){
            $product = Product::all()->where("unique_key", "=",$row['key'])->first();
            if (!empty($product) && $product) {
                $data["unique_key"] = $row['key'];
                $data["display"] = $row["display"];
                if (!empty($row['name']))$data["name"] = $row['name'];
                if (!empty($row['price']))$data["price"] = $row['price'];
                if (!empty($row['description']))$data["description"] = $row['description'];
                Product::all()->where("id","=",$product->id)->update($data);
            } else {
                return new Product([
                    'unique_key'=>$row['key'],
                    'name'=>$row['name'],
                    'price'=>$row['price'],
                    'description'=>$row['description'],
                    'display'=>intval($row["display"]),
                    'photo'=>default_image_upload(),
                ]);
            }
        }
        return null;
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => 'ISO-8859-1',
            'delimiter'=>';'
        ];
    }
}
