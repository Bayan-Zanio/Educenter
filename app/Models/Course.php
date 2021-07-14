<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable=[
        'name','category_id','description','date_of_add','duration','status','slug','image','updated_at','created_at',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id' , 'id');
    }

    public function images()
    {
        return $this->hasMany(CourseImage::class,'course_id','id');
    }

    public function tags()
    {
        return $this->belongsToMany(
         Tag::class,
         'course_tag',
         'course_id',
         'tag_id',
         'id',
         'id',
        );
    }

    public function getImageUrlAttribute()
    {
        if($this->image)
        {
            if(strpos($this->image,'http') ===0)
            {
                return $this->image;
            }
            return asset('uploads/' . $this->image);
            //return Storage::disk('uploads')->url($this->image);
        }

        return asset('images/default-image.jpg');

    }
    

    public static function validateRules()
    {
        return [
            'name'=>'required|string|max:255|min:3',
            'category_id'=>'required|exists:categories,id',
            'image'=>'image',
            
        ];
    }
}
