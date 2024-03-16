<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

abstract class ModelWithUuid extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Model $model) {
            if (!$model->getAttribute($model->getKeyName())) {
                $model->setAttribute($model->getKeyName(), Uuid::uuid4()->toString());
            }
        });
    }
}
