<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
     protected $table = "product_sizes";
    protected $fillable =  ['fkProduct','fkSize'];
    public $timestamps = false;
}
