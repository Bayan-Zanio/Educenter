<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    public static function rules()
    {
        return [

        ];
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'category_id' , 'id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id' , 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id' , 'id')->withDefault([
            'name'=>'No Parent'
        ]);
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
            
            'image'=>'image',
            
            
        ];
    }
}
