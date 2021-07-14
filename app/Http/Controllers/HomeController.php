<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $latest=Course::latest()->take(6)->get();
        
        return view('front.home' , [
           'latest'=>$latest,
           
        ]);
    }

    public function show()
    {   
        return view('front.courses');
    }

    public function about()
    {   
        return view('front.about');
    }
}
