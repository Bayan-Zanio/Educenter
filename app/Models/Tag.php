<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    
    protected $fillable=['name','slug'];

    public function courses()
    {
        return $this->belongsToMany(
            Course::class,
            'course_tag',
            'tag_id',
            'course_id',
            'id',
            'id',
        );
    }
}
