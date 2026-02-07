<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Research extends Model
{
    // 1. Siguraduhin na plural 'researches' ang table name 
    protected $table = 'researches'; 

    // 2. Nilista natin dito lahat ng fields, kasama ang 'is_archived'
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
        'coc_date',
        'is_archived' // <--- Eto yung dinagdag natin para sa Archive feature
    ];

    // 3. Casting para sigurado tayong True/False ang is_archived
    protected $casts = [
        'is_archived' => 'boolean',
    ];
}