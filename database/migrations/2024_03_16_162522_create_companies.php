<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->uuid()->primary()->default(DB::raw('UUID()'));;
            $table->string('name');
            $table->string('inn');
            $table->string('kpp')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('website')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
