<?php

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
        Schema::create('skin3d', function (Blueprint $table) {
            $table->id();
            $table->string('service');
            $table->string('phrase')->nullable();
            $table->string('background')->nullable();
            $table->string('backgroundMode')->default('background');
            $table->boolean('showPhrase')->default(true);
            $table->boolean('showButtons')->default(true);
            $table->boolean('activeCapes')->default(true);
            $table->string('custom_capes_api')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skin3d');
    }
};
