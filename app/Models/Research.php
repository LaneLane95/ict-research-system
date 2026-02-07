<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Research extends Model
{
    // 1. Siguraduhin na plural 'researches' ang table name 
    // (kasi 'researches' ang ginamit natin sa bagong migration)
    protected $table = 'researches'; 

    // 2. Dito natin ililista lahat ng fields na hiningi mo para payagan ni Laravel
    protected $fillable = [
        'category',
        'sub_type',
        'date_received',
        'school_id',
        'school_name',
        'district',
        'author',
        'title',
        'type_of_research',
        'theme',
        'endorsement_date',
        'released_date',
        'completion_date',
        'coc_date'
    ];
}