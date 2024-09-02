<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ImageFilterRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ImageUpload;
use App\Models\Property;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rules\ImageFile;

class ImageUploadController extends Controller
{
    public function __construct()
    {
        //$this->authorize(ImageUpload::class, 'image_upload');
    }
    public function index(Property $property)
    {
        $propertyImages = $property->images()->get();
        //$propertyImages = Property::where('product_id', $property->id)->get();
        return view('image_upload', ['property' => $property, 'propertyImages' => $propertyImages]);
    }

    public function store_image(ImageFilterRequest $request, Property $property)
    {
        $data = $request->validated();
        if($images = $request->file('image')){
            foreach ($images as $image) {
                $filename = $image->getClientOriginalName();
                $imageName = time().'-'.uniqid().'_'.$filename;
                $path = 'images/uploads/property/'.$property->id.'/';

                $image->move($path, $imageName);
                ImageUpload::create([
                    'image' => $path.$imageName,
                    'property_id' => $property->id
                ]);
            } 
        }
        return to_route('admin.upload.image', $property)->with('success', 'Le bien a bien été créé');
    }

    public function destroy($imageUpload)
    {
        $image = ImageUpload::findOrFail($imageUpload);
        //dd($this->authorize('delete', $image));
        if (File::exists($image->image)) {
            File::delete($image->image);
        }
        $image->delete();

        return redirect()->back()->with('status', 'Image supprimé');
    }
}
