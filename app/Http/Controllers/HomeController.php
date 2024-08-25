<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\UploadImageProperty;
use App\Models\ImageUpload;

class HomeController extends Controller
{
    public function index(){
        $properties = Property::available()->recent()->limit(6)->get();
        
        return view('home', ['properties' => $properties]);
    }
}
