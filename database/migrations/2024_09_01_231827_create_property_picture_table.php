<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\Models\Picture;
use \App\Models\Property;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('property_pictures', function (Blueprint $table) {
            $table->foreignIdFor(Picture::class)->constraint()->cascadeOnDelete();
            $table->foreignIdFor(Property::class)->constraint()->cascadeOnDelete();
            $table->primary(['picture_id', 'property_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_pictures');
    }
};
