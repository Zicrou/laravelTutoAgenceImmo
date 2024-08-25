<?php

use App\Models\ImageUpload;
use App\Models\Property;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('upload_image_properties', function (Blueprint $table) {
            $table->foreignIdFor(ImageUpload::class)->constraint()->cascadeOnDelete();
            $table->foreignIdFor(Property::class)->constraint()->cascadeOnDelete();
            $table->primary(['image_upload_id', 'property_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upload_image_properties');
    }
};
