<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('role_permission', function (Blueprint $table) {
            $table->foreignIdFor(Role::class)->references('uuid')->on('roles')->onDelete('cascade');
            $table->foreignIdFor(Permission::class)->references('uuid')->on('permissions')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_permission');
    }
};
