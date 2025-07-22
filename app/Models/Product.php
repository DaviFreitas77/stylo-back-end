<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ["name", "description", "price", "lastPrice","fkCategory","news"];
    public $timestamps = false;


    public function category()
    {
        return $this->belongsTo(Category::class, 'fkCategory');
    }

    public function colors()
    {
        return $this->belongsToMany(Colors::class, 'product_colors', 'fkProduct', 'fkColor');
    }

    public function sizes()
    {
        return  $this->belongsToMany(Size::class, 'product_sizes', 'fkProduct', 'fkSize');
    }
}
