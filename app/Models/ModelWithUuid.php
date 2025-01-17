<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

abstract class ModelWithUuid extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            do {
                $uuid = Uuid::uuid4()->toString();
            } while (self::where('uuid', $uuid)->exists());

            $model->uuid = $uuid;
        });
    }
}
