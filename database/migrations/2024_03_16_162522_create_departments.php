<?php

use App\Models\Company;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->uuid()->primary()->default(DB::raw('UUID()'));;
            $table->uuid('company_uuid')->change();
            $table->string('name');

            $table->foreignIdFor(Company::class)->references('uuid')->on('companies')->onDelete('cascade');
            $table->unique(['company_uuid', 'name']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
