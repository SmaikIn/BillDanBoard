<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

abstract class ModelWithUuid extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';

   /* protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid(); // Генерация UUID перед созданием
        });
    }*/
}
