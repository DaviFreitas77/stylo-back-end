<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariacoes extends Model
{
    protected $table = 'product_variacoes';
    protected $fillable = ['fkProduto','fkColor','fkSize','image'];
    public $timestamps = false;



      public function color()
    {
        return $this->belongsTo(Colors::class, 'fkColor');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'fkSize');
    }
}
