<?php

/**
 * (ɔ) Aziz - 2024-2024
 */

namespace App\Http\Controllers;

use App\Models\{Property};

class HomeController extends Controller
{
	public function index()
	{
		$properties = Property::latest()->available(true)->limit(40)->paginate(6);

		return view('home', compact('properties'));
	}
}
