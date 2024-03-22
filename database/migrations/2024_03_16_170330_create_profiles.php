<?php

use App\Models\Company;
use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->uuid('company_uuid')->change();
            $table->uuid('user_uuid')->change();
            $table->uuid('department_uuid')->nullable()->change();
            $table->uuid('role_uuid')->nullable()->change();

            $table->foreignIdFor(Company::class)->references('uuid')->on('companies')->onDelete('cascade');
            $table->foreignIdFor(User::class)->references('uuid')->on('users')->onDelete('cascade');
            $table->foreignIdFor(Role::class)->nullable()->references('uuid')->on('roles')->onDelete('set null');
            $table->foreignIdFor(Department::class)->nullable()->references('uuid')->on('departments')->onDelete('set null');

            $table->string('first_name');
            $table->string('last_name');
            $table->string('second_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('avatar')->default('avatar.svg');
            $table->string('position')->nullable();
            $table->text('description')->nullable();
            $table->date('birthday')->nullable();
            $table->boolean('is_active')->default(true);

            $table->unique(['company_uuid', 'user_uuid']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
