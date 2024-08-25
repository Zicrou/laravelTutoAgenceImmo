<?php

/**
 * (ɔ) Aziz - 2024-2024
 */

namespace Database\Seeders;

use App\Models\{Option, Property, User};
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
	use WithoutModelEvents;

	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		User::factory()->create([
			'name'       => 'Admin',
			'email'      => 'admin@example.com',
			'password'   => Hash::make('password'),
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now(),
		]);
		$options = Option::factory(10)->create();
		Property::factory(50)
			->hasAttached($options->random(3))
			->create();

        // REPORT
        printf('%s%s', str_repeat(' ', 2), "Data tables properly filled.\n\n");
        }
}
