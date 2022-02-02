<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    use HasTranslations;

    public $translatable = [
        'Name'
    ];
    
    protected $fillable = [
        'Name', 'Notes'
    ];

    protected $table = 'grades';
    public $timestamps = true;
}