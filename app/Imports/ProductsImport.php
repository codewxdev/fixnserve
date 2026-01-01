<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // dd(array_keys($row));

        return new Product([
            'name' => $row['name'],
            'sku_no' => $row['sku_no'],
            'category_id' => $row['category_id'],
            'sub_category_id' => $row['sub_category_id'],
            'quantity' => $row['quantity'] ?? 0,
            'min_stock' => $row['min_stock'] ?? 5,
            'price' => $row['price'],
            'description' => $row['description'] ?? null,
            'image' => $row['image'] ?? null,
            'user_id' => $this->userId, // logged-in user ID

        ]);
    }
}
