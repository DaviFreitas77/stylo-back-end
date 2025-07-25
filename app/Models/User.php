<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable

{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = "users";
    protected $fillable = ["name", 'email', 'password','role'];
    public $timestamps = false;
}
