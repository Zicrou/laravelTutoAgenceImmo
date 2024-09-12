<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchPropertiesRequest;
use App\Mail\PropertyContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Property;
use App\Http\Requests\PropertyContactRequest;
use App\Models\ImageUpload;
use App\Events\ContactRequestEvent;
use App\Jobs\DemoJob;
use App\Models\Picture;
use App\Models\User;
use App\Notifications\ContactRequestNotification;

class PropertyController extends Controller
{
    public function index(SearchPropertiesRequest $request){
        $query = Property::query()->orderBy('created_at', 'desc');
        if ($price = $request->validated('price')) {
            $query->where('price', '<=', $price);
        }
        if ($surface = $request->validated('surface')) {
            $query->where('surface', '>=', $surface);
        }
        if ($rooms = $request->validated('rooms')) {
            $query->where('rooms', '>=', $rooms);
        }
        if ($title = $request->validated('title')) {
            $query->where('title', 'like', "%{$title}%");
        }
        return view("property.index", [
            'properties' => $query->paginate(16),
            'input' => $request->validated()
        ]);
    }

    public function show(string $slug, Property $property)
    {
        /** @var User $user */
        //$user = User::first();
        DemoJob::dispatch($property)->delay(now()->addSeconds(10));
        $expectedSlug = $property->getSlug();
        if($slug !== $expectedSlug){
            return to_route('property.show', ['slug' => $expectedSlug, 'property' => $property]);
        }
        $images = Picture::where('property_id', $property->id)->get();
        return view('property.show', [
            'property' => $property,
            'images' => $images
        ]);
    } 


    public function contact(Property $property, PropertyContactRequest $request)
    {
        /** @var User $user */
        $user = User::first();
        $user->notify(new ContactRequestNotification($property, $request->validated()));
        event(new ContactRequestEvent($property, $request->validated()) );
        return back()->with('success', 'votre demande de contact a bien été envoyé');
    }
    
}
