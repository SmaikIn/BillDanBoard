<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Department extends ModelWithUuid
{
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'uuid');
    }
}
