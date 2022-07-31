<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    //
    protected $fillable = ['date', 'time_slot', 'customer_id', 'number_of_people'];
    //
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
