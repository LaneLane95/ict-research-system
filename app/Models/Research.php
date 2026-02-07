<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Research extends Model
{
    protected $table = 'researches'; 

    protected $fillable = [
        'category', 'sub_type', 'date_received', 'school_id', 'school_name', 
        'district', 'author', 'title', 'type_of_research', 'theme', 
        'endorsement_date', 'released_date', 'completion_date', 'coc_date', 'is_archived'
    ];

    protected $casts = [
        'is_archived' => 'boolean',
    ];
}