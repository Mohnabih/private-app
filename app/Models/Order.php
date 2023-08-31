<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $with = ['sender', 'recipient'];
    protected $dates=['end_at'];
    protected $fillable=[
        'sender_id',
        'targeted_id',
        'status',
        'Is_paid'
    ];

    protected $casts=[
        'sender_id'=>'integer',
        'targeted_id'=>'integer',
        'status'=>'integer',
        'Is_paid'=>'boolean'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }


    public function recipient()
    {
        return $this->belongsTo(User::class, 'targeted_id');
    }

    public function card(){
        return $this->hasOne(Card::class,'order_id');
    }
}
