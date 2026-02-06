<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Research extends Model
{
    protected $table = 'research'; 

    protected $fillable = [
        'title', 
        'author', 
        'module', 
        'status', 
        'entry_date', 
        'released_date'
    ];
}