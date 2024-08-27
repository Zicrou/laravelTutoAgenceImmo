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
    public function store(PropertyFormRequest $request)
    {
        $data = $request->validated();
        // Enregistrer la property aprés $check is true ou bien l'enregistrer ici directement
        $property = Property::create($request->except('image'));
        $property->options()->sync($request->validated('options'));
        $check = '';
        $imageName = '';
        
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
                    $imageName = time().'-'.uniqid().'_'.$filename;
                    $data['image'] = $file->move('images/uploads/property/'.$property->id.'/', $imageName);
                    $data['imageName'] = $imageName;
                    
                    foreach ($request->image as $img) {
                        $img = ImageUpload::create([
                            'property_id' => $property->id,
                            'image' => $imageName,
                        ]);
                    }
                    return to_route('admin.property.index')->with('success', 'Le bien a bien été créé');
                }else{
                    return $data;
                }
            }
        }
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
                            dd($data);
                        //}
                    }

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
