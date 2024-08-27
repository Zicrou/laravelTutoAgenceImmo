<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PropertyFormRequest;
use App\Models\Property;
use App\Models\Option;
use App\Models\ImageUpload;
use App\Models\UploadImageProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\Models\User;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Property::class, 'property');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.properties.index', [
            //'properties' => Property::orderBy('created_at', 'desc')->withTrashed()->paginate(25)
            'properties' => Property::orderBy('created_at', 'desc')->paginate(25)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $property = new Property();
        $property->fill([
            'surface' => 40,
            'rooms' => 3,
            'bedrooms' => 1,
            'floor' => 0,
            'city' => 'Montpellier',
            'postal_code' => 34000,
            'sold' => false,
        ]);
        
        return view('admin.properties.form', [
            'property' => $property,
            'options' => Option::pluck('name', 'id'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $data = $this->validate($request, [
            'title' => ['required', 'min:8'],
            'description' => ['required', 'min:8'],
            'surface' => ['required', 'integer', 'min:10'],
            'rooms' => ['required','integer', 'min:1'],
            'bedrooms' => ['required', 'integer', 'min:0'],
            'floor' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'integer', 'min:0'],
            'city' => ['required', 'min:4'],
            'address' => ['required', 'min:8'],
            'postal_code' => ['required', 'min:3'],
            'sold' => ['required', 'boolean'],
            'options' => ['array', 'exists:options,id', 'required'],
            'image' => ['required|mimes:jpg, jpeg, png, bmp']
            ]);
        /**
         * @var UploadedFile|null $image
         */
        $property = Property::create($request->validate());
        if($request->hasFile('image'))
            {
                $allowedfileExtension=['pdf', 'webp','jpg', 'jpeg','png','docx'];
                $files = $request->file('image');
                foreach($files as $file){
                    $filename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $check=in_array($extension,$allowedfileExtension);
                    
                    if($check)
                    {
                        $imageName = time().'-'.uniqid().'_'.$filename;
                        $data['image'] = $file->move('images/uploads/property/', $imageName);
                        foreach ($request->image as $img) {
                            
                            ImageUpload::create([
                                'property_id' => $property->id,
                                'image' => $imageName,
                            ]);
                        }
                    }

                }
            }
            
        // Enregistrer la property aprés $check is true ou bien l'enregistrer ici directement
        
        $property->options()->sync($request->validate(['options']));
        return to_route('admin.property.index')->with('success', 'Le bien a bien été modifié');
    }

     

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        
        return view('admin.properties.form', [
            'property' => $property,
            'options' => Option::pluck('name', 'id'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PropertyFormRequest $request, Property $property)
    {
        $property->options()->sync($request->validated('options'));
        $property->update($this->extractData($property, $request));
        foreach ($request->image as $img) {
            $img = ImageUpload::create([
                'property_id' => $property->id,
                'image' => $imageName,
            ]);
        }
        return to_route('admin.property.index')->with('success', 'Le bien a bien été modifié');
    }

    public function extractData(Property $property, PropertyFormRequest $request): array
    {
        $data = $request->validated();
        
        $check = '';
        
        /**
         * @var UploadedFile|null $image
         */
        if($request->hasFile('image'))
            {
                $allowedfileExtension=['pdf', 'webp','jpg', 'jpeg','png','docx'];
                $files = $request->file('image');
                foreach($files as $file){
                    $filename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $check=in_array($extension,$allowedfileExtension);
                    
                    if($check)
                    {
                        // $imageName = time().'_'.uniqid().'_'.$filename;
                        // $data['image'] = $file->move('images/uploads/property/'.$property->id.'/', $imageName);
                        //$imageValidated = $check; //$request->validated('image');

                        // if($imageValidated == null || $imageValidated->getError)
                        // {
                        //     return $data;
                        // }
                        //if($imageValidated){
                            $imageName = time().'-'.uniqid().'_'.$filename;
                            $data['image'] = $file->move('images/uploads/property/'.$property->id.'/', $imageName);
                        //}
                    }

                }
            }

        return $data;
    }

    public function extractDataFirstImageProperty(Request $request): array
    {
        $property = '';
        $data = $this->validate($request, [
            'title' => ['required', 'min:8'],
            'description' => ['required', 'min:8'],
            'surface' => ['required', 'integer', 'min:10'],
            'rooms' => ['required','integer', 'min:1'],
            'bedrooms' => ['required', 'integer', 'min:0'],
            'floor' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'integer', 'min:0'],
            'city' => ['required', 'min:4'],
            'address' => ['required', 'min:8'],
            'postal_code' => ['required', 'min:3'],
            'sold' => ['required', 'boolean'],
            'options' => ['array', 'exists:options,id', 'required'],
            'image'=> ['required','mime:jpg, jpeg, png, webp, gif']
            ]);
        /**
         * @var UploadedFile|null $image
         */

        if($request->hasFile('image'))
        {
            $allowedfileExtension=['pdf', 'webp','jpg', 'jpeg','png','docx'];
            $file = $request->file('image')[0];
            
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $check=in_array($extension,$allowedfileExtension);
            $imageValidated = $request->validate(['image']);
            if($check)
            {
                if($imageValidated == null || $imageValidated->getError())
                {
                    return $data;
                }
                $imageName = time().'-'.uniqid().'_'.$filename;
                
                $data['image'] = $file->move('images/uploads/property', $imageName);
            }else{
                return $data;
            }

        }
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        $property->delete();
        
        // Pour remettre le deleted_at a null et restaurer le propriété
        //$property->restore();

        // Pour supprimer veritablement
        //$property->forceDelete();
        return to_route('admin.property.index')->with('success', 'Le bien a été supprimé');
    }
}
