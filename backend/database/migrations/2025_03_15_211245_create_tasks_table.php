<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title')->nullable(false);
            $table->text('description')->nullable();
            $table->enum('status', [
                'pending',
                'progress',
                'completed',
                'cancelled'
            ])->default('pending');
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
