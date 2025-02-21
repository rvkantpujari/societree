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
        Schema::create('societies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('random_slug_key')->unique();
            $table->integer('number_of_units');
            $table->string('street');
            $table->string('landmark')->nullable();
            $table->string('area')->nullable();
            $table->string('city')->nullable();
            $table->foreignId('state_id')->constrained()->cascadeOnUpdate();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('societies');
    }
};
