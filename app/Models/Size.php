<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
     protected $table = 'Sizes';
   protected $fillable = ['name'];
   public $timestamps = false;
}
