<?php

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('company_user', function (Blueprint $table) {
            $table->foreignIdFor(Company::class)->references('uuid')->on('companies')->onDelete('cascade');
            $table->foreignIdFor(User::class)->references('uuid')->on('users')->onDelete('cascade');

            $table->unique(['company_uuid', 'user_uuid']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_user');
    }
};
