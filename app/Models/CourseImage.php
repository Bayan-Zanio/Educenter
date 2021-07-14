<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CourseImage extends Model
{
    use HasFactory;

    protected $fillable=['course_id','image_path'];

    public function grtImageUrlAttribute()
    {
        return Storage::disk('uploads')->url($this->image_path);
        //return asset('uploads/' . $this->image);
    }
}
