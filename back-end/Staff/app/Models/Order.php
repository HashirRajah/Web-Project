<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    //
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    //
    public function payment(){
        return $this->hasOne(Payment::class);
    }
    //many to many
    public function items(){
        return $this->belongsToMany(Item::class);
    }
}
