<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends ModelWithUuid
{

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function profiles(): HasMany
    {
        return $this->HasMany(Profile::class, 'company_uuid', 'uuid');
    }

    public function roles(): HasMany
    {
        return $this->HasMany(Role::class, 'company_uuid', 'uuid');
    }

    public function department(): HasMany
    {
        return $this->HasMany(Department::class, 'company_uuid', 'uuid');
    }

}
