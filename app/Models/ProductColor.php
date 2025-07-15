<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    protected $table = "product_colors";
    protected $fillable =  ['fkProduct','fkColor'];
    public $timestamps = false;
}
