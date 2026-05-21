<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('company');
            $table->string('role');
            $table->string('location')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable()->comment('null = current job');
            $table->text('description')->nullable();
            $table->json('technologies')->nullable();
            $table->string('company_url')->nullable();
            $table->unsignedInteger('order_column')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->index(['is_published', 'order_column']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
