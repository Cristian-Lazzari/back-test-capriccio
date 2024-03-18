<?php

namespace App\Models;

use App\Models\Month;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Date extends Model
{
    use HasFactory;

    protected $fillable = [
        'reserved', 
        'reserved_pz_q',
        'reserved_pz_t',
        'reserved_domicilio',
        'year',
        'month',
        'day',
        'day_w', 
        'time', 
        'max_res', 
        'max_pz_q', 
        'max_pz_t', 
        'max_domicilio', 
        'date_slot', 
        'status', 
        'visible_d',
        'visible_t',
        'visible_fq',
        'visible_ft',
    ];
    public $timestamps = false;

    // public function month() {
    //     // belongsTo si usa nel model della tabella che ha la chiave esterna, di conseguenza quella che sta dalla parte del molti
    //     return $this->belongsTo(Month::class);
    // }
}
