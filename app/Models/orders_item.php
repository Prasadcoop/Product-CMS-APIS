<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders_item extends Model
{
    use HasFactory;
    public function order()
    {
        return $this->belongsTo(orders::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
