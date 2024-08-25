<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ImageUpload;
use Illuminate\Support\Facades\Session;

class ImageUploadController extends Controller
{
    public function upload_image()
    {
        return view('image_upload');
    }

    public function store_image(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:jpg, jpeg, png, bmp',
        ]);

        $image = '';
        if($image = $request->file('image')){
            $imageName = time().'-'.uniqid().'.'.$image->getClientOriginalExtension();
            $image->move('images/uploads/property', $imageName);
        }
        $imageUploaded = ImageUpload::create([
            'image' => $imageName,
        ]);

        //dd($image);
        //$property->options()->sync($request->validated(('options')));
        //$property->options()->sync($request->validated(('options')));

        Session::flash('message','L\'image a bien été créer');
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();

        // return view('show_image', [
        //     'images' => ImageUpload::orderBy('created_at', 'desc')->withTrashed()->paginate(25)
        // ]);
        //return to_route('')->with('success', 'L\'image a bien été créer');
    }
}
