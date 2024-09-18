<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\Picture;
use \App\Models\Property;
use \App\Models\PropertyPicture;
use Illuminate\Support\Facades\File;
use App\Http\Requests\PictureFilterRequest;
use Illuminate\Support\Facades\Auth;

class PictureController extends Controller
{
    public function __construct()
    {
        //$this->authorize(Picture::class, 'picture');
    }
    public function index(Property $property)
    {
        $propertyPictures = $property->pictures()->get();
        
        return view('admin.pictures.picture', ['property' => $property, 'propertyPictures' => $propertyPictures]);
    }

    public function store_picture(PictureFilterRequest $request, Property $property)
    {
        $data = $request->validated();
        if($images = $request->file('image')){
            foreach ($images as $image) {
                $filename = $image->getClientOriginalName();
                $imageName = time().'-'.uniqid().'_'.$filename;
                $path = 'pictures/property/'.$property->id.'/';
                $image->storeAs($path, $imageName, 's3'); 

                $image->move($path, $imageName);
                $picture = Picture::create([
                    'image' => $path.$imageName,
                    'property_id' => $property->id
                ]);
                PropertyPicture::create([
                    'picture_id' => $picture->id,
                    'property_id' => $property->id
                ]);
            }
        }
        return to_route('admin.picture.index', $property)->with('success', 'Le bien a bien été créé');
    }

    public function destroy($picture)
    {
        $image = Picture::findOrFail($picture);
        if(Auth::user()->can('delete', $image))
        {
            if (File::exists($image->image)) {
            File::delete($image->image);
            }
            $image->delete();
            return redirect()->back()->with('status', 'Image supprimée');
        }else{
            return redirect()->back()->with('status', 'Impossible de supprimer l\'image');
        }
    }
}
