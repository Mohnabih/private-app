<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Coffee;
use App\Models\User;

class Card extends Model
{
    use HasFactory;

    protected $with = ['sender', 'recipient','coffee'];
    protected $dates=['time'];
    protected $fillable=[
        'order_id',
        'sender_id',
        'targeted_id',
        'coffee_id',
        'time'
    ];

    protected $casts=[
        'order_id'=>'integer',
        'sender_id'=>'integer',
        'targeted_id'=>'integer',
        'coffee_id'=>'integer',
    ];
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id')->without(['skills','hobbies']);
    }


    public function recipient()
    {
        return $this->belongsTo(User::class, 'targeted_id')->without(['skills','hobbies']);
    }

    public function coffee()
    {
        return $this->belongsTo(Coffee::class, 'coffee_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    public function getTimeAttribute($value) {
        return date('d-m-Y H:i:s', strtotime($value));
    }
}
