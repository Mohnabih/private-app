<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coffee extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'category',
        'address',
        'latitude',
        'longitude'
    ];

    protected $casts=[
        'name'=> 'string',
        'category'=>'integer',
        'address' => 'string',
        'latitude' => 'float',
        'longitude' => 'float',
    ];
}
