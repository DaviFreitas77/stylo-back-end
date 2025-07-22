<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariacoes extends Model
{
    protected $table = 'product_variacoes';
    protected $fillable = ['fkProduct','fkColor','fkSize','stock'];
    public $timestamps = false;
}
