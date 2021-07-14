<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    public function show($slug)
    {
        $course = Course::where('slug' , $slug)->firstOrFail();
        return view('front.coursesingle' , [
            'course' => $course,
        ]);
    }
}
