<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('model_id')->index();
            $table->string('name');
            $table->string('engine')->default('');
            $table->unsignedInteger('power')->default(0);
            $table->string('transmission')->default('');
            $table->string('wheel_drive')->default('');
            $table->json('options');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};
