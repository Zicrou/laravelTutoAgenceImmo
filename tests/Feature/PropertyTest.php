<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Property;
use App\Models\Option;
use App\Notifications\ContactRequestNotification;
use Illuminate\Support\Facades\Notification;

class PropertyTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_send_not_found_on_non_existent_property(): void
    {
        $response = $this->get('/biens/nisi-expedita-et-voluptatum-qui-vero-doloribus-eius-molestias-eos-et-animi-magni-blanditiis-neque-qui-eveniet-nobis-id-harum-placeat-et-natus-soluta-nihil-quia-quod-ut-iste-tempore-ullam-optio-officia-provident-soluta-sed-aperiam-5');

        $response->assertStatus(404);
    }

    public function test_redirect_bad_slug_property(): void
    {
        /** @var Property $property */
        $property = Property::factory()->create();

        $response = $this->get('/biens/nisi-expedita-et-voluptatum-qui-vero-doloribus-eius-molestias-eos-et-animi-magni-blanditiis-neque-qui-eveniet-nobis-id-harum-placeat-et-natus-soluta-nihil-quia-quod-ut-iste-tempore-ullam-optio-officia-provident-soluta-sed-aperiam-'.$property->id);

        $response->assertRedirectToRoute('property.show', ['property' => $property->id, 'slug' => $property->getSlug()]);
    }

    public function test_ok_on_property(): void
    {
        /** @var Property $property */
        $property = Property::factory()->create();

        $response = $this->get("/biens/{$property->getSlug()}-{$property->id}");

        $response->assertOk();
        $response->assertSee($property->title);
    }

    public function test_error_on_contact(): void
    {
        /** @var Property $property */
        $property = Property::factory()->create();
        $response = $this->post("/biens/{$property->id}/contact", [
            "firstname" => "John",
            "lastname" => "Doe",
            "phone" => "0000000000",
            "email" => "doe",
            "message" => "Pouvez vous me contacter"
        ]);
        $response->assertRedirect();
        $response->assertSessionHasErrors(['email']);
        $response->assertSessionHasInput('email', 'doe');
    }


    public function test_ok_on_contact(): void
    {
        Notification::fake();
        /** @var Property $property */
        $property = Property::factory()->create();
        $response = $this->post("/biens/{$property->id}/contact", [
            "firstname" => "John",
            "lastname" => "Doe",
            "phone" => "0000000000",
            "email" => "doe@demo.fr",
            "message" => "Pouvez vous me contacter"
        ]);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('success');
        //Notification::assertCount(1);
        Notification::assertSentOnDemand(ContactRequestNotification::class);

    }
}


