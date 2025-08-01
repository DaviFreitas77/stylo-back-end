<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ["name", "description", "price", "lastPrice", "fkCategory", "news"];
    public $timestamps = false;


    public function category()
    {
        return $this->belongsTo(Category::class, 'fkCategory');
    }
    public function variations()
    {
        return $this->hasMany(ProductVariacoes::class, 'fkProduto')->with(['color', 'size']);
    }
}
