<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Classroom extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'Classrooms';
    public $timestamps = true;
    public $translatable = [
        'Name'
    ];
    protected $fillable=[
        'Name_Class','Grade_id'
    ];

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'Grade_id');
    }
}
