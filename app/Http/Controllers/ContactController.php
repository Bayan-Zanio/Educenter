<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {   
        return view('front.contact');
    }

    public function events()
    {   
        return view('front.events');
    }

}
